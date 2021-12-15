import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:flutter/material.dart';

class StatusDot extends StatelessWidget {
  const StatusDot({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      height: AppConstants.dotSized,
      width: AppConstants.dotSized,
      decoration: BoxDecoration(
          color: DarkTheme.white,
          borderRadius: BorderRadius.circular(50)),
      child: Container(
        margin: const EdgeInsets.all(AppConstants.dotSized / 8),
        decoration: BoxDecoration(
            color: DarkTheme.adding,
            borderRadius: BorderRadius.circular(10)),
      ),
    );
  }
}
