@extends('layouts.admin')

@section('title', 'Dashboard Administrativo')

@section('content')
<style>
.admin-stat-card { border: 1px solid var(--border-color); transition: transform 0.15s ease; }
.admin-stat-card:hover { transform: translateY(-1px); }
.admin-stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem; flex-shrink: 0;
}
.admin-stat-label {
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.09em;
    text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.2rem;
}
.admin-stat-value { font-size: 1.9rem; font-weight: 700; line-height: 1; color: var(--text-primary); }
</style>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="admin-stat-icon" style="background:rgba(16,185,129,0.12);color:#10B981;">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Total Usuários</div>
                    <div class="admin-stat-value">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="admin-stat-icon" style="background:rgba(52,211,153,0.12);color:#34D399;">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Ativos</div>
                    <div class="admin-stat-value">{{ $activeUsers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="admin-stat-icon" style="background:rgba(251,191,36,0.12);color:#FCD34D;">
                    <i class="bi bi-person-dash"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Inativos</div>
                    <div class="admin-stat-value">{{ $inactiveUsers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="admin-stat-icon" style="background:rgba(56,189,248,0.12);color:#38BDF8;">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Dashboards</div>
                    <div class="admin-stat-value">{{ $users->where('has_dashboard_access', true)->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people" style="color:#10B981;font-size:0.9rem;"></i>
            <span class="fw-semibold" style="font-size:0.875rem;">Usuários Recentes</span>
        </div>
        <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-people me-1"></i>Gerenciar
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="padding-left:1.25rem;">Nome</th>
                        <th>E-mail</th>
                        <th>Dashboard</th>
                        <th>Status</th>
                        <th>Criado em</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users->take(10) as $user)
                        <tr>
                            <td style="padding-left:1.25rem;vertical-align:middle;">{{ $user->name }}</td>
                            <td style="vertical-align:middle;font-size:0.85rem;">{{ $user->email }}</td>
                            <td style="vertical-align:middle;">
                                <span class="badge bg-secondary">{{ $user->getDashboardName() }}</span>
                            </td>
                            <td style="vertical-align:middle;">
                                @if($user->has_dashboard_access)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td style="vertical-align:middle;font-size:0.82rem;color:var(--text-muted);">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum usuário encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
