@extends('layouts.app')

@section('title', 'Boxes - Sistema de Controle')
@section('page-title', 'Boxes do Mercado')

@section('page-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#boxModal">
    <i class="bi bi-plus-circle"></i>
    Novo Box
</button>
@endsection

@section('content')
<div class="row g-3">
    @foreach($boxes as $box)
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card h-100 border-0 shadow-sm {{ $box->status === 'disponivel' ? '' : 'border-warning border-2' }}">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-3">                    <div class="flex-grow-1">
                        <h5 class="card-title mb-1">
                            <i class="bi bi-grid-3x3-gap me-2"></i>
                            {{ $box->name }} | Box {{ $box->number }}
                        </h5>
                        <p class="text-muted mb-0 small">{{ $box->location }}</p>
                    </div>
                    <div class="ms-2">
                        <span class="badge {{ $box->status_class }}">{{ $box->status_text }}</span>
                    </div>
                </div>

                @if($box->monthly_price)
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded p-2 text-center">
                            <h6 class="text-primary mb-0">R$ {{ number_format($box->monthly_price, 2, ',', '.') }}/mês</h6>
                        </div>
                    </div>
                @endif

                @if($box->description)
                    <p class="text-muted small mb-3">{{ $box->description }}</p>
                @endif

                @if($box->schedules->count() > 0)
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-clock me-1"></i>
                            Horários Ocupados:
                        </h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach($box->schedules as $schedule)
                                @if($schedule->active)
                                    <div class="bg-light rounded p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="fw-semibold text-truncate">{{ $schedule->vendor->name }}</div>
                                                <small class="text-muted">{{ $schedule->vendor->food_type }}</small>
                                            </div>
                                            <div class="text-end ms-2">
                                                <span class="badge bg-secondary mb-1">{{ ucfirst($schedule->day_of_week) }}</span>
                                                <div class="small">{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-calendar-x text-muted fs-4"></i>
                        <p class="text-muted small mb-0">Nenhum horário agendado</p>
                    </div>
                @endif
            </div>
            
            <div class="card-footer bg-transparent p-3 pt-0">
                <div class="d-none d-md-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="editBox({{ $box->id }})">
                        <i class="bi bi-pencil"></i>
                        Editar
                    </button>
                    <button class="btn btn-sm btn-outline-info" onclick="viewBoxDetails({{ $box->id }})">
                        <i class="bi bi-eye"></i>
                        Detalhes
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBox({{ $box->id }})">
                        <i class="bi bi-trash"></i>
                        Excluir
                    </button>
                </div>
                
                <div class="d-md-none">
                    <div class="btn-group w-100" role="group">
                        <button class="btn btn-outline-primary btn-sm" onclick="editBox({{ $box->id }})">
                            <i class="bi bi-pencil"></i>
                            Editar
                        </button>
                        <button class="btn btn-outline-info btn-sm" onclick="viewBoxDetails({{ $box->id }})">
                            <i class="bi bi-eye"></i>
                            Detalhes
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteBox({{ $box->id }})">
                            <i class="bi bi-trash"></i>
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="modal fade" id="boxModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">                <form id="boxForm">
                    <input type="hidden" id="box_id" name="box_id">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Box</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Ex: Box Principal, Box da Entrada, Box Familiar...">
                    </div>
                    
                    <div class="mb-3">
                        <label for="number" class="form-label">Número do Box</label>
                        <input type="text" class="form-control" id="number" name="number" required placeholder="Ex: A01, B15, C03...">
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Localização</label>
                        <input type="text" class="form-control" id="location" name="location" required placeholder="Ex: Setor A - Entrada Principal">
                    </div>

                    <div class="mb-3">
                        <label for="monthly_price" class="form-label">Preço Mensal (R$)</label>
                        <input type="number" class="form-control" id="monthly_price" name="monthly_price" step="0.01" min="0" placeholder="800.00">
                    </div>

                    <div class="mb-3">
                        <label for="box_description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="box_description" name="description" rows="3" placeholder="Descrição do box, características especiais..."></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="available" name="available" checked>
                        <label class="form-check-label" for="available">Disponível</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveBox()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="boxDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="boxDetailsContent">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configurar CSRF token
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');    function editBox(boxId) {
        console.log('Editando box ID:', boxId);
        axios.get(`/api/boxes/${boxId}`)
            .then(response => {
                const box = response.data;
                console.log('Dados recebidos da API:', box);
                
                // Limpar formulário primeiro
                document.getElementById('boxForm').reset();
                
                // Popular campos com os dados do box
                document.getElementById('box_id').value = box.id;
                document.getElementById('name').value = box.name || '';
                document.getElementById('number').value = box.number || '';
                document.getElementById('location').value = box.location || '';
                document.getElementById('monthly_price').value = box.monthly_price || '';
                document.getElementById('box_description').value = box.description || '';
                document.getElementById('available').checked = box.available;
                
                console.log('Campos populados:');
                console.log('- Name:', document.getElementById('name').value);
                console.log('- Number:', document.getElementById('number').value);
                console.log('- Location:', document.getElementById('location').value);
                
                // Alterar título do modal
                document.querySelector('#boxModal .modal-title').textContent = 'Editar Box';
                
                // Aguardar um pouco antes de mostrar o modal para garantir que os campos foram populados
                setTimeout(() => {
                    new bootstrap.Modal(document.getElementById('boxModal')).show();
                }, 100);
            })            .catch(error => {
                modernToast.error('Erro ao carregar dados do box');
                console.error('Erro na API:', error);
            });
    }function saveBox() {
        const form = document.getElementById('boxForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Converter checkbox para boolean
        data.available = document.getElementById('available').checked;
        
        // Converter preço para número ou null
        data.monthly_price = data.monthly_price ? parseFloat(data.monthly_price) : null;
        
        const boxId = document.getElementById('box_id').value;
        const isEditing = boxId !== '';
        
        console.log('Dados sendo enviados:', data);
        console.log('Box ID:', boxId);
        console.log('Is Editing:', isEditing);
        
        const request = isEditing 
            ? axios.put(`/api/boxes/${boxId}`, data)
            : axios.post('/api/boxes', data);
              request            .then(response => {
                console.log('Resposta da API:', response.data);
                
                // Fechar o modal primeiro
                const modal = bootstrap.Modal.getInstance(document.getElementById('boxModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Aguardar o modal fechar completamente antes de mostrar a notificação
                setTimeout(() => {
                    modernToast.success(isEditing ? 'Box atualizado com sucesso!' : 'Box criado com sucesso!');
                    
                    // Recarregar a página após um pequeno delay para o usuário ver a notificação
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }, 300);
            })
            .catch(error => {
                console.error('Erro completo:', error);
                if (error.response && error.response.data.errors) {
                    let errorMessage = 'Erro de validação:\n';
                    Object.values(error.response.data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += '- ' + error + '\n';
                        });
                    });                    modernToast.error(errorMessage);
                } else {
                    modernToast.error('Erro ao salvar box: ' + (error.response?.data?.message || error.message));
                }
            });
    }

    function viewBoxDetails(boxId) {
        axios.get(`/api/boxes/${boxId}`)
            .then(response => {
                const box = response.data;
                
                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informações Básicas</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Número:</strong></td><td>Box ${box.number}</td></tr>
                                <tr><td><strong>Localização:</strong></td><td>${box.location}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge ${box.status_class}">${box.status_text}</span></td></tr>
                                ${box.monthly_price ? `<tr><td><strong>Preço:</strong></td><td>R$ ${parseFloat(box.monthly_price).toLocaleString('pt-BR', {minimumFractionDigits: 2})}/mês</td></tr>` : ''}
                                ${box.description ? `<tr><td><strong>Descrição:</strong></td><td>${box.description}</td></tr>` : ''}
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Horários Agendados</h6>
                `;
                
                if (box.schedules && box.schedules.length > 0) {
                    html += '<div class="table-responsive"><table class="table table-sm"><tbody>';
                    box.schedules.forEach(schedule => {
                        if (schedule.active) {
                            html += `
                                <tr>
                                    <td>
                                        <strong>${schedule.vendor.name}</strong><br>
                                        <small class="text-muted">${schedule.vendor.food_type}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">${schedule.day_of_week}</span><br>
                                        <small>${schedule.start_time.substring(0,5)} - ${schedule.end_time.substring(0,5)}</small>
                                    </td>
                                </tr>
                            `;
                        }
                    });
                    html += '</tbody></table></div>';
                } else {
                    html += '<p class="text-muted">Nenhum horário agendado</p>';
                }
                
                html += `
                        </div>
                    </div>
                `;
                
                // Buscar entradas recentes
                axios.get(`/api/entries?box_id=${boxId}`)
                    .then(entriesResponse => {
                        if (entriesResponse.data.length > 0) {
                            html += `
                                <hr>
                                <h6>Últimas Atividades</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead><tr><th>Vendedor</th><th>Data</th><th>Entrada</th><th>Saída</th></tr></thead>
                                        <tbody>
                            `;
                            
                            entriesResponse.data.slice(0, 5).forEach(entry => {
                                const entryDate = new Date(entry.entry_date).toLocaleDateString('pt-BR');
                                const entryTime = new Date(entry.entry_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
                                const exitTime = entry.exit_time ? new Date(entry.exit_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'}) : '-';
                                
                                html += `
                                    <tr>
                                        <td>${entry.vendor.name}</td>
                                        <td>${entryDate}</td>
                                        <td>${entryTime}</td>
                                        <td>${exitTime}</td>
                                    </tr>
                                `;
                            });
                            
                            html += '</tbody></table></div>';
                        }
                        
                        document.getElementById('boxDetailsContent').innerHTML = html;
                        new bootstrap.Modal(document.getElementById('boxDetailsModal')).show();
                    })
                    .catch(error => {
                        document.getElementById('boxDetailsContent').innerHTML = html;
                        new bootstrap.Modal(document.getElementById('boxDetailsModal')).show();
                    });
            })            .catch(error => {
                modernToast.error('Erro ao carregar detalhes do box');
            });
    }    // Limpar form quando modal é fechado
    document.getElementById('boxModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('boxForm').reset();
        document.getElementById('box_id').value = '';
        document.querySelector('#boxModal .modal-title').textContent = 'Novo Box';
    });

    function deleteBox(boxId) {
        // Buscar informações do box primeiro
        axios.get(`/api/boxes/${boxId}`)
            .then(response => {
                const box = response.data;
                const boxInfo = `Box ${box.number} (${box.location})`;
                
                // Verificar se há agendamentos ativos
                const activeSchedules = box.schedules ? box.schedules.filter(s => s.active).length : 0;
                const totalEntries = box.entries ? box.entries.length : 0;
                
                let warningMessage = '';
                if (activeSchedules > 0) {
                    warningMessage += `\n⚠️ Este box possui ${activeSchedules} agendamento(s) ativo(s).`;
                }
                if (totalEntries > 0) {
                    warningMessage += `\n⚠️ Este box possui ${totalEntries} entrada(s) no histórico.`;
                }
                  const confirmMessage = `Tem certeza que deseja excluir o ${boxInfo}?${warningMessage}\n\nEsta ação não pode ser desfeita.`;
                
                modernToast.confirm(
                    confirmMessage,
                    'Confirmar Exclusão',
                    () => {
                        // Função executada ao confirmar
                        axios.delete(`/api/boxes/${boxId}`)                        .then(response => {
                            modernToast.success('Box excluído com sucesso!');
                            location.reload();
                        })
                        .catch(error => {
                            console.error('Erro ao excluir box:', error);
                              if (error.response && error.response.data.error) {
                                modernToast.error('Erro: ' + error.response.data.error);
                            } else if (error.response && error.response.status === 422) {
                                modernToast.error('Erro: Não é possível excluir este box devido a relacionamentos existentes.');                            } else {
                                modernToast.error('Erro ao excluir box. Tente novamente.');
                            }
                        });
                    }
                );
            }).catch(error => {
                console.error('Erro ao carregar dados do box:', error);
                modernToast.error('Erro ao carregar dados do box.');
            });
    }
</script>
@endsection
