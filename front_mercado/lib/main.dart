import 'package:flutter/material.dart';
import 'package:front_mercado/presentation/pages/history/history_page.dart';
import 'presentation/pages/dashboard/dashboard_page.dart';
import 'presentation/pages/boxes/boxes_page.dart';
import 'presentation/pages/sellers/sellers_page.dart';
import 'presentation/pages/checkin/entry_pages.dart';

void main() {
  runApp(const MercadoApp());
}

class MercadoApp extends StatelessWidget {
  const MercadoApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Mercado N. S. Fátima',
      theme: ThemeData(primarySwatch: Colors.blue, fontFamily: 'Roboto'),
      initialRoute: '/dashboard',
      routes: {
        '/dashboard': (context) => const DashboardPage(),
        '/boxes': (context) => const BoxesPage(),
        '/sellers': (context) => const SellersPage(),
        '/entries': (context) => const EntryPage(),
        '/history': (context) => const HistoryPage(),
      },
      debugShowCheckedModeBanner: false,
    );
  }
}
