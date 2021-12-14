import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/widgets/stateful/inbox_dot.dart';
import 'package:e_study/widgets/stateless/circle_avatar.dart';
import 'package:e_study/widgets/stateless/inbox_item.dart';
import 'package:e_study/widgets/stateless/status_dot.dart';
import 'package:flutter/material.dart';

class ComponentsScreen extends StatelessWidget {
  const ComponentsScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;

    Widget session(Widget child) {
      return Padding(
        padding:
            const EdgeInsets.symmetric(vertical: AppConstants.regularPadding),
        child: Container(
            width: size.width,
            padding: const EdgeInsets.symmetric(
                vertical: AppConstants.regularPadding),
            decoration: BoxDecoration(
                color: DarkTheme.lighterPink,
                borderRadius:
                    BorderRadius.circular(AppConstants.regularRadius)),
            child: child),
      );
    }

    Widget sessionTitle(String content) {
      return Padding(
        padding: const EdgeInsets.only(bottom: AppConstants.regularPadding),
        child: Text(
          content,
          style: CustomTextStyle.heading2Bold
              .copyWith(color: DarkTheme.lighterPink),
        ),
      );
    }

    return Scaffold(
      appBar: AppBar(
        title: const Text('Components Screen',style: CustomTextStyle.heading1,),
      ),
      body: SingleChildScrollView(
        padding:
            const EdgeInsets.symmetric(horizontal: AppConstants.regularPadding),
        child: Column(
          children: [
            session(Column(
              children: [
                sessionTitle('All Typo'),
                const Text(
                  'Heading 1',
                  style: CustomTextStyle.heading1,
                ),
                const Text(
                  'Heading 1 Bold',
                  style: CustomTextStyle.heading1Bold,
                ),
                const Text(
                  'Heading 2',
                  style: CustomTextStyle.heading2,
                ),
                const Text(
                  'Heading 2',
                  style: CustomTextStyle.heading2Bold,
                ),
                const Text(
                  'Heading 3',
                  style: CustomTextStyle.heading3,
                ),
                const Text(
                  'Heading 3',
                  style: CustomTextStyle.heading3Bold,
                ),
              ],
            )),
            session(Column(
              children: [
                sessionTitle('Dots'),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceAround,
                  children: const [
                    StatusDot(),
                    InboxDot(
                      messageCounter: 10,
                    )
                  ],
                )
              ],
            )),
            session(Column(
              children: [
                sessionTitle('Avatar Item'),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: const [
                    CustomCircleAvatar(messageCounter: null, isActive: null),
                    CustomCircleAvatar(messageCounter: null, isActive: true),
                    CustomCircleAvatar(messageCounter: 9, isActive: true),
                    CustomCircleAvatar(messageCounter: 10, isActive: true),
                  ],
                ),
              ],
            )),
            session(Column(
              // children: [sessionTitle('Inbox Item'), InboxItem(size: size)],
            )),
          ],
        ),
      ),
    );
  }
}
