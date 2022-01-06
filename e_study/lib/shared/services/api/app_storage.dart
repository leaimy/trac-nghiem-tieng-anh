import 'package:e_study/models/quiz.dart';
import 'package:e_study/models/topic.dart';
import 'package:e_study/models/user.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AppStorage {
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
  final Map<String, dynamic> _result = {
    "quiz_title": "",
    "numberOfTrue": 0,
    "numberOfFalse": 0,
  };

  Map<String, dynamic> get result => _result;

  void setResult(String title, int trueNum, int falseNum) {
    _result["quiz_title"] = title;
    _result["numberOfTrue"] = trueNum;
    _result["numberOfFalse"] = falseNum;
  }

  //==================== save data for render log
  final List<Map<String, dynamic>> _historyList = [];
  List<Map<String, dynamic>> get historyList => _historyList;
  void addHistory(Map<String, dynamic> item) {
    _historyList.add(item);
  }

  //==================== clear preferences
  Future clearPrefs() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.clear();
  }
}
