// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'history.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

History _$HistoryFromJson(Map<String, dynamic> json) => History(
      title: json['title'] as String?,
      trueNum: json['trueNum'] as int?,
      falseNum: json['falseNum'] as int?,
    );

Map<String, dynamic> _$HistoryToJson(History instance) => <String, dynamic>{
      'title': instance.title,
      'trueNum': instance.trueNum,
      'falseNum': instance.falseNum,
    };
