import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/widgets/stateful/answer_button.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';

import 'practice_screen_model.dart';

class PracticeScreen extends StatefulWidget {
  const PracticeScreen({Key? key}) : super(key: key);

  @override
  State<PracticeScreen> createState() => _PracticeScreenState();
}

class _PracticeScreenState extends State<PracticeScreen> {
  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return ChangeNotifierProvider(
      create: (_) => PracticeScreenModel(),
      builder: (context, child) {
        return Consumer<PracticeScreenModel>(
          builder: (context, model, child) {
            model.initGeneralStatus();
            return Scaffold(
              body: SafeArea(
                child: Column(
                  children: [
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 24.0),
                      child: SizedBox(
                        height: size.height / 24,
                        child: Row(
                          children: [
                            const FaIcon(
                              FontAwesomeIcons.checkCircle,
                              color: LightTheme.green,
                            ),
                            buildWidthSpace(),
                            Text(
                              '${model.numberOfTrue}',
                              style: CustomTextStyle.heading2,
                            ),
                            const SizedBox(width: 16),
                            const FaIcon(
                              FontAwesomeIcons.timesCircle,
                              color: LightTheme.red,
                            ),
                            buildWidthSpace(),
                            Text(
                              '${model.numberOfFalse}',
                              style: CustomTextStyle.heading2,
                            ),
                            Expanded(child: Container()),
                            model.currentIndex + 1 != model.questionQuantity
                                ? InkWell(
                                    onTap: () {
                                      showQuitWarning(context, size, model);
                                    },
                                    child: const FaIcon(
                                      FontAwesomeIcons.signOutAlt,
                                      color: LightTheme.darkBlue,
                                    ),
                                  )
                                : GestureDetector(
                                    onTap: () {
                                      model.setResultData();
                                      Navigator.pushNamedAndRemoveUntil(
                                          context,
                                          Routes.resultScreen,
                                          (Route<dynamic> route) => false);
                                    },
                                    child: Container(
                                      width: size.width / 4,
                                      height: size.height / 24,
                                      alignment: Alignment.center,
                                      decoration: BoxDecoration(
                                          color: LightTheme.darkBlue,
                                          borderRadius:
                                              BorderRadius.circular(22)),
                                      child: const Text(
                                        'Kết thúc',
                                        style: CustomTextStyle.heading4White,
                                      ),
                                    ),
                                  )
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(height: 16),
                    Expanded(
                      child: PageView.builder(
                        controller: model.pageController,
                        onPageChanged: (index) {
                          model.setCurrentIndex(index);
                        },
                        itemCount: model.questionQuantity,
                        itemBuilder: (_, index) => Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          children: [
                            Padding(
                              padding: const EdgeInsets.only(left: 24.0),
                              child: Text(
                                'Question ${index + 1}',
                                style: CustomTextStyle.heading2,
                              ),
                            ),
                            Expanded(
                              child: Padding(
                                padding: const EdgeInsets.symmetric(
                                    horizontal: 24.0),
                                child: Text(
                                  '${model.questions[index].content}',
                                  style: CustomTextStyle.heading3,
                                ),
                              ),
                            ),
                            Padding(
                              padding:
                                  const EdgeInsets.symmetric(horizontal: 24.0),
                              child: Column(
                                children: model.questions[index].answers!
                                    .asMap()
                                    .entries
                                    .map((e) => AnswerButton(
                                          content:
                                              e.value.content ?? "Undefined",
                                          size: size,
                                          isActive: model.isActive,
                                          status: model.generalStatus[
                                              model.currentIndex][e.key],
                                          onTap: () {
                                            model.checkAnswer(e.value, e.key,
                                                model.questions[index]);
                                          },
                                        ))
                                    .toList(),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        );
      },
    );
  }

  Future<void> showQuitWarning(
      BuildContext context, Size size, PracticeScreenModel model) {
    return showCupertinoModalPopup(
      context: context,
      builder: (_) => Center(
          child: Container(
        height: size.height / 4,
        margin: const EdgeInsets.symmetric(horizontal: 24),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(22),
          color: LightTheme.white,
        ),
        alignment: Alignment.center,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.end,
          children: [
            const Expanded(
              child: Center(
                child: Text(
                  'Bạn muốn kết thúc bài trắc nghiệm ?',
                  style: CustomTextStyle.heading3,
                ),
              ),
            ),
            Expanded(
                child: Row(
              children: [
                Expanded(
                  child: Material(
                    color: LightTheme.white,
                    borderRadius: BorderRadius.circular(20),
                    child: GestureDetector(
                      onTap: () {
                        model.showOption('Yes');
                        Navigator.pop(context);
                        model.setResultData();
                        Navigator.pushNamed(context, Routes.resultScreen);
                      },
                      child: const Center(
                        child: Text(
                          'Có',
                          style: CustomTextStyle.heading3,
                        ),
                      ),
                    ),
                  ),
                ),
                Expanded(
                  child: Material(
                    color: LightTheme.white,
                    borderRadius: BorderRadius.circular(20),
                    child: GestureDetector(
                      onTap: () {
                        model.showOption('No');
                        Navigator.pop(context);
                      },
                      child: Container(
                        margin: const EdgeInsets.all(24),
                        alignment: Alignment.center,
                        decoration: BoxDecoration(
                            border: Border.all(color: LightTheme.black),
                            borderRadius: BorderRadius.circular(20)),
                        child: const Text(
                          'Không',
                          style: CustomTextStyle.heading3,
                        ),
                      ),
                    ),
                  ),
                ),
              ],
            ))
          ],
        ),
      )),
    );
  }

  SizedBox buildWidthSpace() => const SizedBox(width: 8);
}
