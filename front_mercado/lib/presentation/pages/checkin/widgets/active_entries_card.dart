import 'package:flutter/material.dart';
import '../../../../data/models/entry_model.dart';
import '../../../../data/models/box_model.dart';
import '../../../../data/services/entry_service.dart';

class ActiveEntriesCard extends StatelessWidget {
  final List<EntryModel> entries;
  final List<BoxModel> boxes;
  final VoidCallback onCheckout;

  const ActiveEntriesCard({
    Key? key,
    required this.entries,
    required this.boxes,
    required this.onCheckout,
  }) : super(key: key);

  String? getBoxName(int boxId) {
    final box = boxes.firstWhere(
      (b) => b.id == boxId,
      orElse: () => BoxModel(
        id: 0,
        number: '---',
        location: '',
        description: '',
        available: false,
        monthlyPrice: '0',
      ),
    );
    return box.number;
  }

  String formatTime(DateTime dt) {
    return "${dt.hour.toString().padLeft(2, '0')}:${dt.minute.toString().padLeft(2, '0')}";
  }

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 1,
      margin: EdgeInsets.zero,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            decoration: const BoxDecoration(
              color: Color(0xFF2086FF),
              borderRadius: BorderRadius.vertical(top: Radius.circular(10)),
            ),
            width: double.infinity,
            padding: const EdgeInsets.symmetric(vertical: 10, horizontal: 18),
            child: const Text(
              "Vendedores Ativos",
              style: TextStyle(
                color: Colors.white,
                fontWeight: FontWeight.w700,
                fontSize: 17,
              ),
            ),
          ),
          ...entries.isEmpty
              ? [
                  const Padding(
                    padding: EdgeInsets.all(18),
                    child: Text(
                      "Nenhum vendedor ativo no momento.",
                      style: TextStyle(color: Colors.black54),
                    ),
                  ),
                ]
              : entries.map(
                  (c) => Padding(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 18,
                      vertical: 10,
                    ),
                    child: Row(
                      children: [
                        Text(
                          c.sellerId.toString(),
                          style: const TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                          ),
                        ),
                        const SizedBox(width: 10),
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                "Box ${getBoxName(c.boxId)} - desde ${formatTime(c.dateTimeIn)}",
                                style: const TextStyle(
                                  fontSize: 14,
                                  color: Colors.black54,
                                ),
                              ),
                            ],
                          ),
                        ),
                        ElevatedButton.icon(
                          icon: const Icon(Icons.logout, color: Colors.black87),
                          label: const Text(
                            "Check-out",
                            style: TextStyle(color: Colors.black87),
                          ),
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xFFFFE066),
                            foregroundColor: Colors.black87,
                            padding: const EdgeInsets.symmetric(
                              horizontal: 10,
                              vertical: 8,
                            ),
                          ),
                          onPressed: () async {
                            final ok = await EntryService().checkout(c.id);
                            if (ok && context.mounted) {
                              ScaffoldMessenger.of(context).showSnackBar(
                                const SnackBar(
                                  content: Text('Check-out realizado!'),
                                ),
                              );
                              onCheckout();
                            }
                          },
                        ),
                      ],
                    ),
                  ),
                ),
        ],
      ),
    );
  }
}
