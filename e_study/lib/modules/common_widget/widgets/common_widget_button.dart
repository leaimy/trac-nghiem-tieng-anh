import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/material.dart';

class CommonWidgetButton extends StatelessWidget {
  final String content;
  final VoidCallback onTap;
  final Size size;

  const CommonWidgetButton(
      {Key? key,
      required this.content,
      required this.onTap,
      required this.size})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: GradientButton(
        content: content,
        onTap: onTap,
        size: size,
      ),
    );
  }
}
