import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/material.dart';

class AboutUsSreen extends StatelessWidget {
  const AboutUsSreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          children: [
            BaseButton(
              content: 'Nguyễn Ngọc Quang - 1812832',
              size: size,
            ),
            const SizedBox(
              height: 16,
            ),
            BaseButton(
              content: 'Nguyễn Trọng Hiếu - 1812756',
              size: size,
            ),
            const SizedBox(
              height: 16,
            ),
            BaseButton(
              content: 'Nguyễn Thị Hà - 1812751',
              size: size,
            ),
          ],
        ),
      ),
    );
  }
}
