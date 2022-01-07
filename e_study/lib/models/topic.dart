import 'package:e_study/models/quiz.dart';
import 'package:json_annotation/json_annotation.dart';

part 'topic.g.dart';

@JsonSerializable()
class Topic {
  final String id;
  final String title;
  final String description;
  @JsonKey(name: 'created_at', includeIfNull: false)
  DateTime? createdAt;
  List<Quiz>? quizzes;

  Topic(this.id, this.title, this.description, this.createdAt,this.quizzes);

  factory Topic.fromJson(Map<String, dynamic> json) => _$TopicFromJson(json);
  Map<String, dynamic> toJson() => _$TopicToJson(this);

}
