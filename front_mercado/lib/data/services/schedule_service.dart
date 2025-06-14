import '../models/schedule_model.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class ScheduleService {
  final String baseUrl = 'http://10.0.2.2:8000/api/schedules';

  Future<List<ScheduleModel>> fetchSchedules() async {
    final response = await http.get(Uri.parse(baseUrl));
    if (response.statusCode == 200) {
      final List<dynamic> data = json.decode(response.body);
      return data.map((json) => ScheduleModel.fromJson(json)).toList();
    } else {
      throw Exception('Erro ao buscar horários agendados');
    }
  }
}
