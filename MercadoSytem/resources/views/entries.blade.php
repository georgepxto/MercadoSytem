@extends('layouts.app')

@section('title', 'Histórico - Sistema de Controle')
@section('page-title', 'Histórico de Entradas')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-funnel me-2"></i>
                        Filtros
                    </h5>
                    <button class="btn btn-outline-light btn-sm" onclick="clearFilters()">
                        <i class="bi bi-x-circle me-1"></i>
                        Limpar
                    </button>
                </div>
            </div>            <div class="card-body p-3">
                <form class="row g-3" id="filterForm">
                    <div class="col-lg-3 col-md-6 col-12">
                        <label for="filter_vendor" class="form-label fw-semibold">Vendedor</label>
                        <select class="form-select" id="filter_vendor">
                            <option value="">Todos os vendedores</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <label for="filter_box" class="form-label fw-semibold">Box</label>
                        <select class="form-select" id="filter_box">
                            <option value="">Todos os boxes</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <label for="filter_date_from" class="form-label fw-semibold">Data Início</label>
                        <input type="date" class="form-control" id="filter_date_from">
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <label for="filter_date_to" class="form-label fw-semibold">Data Fim</label>
                        <input type="date" class="form-control" id="filter_date_to">
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                <i class="bi bi-funnel-fill me-1"></i>
                                Filtrar
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                <i class="bi bi-x-circle me-1"></i>
                                Limpar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Registros de Entrada/Saída
                    </h5>
                    <span id="totalRecords" class="badge bg-light text-dark">{{ $entries->total() }} registros</span>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive d-none d-lg-block">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Vendedor</th>
                                <th>Box</th>
                                <th>Entrada</th>
                                <th>Saída</th>
                                <th>Tempo Total</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="entriesTableBody">
                            @foreach($entries as $entry)
                            <tr>
                                <td>{{ $entry->entry_date->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                            {{ substr($entry->vendor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $entry->vendor->name }}</div>
                                            <small class="text-muted">{{ $entry->vendor->food_type }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $entry->box->number }}</span>
                                    <br>
                                    <small class="text-muted">{{ $entry->box->location }}</small>
                                </td>
                                <td>{{ $entry->entry_time->format('H:i') }}</td>
                                <td>
                                    @if($entry->exit_time)
                                        {{ $entry->exit_time->format('H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($entry->exit_time)
                                        @php
                                            $totalMinutes = $entry->entry_time->diffInMinutes($entry->exit_time);
                                            $hours = floor($totalMinutes / 60);
                                            $minutes = $totalMinutes % 60;
                                        @endphp
                                        {{ $hours }}h {{ $minutes }}min
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($entry->exit_time)
                                        <span class="badge bg-secondary">Finalizado</span>
                                    @else
                                        <span class="badge bg-success">Ativo</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$entry->exit_time)
                                        <button class="btn btn-sm btn-warning" onclick="checkOut({{ $entry->id }})">
                                            <i class="bi bi-box-arrow-right"></i>
                                            Check-out
                                        </button>
                                    @endif
                                    @if($entry->notes)
                                        <button class="btn btn-sm btn-outline-info" onclick="showNotes('{{ $entry->notes }}')" title="Ver observações">
                                            <i class="bi bi-chat-text"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-lg-none" id="mobileEntriesContainer">
                    @foreach($entries as $entry)
                    <div class="card mb-3 border-start border-3 @if($entry->exit_time) border-secondary @else border-success @endif">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                                        <span class="fw-bold">{{ substr($entry->vendor->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <h6 class="mb-1 fw-bold text-truncate">{{ $entry->vendor->name }}</h6>
                                        <small class="text-muted">{{ $entry->vendor->food_type }}</small>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    @if($entry->exit_time)
                                        <span class="badge bg-secondary">Finalizado</span>
                                    @else
                                        <span class="badge bg-success">Ativo</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="small text-muted mb-1">Data</div>
                                    <div class="fw-semibold">{{ $entry->entry_date->format('d/m/Y') }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted mb-1">Box</div>
                                    <div>
                                        <span class="badge bg-secondary me-1">{{ $entry->box->number }}</span>
                                        <small class="text-muted">{{ $entry->box->location }}</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted mb-1">Entrada</div>
                                    <div class="fw-semibold">{{ $entry->entry_time->format('H:i') }}</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted mb-1">Saída</div>
                                    <div class="fw-semibold">
                                        @if($entry->exit_time)
                                            {{ $entry->exit_time->format('H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted mb-1">Tempo Total</div>
                                    <div class="fw-semibold">
                                        @if($entry->exit_time)
                                            @php
                                                $totalMinutes = $entry->entry_time->diffInMinutes($entry->exit_time);
                                                $hours = floor($totalMinutes / 60);
                                                $minutes = $totalMinutes % 60;
                                            @endphp
                                            {{ $hours }}h {{ $minutes }}min
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if(!$entry->exit_time || $entry->notes)
                            <div class="d-flex gap-2">
                                @if(!$entry->exit_time)
                                    <button class="btn btn-warning btn-sm flex-grow-1" onclick="checkOut({{ $entry->id }})">
                                        <i class="bi bi-box-arrow-right me-1"></i>
                                        Check-out
                                    </button>
                                @endif
                                @if($entry->notes)
                                    <button class="btn btn-outline-info btn-sm" onclick="showNotes('{{ $entry->notes }}')" title="Ver observações">
                                        <i class="bi bi-chat-text"></i>
                                    </button>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

                @if($entries->count() == 0)
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhum registro encontrado</h5>
                        <p class="text-muted">Não há registros de entrada/saída no período selecionado.</p>
                    </div>
                @endif
            </div>
            @if($entries->hasPages())
            <div class="card-footer">
                {{ $entries->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="notesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Observações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="notesContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configurar CSRF token
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');    // Carregar dados iniciais
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página de entries carregada');
        loadFilterOptions();
    });

    function loadFilterOptions() {
        console.log('Carregando opções de filtro...');
        
        // Carregar vendedores
        axios.get('/api/vendors')
            .then(response => {
                console.log('Vendedores carregados:', response.data.length);
                const select = document.getElementById('filter_vendor');
                response.data.forEach(vendor => {
                    const option = document.createElement('option');
                    option.value = vendor.id;
                    option.textContent = vendor.name + ' - ' + vendor.food_type;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar vendedores:', error);
            });

        // Carregar boxes
        axios.get('/api/boxes')
            .then(response => {
                console.log('Boxes carregados:', response.data.length);
                const select = document.getElementById('filter_box');
                response.data.forEach(box => {
                    const option = document.createElement('option');
                    option.value = box.id;
                    option.textContent = (box.name || 'Box') + ' | Box ' + box.number + ' - ' + box.location;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar boxes:', error);
            });
    }    function applyFilters() {
        console.log('=== APLICANDO FILTROS ===');
        
        const vendorId = document.getElementById('filter_vendor').value;
        const boxId = document.getElementById('filter_box').value;
        const dateFrom = document.getElementById('filter_date_from').value;
        const dateTo = document.getElementById('filter_date_to').value;

        console.log('Filtros selecionados:', {
            vendorId,
            boxId,
            dateFrom,
            dateTo
        });

        let params = new URLSearchParams();
        
        if (vendorId) {
            params.append('vendor_id', vendorId);
            console.log('Adicionado filtro vendor_id:', vendorId);
        }
        if (boxId) {
            params.append('box_id', boxId);
            console.log('Adicionado filtro box_id:', boxId);
        }
        if (dateFrom) {
            params.append('date_from', dateFrom);
            console.log('Adicionado filtro date_from:', dateFrom);
        }
        if (dateTo) {
            params.append('date_to', dateTo);
            console.log('Adicionado filtro date_to:', dateTo);
        }

        const queryString = params.toString();
        const url = queryString ? `/api/entries?${queryString}` : '/api/entries';

        console.log('URL final da API:', url);

        // Mostrar loading
        const tbody = document.getElementById('entriesTableBody');
        const mobileContainer = document.getElementById('mobileEntriesContainer');
        
        if (tbody) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                        <p class="mt-2 mb-0">Aplicando filtros...</p>
                    </td>
                </tr>
            `;
        }

        if (mobileContainer) {
            mobileContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2 mb-0">Aplicando filtros...</p>
                </div>
            `;
        }

        axios.get(url)
            .then(response => {
                console.log('Resposta da API recebida:', response.data.length, 'registros');
                console.log('Primeiros 3 registros:', response.data.slice(0, 3));
                
                updateEntriesTable(response.data);
                updateMobileEntries(response.data);
                
                const totalElement = document.getElementById('totalRecords');
                if (totalElement) {
                    totalElement.textContent = response.data.length + ' registros';
                }
                
                // Feedback de sucesso
                if (typeof modernToast !== 'undefined') {
                    modernToast.success(`Filtros aplicados! ${response.data.length} registros encontrados.`);
                } else {
                    alert(`Filtros aplicados! ${response.data.length} registros encontrados.`);
                }
                
                console.log('=== FILTROS APLICADOS COM SUCESSO ===');
            })
            .catch(error => {
                console.error('Erro ao aplicar filtros:', error);
                console.error('Resposta de erro:', error.response);
                
                if (typeof modernToast !== 'undefined') {
                    modernToast.error('Erro ao aplicar filtros: ' + (error.response?.data?.message || error.message));
                } else {
                    alert('Erro ao aplicar filtros: ' + (error.response?.data?.message || error.message));
                }
            });
    }

    function updateEntriesTable(entries) {
        const tbody = document.getElementById('entriesTableBody');
        
        if (entries.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhum registro encontrado</h5>
                        <p class="text-muted">Não há registros com os filtros aplicados.</p>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        entries.forEach(entry => {
            const entryDate = new Date(entry.entry_date).toLocaleDateString('pt-BR');
            const entryTime = new Date(entry.entry_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
            const exitTime = entry.exit_time ? new Date(entry.exit_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'}) : '-';
            
            let totalTime = '-';
            if (entry.exit_time) {
                const totalMinutes = Math.floor((new Date(entry.exit_time) - new Date(entry.entry_time)) / (1000 * 60));
                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;
                totalTime = `${hours}h ${minutes}min`;
            }

            html += `
                <tr>
                    <td>${entryDate}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                ${entry.vendor.name.charAt(0)}
                            </div>
                            <div>
                                <div class="fw-bold">${entry.vendor.name}</div>
                                <small class="text-muted">${entry.vendor.food_type}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-secondary">${entry.box.number}</span>
                        <br>
                        <small class="text-muted">${entry.box.location}</small>
                    </td>
                    <td>${entryTime}</td>
                    <td>${exitTime}</td>
                    <td>${totalTime}</td>
                    <td>
                        ${entry.exit_time ? '<span class="badge bg-secondary">Finalizado</span>' : '<span class="badge bg-success">Ativo</span>'}
                    </td>
                    <td>
                        ${!entry.exit_time ? `<button class="btn btn-sm btn-warning" onclick="checkOut(${entry.id})"><i class="bi bi-box-arrow-right"></i> Check-out</button>` : ''}
                        ${entry.notes ? `<button class="btn btn-sm btn-outline-info" onclick="showNotes('${entry.notes.replace(/'/g, "\\'")}')" title="Ver observações"><i class="bi bi-chat-text"></i></button>` : ''}
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    function updateMobileEntries(entries) {
        const mobileContainer = document.getElementById('mobileEntriesContainer');
        if (!mobileContainer) return;
        
        if (entries.length === 0) {
            mobileContainer.innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum registro encontrado</h5>
                    <p class="text-muted">Não há registros com os filtros aplicados.</p>
                </div>
            `;
            return;
        }

        let html = '';
        entries.forEach(entry => {
            const entryDate = new Date(entry.entry_date).toLocaleDateString('pt-BR');
            const entryTime = new Date(entry.entry_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
            const exitTime = entry.exit_time ? new Date(entry.exit_time).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'}) : '-';
            
            let totalTime = '-';
            if (entry.exit_time) {
                const totalMinutes = Math.floor((new Date(entry.exit_time) - new Date(entry.entry_time)) / (1000 * 60));
                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;
                totalTime = `${hours}h ${minutes}min`;
            }

            const statusBadge = entry.exit_time ? 
                '<span class="badge bg-secondary">Finalizado</span>' : 
                '<span class="badge bg-success">Ativo</span>';

            const checkoutButton = !entry.exit_time ? 
                `<button class="btn btn-warning btn-sm flex-grow-1" onclick="checkOut(${entry.id})">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Check-out
                </button>` : '';

            const notesButton = entry.notes ? 
                `<button class="btn btn-outline-info btn-sm" onclick="showNotes('${entry.notes.replace(/'/g, "\\'")}'" title="Ver observações">
                    <i class="bi bi-chat-text"></i>
                </button>` : '';

            html += `
                <div class="card mb-3 border-start border-3 ${entry.exit_time ? 'border-secondary' : 'border-success'}">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="d-flex align-items-center flex-grow-1">
                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                                    <span class="fw-bold">${entry.vendor.name.charAt(0)}</span>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="mb-1 fw-bold text-truncate">${entry.vendor.name}</h6>
                                    <small class="text-muted">${entry.vendor.food_type}</small>
                                </div>
                            </div>
                            <div class="ms-2">
                                ${statusBadge}
                            </div>
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="small text-muted mb-1">Data</div>
                                <div class="fw-semibold">${entryDate}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted mb-1">Box</div>
                                <div>
                                    <span class="badge bg-secondary me-1">${entry.box.number}</span>
                                    <small class="text-muted">${entry.box.location}</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted mb-1">Entrada</div>
                                <div class="fw-semibold">${entryTime}</div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted mb-1">Saída</div>
                                <div class="fw-semibold">${exitTime}</div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted mb-1">Tempo Total</div>
                                <div class="fw-semibold">${totalTime}</div>
                            </div>
                        </div>

                        ${(checkoutButton || notesButton) ? `
                        <div class="d-flex gap-2">
                            ${checkoutButton}
                            ${notesButton}
                        </div>` : ''}
                    </div>
                </div>
            `;
        });

        mobileContainer.innerHTML = html;
    }

    function clearFilters() {
        document.getElementById('filter_vendor').value = '';
        document.getElementById('filter_box').value = '';
        document.getElementById('filter_date_from').value = '';
        document.getElementById('filter_date_to').value = '';
        
        location.reload();
    }    function checkOut(entryId) {
        modernToast.confirm(
            'Confirma o check-out deste vendedor?',
            'Confirmar Check-out',
            () => {
                // Função executada ao confirmar
                axios.post(`/api/entries/${entryId}/checkout`)
                    .then(response => {
                        modernToast.success('Check-out realizado com sucesso!');
                        location.reload();
                    })
                    .catch(error => {
                        modernToast.error('Erro ao fazer check-out: ' + (error.response?.data?.message || error.message));
                    });
            }
        );
    }

    function showNotes(notes) {
        document.getElementById('notesContent').textContent = notes;
        new bootstrap.Modal(document.getElementById('notesModal')).show();
    }
</script>
@endsection
