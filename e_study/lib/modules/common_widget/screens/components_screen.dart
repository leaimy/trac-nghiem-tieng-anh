import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/widgets/stateless/custom_input_field.dart';
import 'package:e_study/widgets/stateless/error_box.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';

import 'package:flutter/material.dart';

class ComponentsScreen extends StatelessWidget {
  const ComponentsScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    final TextEditingController input = TextEditingController();

    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Components Screen',
        ),
      ),
      body: SingleChildScrollView(
        padding:
            const EdgeInsets.symmetric(horizontal: AppConstants.regularPadding),
        child: Column(
          children: [
            BaseButton(
              size: size,
              content: "Base Button",
              onTap: () {},
              isDisable: true,
            ),
            ErrorBox(size: size, errorMessage: 'ErrorBox'),
            CustomInputField(
              content: 'Custom Input Field',
              description: 'Custom Input Field',
              controller: input,
              size: size,
            )
          ],
        ),
      ),
    );
  }
}
