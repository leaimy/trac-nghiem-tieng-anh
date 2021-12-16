import 'dart:convert';
import 'package:e_study/constants/app_data.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:http/http.dart' as http;
import '../helper/helper.dart';

class HttpService {
  LogProvider logger = const LogProvider('HTTP Response');
  String host = AppData().apiHost;
  String method = '';
  var params = <String, dynamic>{};
  var queries = <String, String>{};
  List<String> paths = [];
  String urlRequest = '';

  HttpService();

  HttpService withUrl(String url) {
    String path = url.replaceAll(appData.apiUrl + '/', '');
    List<String> paths = [];
    host = appData.apiHost;
    paths.add(path);
    this.paths = paths;
    return this;
  }

  HttpService withHost(String host) {
    this.host = host;
    return this;
  }

  HttpService withVersion(String version) {
    paths.add(version);
    return this;
  }

  HttpService withPath(String path) {
    paths.add(path);
    return this;
  }

  HttpService makeGet() {
    method = 'GET';
    return this;
  }

  HttpService makePost() {
    method = 'POST';
    return this;
  }

  HttpService makePut() {
    method = 'PUT';
    return this;
  }

  HttpService makeDelete() {
    method = 'DELETE';
    return this;
  }

  HttpService withParam(Map<String, dynamic> params) {
    this.params.addAll(params);
    return this;
  }

  HttpService withQueries(Map<String, String> queries) {
    this.queries.addAll(queries);
    return this;
  }

  getHeader() async {
    return {'content-type': 'application/json'};
  }

  /// Call api service and notify error or response success data
  Future<ResponseObject> execute({String? key}) async {
    var httpClient = http.Client();
    Map<String, String> headers = await getHeader();
    ResponseObject responseObject = ResponseObject();
    Future<http.Response> exec;

    switch (method) {
      case 'GET':
        Uri uri = Uri.https(host, paths.join('/'), queries);
        // print(uri);

        exec = httpClient.get(uri, headers: headers);
        break;
      case 'POST':
        Uri uri = Uri.https(host, paths.join('/'));
        exec =
            httpClient.post(uri, body: json.encode(params), headers: headers);
        break;
      case 'PUT':
        exec = httpClient.put(Uri.https(host, paths.join('/')),
            body: json.encode(params), headers: headers);
        break;
      case 'DELETE':
        exec = httpClient.delete(Uri.https(host, paths.join('/')),
            headers: headers);
        break;
      default:
        throw 'Method is required';
      // break;
    }
    return exec.then((response) async {
      httpClient.close();

      try {} catch (_) {}
      // if (response == null) {
      //   responseObject.errorMessage = 'Không xác định';
      //   throw responseObject;
      // }
      responseObject.statusCode = response.statusCode;

      if (response.statusCode == 505) {
        responseObject.invalidVersion = true;
        responseObject.errorMessage = 'Yêu cầu update app';
        throw responseObject;
      }

      if ([503, 413, 500].contains(response.statusCode)) {
        responseObject.errorMessage = 'Không xác định';

        throw responseObject;
      }
      if (response.statusCode == 204) {
        return responseObject;
      }
      if (response.statusCode == 400) {
        dynamic result = Helper.tryParseJson(utf8.decode(response.bodyBytes));
        logger.log(result);
        return responseObject;
      }
      dynamic result = Helper.tryParseJson(utf8.decode(response.bodyBytes));
      if ([200, 201, 202, 203].contains(response.statusCode)) {
        responseObject.data = key != null ? result[key] : result;
        return responseObject;
      }
      throw responseObject;
    }).catchError((onError) {
      throw responseObject;
    });
  }
}

class ResponseObject {
  int statusCode = -1;
  dynamic data;
  String errorCode = '';
  String errorMessage = '';
  bool isForceLogin = false;
  bool invalidVersion = false;

  ResponseObject();
}
