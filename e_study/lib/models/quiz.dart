// import 'package:e_study/models/question.dart';
import 'package:e_study/models/question.dart';
import 'package:json_annotation/json_annotation.dart';
part 'quiz.g.dart';

@JsonSerializable()
class Quiz {
  final String id;
  final String title;
  @JsonKey(name: 'question_quantity', includeIfNull: false)
  final String questionQuantity;
  final List<Question>? questions;

  Quiz(this.id, this.title, this.questionQuantity, this.questions);
  factory Quiz.fromJson(Map<String, dynamic> json) => _$QuizFromJson(json);
  Map<String, dynamic> toJson() => _$QuizToJson(this);

}
