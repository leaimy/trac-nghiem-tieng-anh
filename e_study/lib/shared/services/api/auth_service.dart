import 'package:e_study/models/user.dart';
import 'package:e_study/shared/provider/api_provider.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

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

  Future<dynamic> signIn(String username, String password) async {
    try {
      final response = await _apiProvider.post('/auth/login',
          data: {"username": username, "password": password});
      if (response.statusCode == 200) {
        logger.log('${response.data["data"]["user"]["fullname"]}');
        saveUser(response.data["data"]["user"]["fullname"]);
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
        logger.log('$response');
        return response.data;
      }
    } catch (e) {
      rethrow;
    }
  }

  Future saveUser(String fullName) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('fullname', fullName);
  }
}
