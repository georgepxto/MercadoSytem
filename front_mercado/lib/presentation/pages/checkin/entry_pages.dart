import 'package:flutter/material.dart';
import '../../../data/models/entry_model.dart';
import '../../../data/models/seller_model.dart';
import '../../../data/models/box_model.dart';
import '../../../data/services/entry_service.dart';
import '../../../data/services/box_service.dart';
import '../../../data/services/seller_service.dart';
import '../../widgets/custom_drawer.dart';
import '../../widgets/custom_app_bar.dart'; // Import da CustomAppBar!
import 'widgets/entry_form_card.dart';
import 'widgets/active_entries_card.dart';
// import 'widgets/recent_activities_card.dart';

class EntryPage extends StatefulWidget {
  const EntryPage({Key? key}) : super(key: key);

  @override
  State<EntryPage> createState() => _EntryPageState();
}

class _EntryPageState extends State<EntryPage> {
  List<EntryModel> entries = [];
  List<SellerModel> sellers = [];
  List<BoxModel> boxes = [];
  bool isLoading = true;
  String selectedRoute = '/entries';

  @override
  void initState() {
    super.initState();
    fetchAllData();
  }

  Future<void> fetchAllData() async {
    setState(() => isLoading = true);
    try {
      final fetchedEntries = await EntryService().fetchEntries();
      final fetchedSellers = await SellerService().fetchSellers();
      final fetchedBoxes = await BoxService().fetchBoxes();
      setState(() {
        entries = fetchedEntries;
        sellers = fetchedSellers;
        boxes = fetchedBoxes;
      });
    } catch (e) {
      setState(() {
        entries = [];
        sellers = [];
        boxes = [];
      });
      print("Erro ao carregar dados: $e");
    }
    setState(() => isLoading = false);
  }

  void onDrawerSelect(String route) {
    setState(() => selectedRoute = route);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: CustomDrawer(
        selectedRoute: selectedRoute,
        onSelect: onDrawerSelect,
      ),
      appBar: const CustomAppBar(title: 'Mercado N. S. Fátima'),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : SingleChildScrollView(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Check-in / Check-out',
                    style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 18),
                  EntryFormCard(
                    sellers: sellers,
                    boxes: boxes,
                    onEntry: fetchAllData,
                  ),
                  const SizedBox(height: 16),
                  ActiveEntriesCard(
                    entries: entries.where((c) => c.isActive).toList(),
                    boxes: boxes,
                    onCheckout: fetchAllData,
                  ),
                  const SizedBox(height: 16),
                  // RecentActivitiesCard(checkins: checkins, boxes: boxes),
                ],
              ),
            ),
    );
  }
}
