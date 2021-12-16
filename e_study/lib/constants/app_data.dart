class AppData {
  static final AppData _appData = AppData._internal();
  String appName = 'E Study';
  String env = '';
  int version = 1;
  String apiHost = '';
  String apiVersion = 'api/v1';
  String apiUrl = '';
  String dbName = '';

  String openWeatherMapURL = 'api.openweathermap.org';
  String openWeatherApiKey = '1f265597ec6308021c410fde44fd3f60';

  String baseUrl = '';

  double widthScreen = 0;
  double heightScreen = 0;

  String pusherKey = '';
  String pusherCluster = '';
  var downloadProcess = <String, dynamic>{};
  factory AppData() {
    return _appData;
  }
  AppData._internal();
}

final appData = AppData();
