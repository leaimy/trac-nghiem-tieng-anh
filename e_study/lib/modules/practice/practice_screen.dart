import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
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
  List<String> answers = ['01', '02', '03', '04'];

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return ChangeNotifierProvider(
      create: (_) => PracticeScreenModel(),
      builder: (context, child) {
        return Consumer<PracticeScreenModel>(builder: (context, model, child) {
          return Scaffold(
            body: SafeArea(
              child: Column(
                children: [
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 24.0),
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
                        InkWell(
                          onTap: () {
                            showQuitWarning(context, size, model);
                          },
                          child: const FaIcon(
                            FontAwesomeIcons.signOutAlt,
                            color: LightTheme.darkBlue,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 16),
                  Expanded(
                      child: PageView.builder(
                          controller: model.pageController,
                          onPageChanged: (index) {
                            model.setCurrentIndex(index);
                          },
                          itemCount: 10,
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
                                  const Expanded(
                                    child: Padding(
                                      padding: EdgeInsets.symmetric(
                                          horizontal: 24.0),
                                      child: Text(
                                        'Question Content',
                                        style: CustomTextStyle.heading3,
                                      ),
                                    ),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.symmetric(
                                        horizontal: 24.0),
                                    child: Column(
                                        children: answers
                                            .map((e) => BaseButton(
                                                size: size, content: e))
                                            .toList()),
                                  ),
                                ],
                              ))),
                ],
              ),
            ),
          );
        });
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
                  'Bạn muốn dừng việc ôn tập ?',
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
