import 'package:json_annotation/json_annotation.dart';
part 'answer.g.dart';

@JsonSerializable()
class Answer {
  bool? isTrue;
  String? content;

  Answer({this.content, this.isTrue});
  factory Answer.fromJson(Map<String, dynamic> json) => _$AnswerFromJson(json);
}
