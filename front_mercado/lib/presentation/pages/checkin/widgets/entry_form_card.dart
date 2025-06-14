import 'package:flutter/material.dart';
import '../../../../data/models/seller_model.dart';
import '../../../../data/models/box_model.dart';
import '../../../../data/services/entry_service.dart';

class EntryFormCard extends StatefulWidget {
  final List<SellerModel> sellers;
  final List<BoxModel> boxes;
  final VoidCallback onEntry;

  const EntryFormCard({
    Key? key,
    required this.sellers,
    required this.boxes,
    required this.onEntry,
  }) : super(key: key);

  @override
  State<EntryFormCard> createState() => _EntryFormCardState();
}

class _EntryFormCardState extends State<EntryFormCard> {
  SellerModel? selectedSeller;
  BoxModel? selectedBox;
  final observationsController = TextEditingController();
  bool isSubmitting = false;

  @override
  void dispose() {
    observationsController.dispose();
    super.dispose();
  }

  Future<void> handleEntry() async {
    if (selectedSeller == null || selectedBox == null) return;
    setState(() => isSubmitting = true);
    final ok = await EntryService().createEntry(
      sellerId: selectedSeller!.id,
      boxId: selectedBox!.id,
      observations: observationsController.text,
    );
    setState(() => isSubmitting = false);
    if (ok) {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(const SnackBar(content: Text('Check-in realizado!')));
      setState(() {
        selectedSeller = null;
        selectedBox = null;
        observationsController.clear();
      });
      widget.onEntry();
    } else {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(const SnackBar(content: Text('Erro ao fazer check-in.')));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 2,
      margin: EdgeInsets.zero,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: Padding(
        padding: const EdgeInsets.fromLTRB(0, 0, 0, 16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              decoration: const BoxDecoration(
                color: Color(0xFF219653),
                borderRadius: BorderRadius.vertical(top: Radius.circular(10)),
              ),
              width: double.infinity,
              padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 20),
              child: const Text(
                "Fazer Check-in",
                style: TextStyle(
                  color: Colors.white,
                  fontWeight: FontWeight.w700,
                  fontSize: 18,
                ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 14),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Row(
                    children: [
                      Icon(Icons.person, size: 18),
                      SizedBox(width: 4),
                      Text(
                        "Vendedor",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                    ],
                  ),
                  const SizedBox(height: 4),
                  DropdownButtonFormField<SellerModel>(
                    value: selectedSeller,
                    items: widget.sellers.map((s) {
                      return DropdownMenuItem<SellerModel>(
                        value: s,
                        child: Text(s.name),
                      );
                    }).toList(),
                    onChanged: (val) => setState(() => selectedSeller = val),
                    decoration: const InputDecoration(
                      hintText: "Selecione um vendedor",
                      border: OutlineInputBorder(),
                      contentPadding: EdgeInsets.symmetric(
                        horizontal: 12,
                        vertical: 10,
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  const Row(
                    children: [
                      Icon(Icons.grid_on, size: 18),
                      SizedBox(width: 4),
                      Text(
                        "Box",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                    ],
                  ),
                  const SizedBox(height: 4),
                  DropdownButtonFormField<BoxModel>(
                    value: selectedBox,
                    items: widget.boxes.map((b) {
                      return DropdownMenuItem<BoxModel>(
                        value: b,
                        child: Text(b.number),
                      );
                    }).toList(),
                    onChanged: (val) => setState(() => selectedBox = val),
                    decoration: const InputDecoration(
                      hintText: "Selecione um box",
                      border: OutlineInputBorder(),
                      contentPadding: EdgeInsets.symmetric(
                        horizontal: 12,
                        vertical: 10,
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  const Row(
                    children: [
                      Icon(Icons.chat_bubble_outline, size: 18),
                      SizedBox(width: 4),
                      Text(
                        "Observações (opcional)",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                    ],
                  ),
                  const SizedBox(height: 4),
                  TextField(
                    controller: observationsController,
                    minLines: 2,
                    maxLines: 3,
                    decoration: const InputDecoration(
                      hintText: "Observações sobre o check-in...",
                      border: OutlineInputBorder(),
                      contentPadding: EdgeInsets.symmetric(
                        horizontal: 12,
                        vertical: 10,
                      ),
                    ),
                  ),
                  const SizedBox(height: 18),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      icon: const Icon(Icons.check_circle, color: Colors.white),
                      label: const Text(
                        "Fazer Check-in",
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFF219653),
                        padding: const EdgeInsets.symmetric(vertical: 12),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
                      onPressed: isSubmitting ? null : handleEntry,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
