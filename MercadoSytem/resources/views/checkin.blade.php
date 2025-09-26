@extends('layouts.app')

@section('title', 'Check-in/Check-out - Sistema de Controle')
@section('page-title', 'Check-in / Check-out')

@push('styles')
<style>
    .filter-panel {
        transition: all 0.3s ease;
        border-top: 3px solid transparent;
    }
    
    .filter-panel.show {
        border-top-color: var(--bs-info);
    }
    
    .btn-filter-toggle {
        transition: all 0.2s ease;
    }
    
    .btn-filter-toggle:hover {
        transform: translateY(-1px);
    }
    
    .filter-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .activity-duration {
        font-weight: 500;
        color: #6c757d;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.075);
        transition: background-color 0.2s ease;
    }
    
    .filter-count {
        font-size: 0.6rem !important;
        min-width: 18px;
        height: 18px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        animation: pulse 0.3s ease-in-out;
    }
    
    @keyframes pulse {
        0% { transform: scale(0.8); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #17a2b8;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .search-highlight {
        background-color: yellow;
        font-weight: bold;
        padding: 2px 4px;
        border-radius: 3px;
    }
    
    /* Melhorias para mobile */
    @media (max-width: 768px) {
        #activeVendors .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        
        #activeVendors .flex-shrink-0 {
            width: 100%;
        }
        
        #activeVendors .btn {
            width: 100%;
            justify-content: center;
        }
        
        .card-body {
            padding: 1rem !important;
        }
    }
    
    /* Garantir que o container seja visível */
    #activeVendors {
        min-height: 60px;
        position: relative;
    }
</style>
@endpush

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
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-check me-2"></i>
                        Vendedores Ativos
                    </h5>
                    <button class="btn btn-sm btn-outline-light" onclick="loadActiveVendors()" title="Recarregar">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <div id="activeVendors">
                    <div class="text-center py-3">
                        <div class="loading-spinner"></div>
                        <p class="text-muted mb-0 mt-2">Inicializando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Últimas Atividades
                    </h5>
                    <button class="btn btn-sm btn-outline-light btn-filter-toggle" id="toggleRecentFilters">
                        <i class="bi bi-funnel"></i>
                        Filtros
                    </button>
                </div>
            </div>
            
            <!-- Painel de Filtros - Últimas Atividades -->
            <div class="card-body p-0 filter-panel" id="recentFiltersPanel" style="display: none;">
                <div class="bg-light border-bottom p-3">
                    <div class="row g-2">
                        <div class="col-12 mb-2">
                            <label for="recentFilterSearch" class="form-label fw-semibold small">Buscar Vendedor</label>
                            <input type="text" class="form-control form-control-sm" id="recentFilterSearch" placeholder="Digite o nome do vendedor...">
                        </div>
                        <div class="col-md-4">
                            <label for="recentFilterFoodType" class="form-label fw-semibold small">Tipo de Comida</label>
                            <select class="form-select form-select-sm" id="recentFilterFoodType">
                                <option value="">Todos os tipos</option>
                                @foreach($vendors->pluck('food_type')->unique() as $foodType)
                                    <option value="{{ $foodType }}">{{ $foodType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="recentFilterStatus" class="form-label fw-semibold small">Status</label>
                            <select class="form-select form-select-sm" id="recentFilterStatus">
                                <option value="">Todos</option>
                                <option value="active">Ativos</option>
                                <option value="finished">Finalizados</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="recentFilterLimit" class="form-label fw-semibold small">Quantidade</label>
                            <select class="form-select form-select-sm" id="recentFilterLimit">
                                <option value="5">5 registros</option>
                                <option value="10">10 registros</option>
                                <option value="20">20 registros</option>
                                <option value="50">50 registros</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-info btn-sm me-2" onclick="applyRecentFilters()">
                                <i class="bi bi-funnel-fill me-1"></i> Filtrar
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="clearRecentFilters()">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpar
                            </button>
                        </div>
                    </div>
                </div>
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

    // Variável global para garantir que as funções estejam disponíveis
    window.applyRecentFilters = function() {
        console.log('Filtro aplicado!');
        
        const filters = {
            search: document.getElementById('recentFilterSearch')?.value || '',
            foodType: document.getElementById('recentFilterFoodType')?.value || '',
            status: document.getElementById('recentFilterStatus')?.value || '',
            limit: parseInt(document.getElementById('recentFilterLimit')?.value || '5')
        };
        
        // Remover filtros vazios (exceto limit)
        const cleanFilters = {};
        Object.keys(filters).forEach(key => {
            if (filters[key] && filters[key] !== '') {
                cleanFilters[key] = filters[key];
            }
        });
        if (!cleanFilters.limit) cleanFilters.limit = 5;
        
        console.log('Aplicando filtros:', cleanFilters);
        loadRecentEntries(cleanFilters);
        
        alert('Filtros aplicados com sucesso!');
    };

    window.clearRecentFilters = function() {
        console.log('Limpando filtros!');
        
        document.getElementById('recentFilterSearch').value = '';
        document.getElementById('recentFilterFoodType').value = '';
        document.getElementById('recentFilterStatus').value = '';
        document.getElementById('recentFilterLimit').value = '5';
        
        loadRecentEntries();
        alert('Filtros limpos!');
    };

    // Carregar dados iniciais
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página carregada, iniciando carregamento de dados...');
        
        // Verificar se axios está disponível
        if (typeof axios === 'undefined') {
            console.error('Axios não está carregado!');
            document.getElementById('activeVendors').innerHTML = `
                <div class="text-center py-3 text-danger">
                    <i class="bi bi-exclamation-triangle fs-2"></i>
                    <p class="mb-0">Erro: Biblioteca axios não carregada</p>
                </div>
            `;
            return;
        }
        
        // Verificar se o token CSRF está configurado
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
            console.log('Token CSRF configurado');
        } else {
            console.warn('Token CSRF não encontrado');
        }
        
        // Testar conectividade básica
        console.log('Testando conectividade...');
        
        // Teste de conectividade antes de carregar os dados
        axios.get('/api/entries/today')
            .then(response => {
                console.log('Teste de conectividade bem-sucedido:', response.status);
                console.log('Dados recebidos:', response.data.length, 'entradas');
                
                setTimeout(() => {
                    loadActiveVendors();
                    loadRecentEntries();
                }, 100);
            })
            .catch(error => {
                console.error('Erro no teste de conectividade:', error);
                document.getElementById('activeVendors').innerHTML = `
                    <div class="text-center py-3 text-danger">
                        <i class="bi bi-wifi-off fs-2"></i>
                        <p class="mb-1">Erro de conectividade</p>
                        <small>Código: ${error.response?.status || 'N/A'}</small>
                        <br>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="location.reload()">
                            <i class="bi bi-arrow-clockwise"></i> Recarregar página
                        </button>
                    </div>
                `;
            });
        
        // Toggle dos filtros
        const toggleBtn = document.getElementById('toggleRecentFilters');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const panel = document.getElementById('recentFiltersPanel');
                const isVisible = panel.style.display !== 'none';
                
                if (isVisible) {
                    panel.style.display = 'none';
                } else {
                    panel.style.display = 'block';
                }
                
                const icon = this.querySelector('i');
                icon.className = isVisible ? 'bi bi-funnel' : 'bi bi-funnel-fill';
            });
        }
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
        console.log('Carregando vendedores ativos...');
        
        const container = document.getElementById('activeVendors');
        if (!container) {
            console.error('Container activeVendors não encontrado!');
            return;
        }
        
        // Mostrar loading
        container.innerHTML = `
            <div class="text-center py-3">
                <div class="loading-spinner"></div>
                <p class="text-muted mb-0 mt-2">Carregando vendedores...</p>
            </div>
        `;
        
        axios.get('/api/entries/today')
            .then(response => {
                console.log('Resposta da API /api/entries/today:', response.data);
                
                const activeVendors = response.data.filter(entry => !entry.exit_time);
                console.log('Vendedores ativos filtrados:', activeVendors);
                
                if (activeVendors.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-3">
                            <i class="bi bi-person-x fs-2 text-muted"></i>
                            <p class="text-muted mb-0">Nenhum vendedor ativo</p>
                            <small class="text-muted">Total de entradas hoje: ${response.data.length}</small>
                        </div>
                    `;
                    return;
                }

                let html = '';
                activeVendors.forEach(entry => {
                    const entryTime = entry.entry_time;
                    const timeDisplay = entryTime ? new Date(`2000-01-01T${entryTime}`).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'}) : 'N/A';
                    
                    html += `
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div class="flex-grow-1 pe-2">
                                <div class="fw-bold">${entry.vendor.name}</div>
                                <small class="text-muted d-block">${entry.box.name ? entry.box.name + ' | ' : ''}Box ${entry.box.number}</small>
                                <small class="text-info">desde ${timeDisplay}</small>
                            </div>
                            <div class="flex-shrink-0">
                                <button class="btn btn-sm btn-warning" onclick="checkOut(${entry.id})" data-entry-id="${entry.id}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span class="d-none d-md-inline ms-1">Check-out</span>
                                </button>
                            </div>
                        </div>
                    `;
                });
                
                container.innerHTML = html;
                console.log('Vendedores ativos carregados com sucesso');
            })
            .catch(error => {
                console.error('Erro ao carregar vendedores ativos:', error);
                container.innerHTML = `
                    <div class="text-center py-3 text-danger">
                        <i class="bi bi-exclamation-triangle fs-2"></i>
                        <p class="mb-0">Erro ao carregar vendedores</p>
                        <small>Verifique a conexão</small>
                        <br>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadActiveVendors()">
                            <i class="bi bi-arrow-clockwise"></i> Tentar novamente
                        </button>
                    </div>
                `;
            });
    }    function loadRecentEntries(filters = {}) {
        console.log('Carregando entradas com filtros:', filters);
        
        const container = document.getElementById('recentEntries');
        if (!container) {
            console.error('Container recentEntries não encontrado!');
            return;
        }
        
        axios.get('/api/entries/today')
            .then(response => {
                console.log('API retornou', response.data.length, 'entradas');
                let entries = response.data;
                
                // Aplicar filtros
                if (filters.search) {
                    entries = entries.filter(entry => 
                        entry.vendor.name.toLowerCase().includes(filters.search.toLowerCase())
                    );
                    console.log('Após filtro de busca:', entries.length, 'entradas');
                }
                
                if (filters.foodType) {
                    entries = entries.filter(entry => entry.vendor.food_type === filters.foodType);
                    console.log('Após filtro de tipo:', entries.length, 'entradas');
                }
                
                if (filters.status === 'active') {
                    entries = entries.filter(entry => !entry.exit_time);
                    console.log('Após filtro ativo:', entries.length, 'entradas');
                } else if (filters.status === 'finished') {
                    entries = entries.filter(entry => entry.exit_time);
                    console.log('Após filtro finalizado:', entries.length, 'entradas');
                }
                
                // Limitar quantidade
                const limit = filters.limit || 5;
                entries = entries.slice(0, limit);
                console.log('Após limite:', entries.length, 'entradas');
                
                if (entries.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-3">
                            <i class="bi bi-clock fs-2 text-muted"></i>
                            <p class="text-muted mb-0">${Object.keys(filters).length > 0 ? 'Nenhuma atividade encontrada com os filtros aplicados' : 'Nenhuma atividade hoje'}</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="table-responsive"><table class="table table-sm table-hover"><thead><tr><th>Vendedor</th><th>Box</th><th>Entrada</th><th>Saída</th><th>Duração</th></tr></thead><tbody>';
                entries.forEach(entry => {
                    const entryTime = new Date(entry.entry_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
                    const exitTime = entry.exit_time ? new Date(entry.exit_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'}) : null;
                    
                    // Calcular duração
                    let duration = '';
                    if (entry.exit_time) {
                        const start = new Date(entry.entry_time);
                        const end = new Date(entry.exit_time);
                        const diffMs = end - start;
                        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                        const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                        duration = `${diffHours}h ${diffMinutes}m`;
                    } else {
                        const start = new Date(entry.entry_time);
                        const now = new Date();
                        const diffMs = now - start;
                        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                        const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                        duration = `${diffHours}h ${diffMinutes}m`;
                    }
                    
                    // Highlighting search terms
                    let vendorName = entry.vendor.name;
                    if (filters.search) {
                        const regex = new RegExp(`(${filters.search})`, 'gi');
                        vendorName = vendorName.replace(regex, '<span class="search-highlight">$1</span>');
                    }
                    
                    html += `
                        <tr>
                            <td>
                                <strong>${vendorName}</strong><br>
                                <small class="text-muted">
                                    <span class="badge bg-secondary filter-badge">${entry.vendor.food_type}</span>
                                </small>
                            </td>
                            <td>Box ${entry.box.number}<br><small class="text-muted">${entry.box.location || 'N/A'}</small></td>
                            <td>${entryTime}</td>
                            <td>${exitTime || '<span class="text-success fw-bold">Ativo</span>'}</td>
                            <td><span class="activity-duration">${duration}</span></td>
                        </tr>
                    `;
                });
                html += '</tbody></table></div>';
                
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar entradas recentes:', error);
                container.innerHTML = `
                    <div class="text-center py-3">
                        <i class="bi bi-exclamation-triangle fs-2 text-danger"></i>
                        <p class="text-danger mb-0">Erro ao carregar atividades recentes</p>
                    </div>                `;
            });
    }    // Funções para filtros de atividades recentes
    function applyRecentFilters() {
        console.log('applyRecentFilters called');
        
        // Mostrar feedback visual no botão
        const filterBtn = document.querySelector('button[onclick="applyRecentFilters()"]');
        if (!filterBtn) {
            console.error('Filter button not found!');
            return;
        }
        
        const originalText = filterBtn.innerHTML;
        filterBtn.disabled = true;
        filterBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Filtrando...';
        
        const filters = {
            search: document.getElementById('recentFilterSearch')?.value || '',
            foodType: document.getElementById('recentFilterFoodType')?.value || '',
            status: document.getElementById('recentFilterStatus')?.value || '',
            limit: parseInt(document.getElementById('recentFilterLimit')?.value || '5')
        };
        
        console.log('Filters collected:', filters);
        
        // Remover filtros vazios (exceto limit que sempre tem valor)
        Object.keys(filters).forEach(key => {
            if (!filters[key] && key !== 'limit') delete filters[key];
        });
        
        console.log('Filters after cleanup:', filters);
        
        loadRecentEntries(filters);
        
        const filterCount = Object.keys(filters).filter(key => key !== 'limit').length;
        const message = filterCount > 0 
            ? `${filterCount} filtro(s) aplicado(s) às atividades recentes`
            : 'Filtros aplicados às atividades recentes';
        
        if (typeof modernToast !== 'undefined') {
            modernToast.success(message);
        } else {
            console.log(message);
        }
        
        // Atualizar botão de filtros com badge
        const toggleBtn = document.getElementById('toggleRecentFilters');
        const badge = toggleBtn.querySelector('.filter-count');
        if (filterCount > 0) {
            if (!badge) {
                toggleBtn.innerHTML += `<span class="badge bg-warning filter-count ms-1">${filterCount}</span>`;
            } else {
                badge.textContent = filterCount;
            }
        } else if (badge) {
            badge.remove();
        }
        
        // Restaurar botão após um delay
        setTimeout(() => {
            filterBtn.disabled = false;
            filterBtn.innerHTML = originalText;
        }, 800);
    }

    function clearRecentFilters() {
        // Mostrar feedback visual no botão
        const clearBtn = document.querySelector('button[onclick="clearRecentFilters()"]');
        const originalText = clearBtn.innerHTML;
        clearBtn.disabled = true;
        clearBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Limpando...';
        
        document.getElementById('recentFilterSearch').value = '';
        document.getElementById('recentFilterFoodType').value = '';
        document.getElementById('recentFilterStatus').value = '';
        document.getElementById('recentFilterLimit').value = '5';
        loadRecentEntries();
        modernToast.info('Filtros limpos');
        
        // Remover badge do botão
        const toggleBtn = document.getElementById('toggleRecentFilters');
        const badge = toggleBtn.querySelector('.filter-count');
        if (badge) badge.remove();
        
        // Restaurar botão após um delay
        setTimeout(() => {
            clearBtn.disabled = false;
            clearBtn.innerHTML = originalText;
        }, 500);
    }

    function checkOut(entryId) {
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
