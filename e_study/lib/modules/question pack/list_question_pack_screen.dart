import 'package:e_study/config/themes/themes.dart';
import 'package:flutter/material.dart';

class ListQuestionPackScreen extends StatelessWidget {
  const ListQuestionPackScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(
        title: Text('Question Pack'),
      ),
      body: ListView.builder(
          padding: const EdgeInsets.symmetric(horizontal: 24),
          itemCount: 10,
          itemBuilder: (context, index) {
            return Padding(
              padding: const EdgeInsets.only(bottom: 16.0),
              child: InkWell(
                onTap: () {},
                child: Container(
                  height: size.height / 8,
                  decoration: BoxDecoration(
                      color: LightTheme.lightBlue,
                      borderRadius: BorderRadius.circular(22)),
                  alignment: Alignment.center,
                  child: Text('Pack ${index + 1}'),
                ),
              ),
            );
          }),
    );
  }
}
