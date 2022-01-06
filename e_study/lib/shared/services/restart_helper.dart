import 'package:flutter/material.dart';

class RestartApp extends StatefulWidget {
  const RestartApp(Key? key, this.child) : super(key: key);
  final Widget child;
  static void restartApp(BuildContext context) {
    context.findAncestorStateOfType<_RestartAppState>()?.restartApp();
  }

  @override
  _RestartAppState createState() => _RestartAppState();
}

class _RestartAppState extends State<RestartApp> {
  Key key = UniqueKey();
  void restartApp() {
    setState(() {
      key = UniqueKey();
    });
  }

  @override
  Widget build(BuildContext context) {
    return KeyedSubtree(
      key: key,
      child: widget.child,
    );
  }
}
