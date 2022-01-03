import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:flutter/cupertino.dart';

enum Status { isTrue, isFalse, none }

class AnswerButton extends StatefulWidget {
  const AnswerButton(
      {Key? key,
      required this.size,
      required this.content,
      this.onTap,
      required this.isActive,
      required this.status})
      : super(key: key);
  final Size size;
  final String content;
  final VoidCallback? onTap;
  final bool isActive;
  final Status status;

  @override
  _AnswerButtonState createState() => _AnswerButtonState();
}

class _AnswerButtonState extends State<AnswerButton> {
  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: widget.isActive == false ? () {} : widget.onTap,
      child: Container(
        margin: const EdgeInsets.only(bottom: 8),
        height: widget.size.height / 16,
        width: widget.size.width,
        alignment: Alignment.center,
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(22),
            color: pickColor(widget.status)),
        child: Text(
          widget.content,
          style: CustomTextStyle.heading3,
        ),
      ),
    );
  }

  Color pickColor(Status value) {
    switch (value) {
      case Status.none:
        return LightTheme.lightBlue;
      case Status.isTrue:
        return LightTheme.green;
      case Status.isFalse:
        return LightTheme.red;
    }
  }
}
