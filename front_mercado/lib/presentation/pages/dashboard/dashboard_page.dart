import 'package:flutter/material.dart';
import '../../widgets/custom_drawer.dart';
import 'widgets/card_info.dart';
import '../../../data/services/box_service.dart';
import '../../../data/services/seller_service.dart';
import '../../../data/services/entry_service.dart';
import '../../../data/models/seller_model.dart';
import '../../../data/models/entry_model.dart';
import '../../../data/models/box_model.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({Key? key}) : super(key: key);

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  String selectedRoute = '/dashboard';
  late Future<int> totalBoxesFuture;
  late Future<List<SellerModel>> sellersFuture;
  late Future<List<EntryModel>> entriesFuture;
  late Future<List<BoxModel>> boxesFuture;

  @override
  void initState() {
    super.initState();
    totalBoxesFuture = BoxService().fetchBoxesCount();
    sellersFuture = SellerService().fetchSellers();
    entriesFuture = EntryService().fetchEntries();
    boxesFuture = BoxService().fetchBoxes();
  }

  void onDrawerSelect(String route) {
    if (route == selectedRoute) return;
    setState(() {
      selectedRoute = route;
    });
  }

  void _refreshDashboardData() {
    setState(() {
      totalBoxesFuture = BoxService().fetchBoxesCount();
      sellersFuture = SellerService().fetchSellers();
      entriesFuture = EntryService().fetchEntries();
      boxesFuture = BoxService().fetchBoxes();
    });
  }

  Future<void> _navigateToBoxesPage(BuildContext context) async {
    await Navigator.pushNamed(context, '/boxes');
    setState(() {
      totalBoxesFuture = BoxService().fetchBoxesCount();
      boxesFuture = BoxService().fetchBoxes();
    });
  }

  Future<void> _navigateToSellersPage(BuildContext context) async {
    await Navigator.pushNamed(context, '/sellers');
    setState(() {
      sellersFuture = SellerService().fetchSellers();
    });
  }

  String _formatToday() {
    final now = DateTime.now();
    return "${now.day.toString().padLeft(2, '0')}/${now.month.toString().padLeft(2, '0')}/${now.year}";
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: CustomDrawer(
        selectedRoute: selectedRoute,
        onSelect: onDrawerSelect,
      ),
      appBar: AppBar(
        elevation: 0,
        flexibleSpace: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              colors: [Color(0xFF8E2DE2), Color(0xFF4A00E0)],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
          ),
        ),
        title: Row(
          children: const [
            Icon(Icons.store_mall_directory, color: Colors.white),
            SizedBox(width: 10),
            Flexible(
              child: Text(
                'Mercado N. S. Fátima',
                style: TextStyle(color: Colors.white),
              ),
            ),
          ],
        ),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Dashboard',
              style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 16),
            GestureDetector(
              onTap: () => _navigateToSellersPage(context),
              child: FutureBuilder<List<SellerModel>>(
                future: sellersFuture,
                builder: (context, snapshot) {
                  int totalVendedores = 0;
                  bool loading = snapshot.connectionState == ConnectionState.waiting;
                  bool error = snapshot.hasError;
                  if (snapshot.hasData) {
                    totalVendedores = snapshot.data!.length;
                  }
                  return CardInfo(
                    title: 'Total Vendedores',
                    value: totalVendedores,
                    color: Colors.blue,
                    icon: Icons.groups,
                    loading: loading,
                    error: error,
                  );
                },
              ),
            ),
            const SizedBox(height: 16),
            GestureDetector(
              onTap: () => _navigateToBoxesPage(context),
              child: FutureBuilder<int>(
                future: totalBoxesFuture,
                builder: (context, snapshot) {
                  int value = snapshot.data ?? 0;
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return CardInfo(
                      title: 'Total Boxes',
                      value: 0,
                      color: Colors.green,
                      icon: Icons.grid_on,
                      loading: true,
                    );
                  }
                  if (snapshot.hasError) {
                    return CardInfo(
                      title: 'Total Boxes',
                      value: 0,
                      color: Colors.green,
                      icon: Icons.grid_on,
                      error: true,
                    );
                  }
                  return CardInfo(
                    title: 'Total Boxes',
                    value: value,
                    color: Colors.green,
                    icon: Icons.grid_on,
                  );
                },
              ),
            ),
            const SizedBox(height: 16),
            FutureBuilder<List<EntryModel>>(
              future: entriesFuture,
              builder: (context, entrySnapshot) {
                int ativosHoje = 0;
                int entradasHoje = 0;
                List<EntryModel> entries = [];
                if (entrySnapshot.hasData) {
                  entries = entrySnapshot.data!;
                  final hoje = DateTime.now();
                  final hojeInicio = DateTime(hoje.year, hoje.month, hoje.day);
                  final hojeFim = hojeInicio.add(const Duration(days: 1));
                  final ativosVendedores = <int>{};
                  for (var entry in entries) {
                    final inToday = entry.dateTimeIn.isAfter(hojeInicio.subtract(const Duration(seconds: 1))) &&
                        entry.dateTimeIn.isBefore(hojeFim);
                    if (entry.dateTimeOut == null && inToday) {
                      ativosVendedores.add(entry.sellerId);
                    }
                    if (inToday) {
                      entradasHoje += 1;
                    }
                  }
                  ativosHoje = ativosVendedores.length;
                }
                if (entrySnapshot.connectionState == ConnectionState.waiting) {
                  return Column(
                    children: [
                      CardInfo(
                        title: 'Ativos Hoje',
                        value: 0,
                        color: Colors.amber,
                        icon: Icons.person,
                        loading: true,
                      ),
                      const SizedBox(height: 16),
                      CardInfo(
                        title: 'Entradas Hoje',
                        value: 0,
                        color: Colors.cyan,
                        icon: Icons.login,
                        loading: true,
                      ),
                    ],
                  );
                }
                if (entrySnapshot.hasError) {
                  return Column(
                    children: [
                      CardInfo(
                        title: 'Ativos Hoje',
                        value: 0,
                        color: Colors.amber,
                        icon: Icons.person,
                        error: true,
                      ),
                      const SizedBox(height: 16),
                      CardInfo(
                        title: 'Entradas Hoje',
                        value: 0,
                        color: Colors.cyan,
                        icon: Icons.login,
                        error: true,
                      ),
                    ],
                  );
                }
                return Column(
                  children: [
                    CardInfo(
                      title: 'Ativos Hoje',
                      value: ativosHoje,
                      color: Colors.amber,
                      icon: Icons.person,
                    ),
                    const SizedBox(height: 16),
                    CardInfo(
                      title: 'Entradas Hoje',
                      value: entradasHoje,
                      color: Colors.cyan,
                      icon: Icons.login,
                    ),
                  ],
                );
              },
            ),
            const SizedBox(height: 16),
            FutureBuilder<List<EntryModel>>(
              future: entriesFuture,
              builder: (context, entrySnapshot) {
                if (!entrySnapshot.hasData) {
                  return const Center(child: CircularProgressIndicator());
                }
                return FutureBuilder<List<SellerModel>>(
                  future: sellersFuture,
                  builder: (context, sellerSnapshot) {
                    if (!sellerSnapshot.hasData) {
                      return const Center(child: CircularProgressIndicator());
                    }
                    return FutureBuilder<List<BoxModel>>(
                      future: boxesFuture,
                      builder: (context, boxSnapshot) {
                        if (!boxSnapshot.hasData) {
                          return const Center(child: CircularProgressIndicator());
                        }
                        final entries = entrySnapshot.data!;
                        final sellers = sellerSnapshot.data!;
                        final boxes = boxSnapshot.data!;

                        final hoje = DateTime.now();
                        final hojeInicio = DateTime(hoje.year, hoje.month, hoje.day);
                        final hojeFim = hojeInicio.add(const Duration(days: 1));
                        final entriesHoje = entries.where((entry) =>
                        entry.dateTimeIn.isAfter(hojeInicio.subtract(const Duration(seconds: 1))) &&
                            entry.dateTimeIn.isBefore(hojeFim)
                        ).toList();

                        if (entriesHoje.isEmpty) {
                          return Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const SizedBox(height: 8),
                              Row(
                                children: [
                                  const Icon(Icons.schedule, size: 20, color: Colors.black54),
                                  const SizedBox(width: 6),
                                  Text(
                                    "Atividade de Hoje - ${_formatToday()}",
                                    style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87),
                                  ),
                                ],
                              ),
                              const SizedBox(height: 8),
                              Container(
                                width: double.infinity,
                                margin: const EdgeInsets.symmetric(vertical: 8),
                                padding: const EdgeInsets.all(18),
                                decoration: BoxDecoration(
                                  color: Colors.grey.shade100,
                                  borderRadius: BorderRadius.circular(12),
                                  border: Border.all(color: Colors.grey.shade200),
                                ),
                                child: const Center(
                                  child: Text(
                                    "Nenhuma atividade registrada para hoje.",
                                    style: TextStyle(color: Colors.black54),
                                  ),
                                ),
                              )
                            ],
                          );
                        }

                        return Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const SizedBox(height: 8),
                            Row(
                              children: [
                                const Icon(Icons.schedule, size: 20, color: Colors.black54),
                                const SizedBox(width: 6),
                                Text(
                                  "Atividade de Hoje - ${_formatToday()}",
                                  style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87),
                                ),
                              ],
                            ),
                            const SizedBox(height: 8),
                            ...entriesHoje.map((entry) {
                              final seller = sellers.firstWhere(
                                    (s) => s.id == entry.sellerId,
                                orElse: () => SellerModel(
                                  id: 0,
                                  name: 'Desconhecido',
                                  email: '',
                                  phone: '',
                                  foodType: '',
                                  description: '',
                                  hasCnpj: false,
                                  active: false,
                                ),
                              );
                              final box = boxes.firstWhere(
                                    (b) => b.id == entry.boxId,
                                orElse: () => BoxModel(
                                  id: 0,
                                  number: '',
                                  location: '',
                                  description: '',
                                  available: false,
                                  monthlyPrice: '',
                                ),
                              );
                              final statusAtivo = entry.dateTimeOut == null;
                              return Container(
                                width: double.infinity,
                                margin: const EdgeInsets.symmetric(vertical: 8),
                                decoration: BoxDecoration(
                                  color: Colors.white,
                                  borderRadius: BorderRadius.circular(16),
                                  border: Border.all(
                                    color: statusAtivo ? Colors.green.shade300 : Colors.grey.shade300,
                                    width: 2,
                                  ),
                                  boxShadow: [
                                    BoxShadow(
                                      color: Colors.black.withOpacity(0.03),
                                      blurRadius: 8,
                                      offset: const Offset(0, 2),
                                    ),
                                  ],
                                ),
                                child: Padding(
                                  padding: const EdgeInsets.all(16.0),
                                  child: Row(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      CircleAvatar(
                                        radius: 24,
                                        backgroundColor: Colors.blue.shade100,
                                        child: Text(
                                          seller.name.isNotEmpty ? seller.name.substring(0, 1) : "?",
                                          style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 22, color: Colors.blue),
                                        ),
                                      ),
                                      const SizedBox(width: 12),
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Row(
                                              children: [
                                                Text(
                                                  seller.name,
                                                  style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 17),
                                                ),
                                                const SizedBox(width: 12),
                                                Container(
                                                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                                                  decoration: BoxDecoration(
                                                    color: statusAtivo ? Colors.green.shade100 : Colors.grey.shade300,
                                                    borderRadius: BorderRadius.circular(8),
                                                  ),
                                                  child: Text(
                                                    statusAtivo ? "Ativo" : "Finalizado",
                                                    style: TextStyle(
                                                      fontWeight: FontWeight.bold,
                                                      fontSize: 13,
                                                      color: statusAtivo ? Colors.green : Colors.black54,
                                                    ),
                                                  ),
                                                ),
                                              ],
                                            ),
                                            Text(
                                              seller.foodType,
                                              style: const TextStyle(fontSize: 13, color: Colors.black54),
                                            ),
                                            const SizedBox(height: 4),
                                            Row(
                                              children: [
                                                Container(
                                                  padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                                                  decoration: BoxDecoration(
                                                    color: Colors.grey.shade200,
                                                    borderRadius: BorderRadius.circular(8),
                                                  ),
                                                  child: Text(
                                                    box.number.isNotEmpty ? "Box ${box.number}" : "Box",
                                                    style: const TextStyle(fontWeight: FontWeight.bold),
                                                  ),
                                                ),
                                                const SizedBox(width: 6),
                                                Text(box.location, style: const TextStyle(color: Colors.black54)),
                                              ],
                                            ),
                                            const SizedBox(height: 10),
                                            Row(
                                              children: [
                                                const Text("Entrada", style: TextStyle(fontWeight: FontWeight.w500)),
                                                const SizedBox(width: 4),
                                                Text(
                                                  "${entry.dateTimeIn.hour.toString().padLeft(2, '0')}:${entry.dateTimeIn.minute.toString().padLeft(2, '0')}",
                                                  style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                                                ),
                                                const SizedBox(width: 16),
                                                const Text("Saída", style: TextStyle(fontWeight: FontWeight.w500)),
                                                const SizedBox(width: 4),
                                                Text(
                                                  entry.dateTimeOut != null
                                                      ? "${entry.dateTimeOut!.hour.toString().padLeft(2, '0')}:${entry.dateTimeOut!.minute.toString().padLeft(2, '0')}"
                                                      : "-",
                                                  style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                                                ),
                                              ],
                                            ),
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              );
                            }).toList(),
                          ],
                        );
                      },
                    );
                  },
                );
              },
            ),
          ],
        ),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: _refreshDashboardData,
        child: const Icon(Icons.refresh),
        tooltip: 'Atualizar Dashboard',
      ),
    );
  }
}