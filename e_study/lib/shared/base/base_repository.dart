
// import 'package:sqflite/sqflite.dart';
// import 'package:stage_1/src/utils/connection/sqlite.dart';

// import 'base_model.dart';

// abstract class BaseRepository<T extends BaseModel> {
//   String tableName;
//   List<FieldStructure> fields;
//   T parseData(json);
//   BaseRepository();

//   Future<List<T>> gets() async {
//     final Database db = await database;
//     final List<Map<String, dynamic>> maps = await db.query(tableName);
//     List<T> newList = [];
//     for (var i = 0; i < maps.length; i++) {
//       newList.add(this.parseData(maps[i]));
//     }
//     return newList;
//   }

//   Future<List<T>> insertMany(List<T> instances) async {
//     final Database db = await database;
//     Batch batch = db.batch();
//     instances.forEach((instance) {
//       batch.insert(this.tableName, instance.toSqlData(),
//           conflictAlgorithm: ConflictAlgorithm.replace);
//     });
//     await batch.commit();
//     return instances;
//   }

//   Future<T> insert(T instance) async {
//     final Database db = await database;
//     Batch batch = db.batch();
//     batch.insert(this.tableName, instance.toSqlData(),
//         conflictAlgorithm: ConflictAlgorithm.replace);
//     batch.commit();
//     return instance;
//   }

//   Future<List<T>> findByIds(List<String> ids) async {
//     final Database db = await database;
//     List<T> instances = [];
//     dynamic queryInstances = await db.query(this.tableName,
//         where: 'id IN (${ids.map((_) => '?').join(', ')})', whereArgs: ids);

//     for (var i = 0; i < queryInstances.length; i++) {
//       instances.add(this.parseData(queryInstances[i]));
//     }
//     return instances;
//   }

//   Future<T> findById(id) async {
//     final Database db = await database;
//     dynamic data = await db
//         .query(this.tableName, where: 'id=(?)', limit: 1, whereArgs: [id]);
//     if (data.isEmpty == false) {
//       var row = data.first;
//       if (row != null) {
//         dynamic dataJson = Map<String, dynamic>.from(row);
//         return this.parseData(dataJson);
//       }
//     }
//     return null;
//   }

//   Future<bool> removeAll() async {
//     final Database db = await database;
//     await db.rawDelete('DELETE FROM ${this.tableName}');
//     return true;
//   }
// }

// class FieldStructure {
//   final String fieldName;
//   final String type;
//   bool isPrimary = false;
//   FieldStructure(this.fieldName, this.type, {this.isPrimary});
// }
