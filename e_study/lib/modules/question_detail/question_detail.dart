import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/widgets/stateful/inbox_dot.dart';
import 'package:e_study/widgets/stateless/circle_avatar.dart';
import 'package:e_study/widgets/stateless/inbox_item.dart';
import 'package:e_study/widgets/stateless/status_dot.dart';
import 'package:flutter/material.dart';

class QuestionDetailScreen extends StatelessWidget {
  const QuestionDetailScreen({Key? key}) : super(key: key);

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
        title: const Text(
          'Chi tiết câu hỏi',
          style: CustomTextStyle.heading1,
        ),
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
                  'Câu 1: Hello World',
                  style: CustomTextStyle.heading1,
                ),
                const SizedBox(height: 15.0),
                const Text(
                  'Chọn 1 đáp án dưới đây',
                  style: CustomTextStyle.heading3,
                ),
                const SizedBox(height: 35.0),
              ],
            )),
            session(Column(
              children: [
                sessionTitle('Sample answers A'),
                const Text(
                  'A: Hello World A',
                  style: CustomTextStyle.heading2,
                ),
                const SizedBox(height: 35.0),
              ],
            )),
            session(Column(
              children: [
                sessionTitle('Sample answers B'),
                const Text(
                  'B: Hello World B',
                  style: CustomTextStyle.heading2,
                ),
                const SizedBox(height: 35.0),
              ],
            )),
            session(Column(
              children: [
                sessionTitle('Sample answers C'),
                const Text(
                  'C: Hello World C',
                  style: CustomTextStyle.heading2,
                ),
                const SizedBox(height: 35.0),
              ],
            )),
            session(Column(
              children: [
                sessionTitle('Sample answers D'),
                const Text(
                  'D: Hello World D',
                  style: CustomTextStyle.heading2,
                ),
                const SizedBox(height: 35.0),
              ],
            )),
          ],
        ),
      ),
    );
  }
}
