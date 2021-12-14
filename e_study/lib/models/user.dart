import 'package:e_study/models/location.dart';
import 'package:e_study/models/picture.dart';
import 'package:json_annotation/json_annotation.dart';

part 'user.g.dart';

enum Gender { male, female, other }

@JsonSerializable()
class User {
  final String gender;

  final Name name;

  final Location location;

  final String email;

  final Picture picture;

  User(this.gender, this.name, this.location, this.email, this.picture);

  factory User.fromJson(Map<String, dynamic> json) => _$UserFromJson(json);
  Map<String, dynamic> toJson() => _$UserToJson(this);
}

@JsonSerializable()
class Name {
  final String title;

  final String first;

  final String last;

  Name(this.title, this.first, this.last);

  factory Name.fromJson(Map<String, dynamic> json) => _$NameFromJson(json);

  Map<String, dynamic> toJson() => _$NameToJson(this);
}
