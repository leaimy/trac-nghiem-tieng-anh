import 'package:shared_preferences/shared_preferences.dart';
import 'package:e_study/models/history.dart';
import 'package:e_study/shared/services/api/app_storage.dart';
import 'package:flutter/material.dart';

class ResultScreenModel extends ChangeNotifier {
  final History? _currentResult = AppStorage().currentResult;

  void addCurrentResult() {
    AppStorage().addHistory(_currentResult!);
  }


  Future<void> saveToPrefs() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    final List<String> _prefsData = AppStorage().convertHistoryToString();
    await prefs.setStringList('historyData', _prefsData);
  }

  void resetCurrentResult() {
    AppStorage().resetCurrentResult();
  }
}
