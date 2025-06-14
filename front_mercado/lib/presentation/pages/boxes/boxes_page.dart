import 'package:flutter/material.dart';
import '../../../data/models/box_model.dart';
import '../../../data/models/schedule_model.dart';
import '../../../data/models/entry_model.dart';
import '../../../data/models/seller_model.dart';
import '../../../data/services/box_service.dart';
import '../../../data/services/schedule_service.dart';
import '../../../data/services/entry_service.dart';
import '../../../data/services/seller_service.dart';
import '../../widgets/custom_drawer.dart';
import '../../widgets/custom_app_bar.dart';
import 'widgets/box_card.dart';
import 'widgets/box_form_modal.dart';

class BoxesPage extends StatefulWidget {
  const BoxesPage({Key? key}) : super(key: key);

  @override
  State<BoxesPage> createState() => _BoxesPageState();
}

class _BoxesPageState extends State<BoxesPage> {
  List<BoxModel> boxes = [];
  List<ScheduleModel> schedules = [];
  List<EntryModel> entries = [];
  Map<int, SellerModel> sellers = {};
  bool isLoading = true;
  String selectedRoute = '/boxes';

  @override
  void initState() {
    super.initState();
    fetchAllData();
  }

  Future<void> fetchAllData() async {
    setState(() => isLoading = true);
    try {
      boxes = await BoxService().fetchBoxes();
      schedules = await ScheduleService().fetchSchedules();
      entries = await EntryService().fetchEntries();
      final sellerList = await SellerService().fetchSellers();
      sellers = {for (var s in sellerList) s.id: s};
    } catch (e) {
      boxes = [];
      schedules = [];
      entries = [];
      sellers = {};
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text('Erro ao carregar dados: $e')));
    }
    setState(() => isLoading = false);
  }

  void onDrawerSelect(String route) {
    setState(() => selectedRoute = route);
  }

  void openNewBoxModal() async {
    final result = await showDialog(
      context: context,
      builder: (context) => const BoxFormModal(),
    );
    if (result == true) {
      await fetchAllData();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: CustomDrawer(
        selectedRoute: selectedRoute,
        onSelect: onDrawerSelect,
      ),
      appBar: const CustomAppBar(title: 'Mercado N. S. Fátima'),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Boxes do Mercado',
              style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 16),
            ElevatedButton.icon(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
                padding: const EdgeInsets.symmetric(
                  horizontal: 20,
                  vertical: 12,
                ),
              ),
              icon: const Icon(Icons.add_circle_outline, color: Colors.white),
              label: const Text(
                "Novo Box",
                style: TextStyle(
                  color: Colors.white,
                  fontWeight: FontWeight.bold,
                ),
              ),
              onPressed: openNewBoxModal,
            ),
            const SizedBox(height: 16),
            Expanded(
              child: isLoading
                  ? const Center(child: CircularProgressIndicator())
                  : boxes.isEmpty
                  ? const Center(child: Text("Nenhum box cadastrado"))
                  : RefreshIndicator(
                      onRefresh: fetchAllData,
                      child: ListView.builder(
                        itemCount: boxes.length,
                        itemBuilder: (context, idx) => BoxCard(
                          box: boxes[idx],
                          onRefresh: fetchAllData,
                          schedules: schedules,
                          entries: entries,
                          sellers: sellers,
                        ),
                      ),
                    ),
            ),
          ],
        ),
      ),
    );
  }
}
