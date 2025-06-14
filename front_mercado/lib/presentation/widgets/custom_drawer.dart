import 'package:flutter/material.dart';

class CustomDrawer extends StatelessWidget {
  final String selectedRoute;
  final Function(String) onSelect;

  const CustomDrawer({
    Key? key,
    required this.selectedRoute,
    required this.onSelect,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final menuItems = [
      {
        'label': 'Dashboard',
        'icon': Icons.dashboard_customize,
        'route': '/dashboard',
      },
      {
        'label': 'Check-in/Check-out',
        'icon': Icons.login_outlined,
        'route': '/entries',
      },
      {'label': 'Vendedores', 'icon': Icons.groups, 'route': '/sellers'},
      {'label': 'Boxes', 'icon': Icons.grid_on, 'route': '/boxes'},
      {'label': 'Histórico', 'icon': Icons.access_time, 'route': '/history'},
    ];

    return Drawer(
      child: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Color(0xFF8E2DE2), Color(0xFF4A00E0)],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: SafeArea(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Padding(
                padding: const EdgeInsets.only(
                  top: 12.0,
                  left: 16.0,
                  right: 16.0,
                  bottom: 8.0,
                ),
                child: SizedBox(
                  width: double.infinity,
                  child: OutlinedButton(
                    style: OutlinedButton.styleFrom(
                      side: const BorderSide(color: Colors.white54, width: 1),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      backgroundColor: Colors.transparent,
                      padding: const EdgeInsets.symmetric(vertical: 6),
                    ),
                    onPressed: () => Navigator.of(context).pop(),
                    child: const Icon(
                      Icons.close,
                      color: Colors.white,
                      size: 28,
                    ),
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.symmetric(
                  horizontal: 20.0,
                  vertical: 12.0,
                ),
                child: Row(
                  children: const [
                    Icon(
                      Icons.store_mall_directory,
                      color: Colors.white,
                      size: 28,
                    ),
                    SizedBox(width: 10),
                    Flexible(
                      child: Text(
                        'Mercado N. S. Fátima',
                        overflow: TextOverflow.ellipsis,
                        maxLines: 1,
                        style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 18,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 8),
              ...menuItems.map((item) {
                final selected = item['route'] == selectedRoute;
                return Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 8.0),
                  child: Material(
                    color: selected
                        ? Colors.white.withOpacity(0.20)
                        : Colors.transparent,
                    borderRadius: BorderRadius.circular(16),
                    child: InkWell(
                      borderRadius: BorderRadius.circular(16),
                      onTap: () {
                        final route = item['route'] as String;
                        if (route != ModalRoute.of(context)?.settings.name) {
                          Navigator.of(context).pushReplacementNamed(route);
                        } else {
                          Navigator.of(context).pop();
                        }
                        onSelect(route);
                      },
                      child: Padding(
                        padding: const EdgeInsets.symmetric(
                          vertical: 12.0,
                          horizontal: 16.0,
                        ),
                        child: Row(
                          children: [
                            Icon(
                              item['icon'] as IconData,
                              color: Colors.white,
                              size: 22,
                            ),
                            const SizedBox(width: 12),
                            Text(
                              item['label'] as String,
                              style: TextStyle(
                                color: Colors.white,
                                fontWeight: selected
                                    ? FontWeight.bold
                                    : FontWeight.normal,
                                fontSize: 16,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                );
              }).toList(),
              const Spacer(),
            ],
          ),
        ),
      ),
    );
  }
}
