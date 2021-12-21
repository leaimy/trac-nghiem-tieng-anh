import 'package:e_study/models/question.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:flutter/material.dart';

class PracticeScreenModel extends ChangeNotifier {
  LogProvider get logger => const LogProvider('👋 Practice Page Log: ');

  final PageController _pageController = PageController();

  PageController get pageController => _pageController;

  final List<Question> _questions = [];

  List<Question> get questions => _questions;

  int _currentIndex = 0; // max 10 cau hoi
  int get currentIndex => _currentIndex;

  void setCurrentIndex(int value) {
    _currentIndex = value;
    notifyListeners();
  }

  int _numberOfTrue = 0;

  int get numberOfTrue => _numberOfTrue;

  void setNumberOfTrue(int value) {
    _numberOfTrue = value;
    notifyListeners();
  }

  int _numberOfFalse = 0;

  int get numberOfFalse => _numberOfFalse;

  void setNumberOfFalse(int value) {
    _numberOfFalse = value;
    notifyListeners();
  }

  void showOption(String content) {
    logger.log(content);
  }
}
