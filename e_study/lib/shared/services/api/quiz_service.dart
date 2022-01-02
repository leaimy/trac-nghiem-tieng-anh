import 'package:e_study/shared/provider/api_provider.dart';
import 'package:e_study/shared/provider/log_provider.dart';

class QuizService {
  String endpoint = 'auth';

  final _apiProvider = ApiProvider();

  LogProvider get logger => const LogProvider('🛎 Response');

  Future<dynamic> getTopic() async {
    try {
      final response = await _apiProvider.get('/quizzes');
      if (response.statusCode == 200) {
        logger.log('${response.data}');
        return response.data;
      }
    } catch (e) {
      rethrow;
    }
  }
}
