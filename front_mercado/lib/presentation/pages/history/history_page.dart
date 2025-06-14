import 'package:flutter/material.dart';
import '../../../data/models/entry_model.dart';
import '../../../data/models/seller_model.dart';
import '../../../data/models/box_model.dart';
import '../../../data/services/entry_service.dart';
import '../../../data/services/seller_service.dart';
import '../../../data/services/box_service.dart';
import '../../widgets/custom_drawer.dart';
import '../../widgets/custom_app_bar.dart';

class HistoryPage extends StatefulWidget {
  const HistoryPage({Key? key}) : super(key: key);

  @override
  State<HistoryPage> createState() => _HistoryPageState();
}

class _HistoryPageState extends State<HistoryPage> {
  List<EntryModel> entries = [];
  List<SellerModel> sellers = [];
  List<BoxModel> boxes = [];
  bool isLoading = true;
  String selectedRoute = '/history';

  int? selectedSellerId;
  int? selectedBoxId;
  DateTime? selectedStartDate;
  DateTime? selectedEndDate;

  @override
  void initState() {
    super.initState();
    fetchAll();
  }

  Future<void> fetchAll() async {
    setState(() => isLoading = true);
    try {
      final fetchedEntries = await EntryService().fetchEntries();
      final fetchedSellers = await SellerService().fetchSellers();
      final fetchedBoxes = await BoxService().fetchBoxes();
      setState(() {
        entries = fetchedEntries;
        sellers = fetchedSellers;
        boxes = fetchedBoxes;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        entries = [];
        sellers = [];
        boxes = [];
        isLoading = false;
      });
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text('Erro ao carregar histórico: $e')));
    }
  }

  void onDrawerSelect(String route) {
    setState(() => selectedRoute = route);
  }

  void clearFilters() {
    setState(() {
      selectedSellerId = null;
      selectedBoxId = null;
      selectedStartDate = null;
      selectedEndDate = null;
    });
  }

  List<EntryModel> get filteredEntries {
    return entries.where((entry) {
      final sellerMatch =
          selectedSellerId == null || entry.sellerId == selectedSellerId;
      final boxMatch = selectedBoxId == null || entry.boxId == selectedBoxId;
      final startMatch =
          selectedStartDate == null ||
          !entry.dateTimeIn.isBefore(selectedStartDate!);
      final endMatch =
          selectedEndDate == null ||
          !entry.dateTimeIn.isAfter(selectedEndDate!);
      return sellerMatch && boxMatch && startMatch && endMatch;
    }).toList();
  }

  String _getSellerName(int sellerId) {
    return sellers
        .firstWhere(
          (s) => s.id == sellerId,
          orElse: () => SellerModel(
            id: 0,
            name: '',
            email: '',
            phone: '',
            foodType: '',
            description: '',
            hasCnpj: false,
            active: false,
          ),
        )
        .name;
  }

  String _getSellerFoodType(int sellerId) {
    return sellers
        .firstWhere(
          (s) => s.id == sellerId,
          orElse: () => SellerModel(
            id: 0,
            name: '',
            email: '',
            phone: '',
            foodType: '',
            description: '',
            hasCnpj: false,
            active: false,
          ),
        )
        .foodType;
  }

  String _getBoxLabel(int boxId) {
    final box = boxes.firstWhere(
      (b) => b.id == boxId,
      orElse: () => BoxModel(
        id: 0,
        number: '',
        location: '',
        description: '',
        available: false,
        monthlyPrice: '0.00',
      ),
    );
    return box.id == 0 ? "" : "Box ${box.number} - ${box.location}";
  }

  Future<void> _pickDate(BuildContext context, bool isStart) async {
    final initialDate = isStart ? selectedStartDate : selectedEndDate;
    final picked = await showDatePicker(
      context: context,
      initialDate: initialDate ?? DateTime.now(),
      firstDate: DateTime(2020),
      lastDate: DateTime(2100),
    );
    if (picked != null) {
      setState(() {
        if (isStart) {
          selectedStartDate = picked;
        } else {
          selectedEndDate = picked;
        }
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: CustomDrawer(
        selectedRoute: selectedRoute,
        onSelect: onDrawerSelect,
      ),
      appBar: const CustomAppBar(title: 'Histórico de Entradas'),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                children: [
                  Card(
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(14),
                    ),
                    elevation: 2,
                    child: Padding(
                      padding: const EdgeInsets.all(16.0),
                      child: Column(
                        children: [
                          Row(
                            children: [
                              const Icon(Icons.filter_alt, color: Colors.blue),
                              const SizedBox(width: 6),
                              const Text(
                                "Filtros",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 16,
                                ),
                              ),
                              const Spacer(),
                              TextButton.icon(
                                icon: const Icon(Icons.clear),
                                label: const Text("Limpar"),
                                onPressed: clearFilters,
                              ),
                            ],
                          ),
                          const Divider(),
                          DropdownButtonFormField<int?>(
                            value: selectedSellerId,
                            isExpanded: true,
                            decoration: const InputDecoration(
                              labelText: 'Vendedor',
                            ),
                            items: [
                              const DropdownMenuItem<int?>(
                                value: null,
                                child: Text("Todos os vendedores"),
                              ),
                              ...sellers.map(
                                (seller) => DropdownMenuItem(
                                  value: seller.id,
                                  child: Text(seller.name),
                                ),
                              ),
                            ],
                            onChanged: (value) {
                              setState(() {
                                selectedSellerId = value;
                              });
                            },
                          ),
                          const SizedBox(height: 12),
                          DropdownButtonFormField<int?>(
                            value: selectedBoxId,
                            isExpanded: true,
                            decoration: const InputDecoration(labelText: 'Box'),
                            items: [
                              const DropdownMenuItem<int?>(
                                value: null,
                                child: Text("Todos os boxes"),
                              ),
                              ...boxes.map(
                                (box) => DropdownMenuItem(
                                  value: box.id,
                                  child: Text(
                                    "Box ${box.number} - ${box.location}",
                                  ),
                                ),
                              ),
                            ],
                            onChanged: (value) {
                              setState(() {
                                selectedBoxId = value;
                              });
                            },
                          ),
                          const SizedBox(height: 12),
                          Row(
                            children: [
                              Expanded(
                                child: InkWell(
                                  onTap: () => _pickDate(context, true),
                                  child: IgnorePointer(
                                    child: TextFormField(
                                      controller: TextEditingController(
                                        text: selectedStartDate == null
                                            ? ''
                                            : "${selectedStartDate!.day.toString().padLeft(2, '0')}/${selectedStartDate!.month.toString().padLeft(2, '0')}/${selectedStartDate!.year}",
                                      ),
                                      decoration: const InputDecoration(
                                        labelText: 'Data Início',
                                        suffixIcon: Icon(Icons.calendar_today),
                                      ),
                                    ),
                                  ),
                                ),
                              ),
                              const SizedBox(width: 12),
                              Expanded(
                                child: InkWell(
                                  onTap: () => _pickDate(context, false),
                                  child: IgnorePointer(
                                    child: TextFormField(
                                      controller: TextEditingController(
                                        text: selectedEndDate == null
                                            ? ''
                                            : "${selectedEndDate!.day.toString().padLeft(2, '0')}/${selectedEndDate!.month.toString().padLeft(2, '0')}/${selectedEndDate!.year}",
                                      ),
                                      decoration: const InputDecoration(
                                        labelText: 'Data Fim',
                                        suffixIcon: Icon(Icons.calendar_today),
                                      ),
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 18),
                  Row(
                    children: [
                      Container(
                        decoration: BoxDecoration(
                          color: Colors.cyan,
                          borderRadius: BorderRadius.circular(8),
                        ),
                        padding: const EdgeInsets.symmetric(
                          horizontal: 12,
                          vertical: 8,
                        ),
                        child: Text(
                          "Registros de Entrada/Saída",
                          style: const TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                          ),
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Text(
                          "${filteredEntries.length} registros",
                          style: const TextStyle(
                            fontWeight: FontWeight.bold,
                            color: Colors.black54,
                          ),
                          textAlign: TextAlign.right,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 10),
                  Expanded(
                    child: filteredEntries.isEmpty
                        ? const Center(
                            child: Text("Nenhum registro encontrado."),
                          )
                        : ListView.separated(
                            itemCount: filteredEntries.length,
                            separatorBuilder: (_, __) =>
                                const SizedBox(height: 8),
                            itemBuilder: (context, idx) {
                              final entry = filteredEntries[idx];
                              final sellerName = _getSellerName(entry.sellerId);
                              final sellerFoodType = _getSellerFoodType(
                                entry.sellerId,
                              );
                              final boxLabel = _getBoxLabel(entry.boxId);
                              final isFinalized = entry.dateTimeOut != null;
                              return Card(
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(14),
                                ),
                                elevation: 2,
                                child: Padding(
                                  padding: const EdgeInsets.all(16.0),
                                  child: Row(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      CircleAvatar(
                                        radius: 22,
                                        child: Text(
                                          sellerName.isNotEmpty
                                              ? sellerName[0]
                                              : "",
                                          style: const TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 22,
                                          ),
                                        ),
                                      ),
                                      const SizedBox(width: 12),
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment:
                                              CrossAxisAlignment.start,
                                          children: [
                                            Row(
                                              children: [
                                                Text(
                                                  sellerName,
                                                  style: const TextStyle(
                                                    fontWeight: FontWeight.bold,
                                                    fontSize: 17,
                                                  ),
                                                ),
                                                const SizedBox(width: 12),
                                                if (isFinalized)
                                                  Container(
                                                    padding:
                                                        const EdgeInsets.symmetric(
                                                          horizontal: 10,
                                                          vertical: 4,
                                                        ),
                                                    decoration: BoxDecoration(
                                                      color:
                                                          Colors.grey.shade300,
                                                      borderRadius:
                                                          BorderRadius.circular(
                                                            8,
                                                          ),
                                                    ),
                                                    child: const Text(
                                                      "Finalizado",
                                                      style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.bold,
                                                        fontSize: 13,
                                                      ),
                                                    ),
                                                  ),
                                              ],
                                            ),
                                            Text(
                                              sellerFoodType,
                                              style: const TextStyle(
                                                fontSize: 13,
                                                color: Colors.black54,
                                              ),
                                            ),
                                            const SizedBox(height: 4),
                                            Text(
                                              "Box: $boxLabel",
                                              style: const TextStyle(
                                                fontSize: 13,
                                                color: Colors.black87,
                                              ),
                                            ),
                                            const SizedBox(height: 6),
                                            Row(
                                              children: [
                                                const Icon(
                                                  Icons.login,
                                                  size: 16,
                                                  color: Colors.blueGrey,
                                                ),
                                                const SizedBox(width: 4),
                                                Text(
                                                  "Entrada: ${_formatDateTime(entry.dateTimeIn)}",
                                                  style: const TextStyle(
                                                    fontSize: 13,
                                                  ),
                                                ),
                                              ],
                                            ),
                                            if (entry.dateTimeOut != null) ...[
                                              const SizedBox(height: 2),
                                              Row(
                                                children: [
                                                  const Icon(
                                                    Icons.logout,
                                                    size: 16,
                                                    color: Colors.redAccent,
                                                  ),
                                                  const SizedBox(width: 4),
                                                  Text(
                                                    "Saída: ${_formatDateTime(entry.dateTimeOut!)}",
                                                    style: const TextStyle(
                                                      fontSize: 13,
                                                    ),
                                                  ),
                                                ],
                                              ),
                                            ],
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              );
                            },
                          ),
                  ),
                ],
              ),
            ),
    );
  }

  String _formatDateTime(DateTime dt) {
    return "${dt.day.toString().padLeft(2, '0')}/${dt.month.toString().padLeft(2, '0')}/${dt.year} ${dt.hour.toString().padLeft(2, '0')}:${dt.minute.toString().padLeft(2, '0')}";
  }
}
