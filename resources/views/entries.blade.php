@extends('layouts.app')

@section('title', 'Histórico - Sistema de Controle')
@section('page-title', 'Histórico de Entradas')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history"></i>
                            Filtros
                        </h5>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                            <i class="bi bi-x-circle"></i>
                            Limpar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3" id="filterForm">
                    <div class="col-md-3">
                        <label for="filter_vendor" class="form-label">Vendedor</label>
                        <select class="form-select" id="filter_vendor">
                            <option value="">Todos os vendedores</option>
                            <!-- Será preenchido via JavaScript -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_box" class="form-label">Box</label>
                        <select class="form-select" id="filter_box">
                            <option value="">Todos os boxes</option>
                            <!-- Será preenchido via JavaScript -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_date_from" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="filter_date_from">
                    </div>
                    <div class="col-md-3">
                        <label for="filter_date_to" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="filter_date_to">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-ul"></i>
                            Registros de Entrada/Saída
                        </h5>
                    </div>
                    <div class="col-auto">
                        <span id="totalRecords" class="badge bg-secondary">{{ $entries->total() }} registros</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
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

<!-- Modal para mostrar observações -->
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
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Carregar dados iniciais
    document.addEventListener('DOMContentLoaded', function() {
        loadFilterOptions();
        setupFilterListeners();
    });

    function loadFilterOptions() {
        // Carregar vendedores
        axios.get('/api/vendors')
            .then(response => {
                const select = document.getElementById('filter_vendor');
                response.data.forEach(vendor => {
                    const option = document.createElement('option');
                    option.value = vendor.id;
                    option.textContent = vendor.name + ' - ' + vendor.food_type;
                    select.appendChild(option);
                });
            });

        // Carregar boxes
        axios.get('/api/boxes')
            .then(response => {
                const select = document.getElementById('filter_box');
                response.data.forEach(box => {
                    const option = document.createElement('option');
                    option.value = box.id;
                    option.textContent = 'Box ' + box.number + ' - ' + box.location;
                    select.appendChild(option);
                });
            });
    }

    function setupFilterListeners() {
        const filterInputs = ['filter_vendor', 'filter_box', 'filter_date_from', 'filter_date_to'];
        
        filterInputs.forEach(inputId => {
            document.getElementById(inputId).addEventListener('change', applyFilters);
        });
    }

    function applyFilters() {
        const vendorId = document.getElementById('filter_vendor').value;
        const boxId = document.getElementById('filter_box').value;
        const dateFrom = document.getElementById('filter_date_from').value;
        const dateTo = document.getElementById('filter_date_to').value;

        let params = new URLSearchParams();
        
        if (vendorId) params.append('vendor_id', vendorId);
        if (boxId) params.append('box_id', boxId);
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);

        const queryString = params.toString();
        const url = queryString ? `/api/entries?${queryString}` : '/api/entries';

        axios.get(url)
            .then(response => {
                updateEntriesTable(response.data);
                document.getElementById('totalRecords').textContent = response.data.length + ' registros';
            })
            .catch(error => {
                console.error('Erro ao aplicar filtros:', error);
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

    function clearFilters() {
        document.getElementById('filter_vendor').value = '';
        document.getElementById('filter_box').value = '';
        document.getElementById('filter_date_from').value = '';
        document.getElementById('filter_date_to').value = '';
        
        location.reload();
    }

    function checkOut(entryId) {
        if (confirm('Confirma o check-out deste vendedor?')) {
            axios.post(`/api/entries/${entryId}/checkout`)
                .then(response => {
                    alert('Check-out realizado com sucesso!');
                    location.reload();
                })
                .catch(error => {
                    alert('Erro ao fazer check-out: ' + (error.response?.data?.message || error.message));
                });
        }
    }

    function showNotes(notes) {
        document.getElementById('notesContent').textContent = notes;
        new bootstrap.Modal(document.getElementById('notesModal')).show();
    }
</script>
@endsection
