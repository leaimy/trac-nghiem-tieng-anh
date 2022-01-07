import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/constants/assets_path.dart';
import 'package:e_study/modules/result/result_screen_model.dart';
import 'package:e_study/shared/services/api/app_storage.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class ResultScreen extends StatefulWidget {
  const ResultScreen({Key? key}) : super(key: key);

  @override
  State<ResultScreen> createState() => _ResultScreenState();
}

class _ResultScreenState extends State<ResultScreen> {
  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return ChangeNotifierProvider(
      create: (_) => ResultScreenModel(),
      builder: (context, child) {
        return Consumer<ResultScreenModel>(builder: (context, model, child) {
          return Scaffold(
              body: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: [
                Image.asset(
                  AssetPath.imgResult,
                  scale: 1.2,
                ),
                const Text(
                  'Cố gắng luyện tập nhé !',
                  style: CustomTextStyle.heading2,
                ),
                Text(
                  'Số câu đúng : ${AppStorage().currentResult?.trueNum ?? "null"}',
                  style: CustomTextStyle.heading3GreenBold,
                ),
                Text(
                  'Số câu sai : ${AppStorage().currentResult?.falseNum ?? "null"}',
                  style: CustomTextStyle.heading3RedBold,
                ),
                BaseButton(
                  content: 'Về Trang chủ',
                  size: size,
                  onTap: ()  async{
                    model.addCurrentResult();
                    await model.saveToPrefs();
                    Navigator.pushNamedAndRemoveUntil(
                        context, Routes.homeScreen, (route) => false);
                  },
                )
              ],
            ),
          ));
        });
      },
    );
  }
}
