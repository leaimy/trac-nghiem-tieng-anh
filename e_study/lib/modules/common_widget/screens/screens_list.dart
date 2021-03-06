import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/modules/common_widget/widgets/common_widget_button.dart';
import 'package:flutter/material.dart';

class ScreensList extends StatelessWidget {
  const ScreensList({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;

    final List<String> screens = [Routes.homeScreen];

    return Scaffold(
      appBar: AppBar(
        title: const Text('Screens List'),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.symmetric(
              horizontal: AppConstants.regularPadding),
          child: Column(
              children: screens
                  .map((e) => Builder(
                      builder: (context) => CommonWidgetButton(
                          content: e,
                          onTap: () {
                            Navigator.pushNamed(context, e);
                          },
                          size: size)))
                  .toList()),
        ),
      ),
    );
  }
}
