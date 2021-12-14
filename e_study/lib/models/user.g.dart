// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'user.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

User _$UserFromJson(Map<String, dynamic> json) => User(
      json['gender'] as String,
      Name.fromJson(json['name'] as Map<String, dynamic>),
      Location.fromJson(json['location'] as Map<String, dynamic>),
      json['email'] as String,
      Picture.fromJson(json['picture'] as Map<String, dynamic>),
    );

Map<String, dynamic> _$UserToJson(User instance) => <String, dynamic>{
      'gender': instance.gender,
      'name': instance.name,
      'location': instance.location,
      'email': instance.email,
      'picture': instance.picture,
    };

Name _$NameFromJson(Map<String, dynamic> json) => Name(
      json['title'] as String,
      json['first'] as String,
      json['last'] as String,
    );

Map<String, dynamic> _$NameToJson(Name instance) => <String, dynamic>{
      'title': instance.title,
      'first': instance.first,
      'last': instance.last,
    };
