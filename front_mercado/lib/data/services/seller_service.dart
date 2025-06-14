import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/seller_model.dart';

class SellerService {
  static const String apiUrl = "http://10.0.2.2:8000/api/vendors";

  Future<List<SellerModel>> fetchSellers() async {
    final response = await http.get(Uri.parse(apiUrl));
    if (response.statusCode == 200) {
      final List<dynamic> jsonList = jsonDecode(response.body);
      return jsonList.map((e) => SellerModel.fromJson(e)).toList();
    } else {
      throw Exception('Erro ao carregar vendedores');
    }
  }

  Future<bool> createSeller({
    required String name,
    required String email,
    required String phone,
    required String foodType,
    required String description,
    required bool hasCnpj,
    String? cnpj,
    required bool active,
  }) async {
    final response = await http.post(
      Uri.parse(apiUrl),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        "name": name,
        "email": email,
        "phone": phone,
        "food_type": foodType,
        "description": description,
        "has_cnpj": hasCnpj,
        "cnpj": cnpj,
        "active": active,
      }),
    );
    return response.statusCode == 201 || response.statusCode == 200;
  }

  Future<bool> editSeller({
    required int id,
    required String name,
    required String email,
    required String phone,
    required String foodType,
    required String description,
    required bool hasCnpj,
    String? cnpj,
    required bool active,
  }) async {
    final response = await http.put(
      Uri.parse('$apiUrl/$id'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        "name": name,
        "email": email,
        "phone": phone,
        "food_type": foodType,
        "description": description,
        "has_cnpj": hasCnpj,
        "cnpj": cnpj,
        "active": active,
      }),
    );
    return response.statusCode == 200 || response.statusCode == 204;
  }

  Future<bool> deleteSeller(int id) async {
    final response = await http.delete(Uri.parse('$apiUrl/$id'));
    return response.statusCode == 204 || response.statusCode == 200;
  }
}
