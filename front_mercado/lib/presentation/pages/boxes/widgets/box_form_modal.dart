import 'package:flutter/material.dart';
import 'package:front_mercado/data/models/box_model.dart';
import 'package:front_mercado/data/services/box_service.dart';

class BoxFormModal extends StatefulWidget {
  final BoxModel? box; // Se for nulo: criação, se não: edição

  const BoxFormModal({Key? key, this.box}) : super(key: key);

  @override
  State<BoxFormModal> createState() => _BoxFormModalState();
}

class _BoxFormModalState extends State<BoxFormModal> {
  final _formKey = GlobalKey<FormState>();
  late String number;
  late String location;
  late String monthlyPrice;
  late String description;
  bool available = true;
  bool loading = false;

  @override
  void initState() {
    super.initState();
    // Preenche os campos se estiver editando
    number = widget.box?.number ?? '';
    location = widget.box?.location ?? '';
    monthlyPrice = widget.box?.monthlyPrice ?? '';
    description = widget.box?.description ?? '';
    available = widget.box?.available ?? true;
  }

  Future<void> _onSubmit() async {
    if (!(_formKey.currentState?.validate() ?? false)) return;
    setState(() => loading = true);
    bool success = false;
    try {
      if (widget.box == null) {
        // Criação
        success = await BoxService().createBox(
          number: number,
          location: location,
          monthlyPrice: monthlyPrice,
          description: description,
          available: available,
        );
      } else {
        // Edição
        success = await BoxService().editBox(
          id: widget.box!.id,
          number: number,
          location: location,
          monthlyPrice: monthlyPrice,
          description: description,
          available: available,
        );
      }
      if (success) {
        Navigator.of(context).pop(true);
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(
              widget.box == null
                  ? 'Erro ao criar o box'
                  : 'Erro ao editar o box',
            ),
          ),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text('Erro: $e')));
    } finally {
      setState(() => loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final isEdit = widget.box != null;
    return Dialog(
      insetPadding: const EdgeInsets.all(20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(18)),
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 22),
        child: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Expanded(
                    child: Text(
                      isEdit ? "Editar Box" : "Novo Box",
                      style: const TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                  IconButton(
                    icon: const Icon(Icons.close, size: 28),
                    onPressed: () => Navigator.of(context).pop(),
                  ),
                ],
              ),
              const Divider(),
              Form(
                key: _formKey,
                child: Column(
                  children: [
                    TextFormField(
                      initialValue: number,
                      decoration: const InputDecoration(
                        labelText: "Número do Box",
                      ),
                      onChanged: (v) => number = v,
                      validator: (v) =>
                          v == null || v.isEmpty ? 'Informe o número' : null,
                    ),
                    TextFormField(
                      initialValue: location,
                      decoration: const InputDecoration(
                        labelText: "Localização",
                      ),
                      onChanged: (v) => location = v,
                      validator: (v) => v == null || v.isEmpty
                          ? 'Informe a localização'
                          : null,
                    ),
                    TextFormField(
                      initialValue: monthlyPrice,
                      decoration: const InputDecoration(
                        labelText: "Preço Mensal (R\$)",
                      ),
                      keyboardType: TextInputType.number,
                      onChanged: (v) => monthlyPrice = v,
                      validator: (v) =>
                          v == null || v.isEmpty ? 'Informe o preço' : null,
                    ),
                    TextFormField(
                      initialValue: description,
                      decoration: const InputDecoration(labelText: "Descrição"),
                      maxLines: 2,
                      onChanged: (v) => description = v,
                    ),
                    Row(
                      children: [
                        Checkbox(
                          value: available,
                          onChanged: (v) =>
                              setState(() => available = v ?? true),
                        ),
                        const Text("Disponível"),
                      ],
                    ),
                    const SizedBox(height: 18),
                    Row(
                      children: [
                        Expanded(
                          child: ElevatedButton(
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.grey.shade600,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(10),
                              ),
                            ),
                            onPressed: loading
                                ? null
                                : () => Navigator.of(context).pop(),
                            child: const Text("Cancelar"),
                          ),
                        ),
                        const SizedBox(width: 15),
                        Expanded(
                          child: ElevatedButton(
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.blue,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(10),
                              ),
                            ),
                            onPressed: loading ? null : _onSubmit,
                            child: Text(isEdit ? "Salvar" : "Criar"),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
