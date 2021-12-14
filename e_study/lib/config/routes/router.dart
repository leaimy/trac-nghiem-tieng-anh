import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class Router {
  static Route<dynamic>? generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case 'CommonWidgetScreen':
        {
          return MaterialPageRoute(builder: (_) => const Scaffold());
        }
      case 'MessageListPage':
        {
          return MaterialPageRoute(builder: (_) => const Scaffold());
        }
      case 'ComponentsScreen':
        {
          return MaterialPageRoute(builder: (_) => const Scaffold());
        }
      case 'ScreensList':
        {
          return MaterialPageRoute(builder: (_) => const Scaffold());
        }
      case 'MessageScreen':
        {
          return MaterialPageRoute(builder: (_) => const Scaffold());
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
