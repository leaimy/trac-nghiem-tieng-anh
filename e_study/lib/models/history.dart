import 'package:json_annotation/json_annotation.dart';
part 'history.g.dart';

@JsonSerializable()
class History {
  String? title;
  int? trueNum;
  int? falseNum;

  History({this.title, this.trueNum, this.falseNum});
  factory History.fromJson(Map<String, dynamic> json) =>
      _$HistoryFromJson(json);
  Map<String, dynamic> toJson() => _$HistoryToJson(this);
}
