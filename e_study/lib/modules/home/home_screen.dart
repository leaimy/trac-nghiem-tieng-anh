import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/modules/home/home_screen_model.dart';
import 'package:e_study/shared/services/api/app_storage.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Chủ đề',
          style: CustomTextStyle.heading1Bold,
        ),
        leading: Padding(
          padding: const EdgeInsets.only(left: 8.0),
          child: IconButton(
              onPressed: () {
                Navigator.pushNamed(context, Routes.translateScreen);
              },
              icon: const FaIcon(FontAwesomeIcons.search)),
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 8.0),
            child: IconButton(
                onPressed: () {
                  Navigator.pushNamed(context, Routes.profileScreen);
                },
                icon: const FaIcon(FontAwesomeIcons.userGraduate)),
          )
        ],
      ),
      body: ChangeNotifierProvider<HomeScreenModel>(
        create: (_) => HomeScreenModel(),
        builder: (context, child) {
          return Consumer<HomeScreenModel>(builder: (context, model, child) {
            if (model.topicData.isEmpty) {
              model.getHomeData();
            }
            return model.topicData.isEmpty
                ? const Center(child: CircularProgressIndicator())
                : ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 24),
                    itemCount: model.topicData.length,
                    itemBuilder: (context, index) {
                      final date = DateFormat.yMd()
                          .format(model.topicData[index].createdAt!);
                      return Padding(
                        padding: const EdgeInsets.only(bottom: 16.0),
                        child: InkWell(
                          onTap: () {
                            AppStorage()
                                .setSelectedTopic(model.topicData[index]);
                            Navigator.pushNamed(
                              context,
                              Routes.listQuestionPackScreen,
                            );
                          },
                          child: Container(
                              height: size.height / 8,
                              decoration: BoxDecoration(
                                  color: LightTheme.lightBlue,
                                  borderRadius: BorderRadius.circular(22)),
                              child: Row(
                                children: [
                                  Container(
                                    width: size.height / 8,
                                    alignment: Alignment.center,
                                    child: const Icon(Icons.photo),
                                  ),
                                  Column(
                                    mainAxisAlignment:
                                        MainAxisAlignment.spaceEvenly,
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Text(
                                        model.topicData[index].title,
                                        style: CustomTextStyle.heading2Bold,
                                      ),
                                      Text(
                                        date,
                                        style: CustomTextStyle.heading4,
                                      ),
                                    ],
                                  )
                                ],
                              )),
                        ),
                      );
                    });
          });
        },
      ),
    );
  }

  void onLoadingStatus() {
    showCupertinoModalPopup(
        context: context,
        builder: (_) {
          return const Center(child: CircularProgressIndicator());
        });
  }
}
