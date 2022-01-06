import 'package:e_study/shared/services/restart_helper.dart';
import 'package:flutter/material.dart';

import 'src/app.dart';
import 'src/settings/settings_controller.dart';
import 'src/settings/settings_service.dart';

void main() async {
  final settingsController = SettingsController(SettingsService());
  await settingsController.loadSettings();
  runApp(RestartApp(null, MyApp(settingsController: settingsController)));
}
