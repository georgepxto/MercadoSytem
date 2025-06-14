import 'package:flutter/material.dart';

class CardInfo extends StatelessWidget {
  final String title;
  final int value;
  final Color color;
  final IconData icon;
  final bool loading;
  final bool error;

  const CardInfo({
    Key? key,
    required this.title,
    required this.value,
    required this.color,
    required this.icon,
    this.loading = false,
    this.error = false,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.symmetric(vertical: 8.0),
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(16.0),
      ),
      padding: const EdgeInsets.all(16.0),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    color: Colors.white70,
                    fontWeight: FontWeight.w400,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  value.toString(),
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
          ),
          Icon(icon, size: 32, color: Colors.white),
        ],
      ),
    );
  }
}
