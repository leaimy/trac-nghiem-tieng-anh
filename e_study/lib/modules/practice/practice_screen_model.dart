import 'package:e_study/models/answer.dart';
import 'package:e_study/models/history.dart';
import 'package:e_study/models/question.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:e_study/shared/services/api/app_storage.dart';
import 'package:e_study/widgets/stateful/answer_button.dart';
import 'package:flutter/material.dart';

class PracticeScreenModel extends ChangeNotifier {
  LogProvider get logger => const LogProvider('👋 Practice Page Log: ');

  final PageController _pageController = PageController();

  final int _questionQuantity =
      AppStorage().selectedQuestionPack?.questions?.length ?? 0;

  int get questionQuantity => _questionQuantity;
  PageController get pageController => _pageController;

  final List<Question> _questions =
      AppStorage().selectedQuestionPack?.questions ?? [];

  List<Question> get questions => _questions;

  int _currentIndex = 0;
  int get currentIndex => _currentIndex;

  void setCurrentIndex(int value) {
    _currentIndex = value;
    _isActive = true;
    notifyListeners();
  }

  int _numberOfTrue = 0;

  int get numberOfTrue => _numberOfTrue;

  void setNumberOfTrue() {
    _numberOfTrue++;
    notifyListeners();
  }

  int _numberOfFalse = 0;

  int get numberOfFalse => _numberOfFalse;

  void setNumberOfFalse() {
    _numberOfFalse++;
    notifyListeners();
  }

  void showOption(String content) {
    logger.log(content);
  }

  bool _isActive = true;
  bool get isActive => _isActive;
  void setActive(bool value) {
    _isActive = value;
    notifyListeners();
  }

  final List<List<Status>> _generalStatus = [];
  List<List<Status>> get generalStatus => _generalStatus;
  void addStatus(List<Status> item) {}

  void initGeneralStatus() {
    if (_questions.length != _generalStatus.length) {
      for (var i = 0; i < _questions.length; i++) {
        _generalStatus
            .add([Status.none, Status.none, Status.none, Status.none]);
      }
    }
  }

  void setStatusList(Status value, int index) {
    logger.log('$_currentIndex');
    _generalStatus[_currentIndex][index] = value;
    notifyListeners();
  }

  void checkAnswer(Answer answer, int index, Question question) {
    logger.log('You choose \'${answer.content}\'');
    logger.log('You choose \'${answer.isTrue}\'');
    if (answer.isTrue == null) {
      return;
    }
    if (answer.isTrue == true) {
      setActive(false);
      setStatusList(Status.isTrue, index);
      setNumberOfTrue();
    }
    if (answer.isTrue == false) {
      setActive(false);
      int correctIndex = findCorrectAnswer(question.answers);
      setStatusList(Status.isFalse, index);
      setStatusList(Status.isTrue, correctIndex);
      setNumberOfFalse();
    }
  }

  int findCorrectAnswer(List<Answer>? list) {
    final Answer? correctAnswer =
        list?.firstWhere((element) => element.isTrue == true);
    return list?.indexOf(correctAnswer!) ?? 0;
  }

  void setResultData() {
    String title = AppStorage().selectedQuestionPack?.title ?? "Undefined";
    History data =
        History(title: title, trueNum: _numberOfTrue, falseNum: _numberOfFalse);
    AppStorage().setCurrentResult(data);
  }
}
