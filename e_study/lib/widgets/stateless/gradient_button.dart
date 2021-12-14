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
