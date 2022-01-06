import 'package:flutter/material.dart';

class ResultScreenModel extends ChangeNotifier {
  String getText(String value) {
    String result = "";
    value == "numberOfTrue" ? result = "đúng" : result = "sai";
    return result;
  }
}
