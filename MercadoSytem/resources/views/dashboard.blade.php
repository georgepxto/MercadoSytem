@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Controle')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4 g-2 g-sm-3">
    <div class="col-6 col-md-6 col-lg-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body p-2 p-sm-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-white-75 small mb-1" style="font-size: 0.75rem;">Total Vendedores</div>
                        <div class="fs-3 fs-sm-2 fw-bold">{{ $totalVendors }}</div>
                    </div>
                    <div class="ms-2">
                        <i class="bi bi-people fs-2 fs-sm-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body p-2 p-sm-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-white-75 small mb-1" style="font-size: 0.75rem;">Total Boxes</div>
                        <div class="fs-3 fs-sm-2 fw-bold">{{ $totalBoxes }}</div>
                    </div>
                    <div class="ms-2">
                        <i class="bi bi-grid-3x3 fs-2 fs-sm-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body p-2 p-sm-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-white-75 small mb-1" style="font-size: 0.75rem;">Ativos Hoje</div>
                        <div class="fs-3 fs-sm-2 fw-bold">{{ $activeEntries }}</div>
                    </div>
                    <div class="ms-2">
                        <i class="bi bi-person-check fs-2 fs-sm-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body p-2 p-sm-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-white-75 small mb-1" style="font-size: 0.75rem;">Entradas Hoje</div>
                        <div class="fs-3 fs-sm-2 fw-bold">{{ $todayEntries->count() }}</div>
                    </div>
                    <div class="ms-2">
                        <i class="bi bi-box-arrow-in-right fs-2 fs-sm-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock"></i>
                    Atividade de Hoje - {{ date('d/m/Y') }}
                </h5>
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
                                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
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
