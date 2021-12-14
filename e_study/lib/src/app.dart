import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';

import 'package:flutter/material.dart';
import 'package:flutter_gen/gen_l10n/app_localizations.dart';
import 'package:flutter_localizations/flutter_localizations.dart';

import 'settings/settings_controller.dart';

import 'package:e_study/config/routes/router.dart' as router;

class MyApp extends StatelessWidget {
  const MyApp({
    Key? key,
    required this.settingsController,
  }) : super(key: key);

  final SettingsController settingsController;

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: settingsController,
      builder: (BuildContext context, Widget? child) {
        return MaterialApp(
            debugShowCheckedModeBanner: false,
            restorationScopeId: 'app',
            localizationsDelegates: const [
              AppLocalizations.delegate,
              GlobalMaterialLocalizations.delegate,
              GlobalWidgetsLocalizations.delegate,
              GlobalCupertinoLocalizations.delegate,
            ],
            supportedLocales: const [
              Locale('en', ''),
            ],
            onGenerateTitle: (BuildContext context) =>
                AppLocalizations.of(context)!.appTitle,
            theme: ThemeData(
                primaryColor: LightTheme.darkGreen,
                scaffoldBackgroundColor: LightTheme.white,
                appBarTheme: const AppBarTheme(
                    titleTextStyle: CustomTextStyle.heading3,
                    color: LightTheme.white,
                    elevation: 0,
                    iconTheme: IconThemeData(color: LightTheme.black)),
                fontFamily: 'avenirnext'),
            darkTheme: ThemeData.dark(),
            themeMode: settingsController.themeMode,
            initialRoute: Routes.commonWidgetScreen,
            onGenerateRoute: router.Router.generateRoute);
      },
    );
  }
}
