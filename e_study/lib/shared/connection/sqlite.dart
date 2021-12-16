// import 'package:sqflite/sqflite.dart';
// import 'package:sqflite/sqlite_api.dart';
// import 'package:stage_1/src/constants/app_data.dart';


// Database? _database;

// List<BaseRepository>tables = [
  
// ];


// Future<Database?> get database async {
//   if (_database != null) return _database;
//   _database = await initDatabase();
//   return _database;
// }

// Future<Database> initDatabase() async {
//   Database db = await openDatabase(
//       join(await getDatabasesPath(), appData.dbName),
//       version: 2);
//   await initTables(db);
//   return db;
// }

// Future<bool> initTables(db) async {
//   ///create table on init
//   for (var i = 0; i < tables.length; i++) {
//     List<FieldStructure> fields = tables[i].fields;
//     List<String> queryFields = [];
//     for (var j = 0; j < fields.length; j++) {
//       queryFields.add(
//           """${fields[j].fieldName} ${fields[j].type} ${(fields[j].isPrimary == true) ? 'PRIMARY KEY' : ''}""");
//     }
//     await db.execute(
//         """CREATE TABLE IF NOT EXISTS ${tables[i].tableName} (${queryFields.join(',')})""");
//   }
//   return true;
// }
