import 'package:e_study/config/themes/text_theme.dart';
import 'package:flutter/material.dart';
import 'package:translator/translator.dart';

class TranslateScreen extends StatefulWidget {
  const TranslateScreen({Key? key}) : super(key: key);

  @override
  _TranslateScreenState createState() => _TranslateScreenState();
}

class _TranslateScreenState extends State<TranslateScreen> {
  TextEditingController input = TextEditingController();
  String? meaning;
  final translator = GoogleTranslator();
  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;

    return Scaffold(
      appBar: AppBar(
        title: Text(
          'Tra Cứu',
          style: CustomTextStyle.heading1Bold,
        ),
      ),
      body: Column(
        children: [
          Container(
            margin: const EdgeInsets.all(16),
            height: size.height / 16,
            padding: const EdgeInsets.all(8),
            width: size.width,
            decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(22), border: Border.all()),
            child: Row(
              children: [
                Expanded(
                  child: Container(
                    margin: const EdgeInsets.symmetric(horizontal: 8),
                    alignment: Alignment.center,
                    child: TextField(
                      decoration: const InputDecoration(
                          isDense: true,
                          border: InputBorder.none,
                          hintText: "Nhập từ Tiếng Anh bạn muốn tìm"),
                      controller: input,
                    ),
                  ),
                ),
                GestureDetector(
                  onTap: () async {
                    var output = await translator.translate(input.text,
                        from: 'en', to: 'vi');
                    setState(() {
                      meaning = output.toString();
                    });
                  },
                  child: const Icon(Icons.search),
                )
              ],
            ),
          ),
          Expanded(
              child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Container(
                padding: const EdgeInsets.all(16),
                width: size.width,
                decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all()),
                child: Text(meaning ?? "")),
          )),
        ],
      ),
    );
  }
}
