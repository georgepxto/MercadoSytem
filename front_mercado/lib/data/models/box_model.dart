import 'schedule_model.dart';
import 'entry_model.dart';

class BoxModel {
  final int id;
  final String number;
  final String location;
  final String description;
  final bool available;
  final String monthlyPrice;
  final List<ScheduleModel> schedules;
  final List<EntryModel> checkins;

  BoxModel({
    required this.id,
    required this.number,
    required this.location,
    required this.description,
    required this.available,
    required this.monthlyPrice,
    this.schedules = const [],
    this.checkins = const [],
  });

  factory BoxModel.fromJson(Map<String, dynamic> json) {
    final checkinsRaw = json['checkins'] ?? json['entries'] ?? [];
    final schedulesRaw = json['schedules'] ?? [];
    return BoxModel(
      id: json['id'],
      number: json['number'] ?? '',
      location: json['location'] ?? '',
      description: json['description'] ?? '',
      available: json['available'] ?? false,
      monthlyPrice: json['monthly_price']?.toString() ?? '0.00',
      schedules: (schedulesRaw as List<dynamic>)
          .map((s) => ScheduleModel.fromJson(s))
          .toList(),
      checkins: (checkinsRaw as List<dynamic>)
          .map((c) => EntryModel.fromJson(c))
          .toList(),
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'number': number,
    'location': location,
    'description': description,
    'available': available,
    'monthly_price': monthlyPrice,
    'schedules': schedules.map((s) => s.toJson()).toList(),
    'checkins': checkins.map((c) => c.toJson()).toList(),
  };
}