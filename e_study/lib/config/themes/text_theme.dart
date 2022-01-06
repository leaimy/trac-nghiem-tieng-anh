import 'package:e_study/config/themes/themes.dart';
import 'package:flutter/material.dart';

class CustomTextStyle {
  static const TextStyle heading1 =
      TextStyle(fontSize: 24, color: Colors.black);

  static const TextStyle heading2 =
      TextStyle(fontSize: 20, color: Colors.black);

  static const TextStyle heading3White = TextStyle(
      fontSize: 16, color: LightTheme.white, fontWeight: FontWeight.w300);
  static const TextStyle heading3BlackBold =
      TextStyle(fontSize: 16, color: Colors.black, fontWeight: FontWeight.bold);
  static const TextStyle heading3BlueBold =
      TextStyle(fontSize: 16, color: LightTheme.darkBlue, fontWeight: FontWeight.bold);

  static const TextStyle heading3 = TextStyle(
      fontSize: 16,
      fontWeight: FontWeight.w300,
      color: LightTheme.black,
      decoration: TextDecoration.none);
  static const TextStyle heading4 = TextStyle(
      fontSize: 14, fontWeight: FontWeight.w300, color: LightTheme.black);
  static const TextStyle heading4White = TextStyle(
      fontSize: 14, fontWeight: FontWeight.w300, color: LightTheme.white);
  static const TextStyle heading4Grey =
      TextStyle(fontSize: 14, fontWeight: FontWeight.w300, color: Colors.grey);

  static const TextStyle heading1Bold = TextStyle(
    fontSize: 20,
    fontWeight: FontWeight.w600,
  );

  static const TextStyle heading2Bold = TextStyle(
    fontSize: 16,
    fontWeight: FontWeight.w600,
  );

  static const TextStyle heading3Bold = TextStyle(
    fontSize: 14,
    fontWeight: FontWeight.w600,
  );
}
