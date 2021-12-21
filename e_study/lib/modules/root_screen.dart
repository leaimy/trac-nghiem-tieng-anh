import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/modules/profile/profile_screen.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

import 'home/home_screen.dart';

class RootScreen extends StatefulWidget {
  const RootScreen({Key? key}) : super(key: key);

  @override
  _RootScreenState createState() => _RootScreenState();
}

class _RootScreenState extends State<RootScreen> {
  int _currentIndex = 0;

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: IndexedStack(
        index: _currentIndex,
        children: const [
          HomeScreen(),
          ProfileScreen(),
          ProfileScreen(),
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        backgroundColor: Colors.white,
        type: BottomNavigationBarType.fixed,
        elevation: 3,
        selectedItemColor: LightTheme.darkBlue,
        currentIndex: _currentIndex,
        onTap: (index) {
          setState(() {
            _currentIndex = index;
          });
        },
        items: const [
          BottomNavigationBarItem(
            icon: FaIcon(
              FontAwesomeIcons.swatchbook,
              size: 20,
            ),
            label: 'Trang Chủ',
          ),
          BottomNavigationBarItem(
            icon: FaIcon(
              FontAwesomeIcons.userGraduate,
              size: 20,
            ),
            label: 'Hồ sơ',
          ),
        ],
      ),
    );
  }
}
