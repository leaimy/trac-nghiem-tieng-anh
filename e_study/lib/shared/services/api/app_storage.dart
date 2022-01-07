import 'dart:convert';

import 'package:e_study/models/history.dart';
import 'package:e_study/models/quiz.dart';
import 'package:e_study/models/topic.dart';
import 'package:e_study/models/user.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AppStorage {
  LogProvider get logger => const LogProvider('👋 Storage: ');

  static final AppStorage _instance = AppStorage._internal();

  factory AppStorage() => _instance;

  AppStorage._internal();

  User _user = User();

  User get user => _user;

  void setUser(User value) {
    _user = value;
  }

  List<Topic> _topicData = [];
  List<Topic> get topicData => _topicData;
  void setTopicData(List<Topic> value) {
    _topicData = value;
  }

  Topic? _selectedTopic;

  Topic? get selectedTopic => _selectedTopic;
  void setSelectedTopic(Topic value) {
    _selectedTopic = value;
  }

  void resetSelectedTopic() {
    _selectedTopic = null;
  }

  //=====================
  Quiz? _selectedQuestionPack;
  Quiz? get selectedQuestionPack => _selectedQuestionPack;
  void setSelectedQuestionPack(Quiz value) {
    _selectedQuestionPack = value;
  }

  void resetSelectedQuestionPack() {
    _selectedQuestionPack = null;
  }

  //======================
  // final Map<String, dynamic> _result = {
  //   "quiz_title": "",
  //   "numberOfTrue": 0,
  //   "numberOfFalse": 0,
  // };

  // Map<String, dynamic> get result => _result;

  // void setResult(String title, int trueNum, int falseNum) {
  //   _result["quiz_title"] = title;
  //   _result["numberOfTrue"] = trueNum;
  //   _result["numberOfFalse"] = falseNum;
  // }
  History? _currentResult;
  History? get currentResult => _currentResult;

  void setCurrentResult(History value) {
    _currentResult = value;
  }

  void resetCurrentResult() {
    _currentResult = null;
  }

  List<History> _historyData = [];
  List<History> get historyData => _historyData;

  void addHistory(History item) {
    _historyData.add(item);
  }
  
  void resetHistoryData() {
    _historyData = [];
  }

  List<String> convertHistoryToString() {
    List<String> stringData = [];
    if (_historyData.isNotEmpty) {
      for (History item in _historyData) {
        Map<String, dynamic> jsonData = item.toJson();
        String itemData = json.encode(jsonData);
        stringData.add(itemData);
      }
    }
    logger.log(stringData.toString());
    return stringData;
  }

  //==================== clear preferences
  Future clearPrefs() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.clear();
  }
}
