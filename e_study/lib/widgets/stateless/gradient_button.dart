import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:flutter/material.dart';


class GradientPinkButton extends StatelessWidget {
  final double height;
  final double width;
  final double radius;
  final String content;
  final VoidCallback onTap;

  const GradientPinkButton(
      {Key? key,
      required this.content,
      required this.height,
      required this.width,
      required this.radius,
      required this.onTap})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        alignment: Alignment.center,
        height: height,
        width: width,
        decoration: pinkGradientWithRadius(radius),
        child: Text(content),
      ),
    );
  }
}

BoxDecoration pinkGradientWithRadius(double radius) {
  return BoxDecoration(
    borderRadius: BorderRadius.circular(radius),
    gradient: const LinearGradient(
      begin: Alignment.bottomLeft,
      end: Alignment.topRight,
      colors: [DarkTheme.darkerPink, DarkTheme.lighterPink],
    ),
  );
}


class BaseButton extends StatelessWidget {
  final Size size;
  final String content;
  final VoidCallback? onTap;
  final bool isDisable;

  const BaseButton(
      {Key? key,
      this.isDisable = false,
      required this.size,
      required this.content,
      this.onTap})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: isDisable ? null : onTap,
      child: Container(
        margin: const EdgeInsets.only(bottom: 8),
        height: size.height / 16,
        width: size.width,
        alignment: Alignment.center,
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(22),
            color: LightTheme.darkBlue
            ),
        child: Text(
          content,
          style: CustomTextStyle.heading3White,
        ),
      ),
    );
  }
}
