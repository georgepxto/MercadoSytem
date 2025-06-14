import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import '../../../../data/models/seller_model.dart';

class SellerFormDialog extends StatefulWidget {
  final SellerModel? seller;
  final void Function(SellerModel seller) onSave;

  const SellerFormDialog({Key? key, this.seller, required this.onSave})
    : super(key: key);

  @override
  State<SellerFormDialog> createState() => _SellerFormDialogState();
}

class _SellerFormDialogState extends State<SellerFormDialog> {
  final _formKey = GlobalKey<FormState>();

  late TextEditingController _nameController;
  late TextEditingController _emailController;
  late TextEditingController _phoneController;
  late TextEditingController _foodTypeController;
  late TextEditingController _descriptionController;
  late TextEditingController _cnpjController;

  bool _hasCnpj = false;
  bool _active = true;

  @override
  void initState() {
    super.initState();
    final seller = widget.seller;
    _nameController = TextEditingController(text: seller?.name ?? '');
    _emailController = TextEditingController(text: seller?.email ?? '');
    _phoneController = TextEditingController(text: seller?.phone ?? '');
    _foodTypeController = TextEditingController(text: seller?.foodType ?? '');
    _descriptionController = TextEditingController(
      text: seller?.description ?? '',
    );
    _cnpjController = TextEditingController(text: seller?.cnpj ?? '');
    _hasCnpj = seller?.hasCnpj ?? false;
    _active = seller?.active ?? true;
  }

  @override
  void dispose() {
    _nameController.dispose();
    _emailController.dispose();
    _phoneController.dispose();
    _foodTypeController.dispose();
    _descriptionController.dispose();
    _cnpjController.dispose();
    super.dispose();
  }

  // Função para formatar o CNPJ enquanto o usuário digita
  String formatCnpj(String value) {
    var digits = value.replaceAll(RegExp(r'\D'), '');
    if (digits.length > 14) digits = digits.substring(0, 14);
    String cnpj = '';
    if (digits.length > 2) {
      cnpj += digits.substring(0, 2) + '.';
      if (digits.length > 5) {
        cnpj += digits.substring(2, 5) + '.';
        if (digits.length > 8) {
          cnpj += digits.substring(5, 8) + '/';
          if (digits.length > 12) {
            cnpj += digits.substring(8, 12) + '-';
            cnpj += digits.substring(12, digits.length);
          } else if (digits.length > 8) {
            cnpj += digits.substring(8, digits.length);
          }
        } else if (digits.length > 5) {
          cnpj += digits.substring(5, digits.length);
        }
      } else if (digits.length > 2) {
        cnpj += digits.substring(2, digits.length);
      }
    } else {
      cnpj = digits;
    }
    return cnpj;
  }

  // Função para formatar o telefone enquanto o usuário digita
  String formatPhone(String value) {
    var digits = value.replaceAll(RegExp(r'\D'), '');
    if (digits.length > 11) digits = digits.substring(0, 11);
    String phone = '';
    if (digits.length >= 2) {
      phone += '(${digits.substring(0, 2)}) ';
      if (digits.length >= 7) {
        phone += '${digits.substring(2, 7)}-${digits.substring(7)}';
      } else if (digits.length > 2) {
        phone += digits.substring(2);
      }
    } else if (digits.isNotEmpty) {
      phone += digits;
    }
    return phone;
  }

  void _onSave() {
    if (_formKey.currentState?.validate() ?? false) {
      widget.onSave(
        SellerModel(
          id: widget.seller?.id ?? 0,
          name: _nameController.text.trim(),
          email: _emailController.text.trim(),
          phone: _phoneController.text.trim(),
          foodType: _foodTypeController.text.trim(),
          description: _descriptionController.text.trim(),
          hasCnpj: _hasCnpj,
          cnpj: _hasCnpj ? _cnpjController.text.trim() : '',
          active: _active,
        ),
      );
      Navigator.of(context).pop();
    }
  }

  @override
  Widget build(BuildContext context) {
    final isEditing = widget.seller != null;
    return Dialog(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(24),
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Row(
                children: [
                  Expanded(
                    child: Text(
                      isEditing ? 'Editar Vendedor' : 'Novo Vendedor',
                      style: const TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                  IconButton(
                    icon: const Icon(Icons.close),
                    onPressed: () => Navigator.of(context).pop(),
                  ),
                ],
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _nameController,
                decoration: const InputDecoration(labelText: 'Nome'),
                validator: (v) =>
                    v == null || v.trim().isEmpty ? 'Informe o nome' : null,
              ),
              const SizedBox(height: 8),
              TextFormField(
                controller: _emailController,
                decoration: const InputDecoration(labelText: 'Email'),
                keyboardType: TextInputType.emailAddress,
                validator: (v) {
                  if (v == null || v.trim().isEmpty) return 'Informe o email';
                  if (!RegExp(r'^[^@]+@[^@]+\.[^@]+').hasMatch(v.trim())) {
                    return 'Digite um e-mail válido';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 8),
              TextFormField(
                controller: _phoneController,
                decoration: const InputDecoration(
                  labelText: 'Telefone',
                  hintText: '(11) 99999-9999',
                ),
                keyboardType: TextInputType.phone,
                maxLength: 15,
                inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                onChanged: (text) {
                  final formatted = formatPhone(text);
                  if (formatted != text) {
                    _phoneController.value = TextEditingValue(
                      text: formatted,
                      selection: TextSelection.collapsed(
                        offset: formatted.length,
                      ),
                    );
                  }
                },
                validator: (v) {
                  if (v == null || v.trim().isEmpty)
                    return 'Informe o telefone';
                  if (!RegExp(
                    r'^\(\d{2}\)\s?\d{5}-\d{4}$',
                  ).hasMatch(v.trim())) {
                    return 'Digite um telefone válido';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 8),
              TextFormField(
                controller: _foodTypeController,
                decoration: const InputDecoration(
                  labelText: 'Tipo de Comida',
                  hintText: 'Ex: Lanches, Comida Japonesa, Açaí...',
                ),
                validator: (v) => v == null || v.trim().isEmpty
                    ? 'Informe o tipo de comida'
                    : null,
              ),
              const SizedBox(height: 8),
              TextFormField(
                controller: _descriptionController,
                decoration: const InputDecoration(
                  labelText: 'Descrição',
                  hintText: 'Descrição dos produtos/serviços...',
                ),
                maxLines: 2,
              ),
              const SizedBox(height: 8),
              CheckboxListTile(
                contentPadding: EdgeInsets.zero,
                title: const Text('Possui CNPJ'),
                value: _hasCnpj,
                onChanged: (val) {
                  setState(() => _hasCnpj = val ?? false);
                },
              ),
              if (_hasCnpj) ...[
                TextFormField(
                  controller: _cnpjController,
                  decoration: const InputDecoration(
                    labelText: 'CNPJ',
                    hintText: 'XX.XXX.XXX/XXXX-XX',
                  ),
                  keyboardType: TextInputType.number,
                  maxLength: 18,
                  inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                  onChanged: (text) {
                    final formatted = formatCnpj(text);
                    if (formatted != text) {
                      _cnpjController.value = TextEditingValue(
                        text: formatted,
                        selection: TextSelection.collapsed(
                          offset: formatted.length,
                        ),
                      );
                    }
                  },
                  validator: (v) {
                    if (_hasCnpj && (v == null || v.trim().isEmpty)) {
                      return 'Informe o CNPJ';
                    }
                    if (_hasCnpj &&
                        !RegExp(
                          r'^\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}$',
                        ).hasMatch(v!.trim())) {
                      return 'Digite um CNPJ válido';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 8),
              ],
              CheckboxListTile(
                contentPadding: EdgeInsets.zero,
                title: const Text('Ativo'),
                value: _active,
                onChanged: (val) {
                  setState(() => _active = val ?? false);
                },
              ),
              const SizedBox(height: 16),
              Row(
                children: [
                  Expanded(
                    child: OutlinedButton(
                      onPressed: () => Navigator.of(context).pop(),
                      child: const Text('Cancelar'),
                      style: OutlinedButton.styleFrom(
                        foregroundColor: Colors.grey[800],
                        side: BorderSide(color: Colors.grey[400]!),
                        padding: const EdgeInsets.symmetric(vertical: 14),
                      ),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: ElevatedButton(
                      onPressed: _onSave,
                      child: const Text('Salvar'),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.blue,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(vertical: 14),
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
