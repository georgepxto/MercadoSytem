# Validação e Formatação de Telefone - Sistema de Vendedores

## Funcionalidades Implementadas

### 1. Validação Backend (Laravel)

-   **Localização**: `app/Http/Controllers/Api/VendorController.php`
-   **Regex**: `/^\(\d{2}\) \d{4,5}-\d{4}$/`
-   **Formatos Aceitos**:
    -   Celular: `(11) 99999-9999` (9 dígitos)
    -   Fixo: `(11) 3333-4444` (8 dígitos)
-   **Mensagem de Erro**: "O telefone deve estar no formato (XX) XXXXX-XXXX para celular ou (XX) XXXX-XXXX para fixo"

### 2. Formatação Automática Frontend (JavaScript)

-   **Localização**: `resources/views/vendors.blade.php`
-   **Função**: `formatPhone(input)`
-   **Comportamento**:
    -   Remove caracteres não numéricos
    -   Aplica formatação automaticamente conforme o usuário digita
    -   Suporte para números de 8 e 9 dígitos

### 3. Validação Frontend (JavaScript)

-   **Função**: `validatePhone(input)`
-   **Visual**: Adiciona classe `is-invalid` e mostra mensagem de erro
-   **Validação em Tempo Real**: Executa nos eventos `oninput` e `onblur`

### 4. Integração com Formulário

-   **Campo**: Input com placeholder `(11) 99999-9999`
-   **Máximo**: 15 caracteres
-   **Validação Antes do Envio**: Impede submit se telefone inválido

## Exemplos de Uso

### Números Válidos ✓

```
(11) 99999-9999  # Celular
(11) 3333-4444   # Fixo
(21) 98765-4321  # Celular RJ
(47) 3555-7788   # Fixo SC
```

### Números Inválidos ✗

```
11 99999-9999    # Sem parênteses
(11) 999999999   # Sem hífen
11999999999      # Apenas números
(011) 99999-9999 # DDD com 3 dígitos
```

## Arquivos Modificados

1. **VendorController.php**

    - Adicionada validação regex nos métodos `store()` e `update()`
    - Mensagens de erro personalizadas

2. **vendors.blade.php**

    - Adicionadas funções JavaScript `formatPhone()` e `validatePhone()`
    - Campo de telefone com formatação automática
    - Validação visual com Bootstrap

3. **Dados Existentes**
    - Todos os telefones foram corrigidos para o formato padrão
    - VendorSeeder já estava com formato correto

## Como Testar

1. **Interface Web**: Acesse `/vendors` e clique em "Novo Vendedor"
2. **Página de Teste**: Acesse `/test-phone.html` para testar a formatação
3. **API**: Teste via curl/Postman nos endpoints `/api/vendors`

## Benefícios

-   ✅ Consistência nos dados
-   ✅ Melhor experiência do usuário
-   ✅ Validação completa (frontend + backend)
-   ✅ Formatação automática
-   ✅ Suporte para telefones fixos e celulares
-   ✅ Compatível com todos os DDDs brasileiros
