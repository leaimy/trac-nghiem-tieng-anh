import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:flutter/material.dart';

import 'circle_avatar.dart';

class InboxItem extends StatelessWidget {
  const InboxItem({
    Key? key,
    required this.size,
  }) : super(key: key);

  final Size size;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: size.height / 8,
      color: DarkTheme.darkBackground,
      padding: const EdgeInsets.symmetric(vertical: AppConstants.regularPadding),
      child: Row(
        children: [
          const CustomCircleAvatar(
              messageCounter: 9, isActive: true),
          const SizedBox(
            width: AppConstants.regularPadding,
          ),
          Expanded(
              child: Column(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              Row(
                children: [
                  Expanded(
                      child: Container(
                    alignment: Alignment.centerLeft,
                    child: const Text('User Name',style: CustomTextStyle.heading1Bold,),
                  )),
                  Container(
                    alignment: Alignment.centerLeft,
                    child: Text('09:00PM',style: CustomTextStyle.heading3.copyWith(
                      color: DarkTheme.gray1
                    ),),
                  ),
                ],
              ),
              Container(
                alignment: Alignment.topLeft,
                child: const Text('Message Content',style: CustomTextStyle.heading2,),
              ),
            ],
          ))
        ],
      ),
    );
  }
}
