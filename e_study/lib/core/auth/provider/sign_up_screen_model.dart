import 'package:e_study/models/user.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:e_study/shared/services/api/auth_service.dart';
import 'package:flutter/material.dart';

class SignUpScreenModel extends ChangeNotifier {
  final AuthService _authService = AuthService();
  LogProvider get logger => const LogProvider('🛎 Sign Up');

  bool _isLoading = false;
  bool get isLoading => _isLoading;
  void setIsLoading(bool value) {
    _isLoading = value;
    notifyListeners();
  }

  bool? _isSignUpSuccess;
  bool? get isSignUpSuccess => _isSignUpSuccess;

  void setSignUpStatus(bool? value) {
    _isSignUpSuccess = value;
    notifyListeners();
  }

  final User _user = User();
  User get user => _user;

  final TextEditingController _username = TextEditingController();
  TextEditingController get username => _username;

  final TextEditingController _password = TextEditingController();
  TextEditingController get password => _password;

  final TextEditingController _confirmPassword = TextEditingController();
  TextEditingController get confirmPassword => _confirmPassword;

  final TextEditingController _fullname = TextEditingController();
  TextEditingController get fullname => _fullname;

  bool _isError = true;
  bool get isError => _isError;

  String _errorMessage = '';
  String get errorMessage => _errorMessage;
  void setError(bool value, String message) {
    _isError = value;
    _errorMessage = message;
    notifyListeners();
  }

  void checkInput() {
    String namePattern =
        r'(^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$)';
    RegExp nameRegex = RegExp(namePattern);
    if (!nameRegex.hasMatch(_fullname.text) ||
        !nameRegex.hasMatch(_fullname.text)) {
      setError(true, 'Tên không hợp lệ');
      return;
    }
    setError(false, 'Passed');
  }

  Future<void> signUpDio() async {
    setIsLoading(true);
    _user.username = _username.text;
    _user.fullname = _fullname.text;
    _user.password = _password.text;

    try {
      setIsLoading(true);
      await _authService.signUp(_user);
      setIsLoading(false);
      setSignUpStatus(true);
    } catch (e) {
      setIsLoading(false);
    }
  }
}
