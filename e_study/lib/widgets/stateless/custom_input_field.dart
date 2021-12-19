import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

class CustomInputField extends StatelessWidget {
  final String content;
  final String description;
  final Size size;
  final bool? isObsecure;
  final TextInputType? keyboardType;
  final TextEditingController controller;
  final Function(String)? onChange;
  final bool? hasLimit;

  const CustomInputField(
      {Key? key,
      required this.content,
      required this.description,
      required this.size,
      this.isObsecure,
      this.keyboardType,
      this.onChange,
      required this.controller,
      this.hasLimit})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          content,
          style: CustomTextStyle.heading3,
        ),
        Container(
          height: size.height / 20,
          child: TextField(
            onChanged: onChange,
            keyboardType: keyboardType,
            controller: controller,
            obscureText: isObsecure == null ? false : true,
            inputFormatters: hasLimit == null
                ? null
                : [
                    LengthLimitingTextInputFormatter(10),
                  ],
            decoration: InputDecoration(
                hintText: description,
                border: InputBorder.none,
                hintStyle: CustomTextStyle.heading4Grey),
          ),
          decoration: const BoxDecoration(
            border: Border(
              bottom: BorderSide(color: LightTheme.grey, width: 2),
            ),
          ),
        )
      ],
    );
  }
}
