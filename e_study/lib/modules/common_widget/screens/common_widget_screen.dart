import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/material.dart';

class CommonWidgetScreen extends StatelessWidget {
  const CommonWidgetScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;

    return Scaffold(
      appBar: AppBar(
        title: const Text('Common Widget Screen'),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.symmetric(
              horizontal: AppConstants.regularPadding),
          child: Column(
            children: [
              BaseButton(
                  size: size,
                  content: 'Components',
                  onTap: () {
                    Navigator.pushNamed(context, Routes.componentsScreen);
                  }),
              BaseButton(
                  size: size,
                  content: 'Screens',
                  onTap: () {
                    Navigator.pushNamed(context, Routes.screensList);
                  }),
            ],
          ),
        ),
      ),
    );
  }
}
