import 'package:e_study/modules/result/result_screen_model.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class ResultScreen extends StatefulWidget {
  const ResultScreen({Key? key}) : super(key: key);

  @override
  State<ResultScreen> createState() => _ResultScreenState();
}

class _ResultScreenState extends State<ResultScreen> {
  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => ResultScreenModel(),
      builder: (context, child) {
        return Consumer<ResultScreenModel>(builder: (context, model, child) {
          return const Scaffold();
        });
      },
    );
  }
}
