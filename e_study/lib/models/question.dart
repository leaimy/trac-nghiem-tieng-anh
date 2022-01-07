import 'package:e_study/models/answer.dart';
import 'package:json_annotation/json_annotation.dart';
part 'question.g.dart';

@JsonSerializable()
class Question {
  String id;
  @JsonKey(name: 'title', includeIfNull: false)
  String? content;
  List<Answer>? answers;
  Question(this.content, this.answers, this.id);
  factory Question.fromJson(Map<String, dynamic> json) => _$QuestionFromJson(json);
  Map<String, dynamic> toJson() => _$QuestionToJson(this);

}
