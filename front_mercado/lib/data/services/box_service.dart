import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/box_model.dart';

class BoxService {
  static const String _baseUrl = "http://10.0.2.2:8000/api";
  static const String _boxesEndpoint = "$_baseUrl/boxes";
  static const String _schedulesEndpoint = "$_baseUrl/schedules";

  // Buscar todas as boxes (JSON)
  Future<List<dynamic>> _fetchBoxesJsonList({bool? onlyAvailable}) async {
    var url = _boxesEndpoint;
    if (onlyAvailable == true) {
      url += "?available=1";
    }
    final response = await http.get(Uri.parse(url));
    if (response.statusCode == 200) {
      return jsonDecode(response.body) as List<dynamic>;
    } else {
      throw Exception('Erro ao carregar boxes');
    }
  }

  // Buscar todas as boxes (Model)
  Future<List<BoxModel>> fetchBoxes() async {
    final jsonList = await _fetchBoxesJsonList();
    return jsonList.map((e) => BoxModel.fromJson(e)).toList();
  }

  // Buscar apenas boxes disponíveis (Model)
  Future<List<BoxModel>> fetchAvailableBoxes() async {
    final jsonList = await _fetchBoxesJsonList(onlyAvailable: true);
    return jsonList.map((e) => BoxModel.fromJson(e)).toList();
  }

  // Buscar a quantidade total de boxes
  Future<int> fetchBoxesCount() async {
    final jsonList = await _fetchBoxesJsonList();
    return jsonList.length;
  }

  // Criar nova box
  Future<bool> createBox({
    required String number,
    required String location,
    required String monthlyPrice,
    required String description,
    required bool available,
  }) async {
    final response = await http.post(
      Uri.parse(_boxesEndpoint),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        "number": number,
        "location": location,
        "monthly_price": monthlyPrice,
        "description": description,
        "available": available,
      }),
    );
    return response.statusCode == 201 || response.statusCode == 200;
  }

  // Atualizar box existente
  Future<bool> editBox({
    required int id,
    required String number,
    required String location,
    required String monthlyPrice,
    required String description,
    required bool available,
  }) async {
    final response = await http.put(
      Uri.parse('$_boxesEndpoint/$id'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        "number": number,
        "location": location,
        "monthly_price": monthlyPrice,
        "description": description,
        "available": available,
      }),
    );
    return response.statusCode == 200 || response.statusCode == 204;
  }

  // Excluir box. Retorna null se sucesso, ou mensagem de erro do backend se falhar.
  Future<String?> deleteBox(int id) async {
    final response = await http.delete(Uri.parse('$_boxesEndpoint/$id'));
    if (response.statusCode == 204 || response.statusCode == 200) {
      return null;
    }
    try {
      final json = jsonDecode(response.body);
      if (json is Map && json['error'] != null) {
        return json['error'];
      }
    } catch (_) {}
    return 'Erro ao excluir box.';
  }

  // Excluir agendamento (schedule) de box por id. Retorna null se sucesso, ou mensagem de erro do backend se falhar.
  Future<String?> deleteSchedule(int scheduleId) async {
    final response = await http.delete(
      Uri.parse('$_schedulesEndpoint/$scheduleId'),
    );
    if (response.statusCode == 204 || response.statusCode == 200) {
      return null;
    }
    try {
      final json = jsonDecode(response.body);
      if (json is Map && json['error'] != null) {
        return json['error'];
      }
    } catch (_) {}
    return 'Erro ao excluir agendamento.';
  }

  // Converter horário AM/PM para 24h ("HH:mm")
  String convertTo24HourFormat(String time) {
    try {
      final dateTime = DateTime.parse("2020-01-01 " + time);
      final hour = dateTime.hour.toString().padLeft(2, '0');
      final minute = dateTime.minute.toString().padLeft(2, '0');
      return "$hour:$minute";
    } catch (_) {
      return time;
    }
  }

  // Criar novo agendamento (schedule) para um box
  Future<bool> createSchedule({
    required int boxId,
    required int vendorId,
    required String dayOfWeek,
    required String startTime,
    required String endTime,
  }) async {
    final data = {
      "box_id": boxId,
      "vendor_id": vendorId,
      "day_of_week": dayOfWeek.toLowerCase(),
      "start_time": startTime,
      "end_time": endTime,
    };
    // print('JSON enviado para o backend: ${jsonEncode(data)}');
    final response = await http.post(
      Uri.parse(_schedulesEndpoint),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode(data),
    );
    // print('Status: ${response.statusCode}');
    // print('Resposta: ${response.body}');
    return response.statusCode == 201 || response.statusCode == 200;
  }
}
