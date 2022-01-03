import 'package:e_study/models/quiz.dart';
import 'package:e_study/models/topic.dart';
import 'package:e_study/models/user.dart';

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

}
