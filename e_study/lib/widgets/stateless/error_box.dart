import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:flutter/cupertino.dart';

class ErrorBox extends StatelessWidget {
  const ErrorBox({
    Key? key,
    required this.size,
    required this.errorMessage,
    this.close,
  }) : super(key: key);

  final Size size;
  final String errorMessage;
  final VoidCallback? close;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.all(AppConstants.primaryPadding),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(22),
        color: LightTheme.white ,
      ),
      height: size.height / 8,
      alignment: Alignment.center,
      child: Column(
        mainAxisAlignment: MainAxisAlignment.end,
        children: [
          Text(
            errorMessage,
            style: CustomTextStyle.heading3,
          ),
          CupertinoButton(
              child: const Text('OK'),
              
              onPressed: () {
                if (close != null) {
                  close!();
                }
                Navigator.of(context).pop();
              })
        ],
      ),
    );
  }
}
