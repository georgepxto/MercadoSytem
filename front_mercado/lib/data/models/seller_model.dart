import 'schedule_model.dart';
import 'entry_model.dart';

class SellerModel {
  final int id;
  final String name;
  final String email;
  final String phone;
  final String foodType;
  final String description;
  final bool hasCnpj;
  final String? cnpj;
  final bool active;
  final List<ScheduleModel> schedules;
  final List<EntryModel> entries;

  SellerModel({
    required this.id,
    required this.name,
    required this.email,
    required this.phone,
    required this.foodType,
    required this.description,
    required this.hasCnpj,
    this.cnpj,
    required this.active,
    this.schedules = const [],
    this.entries = const [],
  });

  factory SellerModel.fromJson(Map<String, dynamic> json) {
    final checkinsRaw = json['entries'] ?? json['checkins'] ?? [];
    final schedulesRaw = json['schedules'] ?? [];
    return SellerModel(
      id: json['id'],
      name: json['name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'] ?? '',
      foodType: json['food_type'] ?? '',
      description: json['description'] ?? '',
      hasCnpj: json['has_cnpj'] ?? false,
      cnpj: json['cnpj'],
      active: json['active'] ?? false,
      schedules: (schedulesRaw as List<dynamic>)
          .map((s) => ScheduleModel.fromJson(s))
          .toList(),
      entries: (checkinsRaw as List<dynamic>)
          .map((c) => EntryModel.fromJson(c))
          .toList(),
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'name': name,
    'email': email,
    'phone': phone,
    'food_type': foodType,
    'description': description,
    'has_cnpj': hasCnpj,
    'cnpj': cnpj,
    'active': active,
    'schedules': schedules.map((s) => s.toJson()).toList(),
    'entries': entries.map((c) => c.toJson()).toList(),
  };
}