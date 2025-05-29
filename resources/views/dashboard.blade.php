@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Controle')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">Total Vendedores</div>
                        <div class="fs-2 fw-bold">{{ $totalVendors }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">Total Boxes</div>
                        <div class="fs-2 fw-bold">{{ $totalBoxes }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-grid-3x3 fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">Ativos Hoje</div>
                        <div class="fs-2 fw-bold">{{ $activeEntries }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-person-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">Entradas Hoje</div>
                        <div class="fs-2 fw-bold">{{ $todayEntries->count() }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box-arrow-in-right fs-1"></i>
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
            </div>
            <div class="card-body">
                @if($todayEntries->count() > 0)
                    <div class="table-responsive">
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
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function checkOut(entryId) {
        if (confirm('Confirma o check-out deste vendedor?')) {
            axios.post(`/api/entries/${entryId}/checkout`)
                .then(response => {
                    location.reload();
                })
                .catch(error => {
                    alert('Erro ao fazer check-out: ' + error.response.data.message);
                });
        }
    }

    // Auto-refresh da página a cada 30 segundos
    setInterval(() => {
        location.reload();
    }, 30000);
</script>
@endsection
