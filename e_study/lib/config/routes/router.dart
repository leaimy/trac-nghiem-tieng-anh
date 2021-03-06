import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/modules/common_widget/screens/common_widget_screen.dart';
import 'package:e_study/modules/common_widget/screens/components_screen.dart';
import 'package:e_study/modules/common_widget/screens/screens_list.dart';
import 'package:e_study/modules/home/home_screen.dart';
import 'package:e_study/modules/question%20pack/list_question_pack_screen.dart';
import 'package:e_study/modules/question_detail/question_detail.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class Router {
  static Route<dynamic>? generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case Routes.commonWidgetScreen:
        {
          return MaterialPageRoute(builder: (_) => const CommonWidgetScreen());
        }
      case Routes.componentsScreen:
        {
          return MaterialPageRoute(builder: (_) => const ComponentsScreen());
        }
      case Routes.screensList:
        {
          return MaterialPageRoute(builder: (_) => const ScreensList());
        }
      case Routes.homeScreen:
        {
          return MaterialPageRoute(builder: (_) => const HomeScreen());
        }
      case Routes.listQuestionPackScreen:
        {
          return MaterialPageRoute(
              builder: (_) => const ListQuestionPackScreen());
        }
      case Routes.questionDetailScreen:
        {
          return MaterialPageRoute(
              builder: (_) => const QuestionDetailScreen());
        }
      default:
        {
          return MaterialPageRoute(
              builder: (_) => Scaffold(
                    body: Center(
                        child: Text('No route defined for ${settings.name}')),
                  ));
        }
    }
  }
}
