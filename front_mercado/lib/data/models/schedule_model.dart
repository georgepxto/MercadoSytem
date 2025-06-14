import 'seller_model.dart';

class ScheduleModel {
  final int id;
  final int sellerId;
  final int boxId;
  final String dayOfWeek;
  final String startTime;
  final String endTime;
  final bool active;
  final SellerModel? vendor;
  final String? boxNumber; // <-- Adicionado

  ScheduleModel({
    required this.id,
    required this.sellerId,
    required this.boxId,
    required this.dayOfWeek,
    required this.startTime,
    required this.endTime,
    required this.active,
    this.vendor,
    this.boxNumber, // <-- Adicionado
  });

  factory ScheduleModel.fromJson(Map<String, dynamic> json) {
    return ScheduleModel(
      id: json['id'],
      sellerId: json['seller_id'] ?? json['vendor_id'] ?? 0,
      boxId: json['box_id'],
      dayOfWeek: json['day_of_week'],
      startTime: json['start_time'],
      endTime: json['end_time'],
      active: json['active'] ?? true,
      vendor: json['vendor'] != null
          ? SellerModel.fromJson(json['vendor'])
          : null,
      boxNumber: json['box_number']?.toString(), // <-- Adicionado
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'seller_id': sellerId,
    'box_id': boxId,
    'day_of_week': dayOfWeek,
    'start_time': startTime,
    'end_time': endTime,
    'active': active,
    'vendor': vendor?.toJson(),
    'box_number': boxNumber, // <-- Adicionado
  };
}
