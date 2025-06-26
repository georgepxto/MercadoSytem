@extends('layouts.app')

@section('title', 'Vendedores - Sistema de Controle')
@section('page-title', 'Vendedores')

@section('page-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vendorModal">
    <i class="bi bi-plus-circle"></i>
    Novo Vendedor
</button>
@endsection

@section('content')
<div class="row g-3">
    @foreach($vendors as $vendor)
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.5rem;">
                        {{ substr($vendor->name, 0, 1) }}
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <h5 class="card-title mb-1 text-truncate">{{ $vendor->name }}</h5>
                        <small class="text-muted text-truncate d-block">{{ $vendor->email }}</small>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="badge bg-info me-1">{{ $vendor->food_type }}</span>
                    @if($vendor->active)
                        <span class="badge bg-success">Ativo</span>
                    @else
                        <span class="badge bg-secondary">Inativo</span>
                    @endif
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center text-muted small mb-2">
                        <i class="bi bi-telephone me-2 flex-shrink-0"></i>
                        <span class="text-truncate">{{ $vendor->phone }}</span>
                    </div>
                    @if($vendor->has_cnpj && $vendor->cnpj)
                        <div class="d-flex align-items-center text-muted small mb-2">
                            <i class="bi bi-building me-2 flex-shrink-0"></i>
                            <span class="text-truncate">CNPJ: {{ $vendor->cnpj }}</span>
                        </div>
                    @endif
                    @if($vendor->description)
                        <p class="text-muted small mb-0 text-truncate">{{ $vendor->description }}</p>
                    @endif
                </div>

                                @if($vendor->schedules->count() > 0)
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-clock me-1"></i>
                            Horários:
                        </h6>
                        <div class="d-flex flex-column gap-1">
                            @foreach($vendor->schedules as $schedule)
                                <div class="d-flex justify-content-between align-items-center small bg-light rounded p-2">
                                    <span class="badge bg-secondary">{{ ucfirst($schedule->day_of_week) }}</span>
                                    <span class="fw-semibold">{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</span>
                                    <small class="text-muted">Box {{ $schedule->box->number }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="card-footer bg-transparent p-3 pt-0">
                <div class="d-none d-md-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="editVendor({{ $vendor->id }})">
                        <i class="bi bi-pencil"></i>
                        Editar
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="addSchedule({{ $vendor->id }})">
                        <i class="bi bi-calendar-plus"></i>
                        Horário
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteVendor({{ $vendor->id }}, '{{ $vendor->name }}')">
                        <i class="bi bi-trash"></i>
                        Excluir
                    </button>
                </div>
                
                <div class="d-md-none">
                    <div class="d-grid gap-2">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary btn-sm" onclick="editVendor({{ $vendor->id }})">
                                <i class="bi bi-pencil"></i>
                                Editar
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="addSchedule({{ $vendor->id }})">
                                <i class="bi bi-calendar-plus"></i>
                                Horário
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteVendor({{ $vendor->id }}, '{{ $vendor->name }}')">
                                <i class="bi bi-trash"></i>
                                Excluir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="modal fade" id="vendorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Vendedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="vendorForm">
                    <input type="hidden" id="vendor_id" name="vendor_id">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required 
                               placeholder="(11) 99999-9999" maxlength="15">
                        <div class="invalid-feedback" id="phone-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="food_type" class="form-label">Tipo de Comida</label>
                        <input type="text" class="form-control" id="food_type" name="food_type" required placeholder="Ex: Lanches, Comida Japonesa, Açaí...">
                    </div>                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Descrição dos produtos/serviços..."></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="has_cnpj" name="has_cnpj" onchange="toggleCnpjField()">
                        <label class="form-check-label" for="has_cnpj">Possui CNPJ</label>
                    </div>                    <div class="mb-3" id="cnpj-field" style="display: none;">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" 
                               placeholder="XX.XXX.XXX/XXXX-XX" maxlength="18">
                        <div class="invalid-feedback" id="cnpj-error"></div>
                        <div class="form-text">Digite apenas números, a formatação será aplicada automaticamente</div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active" checked>
                        <label class="form-check-label" for="active">Ativo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveVendor()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Horário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm">
                    <input type="hidden" id="schedule_vendor_id" name="vendor_id">
                    
                    <div class="mb-3">
                        <label for="box_id" class="form-label">Box</label>
                        <select class="form-select" id="schedule_box_id" name="box_id" required>
                            <option value="">Selecione um box</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="day_of_week" class="form-label">Dia da Semana</label>
                        <select class="form-select" id="day_of_week" name="day_of_week" required>
                            <option value="">Selecione o dia</option>
                            <option value="segunda">Segunda-feira</option>
                            <option value="terça">Terça-feira</option>
                            <option value="quarta">Quarta-feira</option>
                            <option value="quinta">Quinta-feira</option>
                            <option value="sexta">Sexta-feira</option>
                            <option value="sábado">Sábado</option>
                            <option value="domingo">Domingo</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Horário Início</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">Horário Fim</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveSchedule()">Salvar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configurar CSRF token
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Função para formatar telefone automaticamente
    function formatPhone(input) {
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        
        if (value.length <= 11) {
            // Formato para celular (11) 99999-9999 ou telefone fixo (11) 9999-9999
            if (value.length <= 2) {
                value = value.replace(/^(\d{0,2})/, '($1');
            } else if (value.length <= 6) {
                value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
            } else if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }
        }
        
        input.value = value;
    }    // Função para validar telefone
    function validatePhone(input) {
        const phoneRegex = /^\(\d{2}\) \d{4,5}-\d{4}$/;
        const isValid = phoneRegex.test(input.value);
        const errorDiv = document.getElementById('phone-error');
        
        if (!isValid && input.value.length > 0) {
            input.classList.add('is-invalid');
            errorDiv.textContent = 'Formato inválido. Use: (XX) XXXXX-XXXX para celular ou (XX) XXXX-XXXX para fixo';
        } else {
            input.classList.remove('is-invalid');
            errorDiv.textContent = '';
        }
        
        return isValid;
    }

    // Função para mostrar/ocultar campo de CNPJ
    function toggleCnpjField() {
        const checkbox = document.getElementById('has_cnpj');
        const cnpjField = document.getElementById('cnpj-field');
        const cnpjInput = document.getElementById('cnpj');
        
        if (checkbox.checked) {
            cnpjField.style.display = 'block';
            cnpjInput.setAttribute('required', 'required');
        } else {
            cnpjField.style.display = 'none';
            cnpjInput.removeAttribute('required');
            cnpjInput.value = '';
            cnpjInput.classList.remove('is-invalid');
            document.getElementById('cnpj-error').textContent = '';
        }
    }

    // Função para formatar CNPJ automaticamente
    function formatCnpj(input) {
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        
        if (value.length <= 14) {
            // Formato XX.XXX.XXX/XXXX-XX
            if (value.length <= 2) {
                value = value.replace(/^(\d{0,2})/, '$1');
            } else if (value.length <= 5) {
                value = value.replace(/^(\d{2})(\d{0,3})/, '$1.$2');
            } else if (value.length <= 8) {
                value = value.replace(/^(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
            } else if (value.length <= 12) {
                value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4})/, '$1.$2.$3/$4');
            } else {
                value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
            }
        }
        
        input.value = value;
    }

    // Função para validar CNPJ
    function validateCnpj(input) {
        const cnpjRegex = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;
        const isValid = cnpjRegex.test(input.value);
        const errorDiv = document.getElementById('cnpj-error');
        
        if (!isValid && input.value.length > 0) {
            input.classList.add('is-invalid');
            errorDiv.textContent = 'Formato inválido. Use: XX.XXX.XXX/XXXX-XX';
        } else {
            input.classList.remove('is-invalid');
            errorDiv.textContent = '';
        }
        
        return isValid;
    }    function editVendor(vendorId) {
        console.log('Editando vendedor ID:', vendorId);
        
        axios.get(`/api/vendors/${vendorId}`)
            .then(response => {
                const vendor = response.data;
                console.log('Dados do vendedor recebidos:', vendor);
                
                // Popular campos com os dados do vendedor
                document.getElementById('vendor_id').value = vendor.id;
                document.getElementById('name').value = vendor.name;
                document.getElementById('email').value = vendor.email;
                document.getElementById('phone').value = vendor.phone;
                document.getElementById('food_type').value = vendor.food_type;
                document.getElementById('description').value = vendor.description || '';
                document.getElementById('active').checked = vendor.active;
                
                // Carregar dados de CNPJ
                const hasCnpjCheckbox = document.getElementById('has_cnpj');
                hasCnpjCheckbox.checked = vendor.has_cnpj || false;
                document.getElementById('cnpj').value = vendor.cnpj || '';
                
                // Mostrar/ocultar campo de CNPJ baseado no checkbox
                toggleCnpjField();
                
                // Alterar título do modal
                document.querySelector('#vendorModal .modal-title').textContent = 'Editar Vendedor';
                
                console.log('Campos populados, mostrando modal...');
                
                // Mostrar modal usando data-bs-toggle (método mais confiável)
                const modalElement = document.getElementById('vendorModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.show();
            })
            .catch(error => {
                console.error('Erro ao carregar dados do vendedor:', error);
                modernToast.error('Erro ao carregar dados do vendedor');
            });
    }function saveVendor() {
        const form = document.getElementById('vendorForm');
        const phoneInput = document.getElementById('phone');
          // Validar telefone antes de enviar
        if (!validatePhone(phoneInput)) {
            phoneInput.focus();
            return;
        }
        
        // Validar CNPJ se estiver marcado
        const hasCnpjCheckbox = document.getElementById('has_cnpj');
        const cnpjInput = document.getElementById('cnpj');
        if (hasCnpjCheckbox.checked && !validateCnpj(cnpjInput)) {
            cnpjInput.focus();
            return;
        }
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Converter checkboxes para boolean
        data.active = document.getElementById('active').checked;
        data.has_cnpj = hasCnpjCheckbox.checked;
        
        // Se não possui CNPJ, limpar o campo
        if (!data.has_cnpj) {
            data.cnpj = '';
        }
        
        const vendorId = document.getElementById('vendor_id').value;
        const isEditing = vendorId !== '';
        
        console.log('Dados a serem enviados:', data); // Debug
        
        const request = isEditing 
            ? axios.put(`/api/vendors/${vendorId}`, data)
            : axios.post('/api/vendors', data);
              request
            .then(response => {
                console.log('Sucesso:', response.data); // Debug
                
                // Fechar o modal primeiro
                const modal = bootstrap.Modal.getInstance(document.getElementById('vendorModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Aguardar o modal fechar completamente antes de mostrar a notificação
                setTimeout(() => {
                    modernToast.success(isEditing ? 'Vendedor atualizado com sucesso!' : 'Vendedor criado com sucesso!');
                    
                    // Recarregar a página após um pequeno delay para o usuário ver a notificação
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }, 300);
            })
            .catch(error => {
                console.error('Erro completo:', error); // Debug
                if (error.response && error.response.data.errors) {
                    let errorMessage = 'Erro de validação:\n';
                    Object.values(error.response.data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += '- ' + error + '\n';
                        });
                    });                    modernToast.error(errorMessage);
                } else {
                    modernToast.error('Erro ao salvar vendedor: ' + (error.response?.data?.message || error.message));
                }
            });
    }

    function addSchedule(vendorId) {
        document.getElementById('schedule_vendor_id').value = vendorId;
        
        // Carregar boxes disponíveis
        axios.get('/api/boxes')
            .then(response => {
                const select = document.getElementById('schedule_box_id');
                select.innerHTML = '<option value="">Selecione um box</option>';
                  response.data.forEach(box => {
                    const option = document.createElement('option');
                    option.value = box.id;
                    option.textContent = (box.name || 'Box') + ' | Box ' + box.number + ' - ' + box.location;
                    select.appendChild(option);
                });
                
                new bootstrap.Modal(document.getElementById('scheduleModal')).show();
            })            .catch(error => {
                modernToast.error('Erro ao carregar boxes');
            });
    }    function saveSchedule() {
        const form = document.getElementById('scheduleForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
          axios.post('/api/schedules', data)
            .then(response => {
                // Fechar o modal primeiro
                const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Aguardar o modal fechar completamente antes de mostrar a notificação
                setTimeout(() => {
                    modernToast.success('Horário adicionado com sucesso!');
                    
                    // Recarregar a página após um pequeno delay para o usuário ver a notificação
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }, 300);
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    let errorMessage = 'Erro de validação:\n';
                    Object.values(error.response.data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += '- ' + error + '\n';
                        });
                    });                    modernToast.error(errorMessage);
                } else {
                    modernToast.error('Erro ao salvar horário');
                }
            });
    }    function deleteVendor(vendorId, vendorName) {
        modernToast.confirm(
            `Tem certeza que deseja excluir o vendedor "${vendorName}"?\n\nEsta ação não pode ser desfeita.`,
            'Confirmar Exclusão',
            () => {
                // Função executada ao confirmar
                axios.delete(`/api/vendors/${vendorId}`)
                    .then(response => {
                        modernToast.success('Vendedor excluído com sucesso!');
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Erro ao excluir vendedor:', error);
                        if (error.response && error.response.status === 400) {
                            modernToast.error('Não é possível excluir este vendedor pois ele possui registros associados (horários, entradas, etc.).');
                        } else {
                            modernToast.error('Erro ao excluir vendedor: ' + (error.response?.data?.message || error.message));
                        }
                    });
            }
        );
    }    // Limpar form quando modal é fechado
    document.getElementById('vendorModal').addEventListener('hidden.bs.modal', function () {
        console.log('Modal fechado - limpando formulário');
        document.getElementById('vendorForm').reset();
        document.getElementById('vendor_id').value = '';
        document.querySelector('#vendorModal .modal-title').textContent = 'Novo Vendedor';
        
        // Limpar validações visuais
        document.querySelectorAll('#vendorForm .is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('#vendorForm .invalid-feedback').forEach(el => {
            el.textContent = '';
        });
        
        // Garantir que o campo CNPJ fique oculto
        document.getElementById('cnpj-field').style.display = 'none';
    });    document.getElementById('scheduleModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('scheduleForm').reset();
    });
    
    // Debug do modal - adicionar eventos para detectar problemas
    document.getElementById('vendorModal').addEventListener('show.bs.modal', function () {
        console.log('Modal de vendedor sendo mostrado');
    });
    
    document.getElementById('vendorModal').addEventListener('shown.bs.modal', function () {
        console.log('Modal de vendedor totalmente carregado');
    });
      document.getElementById('vendorModal').addEventListener('hide.bs.modal', function (event) {
        console.log('Modal de vendedor sendo fechado - razão:', event);
    });
    
    // Adicionar eventos de formatação e validação aos campos
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('phone');
        const cnpjInput = document.getElementById('cnpj');
        
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                formatPhone(this);
            });
            phoneInput.addEventListener('blur', function() {
                validatePhone(this);
            });
        }
        
        if (cnpjInput) {
            cnpjInput.addEventListener('input', function() {
                formatCnpj(this);
            });
            cnpjInput.addEventListener('blur', function() {
                validateCnpj(this);
            });
        }
    });
</script>
@endsection
