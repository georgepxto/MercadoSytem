import 'package:flutter/material.dart';
import '../../../../data/models/seller_model.dart';
import '../../../../data/models/box_model.dart';
import '../../../../data/services/box_service.dart';
import 'seller_schedule_dialog.dart';

class SellerCard extends StatelessWidget {
  final SellerModel seller;
  final VoidCallback? onEdit;
  final VoidCallback? onDelete;
  final List<BoxModel> availableBoxes;
  final VoidCallback? onRefresh; // Use para atualizar a tela após agendamento

  const SellerCard({
    Key? key,
    required this.seller,
    required this.availableBoxes,
    this.onEdit,
    this.onDelete,
    this.onRefresh,
  }) : super(key: key);

  Future<void> _deleteSchedule(BuildContext context, int scheduleId) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        title: const Text('Excluir agendamento'),
        content: const Text('Tem certeza que deseja excluir este agendamento?'),
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
      final error = await BoxService().deleteSchedule(scheduleId);
      if (error == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Agendamento excluído com sucesso!')),
        );
        if (onRefresh != null) onRefresh!();
      } else {
        showDialog(
          context: context,
          builder: (ctx) => AlertDialog(
            title: const Text('Erro ao excluir'),
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

  Widget buildSchedulesList(BuildContext context) {
    if (seller.schedules.isEmpty) {
      return const Padding(
        padding: EdgeInsets.symmetric(vertical: 8.0),
        child: Text('Nenhum horário agendado.'),
      );
    }
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Padding(
          padding: EdgeInsets.only(top: 10, bottom: 4),
          child: Row(
            children: [
              Icon(Icons.access_time, size: 20, color: Colors.black54),
              SizedBox(width: 6),
              Text(
                'Horários:',
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
              ),
            ],
          ),
        ),
        ...seller.schedules.map(
          (sched) => Container(
            margin: const EdgeInsets.only(bottom: 6),
            decoration: BoxDecoration(
              color: Colors.grey.shade100,
              borderRadius: BorderRadius.circular(8),
            ),
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 8),
            child: Row(
              children: [
                // Dia da semana
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 10,
                    vertical: 3,
                  ),
                  decoration: BoxDecoration(
                    color: Colors.grey.shade300,
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Text(
                    sched.dayOfWeek[0].toUpperCase() +
                        sched.dayOfWeek.substring(1),
                    style: const TextStyle(fontWeight: FontWeight.bold),
                  ),
                ),
                const SizedBox(width: 10),
                // Horário
                Text(
                  '${sched.startTime} - ${sched.endTime}',
                  style: const TextStyle(fontWeight: FontWeight.w600),
                ),
                const SizedBox(width: 10),
                // Nome do box
                Text(
                  sched.boxNumber ?? '',
                  style: const TextStyle(fontWeight: FontWeight.w500),
                ),
                const Spacer(),
                // Botão lixeira
                IconButton(
                  icon: const Icon(Icons.delete, color: Colors.red),
                  tooltip: 'Remover agendamento',
                  onPressed: () => _deleteSchedule(context, sched.id),
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
    // Cores para os chips
    final foodTypeColor = Colors.teal;
    final activeColor = seller.active ? Colors.green : Colors.grey;

    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 18, horizontal: 18),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Nome do vendedor com avatar
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                CircleAvatar(
                  child: Text(
                    seller.name.isNotEmpty ? seller.name[0].toUpperCase() : "?",
                    style: const TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 20,
                    ),
                  ),
                  backgroundColor: Colors.blue[300],
                  foregroundColor: Colors.white,
                  radius: 26,
                ),
                const SizedBox(width: 16),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        seller.name,
                        style: const TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 2),
                      Text(
                        seller.email,
                        style: const TextStyle(
                          fontSize: 15,
                          color: Colors.black54,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
            const SizedBox(height: 10),

            // Chips (tipo de comida, ativo)
            Row(
              children: [
                if (seller.foodType.isNotEmpty)
                  Padding(
                    padding: const EdgeInsets.only(right: 7),
                    child: Chip(
                      label: Text(
                        seller.foodType,
                        style: const TextStyle(color: Colors.white),
                      ),
                      backgroundColor: foodTypeColor,
                      visualDensity: VisualDensity.compact,
                    ),
                  ),
                Chip(
                  label: Text(
                    seller.active ? "Ativo" : "Inativo",
                    style: const TextStyle(color: Colors.white),
                  ),
                  backgroundColor: activeColor,
                  visualDensity: VisualDensity.compact,
                ),
              ],
            ),
            const SizedBox(height: 6),

            // Telefone
            Row(
              children: [
                const Icon(Icons.phone, size: 17, color: Colors.black54),
                const SizedBox(width: 6),
                Text(
                  seller.phone,
                  style: const TextStyle(fontSize: 15, color: Colors.black87),
                ),
              ],
            ),
            // Exibir CNPJ se houver
            if (seller.hasCnpj && (seller.cnpj?.isNotEmpty ?? false))
              Padding(
                padding: const EdgeInsets.only(top: 6),
                child: Row(
                  children: [
                    const Icon(Icons.badge, size: 17, color: Colors.black54),
                    const SizedBox(width: 6),
                    Text(
                      "CNPJ: ${seller.cnpj}",
                      style: const TextStyle(
                        fontSize: 15,
                        color: Colors.black87,
                      ),
                    ),
                  ],
                ),
              ),
            const SizedBox(height: 10),

            // Horários do vendedor
            buildSchedulesList(context),

            // Botões
            Row(
              children: [
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: onEdit,
                    icon: const Icon(Icons.edit, color: Colors.blue),
                    label: const Text(
                      'Editar',
                      style: TextStyle(color: Colors.blue),
                    ),
                    style: OutlinedButton.styleFrom(
                      side: const BorderSide(color: Colors.blue),
                      padding: const EdgeInsets.symmetric(vertical: 8),
                    ),
                  ),
                ),
                const SizedBox(width: 8),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: availableBoxes.isEmpty
                        ? null
                        : () {
                            showDialog(
                              context: context,
                              builder: (_) => SellerScheduleDialog(
                                availableBoxes: availableBoxes,
                                vendorId: seller.id,
                                onScheduled:
                                    onRefresh, // Atualiza após agendamento
                              ),
                            );
                          },
                    icon: const Icon(Icons.schedule, color: Colors.green),
                    label: const Text(
                      'Horário',
                      style: TextStyle(color: Colors.green),
                    ),
                    style: OutlinedButton.styleFrom(
                      side: const BorderSide(color: Colors.green),
                      padding: const EdgeInsets.symmetric(vertical: 8),
                    ),
                  ),
                ),
                const SizedBox(width: 8),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: onDelete,
                    icon: const Icon(Icons.delete, color: Colors.red),
                    label: const Text(
                      'Excluir',
                      style: TextStyle(color: Colors.red),
                    ),
                    style: OutlinedButton.styleFrom(
                      side: const BorderSide(color: Colors.red),
                      padding: const EdgeInsets.symmetric(vertical: 8),
                    ),
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
