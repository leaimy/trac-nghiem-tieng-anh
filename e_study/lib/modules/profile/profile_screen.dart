import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/constants/assets_path.dart';
import 'package:e_study/shared/services/restart_helper.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({Key? key}) : super(key: key);

  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  late Future<String> _fullname;
  final Future<SharedPreferences> _prefs = SharedPreferences.getInstance();

  @override
  void initState() {
    super.initState();
    _fullname = _prefs.then((SharedPreferences prefs) {
      return prefs.getString('fullname') ?? "Undefined";
    });
  }

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
                  color: Colors.orange,
                  width: size.height / 8,
                  height: size.height / 8,
                  child: Image.asset(
                    AssetPath.img_2,
                    fit: BoxFit.cover,
                  ),
                ),
              ),
            ),
            const SizedBox(
              height: 16,
            ),
            FutureBuilder<String>(
                future: _fullname,
                builder:
                    (BuildContext context, AsyncSnapshot<String> snapshot) {
                  return Text(
                    '${snapshot.data}',
                  );
                }),
            const SizedBox(
              height: 16,
            ),
            BaseButton(
              content: 'Lịch sử',
              size: size,
              onTap: () {
                Navigator.pushNamed(context, Routes.historyScreen);
              },
            ),
            BaseButton(
              content: 'Về chúng tôi',
              size: size,
              onTap: () {
                Navigator.pushNamed(context, Routes.aboutUsScreen);
              },
            ),
            Expanded(
              child: Container(),
            ),
            GestureDetector(
              onTap: () {
                RestartApp.restartApp(context);
              },
              child: Container(
                width: size.width,
                height: size.height / 16,
                alignment: Alignment.center,
                child: const Text(
                  'Đăng Xuất',
                  style: CustomTextStyle.heading3,
                ),
              ),
            )
          ],
        ),
      ),
    );
  }
}
