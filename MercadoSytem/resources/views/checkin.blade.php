@extends('layouts.app')

@section('title', 'Check-in/Check-out - Sistema de Controle')
@section('page-title', 'Check-in / Check-out')

@section('content')
<div class="row g-3">
    <div class="col-lg-6 col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Fazer Check-in
                </h5>
            </div>
            <div class="card-body p-3">
                <form id="checkinForm">
                    <div class="mb-3">
                        <label for="vendor_id" class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i>
                            Vendedor
                        </label>
                        <select class="form-select form-select-lg" id="vendor_id" name="vendor_id" required>
                            <option value="">Selecione um vendedor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" data-food-type="{{ $vendor->food_type }}">
                                    {{ $vendor->name }} - {{ $vendor->food_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="box_id" class="form-label fw-semibold">
                            <i class="bi bi-grid-3x3 me-1"></i>
                            Box
                        </label>
                        <select class="form-select form-select-lg" id="box_id" name="box_id" required>
                            <option value="">Selecione um box</option>                            @foreach($boxes as $box)
                                <option value="{{ $box->id }}">
                                    {{ $box->name }} | Box {{ $box->number }} - {{ $box->location }}
                                    @if($box->monthly_price)
                                        (R$ {{ number_format($box->monthly_price, 2, ',', '.') }}/mês)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-semibold">
                            <i class="bi bi-chat-text me-1"></i>
                            Observações (opcional)
                        </label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Observações sobre o check-in..."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>
                            Fazer Check-in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-check me-2"></i>
                    Vendedores Ativos
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="activeVendors">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Últimas Atividades
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="recentEntries">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configurar CSRF token
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Carregar dados iniciais
    document.addEventListener('DOMContentLoaded', function() {
        loadActiveVendors();
        loadRecentEntries();
    });

    // Form de check-in
    document.getElementById('checkinForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        axios.post('/api/entries', data)
            .then(response => {
                modernToast.success('Check-in realizado com sucesso!');
                this.reset();
                loadActiveVendors();
                loadRecentEntries();
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
                    modernToast.error('Erro ao fazer check-in: ' + (error.response?.data?.message || error.message));
                }
            });
    });

    function loadActiveVendors() {
        axios.get('/api/entries/today')
            .then(response => {
                const activeVendors = response.data.filter(entry => !entry.exit_time);
                const container = document.getElementById('activeVendors');
                
                if (activeVendors.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-3">
                            <i class="bi bi-person-x fs-2 text-muted"></i>
                            <p class="text-muted mb-0">Nenhum vendedor ativo</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                activeVendors.forEach(entry => {
                    html += `                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <div class="fw-bold">${entry.vendor.name}</div>
                                <small class="text-muted">${entry.box.name ? entry.box.name + ' | ' : ''}Box ${entry.box.number} - desde ${new Date(entry.entry_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'})}</small>
                            </div>
                            <button class="btn btn-sm btn-warning" onclick="checkOut(${entry.id})">
                                <i class="bi bi-box-arrow-right"></i>
                                Check-out
                            </button>
                        </div>
                    `;
                });
                
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar vendedores ativos:', error);
            });
    }

    function loadRecentEntries() {
        axios.get('/api/entries/today')
            .then(response => {
                const entries = response.data.slice(0, 5); // Últimas 5 entradas
                const container = document.getElementById('recentEntries');
                
                if (entries.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-3">
                            <i class="bi bi-clock fs-2 text-muted"></i>
                            <p class="text-muted mb-0">Nenhuma atividade hoje</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="table-responsive"><table class="table table-sm"><tbody>';
                entries.forEach(entry => {
                    const entryTime = new Date(entry.entry_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
                    const exitTime = entry.exit_time ? new Date(entry.exit_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'}) : null;
                    
                    html += `
                        <tr>
                            <td>
                                <strong>${entry.vendor.name}</strong><br>
                                <small class="text-muted">${entry.vendor.food_type}</small>
                            </td>
                            <td>Box ${entry.box.number}</td>
                            <td>${entryTime}</td>
                            <td>${exitTime || '<span class="text-success">Ativo</span>'}</td>
                        </tr>
                    `;
                });
                html += '</tbody></table></div>';
                
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar entradas recentes:', error);
            });
    }    function checkOut(entryId) {
        modernToast.confirm(
            'Confirma o check-out deste vendedor?',
            'Confirmar Check-out',
            () => {
                // Função executada ao confirmar
                axios.post(`/api/entries/${entryId}/checkout`)
                    .then(response => {
                        modernToast.success('Check-out realizado com sucesso!');
                        loadActiveVendors();
                        loadRecentEntries();
                    })
                    .catch(error => {
                        modernToast.error('Erro ao fazer check-out: ' + (error.response?.data?.message || error.message));
                    });
            }
        );
    }

    // Auto-refresh a cada 15 segundos
    setInterval(() => {
        loadActiveVendors();
        loadRecentEntries();
    }, 15000);
</script>
@endsection
