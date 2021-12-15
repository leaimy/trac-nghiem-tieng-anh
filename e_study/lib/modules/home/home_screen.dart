import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:flutter/material.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(
        title: const Text('Bài trắc nghiệm'),
      ),
      body: ListView.builder(
          padding: const EdgeInsets.symmetric(horizontal: 24),
          itemCount: 10,
          itemBuilder: (context, index) {
            return Padding(
              padding: const EdgeInsets.only(bottom: 16.0),
              child: InkWell(
                onTap: () {
                  Navigator.pushNamed(context, Routes.listQuestionPackScreen);
                },
                child: Container(
                  height: size.height / 8,
                  decoration: BoxDecoration(
                      color: LightTheme.lightBlue,
                      borderRadius: BorderRadius.circular(22)),
                  alignment: Alignment.center,
                  child: Text('Trắc nghiệm ${index + 1}'),
                ),
              ),
            );
          }),
    );
  }
}
