@extends('layouts.admin')

@section('title', 'Gerenciar Usuários')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Gerenciar Usuários</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fas fa-plus me-2"></i>Novo Usuário
                </button>
            </div>            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Dashboard</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.users.update-dashboard-name', $user) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="dashboard_name" 
                                                       value="{{ $user->getDashboardName() }}" required>
                                                <button class="btn btn-outline-primary" type="submit">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.users.toggle-access', $user) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $user->has_dashboard_access ? 'btn-success' : 'btn-danger' }}">
                                                @if($user->has_dashboard_access)
                                                    <i class="fas fa-check me-1"></i>Ativo
                                                @else
                                                    <i class="fas fa-times me-1"></i>Inativo
                                                @endif
                                            </button>
                                        </form>
                                    </td>                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm me-1" 
                                                data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->getDashboardName() }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="d-inline"
                                              id="deleteForm{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum usuário encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.create') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="dashboard_name" class="form-label">Nome da Dashboard (opcional)</label>
                        <input type="text" class="form-control" name="dashboard_name" 
                               placeholder="Se vazio, usará o nome do usuário">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="password" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" name="password_confirmation" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Usuário</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editUserForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_dashboard_name" class="form-label">Nome da Dashboard (opcional)</label>
                        <input type="text" class="form-control" name="dashboard_name" id="edit_dashboard_name" 
                               placeholder="Se vazio, usará o nome do usuário">
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" class="form-control" name="password" id="edit_password" minlength="8">
                    </div>
                    <div class="mb-3">
                        <label for="edit_password_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" name="password_confirmation" id="edit_password_confirmation" minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editUser(userId, name, email, dashboardName) {
    // Preencher o formulário de edição
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_dashboard_name').value = dashboardName;
    document.getElementById('edit_password').value = '';
    document.getElementById('edit_password_confirmation').value = '';
    
    // Atualizar a action do formulário
    document.getElementById('editUserForm').action = `/admin/users/${userId}`;
}

function confirmDelete(userId) {
    if (typeof modernToast !== 'undefined') {
        modernToast.confirm(
            'Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.',
            'Excluir Usuário',
            () => {
                // Confirmar - submeter o formulário
                document.getElementById('deleteForm' + userId).submit();
            },
            () => {
                // Cancelar - não fazer nada
                modernToast.info('Operação cancelada', 'Cancelado', 3000);
            }
        );
    } else {
        // Fallback para confirm nativo se modernToast não estiver disponível
        if (confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')) {
            document.getElementById('deleteForm' + userId).submit();
        }
    }
}
</script>
@endsection
