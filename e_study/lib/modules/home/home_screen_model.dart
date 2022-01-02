import 'package:e_study/models/topic.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:e_study/shared/services/api/app_storeage.dart';
import 'package:e_study/shared/services/api/quiz_service.dart';
import 'package:flutter/material.dart';

class HomeScreenModel extends ChangeNotifier {
  final QuizService _quiz = QuizService();
  final AppStorage _storage = AppStorage();
  LogProvider get logger => const LogProvider('🛎 HomePage');

  bool _busy = false;
  bool get busy => _busy;

  void setBusy(bool value) {
    _busy = value;
    notifyListeners();
  }

  List<Topic> _topicData = [];
  List<Topic> get topicData => _topicData;
  void setTopicData(List<Topic> value) {
    _topicData = value;
    notifyListeners();
  }

  void getHomeData() async {
    try {
      var result = await _quiz.getTopic();
      List<dynamic> rawList = result['data'];
      // _topicData = rawList.map((e) => Topic.fromJson(e)).toList();
      setTopicData(rawList.map((e) => Topic.fromJson(e)).toList());
      _storage.setTopicData(_topicData);
    } catch (e) {
      logger.log(e.toString());
    }
  }
}
