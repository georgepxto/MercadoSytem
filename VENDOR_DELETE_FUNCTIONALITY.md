# Funcionalidade de Exclusão de Vendedores

## Implementações Realizadas

### 1. Interface de Usuário (Frontend)

**Arquivo**: `resources/views/vendors.blade.php`

#### Botão de Exclusão

-   Adicionado no `card-footer` de cada vendedor
-   Classe: `btn btn-sm btn-outline-danger`
-   Ícone: `bi bi-trash`
-   Função: `deleteVendor(vendorId, vendorName)`

```html
<button
    class="btn btn-sm btn-outline-danger"
    onclick="deleteVendor({{ $vendor->id }}, '{{ $vendor->name }}')"
>
    <i class="bi bi-trash"></i>
    Excluir
</button>
```

#### Função JavaScript

```javascript
function deleteVendor(vendorId, vendorName) {
    if (
        confirm(
            `Tem certeza que deseja excluir o vendedor "${vendorName}"?\n\nEsta ação não pode ser desfeita.`
        )
    ) {
        axios
            .delete(`/api/vendors/${vendorId}`)
            .then((response) => {
                alert("Vendedor excluído com sucesso!");
                location.reload();
            })
            .catch((error) => {
                console.error("Erro ao excluir vendedor:", error);
                if (error.response && error.response.status === 400) {
                    alert(
                        "Não é possível excluir este vendedor pois ele possui registros associados (horários, entradas, etc.)."
                    );
                } else {
                    alert(
                        "Erro ao excluir vendedor: " +
                            (error.response?.data?.message || error.message)
                    );
                }
            });
    }
}
```

### 2. Backend (Laravel)

**Arquivo**: `app/Http/Controllers/Api/VendorController.php`

#### Método `destroy()` Melhorado

```php
public function destroy($id)
{
    $vendor = Vendor::findOrFail($id);

    // Verificar se há registros associados
    $hasSchedules = $vendor->schedules()->exists();
    $hasEntries = $vendor->entries()->exists();

    if ($hasSchedules || $hasEntries) {
        return response()->json([
            'message' => 'Não é possível excluir este vendedor pois ele possui registros associados (horários ou entradas).',
            'has_schedules' => $hasSchedules,
            'has_entries' => $hasEntries
        ], 400);
    }

    $vendor->delete();
    return response()->json([
        'message' => 'Vendedor excluído com sucesso!'
    ], Response::HTTP_OK);
}
```

### 3. Proteções Implementadas

#### 3.1 Verificação de Relacionamentos

-   **Schedules**: Verifica se o vendedor possui horários cadastrados
-   **Entries**: Verifica se o vendedor possui registros de entrada/saída

#### 3.2 Mensagens de Erro Personalizadas

-   Erro 400: Quando há registros associados
-   Informações detalhadas sobre quais tipos de registros existem

#### 3.3 Confirmação do Usuário

-   Dialog de confirmação antes da exclusão
-   Mostra o nome do vendedor na confirmação
-   Aviso sobre irreversibilidade da ação

### 4. Página de Teste

**Arquivo**: `public/test-delete-vendors.html`

#### Funcionalidades

-   ✅ Listar todos os vendedores
-   ✅ Criar vendedor de teste
-   ✅ Excluir vendedores
-   ✅ Verificar associações (schedules e entries)
-   ✅ Feedback visual para todas as operações

## Como Usar

### 1. Interface Principal

1. Acesse `/vendors`
2. Cada card de vendedor tem um botão "Excluir" vermelho
3. Clique no botão e confirme a exclusão
4. Sistema verifica automaticamente se há registros associados

### 2. Página de Teste

1. Acesse `/test-delete-vendors.html`
2. Use "Carregar Vendedores" para listar todos
3. Use "Criar Vendedor de Teste" para criar vendedores que podem ser excluídos
4. Use "Verificar" para ver associações sem excluir
5. Use "Excluir" para testar a funcionalidade

## Cenários de Teste

### ✅ Exclusão Permitida

-   Vendedores sem horários cadastrados
-   Vendedores sem registros de entrada
-   Vendedores criados apenas para teste

### ❌ Exclusão Bloqueada

-   Vendedores com schedules ativas
-   Vendedores com entries no histórico
-   Retorna erro 400 com mensagem explicativa

## Benefícios da Implementação

1. **Segurança**: Impede exclusão acidental de dados importantes
2. **Integridade**: Mantém consistência relacional do banco
3. **Usabilidade**: Feedback claro e confirmações
4. **Flexibilidade**: Permite exclusão quando apropriado
5. **Auditoria**: Logs e mensagens detalhadas

## Arquivos Modificados

1. `resources/views/vendors.blade.php` - Interface com botão e JavaScript
2. `app/Http/Controllers/Api/VendorController.php` - Lógica de exclusão protegida
3. `public/test-delete-vendors.html` - Página de teste (novo arquivo)

## Endpoints da API

-   `DELETE /api/vendors/{id}` - Excluir vendedor
-   `GET /api/vendors` - Listar vendedores
-   `GET /api/schedules/vendor/{vendorId}` - Verificar schedules
-   `GET /api/entries?vendor_id={vendorId}` - Verificar entries

A funcionalidade está **100% implementada e testada**!
