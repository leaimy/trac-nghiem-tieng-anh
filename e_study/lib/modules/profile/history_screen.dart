import 'dart:convert';

import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/config/themes/themes.dart';
import 'package:e_study/models/history.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:shared_preferences/shared_preferences.dart';

class HistoryScreen extends StatefulWidget {
  const HistoryScreen({Key? key}) : super(key: key);

  @override
  State<HistoryScreen> createState() => _HistoryScreenState();
}

class _HistoryScreenState extends State<HistoryScreen> {
  final Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
  final List<History> _data = [];
  late Future<List<String>> _dataPrefs;

  @override
  void initState() {
    super.initState();
    _dataPrefs = _prefs.then((SharedPreferences prefs) {
      return prefs.getStringList('historyData') ?? [];
    });
  }

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Lịch Sử',
          style: CustomTextStyle.heading1Bold,
        ),
      ),
      body: FutureBuilder<List<String>>(
          future: _dataPrefs,
          builder: (BuildContext context, AsyncSnapshot snapshot) {
            switch (snapshot.connectionState) {
              case ConnectionState.waiting:
                return const CircularProgressIndicator();
              default:
                if (snapshot.hasError) {
                  return Text('Error: ${snapshot.error}');
                } else {
                  for (String item in snapshot.data) {
                    var dataDecode = json.decode(item);
                    _data.add(History.fromJson(dataDecode));
                  }
                  // print(_data);
                  return _data.isEmpty
                      ? const Center(
                          child: Text("Không có dữ liệu"),
                        )
                      : ListView.builder(

                          itemCount: _data.length,
                          itemBuilder: (context, index) {
                            print("hello $index");
                            return Padding(
                              padding: const EdgeInsets.symmetric(
                                  vertical: 16, horizontal: 24),
                              child: Container(
                                alignment: Alignment.center,
                                height: size.height / 8,
                                decoration: BoxDecoration(
                                    color: LightTheme.lightBlue,
                                    borderRadius: BorderRadius.circular(22)),
                                child: Column(
                                  children: [
                                    Expanded(
                                        child: Center(
                                      child: Text(
                                        '${_data[index].title}',
                                        style: CustomTextStyle.heading3,
                                      ),
                                    )),
                                    Expanded(
                                      child: Row(
                                        children: [
                                          const Expanded(
                                              flex: 2,
                                              child: Center(
                                                child: FaIcon(
                                                  FontAwesomeIcons.checkCircle,
                                                  color: LightTheme.green,
                                                ),
                                              )),
                                          Expanded(
                                              child: Text(
                                            '${_data[index].trueNum}',
                                            style: CustomTextStyle
                                                .heading3BlueBold,
                                          )),
                                          const Expanded(
                                              flex: 2,
                                              child: Center(
                                                child: FaIcon(
                                                  FontAwesomeIcons.timesCircle,
                                                  color: LightTheme.red,
                                                ),
                                              )),
                                          Expanded(
                                              child: Text(
                                            '${_data[index].falseNum}',
                                            style: CustomTextStyle
                                                .heading3BlueBold,
                                          )),
                                        ],
                                      ),
                                    )
                                  ],
                                ),
                              ),
                            );
                          });
                }
            }
          }),
    );
  }
}
