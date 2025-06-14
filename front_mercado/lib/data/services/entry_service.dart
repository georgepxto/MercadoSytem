import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/entry_model.dart';

class EntryService {
  static const String apiUrl = "http://10.0.2.2:8000/api/entries";

  // Buscar todos os check-ins (ativos e históricos)
  Future<List<EntryModel>> fetchEntries() async {
    final response = await http.get(Uri.parse(apiUrl));
    if (response.statusCode == 200) {
      final decoded = jsonDecode(response.body);
      if (decoded is List) {
        return decoded.map((e) => EntryModel.fromJson(e)).toList();
      } else if (decoded is Map && decoded.containsKey('data')) {
        return (decoded['data'] as List)
            .map((e) => EntryModel.fromJson(e))
            .toList();
      } else {
        throw Exception('Formato inesperado ao carregar check-ins');
      }
    } else {
      throw Exception('Erro ao carregar check-ins');
    }
  }

  // Criar novo check-in
  Future<bool> createEntry({
    required int sellerId,
    required int boxId,
    String? observations,
  }) async {
    final response = await http.post(
      Uri.parse(apiUrl),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        "vendor_id": sellerId,
        "box_id": boxId,
        if (observations != null && observations.isNotEmpty)
          "notes": observations,
      }),
    );
    return response.statusCode == 201 || response.statusCode == 200;
  }

  Future<bool> checkout(int checkinId) async {
    final response = await http.put(
      Uri.parse("$apiUrl/$checkinId/checkout"),
      headers: {'Content-Type': 'application/json'},
    );
    return response.statusCode == 200 || response.statusCode == 204;
  }
}
