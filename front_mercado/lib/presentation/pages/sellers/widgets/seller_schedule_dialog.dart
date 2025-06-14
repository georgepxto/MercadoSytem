import 'package:flutter/material.dart';
import '../../../../data/models/box_model.dart';
import '../../../../data/services/box_service.dart';

class SellerScheduleDialog extends StatefulWidget {
  final List<BoxModel> availableBoxes;
  final int vendorId; // Corrigido aqui!
  final VoidCallback? onScheduled;

  const SellerScheduleDialog({
    Key? key,
    required this.availableBoxes,
    required this.vendorId, // Corrigido aqui!
    this.onScheduled,
  }) : super(key: key);

  @override
  State<SellerScheduleDialog> createState() => _SellerScheduleDialogState();
}

class _SellerScheduleDialogState extends State<SellerScheduleDialog> {
  BoxModel? selectedBox;
  String? selectedDay;
  TimeOfDay? startTime;
  TimeOfDay? endTime;
  bool isSaving = false;

  String formatTimeOfDay(TimeOfDay time) {
    final hour = time.hour.toString().padLeft(2, '0');
    final minute = time.minute.toString().padLeft(2, '0');
    return '$hour:$minute';
  }

  Future<void> _saveSchedule() async {
    if (selectedBox == null ||
        selectedDay == null ||
        startTime == null ||
        endTime == null)
      return;
    setState(() => isSaving = true);

    final success = await BoxService().createSchedule(
      boxId: selectedBox!.id,
      vendorId: widget.vendorId, // Corrigido aqui!
      dayOfWeek: selectedDay!.toLowerCase(), // minúsculo
      startTime: formatTimeOfDay(startTime!),
      endTime: formatTimeOfDay(endTime!),
    );

    setState(() => isSaving = false);

    if (success) {
      if (widget.onScheduled != null) widget.onScheduled!();
      Navigator.of(context).pop(true);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Horário agendado com sucesso!')),
      );
    } else {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(const SnackBar(content: Text('Erro ao agendar horário.')));
    }
  }

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('Adicionar Horário'),
      content: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            DropdownButtonFormField<BoxModel>(
              decoration: const InputDecoration(labelText: "Box"),
              items: widget.availableBoxes
                  .map(
                    (box) => DropdownMenuItem<BoxModel>(
                      value: box,
                      child: Text(box.number),
                    ),
                  )
                  .toList(),
              onChanged: (value) => setState(() {
                selectedBox = value;
              }),
              value: selectedBox,
            ),
            const SizedBox(height: 16),
            DropdownButtonFormField<String>(
              decoration: const InputDecoration(labelText: 'Selecione o dia'),
              items: const [
                DropdownMenuItem(value: 'Segunda', child: Text('Segunda')),
                DropdownMenuItem(value: 'Terça', child: Text('Terça')),
                DropdownMenuItem(value: 'Quarta', child: Text('Quarta')),
                DropdownMenuItem(value: 'Quinta', child: Text('Quinta')),
                DropdownMenuItem(value: 'Sexta', child: Text('Sexta')),
                DropdownMenuItem(value: 'Sábado', child: Text('Sábado')),
                DropdownMenuItem(value: 'Domingo', child: Text('Domingo')),
              ],
              onChanged: (value) => setState(() {
                selectedDay = value;
              }),
              value: selectedDay,
            ),
            const SizedBox(height: 16),
            Row(
              children: [
                Expanded(
                  child: InkWell(
                    onTap: () async {
                      final t = await showTimePicker(
                        context: context,
                        initialTime:
                            startTime ?? const TimeOfDay(hour: 8, minute: 0),
                      );
                      if (t != null) setState(() => startTime = t);
                    },
                    child: InputDecorator(
                      decoration: const InputDecoration(
                        labelText: "Horário Início",
                      ),
                      child: Text(startTime?.format(context) ?? '--:--'),
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: InkWell(
                    onTap: () async {
                      final t = await showTimePicker(
                        context: context,
                        initialTime:
                            endTime ?? const TimeOfDay(hour: 18, minute: 0),
                      );
                      if (t != null) setState(() => endTime = t);
                    },
                    child: InputDecorator(
                      decoration: const InputDecoration(
                        labelText: "Horário Fim",
                      ),
                      child: Text(endTime?.format(context) ?? '--:--'),
                    ),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      actions: [
        TextButton(
          onPressed: isSaving ? null : () => Navigator.of(context).pop(),
          child: const Text('Cancelar'),
        ),
        ElevatedButton(
          onPressed:
              (selectedBox != null &&
                  selectedDay != null &&
                  startTime != null &&
                  endTime != null &&
                  !isSaving)
              ? _saveSchedule
              : null,
          child: isSaving
              ? const SizedBox(
                  height: 18,
                  width: 18,
                  child: CircularProgressIndicator(strokeWidth: 2),
                )
              : const Text('Salvar'),
        ),
      ],
    );
  }
}
