import 'package:e_study/shared/provider/log_provider.dart';
import 'package:e_study/shared/services/api/auth_service.dart';
import 'package:flutter/cupertino.dart';

class SignInScreenModel extends ChangeNotifier {
  final AuthService _authService = AuthService();
  LogProvider get logger => const LogProvider('🛎 Sign In');

  bool _busy = false;
  bool get busy => _busy;

  void setBusy(bool value) {
    _busy = value;
    notifyListeners();
  }

  bool _signedIn = false;
  bool get signedIn => _signedIn;

  bool? _isLoginSuccess;
  bool? get isLoginSuccess => _isLoginSuccess;

  final TextEditingController _username = TextEditingController();
  TextEditingController get username => _username;

  final TextEditingController _password = TextEditingController();
  TextEditingController get password => _password;

  bool _isError = false;
  bool get isError => _isError;

  String _errorMessage = '';
  String get errorMessage => _errorMessage;
  void setError(bool value, String message) {
    _isError = value;
    _errorMessage = message;
    notifyListeners();
  }

  void setSignedIn(bool value) {
    _signedIn = value;
    notifyListeners();
  }

  void checkInput() {
    if (_username.text.isEmpty && _password.text.length < 8) {
      setError(true, 'Thông tin đăng nhập không hợp lệ');
      return;
    }
    setError(false, '');
  }

  void setLoginStatus(bool? value) {
    _isLoginSuccess = value;
  }

  Future<void> signInDio() async {
    try {
      setBusy(true);
      await _authService.signIn(_username.text, _password.text);
      setBusy(false);
      setLoginStatus(true);
    } catch (e) {
      setBusy(false);
      setError(true, 'Đăng nhập không thành công'); // bắt lỗi đăng nhập
    }
  }
}
