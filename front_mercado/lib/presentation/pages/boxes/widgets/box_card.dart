import 'package:flutter/material.dart';
import '../../../../data/models/box_model.dart';
import '../../../../data/models/schedule_model.dart';
import '../../../../data/models/entry_model.dart';
import '../../../../data/models/seller_model.dart';
import 'box_details_modal.dart';
import 'box_form_modal.dart';
import '../../../../data/services/box_service.dart';

class BoxCard extends StatelessWidget {
  final BoxModel box;
  final VoidCallback onRefresh;
  final List<ScheduleModel> schedules;
  final List<EntryModel> entries;
  final Map<int, SellerModel> sellers;

  const BoxCard({
    Key? key,
    required this.box,
    required this.onRefresh,
    required this.schedules,
    required this.entries,
    required this.sellers,
  }) : super(key: key);

  void openDetails(BuildContext context) {
    showDialog(
      context: context,
      builder: (_) => BoxDetailsModal(
        box: box,
        schedules: schedules,
        entries: entries,
        sellers: sellers,
      ),
    );
  }

  Future<void> openEditModal(BuildContext context) async {
    final edited = await showDialog<bool>(
      context: context,
      builder: (_) => BoxFormModal(box: box),
    );
    if (edited == true) {
      onRefresh();
    }
  }

  Future<void> confirmDelete(BuildContext context) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        title: const Text('Confirmar exclusão'),
        content: Text('Deseja realmente excluir o box ${box.number}?'),
        actions: [
          TextButton(
            child: const Text('Cancelar'),
            onPressed: () => Navigator.of(ctx).pop(false),
          ),
          TextButton(
            child: const Text('Excluir', style: TextStyle(color: Colors.red)),
            onPressed: () => Navigator.of(ctx).pop(true),
          ),
        ],
      ),
    );
    if (confirm == true) {
      final error = await BoxService().deleteBox(box.id);
      if (error == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Box excluído com sucesso!')),
        );
        onRefresh();
      } else {
        showDialog(
          context: context,
          builder: (ctx) => AlertDialog(
            title: const Text('Não foi possível excluir'),
            content: Text(error),
            actions: [
              TextButton(
                onPressed: () => Navigator.of(ctx).pop(),
                child: const Text('OK'),
              ),
            ],
          ),
        );
      }
    }
  }

  Widget buildOccupiedSchedules() {
    if (box.schedules.isEmpty) {
      return const Text(
        "Nenhum horário ocupado.",
        style: TextStyle(fontSize: 14, color: Colors.black54),
      );
    }
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          "Horários Ocupados:",
          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
        ),
        const SizedBox(height: 8),
        ...box.schedules.map(
          (ScheduleModel sched) => Padding(
            padding: const EdgeInsets.only(bottom: 6),
            child: Container(
              decoration: BoxDecoration(
                color: Colors.grey.shade100,
                borderRadius: BorderRadius.circular(6),
              ),
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
              child: Row(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  if (sched.vendor != null) ...[
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          sched.vendor!.name,
                          style: const TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 15,
                          ),
                        ),
                        Text(
                          sched.vendor!.foodType,
                          style: const TextStyle(
                            fontSize: 12,
                            color: Colors.black54,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(width: 10),
                  ] else ...[
                    Text(
                      "Vendedor: ${sched.sellerId}",
                      style: const TextStyle(
                        color: Colors.black54,
                        fontSize: 13,
                      ),
                    ),
                    const SizedBox(width: 10),
                  ],
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 8,
                      vertical: 2,
                    ),
                    decoration: BoxDecoration(
                      color: Colors.grey.shade300,
                      borderRadius: BorderRadius.circular(6),
                    ),
                    child: Text(
                      sched.dayOfWeek[0].toUpperCase() +
                          sched.dayOfWeek.substring(1),
                      style: const TextStyle(
                        color: Colors.black87,
                        fontWeight: FontWeight.w600,
                        fontSize: 13,
                      ),
                    ),
                  ),
                  const SizedBox(width: 8),
                  Text(
                    "${sched.startTime} - ${sched.endTime}",
                    style: const TextStyle(
                      fontWeight: FontWeight.w500,
                      fontSize: 15,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ],
    );
  }

  Widget buildActiveCheckins(BuildContext context) {
    final List<EntryModel> activeCheckins = box.checkins
        .where((c) => c.isActive)
        .toList();

    if (activeCheckins.isEmpty) {
      return const SizedBox();
    }
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 6),
        const Text(
          "Check-ins Ativos:",
          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
        ),
        const SizedBox(height: 6),
        ...activeCheckins.map(
          (EntryModel c) => Padding(
            padding: const EdgeInsets.only(bottom: 4),
            child: Row(
              children: [
                const Icon(
                  Icons.person_pin_circle,
                  size: 18,
                  color: Colors.blue,
                ),
                const SizedBox(width: 4),
                Text("Vendedor: ${c.sellerId}"),
                const SizedBox(width: 12),
                Text(
                  "Entrada: ${TimeOfDay.fromDateTime(c.dateTimeIn).format(context)}",
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(vertical: 12),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(18)),
      elevation: 3,
      child: Padding(
        padding: const EdgeInsets.fromLTRB(16, 20, 16, 16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                const Icon(Icons.grid_on, size: 30, color: Colors.black54),
                const SizedBox(width: 8),
                Expanded(
                  child: Text(
                    "Box ${box.number}",
                    style: const TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 10,
                    vertical: 3,
                  ),
                  decoration: BoxDecoration(
                    color: box.available ? Colors.green : Colors.red,
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Text(
                    box.available ? "Disponível" : "Indisponível",
                    style: const TextStyle(color: Colors.white, fontSize: 13),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 5),
            Text(box.location, style: const TextStyle(fontSize: 15)),
            const SizedBox(height: 10),
            Container(
              decoration: BoxDecoration(
                color: Colors.blue.shade50,
                borderRadius: BorderRadius.circular(8),
              ),
              padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
              child: Text(
                "R\$ ${double.tryParse(box.monthlyPrice)?.toStringAsFixed(2).replaceAll('.', ',') ?? box.monthlyPrice}/mês",
                style: const TextStyle(
                  color: Colors.blue,
                  fontWeight: FontWeight.bold,
                  fontSize: 16,
                ),
              ),
            ),
            const SizedBox(height: 8),
            Text(box.description, style: const TextStyle(fontSize: 14)),
            const SizedBox(height: 14),
            buildOccupiedSchedules(),
            buildActiveCheckins(context),
            const Divider(),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                OutlinedButton.icon(
                  icon: const Icon(Icons.edit, color: Colors.blue),
                  label: const Text(
                    "Editar",
                    style: TextStyle(color: Colors.blue),
                  ),
                  onPressed: () => openEditModal(context),
                  style: OutlinedButton.styleFrom(
                    side: const BorderSide(color: Colors.blue),
                  ),
                ),
                OutlinedButton.icon(
                  icon: const Icon(Icons.info_outline, color: Colors.teal),
                  label: const Text(
                    "Detalhes",
                    style: TextStyle(color: Colors.teal),
                  ),
                  onPressed: () => openDetails(context),
                  style: OutlinedButton.styleFrom(
                    side: const BorderSide(color: Colors.teal),
                  ),
                ),
                OutlinedButton.icon(
                  icon: const Icon(Icons.delete, color: Colors.red),
                  label: const Text(
                    "Excluir",
                    style: TextStyle(color: Colors.red),
                  ),
                  onPressed: () => confirmDelete(context),
                  style: OutlinedButton.styleFrom(
                    side: const BorderSide(color: Colors.red),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
