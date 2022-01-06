import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/material.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({Key? key}) : super(key: key);

  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            Center(
              child: ClipOval(
                child: Container(
                  width: size.height / 8,
                  height: size.height / 8,
                  color: Colors.orange,
                ),
              ),
            ),
            const SizedBox(
              height: 16,
            ),
            const Text(
              'Quang Nguyễn',
              style: CustomTextStyle.heading2,
            ),
            const SizedBox(
              height: 16,
            ),
            BaseButton(
              content: 'Lịch sử',
              size: size,
            ),
            BaseButton(
              content: 'Về chúng tôi',
              size: size,
            ),
            BaseButton(
              content: 'Liên hệ',
              size: size,
              onTap: () {},
            ),
          ],
        ),
      ),
    );
  }
}
