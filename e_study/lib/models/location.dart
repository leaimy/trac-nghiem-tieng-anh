import 'package:json_annotation/json_annotation.dart';
part 'location.g.dart';
@JsonSerializable()
class Location {
  final String street;

  final String city;

  final String state;

  Location(this.street, this.city, this.state);

  factory Location.fromJson(Map<String,dynamic> json) => _$LocationFromJson(json);

  Map<String, dynamic> toJson() => _$LocationToJson(this);

}
