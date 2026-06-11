@extends('layouts.app')

@section('title', 'Histórico - Sistema de Controle')
@section('page-title', 'Histórico de Entradas')

@section('page-actions')
<a href="{{ route('entries.export') }}" id="exportBtn" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-download me-1"></i>Exportar CSV
</a>
@endsection

@section('content')
<style>
.filter-bar {
    display: flex; flex-wrap: wrap; gap: 0.5rem;
    align-items: flex-end; padding: 0.85rem 1rem;
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: 0.875rem; margin-bottom: 1.25rem;
}
.filter-bar .filter-group {
    display: flex; flex-direction: column; gap: 0.25rem; flex: 1; min-width: 130px;
}
.filter-bar .filter-label {
    font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--text-muted);
}
.filter-bar .form-select,
.filter-bar .form-control {
    font-size: 0.8rem; padding: 0.35rem 0.6rem; height: 32px; min-height: 32px;
}
.time-chip {
    display: inline-block; font-family: 'Rubik', monospace;
    font-size: 0.78rem; font-weight: 600; letter-spacing: 0.04em;
    padding: 0.15rem 0.55rem; border-radius: 6px;
    background: var(--bg-tertiary); color: var(--text-secondary);
}
.entry-active-row { background: rgba(16,185,129,0.04) !important; }
.table tbody tr { height: 52px; }
@media (max-width: 767px) {
    .filter-bar .filter-group { min-width: calc(50% - 0.5rem); }
}
</style>

{{-- Inline filter bar --}}
<div class="filter-bar">
    <div class="filter-group">
        <span class="filter-label">Vendedor</span>
        <select class="form-select" id="filter_vendor">
            <option value="">Todos</option>
        </select>
    </div>
    <div class="filter-group">
        <span class="filter-label">Box</span>
        <select class="form-select" id="filter_box">
            <option value="">Todos</option>
        </select>
    </div>
    <div class="filter-group">
        <span class="filter-label">De</span>
        <input type="date" class="form-control" id="filter_date_from">
    </div>
    <div class="filter-group">
        <span class="filter-label">Até</span>
        <input type="date" class="form-control" id="filter_date_to">
    </div>
    <div class="d-flex gap-2 align-items-end" style="flex-shrink:0;">
        <button type="button" class="btn btn-primary btn-sm" onclick="applyFilters()">
            <i class="bi bi-funnel-fill me-1"></i>Filtrar
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
            <i class="bi bi-x"></i>
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-list-ul" style="color:var(--accent-color);font-size:0.9rem;"></i>
            <span class="fw-semibold" style="font-size:0.875rem;">Registros</span>
        </div>
        <span id="totalRecords" class="badge bg-secondary">{{ $entries->total() }} registros</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive d-none d-lg-block">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="padding-left:1.25rem;">Data</th>
                        <th>Vendedor</th>
                        <th>Box</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Duração</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="entriesTableBody">
                    @foreach($entries as $entry)
                    <tr class="{{ !$entry->exit_time ? 'entry-active-row' : '' }}">
                        <td style="padding-left:1.25rem;vertical-align:middle;font-size:0.85rem;">
                            {{ $entry->entry_date->format('d/m/Y') }}
                        </td>
                        <td style="vertical-align:middle;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initials">{{ substr($entry->vendor->name, 0, 1) }}</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:0.875rem;">{{ $entry->vendor->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $entry->vendor->food_type }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="vertical-align:middle;">
                            <span class="badge bg-secondary">{{ $entry->box->number }}</span>
                        </td>
                        <td style="vertical-align:middle;">
                            <span class="time-chip">{{ $entry->entry_time->format('H:i') }}</span>
                        </td>
                        <td style="vertical-align:middle;">
                            @if($entry->exit_time)
                                <span class="time-chip">{{ $entry->exit_time->format('H:i') }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="vertical-align:middle;font-size:0.82rem;color:var(--text-muted);">
                            @if($entry->exit_time)
                                @php $mins = $entry->entry_time->diffInMinutes($entry->exit_time); @endphp
                                {{ floor($mins/60) }}h {{ $mins%60 }}min
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="vertical-align:middle;">
                            @if($entry->exit_time)
                                <span class="badge bg-secondary">Finalizado</span>
                            @else
                                <span class="badge bg-success">Ativo</span>
                            @endif
                        </td>
                        <td style="vertical-align:middle;text-align:right;padding-right:1.25rem;">
                            @if(!$entry->exit_time)
                                <button class="btn btn-sm btn-warning" onclick="checkOut({{ $entry->id }})">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            @endif
                            @if($entry->notes)
                                <button class="btn btn-sm btn-outline-secondary" onclick="showNotes('{{ addslashes($entry->notes) }}')" title="Observações">
                                    <i class="bi bi-chat-text"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="d-lg-none p-3" id="mobileEntriesContainer">
            @foreach($entries as $entry)
            <div class="card mb-2" style="border-left:2px solid {{ $entry->exit_time ? 'var(--border-color)' : '#10B981' }} !important;{{ !$entry->exit_time ? 'background:rgba(16,185,129,0.04);' : '' }}">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2 flex-grow-1 min-width-0">
                            <div class="avatar-initials" style="flex-shrink:0;">{{ substr($entry->vendor->name, 0, 1) }}</div>
                            <div class="min-width-0">
                                <div class="fw-semibold text-truncate" style="font-size:0.875rem;">{{ $entry->vendor->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $entry->vendor->food_type }}</div>
                            </div>
                        </div>
                        @if($entry->exit_time)
                            <span class="badge bg-secondary ms-2 flex-shrink-0">Finalizado</span>
                        @else
                            <span class="badge bg-success ms-2 flex-shrink-0">Ativo</span>
                        @endif
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap mb-2" style="font-size:0.8rem;">
                        <span class="badge bg-secondary">Box {{ $entry->box->number }}</span>
                        <span class="text-muted">{{ $entry->entry_date->format('d/m/Y') }}</span>
                        <span class="time-chip">{{ $entry->entry_time->format('H:i') }}</span>
                        @if($entry->exit_time)<span class="time-chip">{{ $entry->exit_time->format('H:i') }}</span>@endif
                    </div>
                    @if(!$entry->exit_time || $entry->notes)
                    <div class="d-flex gap-2">
                        @if(!$entry->exit_time)
                            <button class="btn btn-warning btn-sm flex-grow-1" onclick="checkOut({{ $entry->id }})">
                                <i class="bi bi-box-arrow-right me-1"></i>Check-out
                            </button>
                        @endif
                        @if($entry->notes)
                            <button class="btn btn-outline-secondary btn-sm" onclick="showNotes('{{ addslashes($entry->notes) }}')" title="Observações">
                                <i class="bi bi-chat-text"></i>
                            </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($entries->count() == 0)
        <div class="text-center py-5">
            <i class="bi bi-inbox mb-3" style="font-size:2.5rem;color:var(--text-muted);opacity:0.25;display:block;"></i>
            <h6 style="color:var(--text-secondary);">Nenhum registro encontrado</h6>
            <p class="text-muted small mb-0">Tente ajustar os filtros acima.</p>
        </div>
        @endif
    </div>

    @if($entries->hasPages())
    <div class="card-footer">
        {{ $entries->links() }}
    </div>
    @endif
</div>

<div class="modal fade" id="notesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Observações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"><p id="notesContent"></p></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.addEventListener('DOMContentLoaded', function() {
        loadFilterOptions();
    });

    function loadFilterOptions() {
        axios.get('/api/vendors').then(r => {
            const sel = document.getElementById('filter_vendor');
            r.data.forEach(v => {
                const o = document.createElement('option');
                o.value = v.id;
                o.textContent = v.name + ' — ' + v.food_type;
                sel.appendChild(o);
            });
        }).catch(() => {});

        axios.get('/api/boxes').then(r => {
            const sel = document.getElementById('filter_box');
            r.data.forEach(b => {
                const o = document.createElement('option');
                o.value = b.id;
                o.textContent = (b.name || 'Box') + ' | Box ' + b.number + ' — ' + b.location;
                sel.appendChild(o);
            });
        }).catch(() => {});
    }

    function buildExportUrl() {
        const params = new URLSearchParams();
        const v = document.getElementById('filter_vendor').value;
        const b = document.getElementById('filter_box').value;
        const df = document.getElementById('filter_date_from').value;
        const dt = document.getElementById('filter_date_to').value;
        if (v) params.set('vendor_id', v);
        if (b) params.set('box_id', b);
        if (df) params.set('date_from', df);
        if (dt) params.set('date_to', dt);
        return '/entries/export' + (params.toString() ? '?' + params.toString() : '');
    }

    document.querySelectorAll('#filter_vendor, #filter_box, #filter_date_from, #filter_date_to').forEach(el => {
        el.addEventListener('change', () => {
            document.getElementById('exportBtn').href = buildExportUrl();
        });
    });

    function applyFilters() {
        const params = new URLSearchParams();
        const v = document.getElementById('filter_vendor').value;
        const b = document.getElementById('filter_box').value;
        const df = document.getElementById('filter_date_from').value;
        const dt = document.getElementById('filter_date_to').value;
        if (v) params.set('vendor_id', v);
        if (b) params.set('box_id', b);
        if (df) params.set('date_from', df);
        if (dt) params.set('date_to', dt);

        const url = '/api/entries' + (params.toString() ? '?' + params.toString() : '');
        const tbody = document.getElementById('entriesTableBody');
        const mob = document.getElementById('mobileEntriesContainer');

        if (tbody) tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div></td></tr>';
        if (mob) mob.innerHTML = '<div class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div></div>';

        document.getElementById('exportBtn').href = buildExportUrl();

        axios.get(url).then(r => {
            updateEntriesTable(r.data);
            updateMobileEntries(r.data);
            const el = document.getElementById('totalRecords');
            if (el) el.textContent = r.data.length + ' registros';
            modernToast.success(r.data.length + ' registros encontrados.');
        }).catch(e => {
            modernToast.error('Erro ao filtrar: ' + (e.response?.data?.message || e.message));
        });
    }

    function clearFilters() {
        document.getElementById('filter_vendor').value = '';
        document.getElementById('filter_box').value = '';
        document.getElementById('filter_date_from').value = '';
        document.getElementById('filter_date_to').value = '';
        document.getElementById('exportBtn').href = '/entries/export';
        location.reload();
    }

    function parseDbDate(str) {
        if (!str) return null;
        return new Date(str.replace(' ', 'T'));
    }
    function formatDate(str) {
        const d = parseDbDate(str);
        if (!d || isNaN(d)) return '-';
        return d.toLocaleDateString('pt-BR');
    }
    function formatTime(str) {
        const d = parseDbDate(str);
        if (!d || isNaN(d)) return '-';
        return d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    }
    function calcTotalTime(entryStr, exitStr) {
        if (!exitStr) return '-';
        const e = parseDbDate(entryStr), x = parseDbDate(exitStr);
        if (!e || !x || isNaN(e) || isNaN(x)) return '-';
        const m = Math.floor((x - e) / 60000);
        return `${Math.floor(m/60)}h ${m%60}min`;
    }

    function updateEntriesTable(entries) {
        const tbody = document.getElementById('entriesTableBody');
        if (!tbody) return;
        if (entries.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5"><i class="bi bi-inbox d-block mb-2" style="font-size:2rem;opacity:0.2;"></i><span class="text-muted small">Nenhum registro encontrado</span></td></tr>';
            return;
        }
        tbody.innerHTML = entries.map(entry => {
            const active = !entry.exit_time;
            const rowBg = active ? 'background:rgba(16,185,129,0.04);' : '';
            const date = formatDate(entry.entry_date);
            const t1 = formatTime(entry.entry_time);
            const t2 = entry.exit_time ? formatTime(entry.exit_time) : null;
            const dur = calcTotalTime(entry.entry_time, entry.exit_time);
            return `
                <tr style="height:52px;${rowBg}">
                    <td style="padding-left:1.25rem;vertical-align:middle;font-size:0.85rem;">${date}</td>
                    <td style="vertical-align:middle;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-initials">${entry.vendor.name.charAt(0)}</div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.875rem;">${entry.vendor.name}</div>
                                <div class="text-muted" style="font-size:0.75rem;">${entry.vendor.food_type}</div>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align:middle;"><span class="badge bg-secondary">${entry.box.number}</span></td>
                    <td style="vertical-align:middle;"><span class="time-chip">${t1}</span></td>
                    <td style="vertical-align:middle;">${t2 ? `<span class="time-chip">${t2}</span>` : '<span class="text-muted">—</span>'}</td>
                    <td style="vertical-align:middle;font-size:0.82rem;color:var(--text-muted);">${dur}</td>
                    <td style="vertical-align:middle;">${active ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Finalizado</span>'}</td>
                    <td style="vertical-align:middle;text-align:right;padding-right:1.25rem;">
                        ${active ? `<button class="btn btn-sm btn-warning" onclick="checkOut(${entry.id})"><i class="bi bi-box-arrow-right"></i></button>` : ''}
                        ${entry.notes ? `<button class="btn btn-sm btn-outline-secondary" onclick="showNotes('${entry.notes.replace(/'/g,"\\'")}')"><i class="bi bi-chat-text"></i></button>` : ''}
                    </td>
                </tr>`;
        }).join('');
    }

    function updateMobileEntries(entries) {
        const mob = document.getElementById('mobileEntriesContainer');
        if (!mob) return;
        if (entries.length === 0) {
            mob.innerHTML = '<div class="text-center py-5"><i class="bi bi-inbox d-block mb-2" style="font-size:2rem;opacity:0.2;"></i><span class="text-muted small">Nenhum registro encontrado</span></div>';
            return;
        }
        mob.innerHTML = entries.map(entry => {
            const active = !entry.exit_time;
            const t1 = formatTime(entry.entry_time);
            const t2 = entry.exit_time ? formatTime(entry.exit_time) : null;
            return `
                <div class="card mb-2" style="border-left:2px solid ${active ? '#10B981' : 'var(--border-color)'} !important;${active ? 'background:rgba(16,185,129,0.04);' : ''}">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2 flex-grow-1 min-width-0">
                                <div class="avatar-initials" style="flex-shrink:0;">${entry.vendor.name.charAt(0)}</div>
                                <div class="min-width-0">
                                    <div class="fw-semibold text-truncate" style="font-size:0.875rem;">${entry.vendor.name}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">${entry.vendor.food_type}</div>
                                </div>
                            </div>
                            <span class="badge ${active ? 'bg-success' : 'bg-secondary'} ms-2 flex-shrink-0">${active ? 'Ativo' : 'Finalizado'}</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center flex-wrap mb-2" style="font-size:0.8rem;">
                            <span class="badge bg-secondary">Box ${entry.box.number}</span>
                            <span class="text-muted">${formatDate(entry.entry_date)}</span>
                            <span class="time-chip">${t1}</span>
                            ${t2 ? `<span class="time-chip">${t2}</span>` : ''}
                        </div>
                        ${active || entry.notes ? `<div class="d-flex gap-2">
                            ${active ? `<button class="btn btn-warning btn-sm flex-grow-1" onclick="checkOut(${entry.id})"><i class="bi bi-box-arrow-right me-1"></i>Check-out</button>` : ''}
                            ${entry.notes ? `<button class="btn btn-outline-secondary btn-sm" onclick="showNotes('${entry.notes.replace(/'/g,"\\'")}')"><i class="bi bi-chat-text"></i></button>` : ''}
                        </div>` : ''}
                    </div>
                </div>`;
        }).join('');
    }

    function checkOut(entryId) {
        modernToast.confirm('Confirma o check-out deste vendedor?', 'Confirmar Check-out', () => {
            axios.post(`/api/entries/${entryId}/checkout`)
                .then(() => { modernToast.success('Check-out realizado!'); location.reload(); })
                .catch(e => { modernToast.error('Erro: ' + (e.response?.data?.message || e.message)); });
        });
    }

    function showNotes(notes) {
        document.getElementById('notesContent').textContent = notes;
        new bootstrap.Modal(document.getElementById('notesModal')).show();
    }
</script>
@endsection
