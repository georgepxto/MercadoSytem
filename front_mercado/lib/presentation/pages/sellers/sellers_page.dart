import 'package:flutter/material.dart';
import '../../../data/models/seller_model.dart';
import '../../../data/models/box_model.dart';
import '../../../data/services/seller_service.dart';
import '../../../data/services/box_service.dart';
import 'widgets/seller_card.dart';
import 'widgets/seller_form_dialog.dart';
import '../../widgets/custom_drawer.dart';
import '../../widgets/custom_app_bar.dart';

class SellersPage extends StatefulWidget {
  const SellersPage({Key? key}) : super(key: key);

  @override
  State<SellersPage> createState() => _SellersPageState();
}

class _SellersPageState extends State<SellersPage> {
  late Future<List<SellerModel>> sellersFuture;
  late Future<List<BoxModel>> availableBoxesFuture;

  @override
  void initState() {
    super.initState();
    _refreshData();
  }

  void _refreshData() {
    sellersFuture = SellerService().fetchSellers();
    availableBoxesFuture = BoxService().fetchAvailableBoxes();
  }

  void _refreshSellers() {
    setState(() {
      sellersFuture = SellerService().fetchSellers();
    });
  }

  void _createSeller() {
    showDialog(
      context: context,
      builder: (_) => SellerFormDialog(
        onSave: (seller) async {
          final success = await SellerService().createSeller(
            name: seller.name,
            email: seller.email,
            phone: seller.phone,
            foodType: seller.foodType,
            description: seller.description,
            hasCnpj: seller.hasCnpj,
            cnpj: seller.cnpj,
            active: seller.active,
          );
          if (success) {
            _refreshSellers();
          }
        },
      ),
    );
  }

  void _editSeller(SellerModel seller) {
    showDialog(
      context: context,
      builder: (_) => SellerFormDialog(
        seller: seller,
        onSave: (updatedSeller) async {
          final success = await SellerService().editSeller(
            id: updatedSeller.id,
            name: updatedSeller.name,
            email: updatedSeller.email,
            phone: updatedSeller.phone,
            foodType: updatedSeller.foodType,
            description: updatedSeller.description,
            hasCnpj: updatedSeller.hasCnpj,
            cnpj: updatedSeller.cnpj,
            active: updatedSeller.active,
          );
          if (success) {
            _refreshSellers();
          }
        },
      ),
    );
  }

  void _deleteSeller(SellerModel seller) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        title: const Text('Excluir Vendedor'),
        content: Text('Deseja realmente excluir o vendedor "${seller.name}"?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false),
            child: const Text('Cancelar'),
          ),
          TextButton(
            onPressed: () => Navigator.of(context).pop(true),
            child: const Text('Excluir', style: TextStyle(color: Colors.red)),
          ),
        ],
      ),
    );
    if (confirm == true) {
      final success = await SellerService().deleteSeller(seller.id);
      if (success) {
        _refreshSellers();
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: CustomDrawer(selectedRoute: '/sellers', onSelect: (_) {}),
      appBar: const CustomAppBar(title: 'Mercado N. S. Fátima'),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Vendedores',
              style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 18),
            ElevatedButton.icon(
              icon: const Icon(Icons.person_add),
              label: const Text('Novo Vendedor'),
              onPressed: _createSeller,
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(
                  vertical: 16,
                  horizontal: 18,
                ),
                textStyle: const TextStyle(fontWeight: FontWeight.bold),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
            ),
            const SizedBox(height: 18),
            Expanded(
              child: FutureBuilder<List<SellerModel>>(
                future: sellersFuture,
                builder: (context, sellerSnapshot) {
                  if (sellerSnapshot.connectionState ==
                      ConnectionState.waiting) {
                    return const Center(child: CircularProgressIndicator());
                  }
                  if (sellerSnapshot.hasError) {
                    return const Center(
                      child: Text('Erro ao carregar vendedores'),
                    );
                  }
                  final sellers = sellerSnapshot.data ?? [];
                  if (sellers.isEmpty) {
                    return const Center(
                      child: Text('Nenhum vendedor cadastrado'),
                    );
                  }
                  // Carrega os boxes disponíveis para todos os cards
                  return FutureBuilder<List<BoxModel>>(
                    future: availableBoxesFuture,
                    builder: (context, boxSnapshot) {
                      if (boxSnapshot.connectionState ==
                          ConnectionState.waiting) {
                        return const Center(child: CircularProgressIndicator());
                      }
                      if (boxSnapshot.hasError) {
                        return const Center(
                          child: Text('Erro ao carregar boxes'),
                        );
                      }
                      final availableBoxes = boxSnapshot.data ?? [];
                      return ListView.separated(
                        itemCount: sellers.length,
                        separatorBuilder: (_, __) => const SizedBox(height: 16),
                        itemBuilder: (context, index) {
                          final seller = sellers[index];
                          return SellerCard(
                            seller: seller,
                            availableBoxes: availableBoxes, // List<BoxModel>
                            onEdit: () => _editSeller(seller),
                            onDelete: () => _deleteSeller(seller),
                          );
                        },
                      );
                    },
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
