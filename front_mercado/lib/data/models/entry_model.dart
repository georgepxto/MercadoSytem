class EntryModel {
  final int id;
  final int sellerId;
  final int boxId;
  final DateTime dateTimeIn;
  final DateTime? dateTimeOut;
  final int? scheduleId;
  final String? observations;
  final bool isActive;

  EntryModel({
    required this.id,
    required this.sellerId,
    required this.boxId,
    required this.dateTimeIn,
    this.dateTimeOut,
    this.scheduleId,
    this.observations,
    required this.isActive,
  });

  factory EntryModel.fromJson(Map<String, dynamic> json) {
    final sellerId = json['seller_id'] ?? json['vendor_id'];
    final dateTimeInRaw = json['date_time_in'] ?? json['entry_time'];
    final dateTimeOutRaw = json['date_time_out'] ?? json['exit_time'];
    final observationsRaw = json['observations'] ?? json['notes'];
    bool active;
    if (json.containsKey('is_active')) {
      active = json['is_active'] == true;
    } else if (dateTimeOutRaw == null || dateTimeOutRaw == "" || dateTimeOutRaw == false) {
      active = true;
    } else {
      active = false;
    }
    return EntryModel(
      id: json['id'],
      sellerId: sellerId,
      boxId: json['box_id'],
      dateTimeIn: DateTime.parse(dateTimeInRaw),
      dateTimeOut: (dateTimeOutRaw != null && dateTimeOutRaw != "")
          ? DateTime.tryParse(dateTimeOutRaw)
          : null,
      scheduleId: json['schedule_id'],
      observations: observationsRaw,
      isActive: active,
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'seller_id': sellerId,
    'box_id': boxId,
    'date_time_in': dateTimeIn.toIso8601String(),
    'date_time_out': dateTimeOut?.toIso8601String(),
    'schedule_id': scheduleId,
    'observations': observations,
    'is_active': isActive,
  };
}