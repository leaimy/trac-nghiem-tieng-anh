import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/models/quiz.dart';
import 'package:e_study/shared/provider/log_provider.dart';
import 'package:e_study/shared/services/api/app_storage.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

class ListQuestionPackScreen extends StatelessWidget {
  const ListQuestionPackScreen({
    Key? key,
  }) : super(key: key);

  LogProvider get logger => const LogProvider('🛎 Question Pack');

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    final List<Quiz> listPack = AppStorage().selectedTopic!.quizzes!;

    logger.log(AppStorage().selectedTopic?.title ?? "");
    return Scaffold(
      appBar: AppBar(
        title: Text(
          AppStorage().selectedTopic?.title ?? "",
          style: CustomTextStyle.heading1Bold,
        ),
        leading: IconButton(
          icon: const FaIcon(FontAwesomeIcons.arrowLeft),
          onPressed: () {
            AppStorage().resetSelectedTopic();
            Navigator.pop(context);
          },
        ),
      ),
      body: AppStorage().selectedTopic!.quizzes!.isEmpty
          ? const Center(
              child: Text('Chưa có bộ câu hỏi'),
            )
          : ListView.builder(
              padding: const EdgeInsets.symmetric(horizontal: 24),
              itemCount: AppStorage().selectedTopic!.quizzes!.length,
              itemBuilder: (context, index) {
                return Padding(
                  padding: const EdgeInsets.only(bottom: 16.0),
                  child: InkWell(
                    onTap: () {
                      //set the selected pack
                      AppStorage().setSelectedQuestionPack(listPack[index]);
                      //print selected pack
                      logger.log(AppStorage().selectedQuestionPack?.title ??
                          "No Name");
                      Navigator.pushNamed(context, Routes.practiceScreen);
                    },
                    child: Container(
                      height: size.height / 8,
                      decoration: BoxDecoration(
                          color: LightTheme.lightBlue,
                          borderRadius: BorderRadius.circular(22)),
                      alignment: Alignment.center,
                      child: Text(
                          'Câu hỏi ${AppStorage().selectedTopic!.quizzes![index].title}'),
                    ),
                  ),
                );
              }),
    );
  }
}
