import 'package:e_study/constants/app_data.dart';
import 'package:e_study/models/user.dart';
import 'package:e_study/shared/provider/api_provider.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:shared_preferences/shared_preferences.dart';


import '../http_service.dart';

class AuthService {
  String endpoint = 'auth';

  final _apiProvider = ApiProvider();
  LogProvider get logger => const LogProvider('🛎 Response');

  Future<bool> getToken() async {
    final storage = await SharedPreferences.getInstance();
    var value = storage.getString("token");
    if (value != null) {
      return true;
    } else {
      return false;
    }
  }

  Future<void> saveToken(String token) async {
    final storage = await SharedPreferences.getInstance();
    storage.setString("token", token);
  }

  late HttpService httpService;

  AuthService() {
    httpService = HttpService();
    httpService
        .withHost(appData.apiHost)
        .withVersion(appData.apiVersion)
        .withPath(endpoint);
  }

  Future<ResponseObject> signin(
      {required String username,
      required String pwd,
      required Function(ResponseObject) onErrorCallback}) {
    httpService
        .withPath('login')
        .makePost()
        .withParam({"username": username, "password": pwd});
    return httpService.execute().then((ResponseObject response) {
      return response;
    }).catchError((onError) {
      onErrorCallback(onError);
    });
  }

  Future<dynamic> signIn(String username, String password) async {
    try {
      final response = await _apiProvider.post('/auth/login',
          data: {"username": username, "password": password});
      if (response.statusCode == 200) {
        logger.log('$response.data');
        return response.data;
      }
    } catch (e) {
      rethrow;
    }
  }
  
  Future<dynamic> signUp(User user) async {
    try {
      final response = await _apiProvider.post('/auth/register', data: user);
      if (response.statusCode == 200) {
        logger.log('$response.data');
        return response.data;
      }
    } catch (e) {
      // logger.log(e.toString());
      rethrow;
    }
  }
}
