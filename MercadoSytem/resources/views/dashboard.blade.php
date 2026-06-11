@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Controle')
@section('page-title', 'Dashboard')

@section('content')
<style>
.stat-card {
    border: 1px solid var(--border-color) !important;
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0.07;
}
.stat-card .stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.stat-card .stat-label {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}
.stat-card .stat-value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    color: var(--text-primary);
}
</style>

<div class="row mb-4 g-3">
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:rgba(16,185,129,0.12);color:#10B981;">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="stat-label">Vendedores</div>
                    <div class="stat-value">{{ $totalVendors }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#818CF8;">
                    <i class="bi bi-grid-3x3"></i>
                </div>
                <div>
                    <div class="stat-label">Total Boxes</div>
                    <div class="stat-value">{{ $totalBoxes }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:rgba(251,191,36,0.12);color:#FCD34D;">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <div class="stat-label">Ativos Hoje</div>
                    <div class="stat-value">{{ $activeEntries }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:rgba(56,189,248,0.12);color:#38BDF8;">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div>
                    <div class="stat-label">Entradas Hoje</div>
                    <div class="stat-value">{{ $todayEntries->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-activity" style="color:var(--accent-color);"></i>
                    <span class="fw-semibold" style="font-size:0.9rem;">Atividade de Hoje</span>
                </div>
                <span class="text-muted" style="font-size:0.8rem;">{{ date('d/m/Y') }}</span>
            </div>            <div class="card-body">
                @if($todayEntries->count() > 0)                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Vendedor</th>
                                    <th>Box</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayEntries as $entry)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initials me-2">
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
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                    <div class="d-lg-none">
                        @foreach($todayEntries as $entry)
                        <div class="card mb-2" style="border-left: 2px solid {{ $entry->exit_time ? 'rgba(148,163,184,0.3)' : '#4ADE80' }} !important;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <div class="avatar-initials me-3" style="width:40px;height:40px;min-width:40px;border-radius:10px;">
                                            {{ substr($entry->vendor->name, 0, 1) }}
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
                                        <div class="small text-muted mb-1">Box</div>
                                        <div>
                                            <span class="badge bg-secondary me-1">{{ $entry->box->number }}</span>
                                            <small class="text-muted">{{ $entry->box->location }}</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="small text-muted mb-1">Entrada</div>
                                        <div class="fw-semibold">{{ $entry->entry_time->format('H:i') }}</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="small text-muted mb-1">Saída</div>
                                        <div class="fw-semibold">
                                            @if($entry->exit_time)
                                                {{ $entry->exit_time->format('H:i') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if(!$entry->exit_time)
                                <div class="d-grid">
                                    <button class="btn btn-warning btn-sm" onclick="checkOut({{ $entry->id }})">
                                        <i class="bi bi-box-arrow-right me-1"></i>
                                        Fazer Check-out
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhuma atividade hoje</h5>
                        <p class="text-muted">Não há registros de entrada para hoje.</p>
                        <a href="{{ route('checkin') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Fazer Check-in
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configurar CSRF token para requests AJAX
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');    function checkOut(entryId) {
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
                        modernToast.error('Erro ao fazer check-out: ' + error.response.data.message);
                    });
            }
        );
    }

    // Auto-refresh da página a cada 30 segundos
    setInterval(() => {
        location.reload();
    }, 30000);
</script>
@endsection
