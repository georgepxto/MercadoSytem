import 'package:flutter/material.dart';
import '../../../../data/models/box_model.dart';
import '../../../../data/models/entry_model.dart';
import '../../../../data/models/schedule_model.dart';
import '../../../../data/models/seller_model.dart';

class BoxDetailsModal extends StatelessWidget {
  final BoxModel box;
  final List<ScheduleModel> schedules;
  final List<EntryModel> entries;
  final Map<int, SellerModel> sellers;

  const BoxDetailsModal({
    Key? key,
    required this.box,
    required this.schedules,
    required this.entries,
    required this.sellers,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final boxSchedules = schedules.where((s) => s.boxId == box.id).toList();
    final boxEntries = entries.where((e) => e.boxId == box.id).toList();
    boxEntries.sort((a, b) => b.dateTimeIn.compareTo(a.dateTimeIn));

    return Dialog(
      insetPadding: const EdgeInsets.all(20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(18)),
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 22),
        child: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  const Expanded(
                    child: Text(
                      "Detalhes do Box",
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                  IconButton(
                    icon: const Icon(Icons.close, size: 28),
                    onPressed: () => Navigator.of(context).pop(),
                  ),
                ],
              ),
              const Divider(),
              const Text(
                "Informações Básicas",
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
              ),
              const SizedBox(height: 10),
              _infoRow("Número:", "Box ${box.number}"),
              _infoRow("Localização:", box.location),
              _infoRow(
                "Status:",
                box.available ? "Disponível" : "Indisponível",
                statusColor: box.available ? Colors.green : Colors.red,
              ),
              _infoRow(
                "Preço:",
                "R\$ ${double.parse(box.monthlyPrice).toStringAsFixed(2).replaceAll('.', ',')}/mês",
              ),
              _infoRow("Descrição:", box.description),
              const SizedBox(height: 18),
              const Text(
                "Horários Agendados",
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
              ),
              const SizedBox(height: 6),
              boxSchedules.isEmpty
                  ? const Text("Nenhum horário agendado")
                  : Column(
                      children: boxSchedules.map((s) {
                        final vendorName =
                            s.vendor?.name ?? sellers[s.sellerId]?.name ?? '';
                        return Padding(
                          padding: const EdgeInsets.only(bottom: 4.0),
                          child: Row(
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Text(
                                vendorName,
                                style: const TextStyle(
                                  fontWeight: FontWeight.bold,
                                ),
                              ),
                              const SizedBox(width: 10),
                              Container(
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 8,
                                  vertical: 2,
                                ),
                                margin: const EdgeInsets.only(right: 8),
                                decoration: BoxDecoration(
                                  color: Colors.grey.shade200,
                                  borderRadius: BorderRadius.circular(6),
                                ),
                                child: Text(
                                  _dayOfWeekLabel(s.dayOfWeek),
                                  style: const TextStyle(fontSize: 13),
                                ),
                              ),
                              Text(
                                '${s.startTime} - ${s.endTime}',
                                style: const TextStyle(fontSize: 13),
                              ),
                            ],
                          ),
                        );
                      }).toList(),
                    ),
              const SizedBox(height: 18),
              const Text(
                "Últimas Atividades",
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
              ),
              const SizedBox(height: 6),
              boxEntries.isEmpty
                  ? const Text("Nenhuma atividade registrada.")
                  : DataTable(
                      headingRowHeight: 32,
                      dataRowMinHeight: 28,
                      dataRowMaxHeight: 32,
                      horizontalMargin: 0,
                      columnSpacing: 18,
                      columns: const [
                        DataColumn(
                          label: Text(
                            'Vendedor',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                        DataColumn(
                          label: Text(
                            'Data',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                        DataColumn(
                          label: Text(
                            'Entrada',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                        DataColumn(
                          label: Text(
                            'Saída',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                      ],
                      rows: boxEntries.take(8).map((e) {
                        final vendorName = sellers[e.sellerId]?.name ?? '';
                        return DataRow(
                          cells: [
                            DataCell(
                              Text(
                                vendorName,
                                style: const TextStyle(fontSize: 13),
                              ),
                            ),
                            DataCell(
                              Text(
                                _formatDate(e.dateTimeIn),
                                style: const TextStyle(fontSize: 13),
                              ),
                            ),
                            DataCell(
                              Text(
                                _formatTime(e.dateTimeIn),
                                style: const TextStyle(fontSize: 13),
                              ),
                            ),
                            DataCell(
                              Text(
                                e.dateTimeOut != null
                                    ? _formatTime(e.dateTimeOut!)
                                    : '-',
                                style: const TextStyle(fontSize: 13),
                              ),
                            ),
                          ],
                        );
                      }).toList(),
                    ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _infoRow(String label, String value, {Color? statusColor}) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 2.0),
      child: Row(
        children: [
          SizedBox(
            width: 90,
            child: Text(
              label,
              style: const TextStyle(fontWeight: FontWeight.bold),
            ),
          ),
          if (statusColor != null)
            Container(
              margin: const EdgeInsets.only(left: 4),
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
              decoration: BoxDecoration(
                color: statusColor,
                borderRadius: BorderRadius.circular(8),
              ),
              child: Text(
                value,
                style: const TextStyle(color: Colors.white, fontSize: 13),
              ),
            )
          else
            Expanded(child: Text(value)),
        ],
      ),
    );
  }

  static String _dayOfWeekLabel(String day) {
    switch (day.toLowerCase()) {
      case 'monday':
      case 'segunda':
        return 'segunda';
      case 'tuesday':
      case 'terça':
        return 'terça';
      case 'wednesday':
      case 'quarta':
        return 'quarta';
      case 'thursday':
      case 'quinta':
        return 'quinta';
      case 'friday':
      case 'sexta':
        return 'sexta';
      case 'saturday':
      case 'sábado':
        return 'sábado';
      case 'sunday':
      case 'domingo':
        return 'domingo';
      default:
        return day;
    }
  }

  static String _formatDate(DateTime date) {
    return '${date.day.toString().padLeft(2, '0')}/${date.month.toString().padLeft(2, '0')}/${date.year}';
  }

  static String _formatTime(DateTime date) {
    return '${date.hour.toString().padLeft(2, '0')}:${date.minute.toString().padLeft(2, '0')}';
  }
}
