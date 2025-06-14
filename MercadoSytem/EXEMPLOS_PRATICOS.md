# 🔧 Exemplos Práticos de Uso - Sistema de Feira Alimentar

## 🎯 **Guia de Demonstração**

Este documento contém exemplos práticos detalhados de como usar todas as funcionalidades do sistema, especialmente as funcionalidades de CNPJ e validações.

---

## 📋 **CENÁRIO 1: CADASTRO DE VENDEDOR PESSOA FÍSICA**

### **Passo a Passo:**

1. **Acesse a página de vendedores:**

    ```
    URL: http://localhost:8000/vendors
    ```

2. **Clique em "Novo Vendedor"**

3. **Preencha os dados:**

    ```
    Nome: Maria Silva
    Email: maria.silva@email.com
    Telefone: 11999998888 → Formata para (11) 99999-8888
    Tipo de Comida: Pastéis e Salgados
    Descrição: Especialista em pastéis caseiros, mais de 10 anos de experiência
    Ativo: ✓ (marcado)
    Possui CNPJ?: ✗ (desmarcado) → Campo CNPJ não aparece
    ```

4. **Clique em "Salvar"**

### **Resultado Esperado:**

-   ✅ Vendedor criado com sucesso
-   ✅ Telefone formatado automaticamente
-   ✅ CNPJ não aparece na listagem
-   ✅ Status "Ativo" com badge verde

---

## 🏢 **CENÁRIO 2: CADASTRO DE VENDEDOR PESSOA JURÍDICA**

### **Passo a Passo:**

1. **Acesse a página de vendedores e clique em "Novo Vendedor"**

2. **Preencha os dados básicos:**

    ```
    Nome: Restaurante Sabor & Cia Ltda
    Email: contato@sabor.com.br
    Telefone: 1133334444 → Formata para (11) 3333-4444
    Tipo de Comida: Comida Italiana
    Descrição: Massas artesanais e pizzas tradicionais
    Ativo: ✓ (marcado)
    ```

3. **Marque "Possui CNPJ?":**

    ```
    Possui CNPJ?: ✓ (marcado) → Campo CNPJ aparece
    ```

4. **Preencha o CNPJ:**

    ```
    CNPJ: 12345678000190 → Formata para 12.345.678/0001-90
    ```

5. **Clique em "Salvar"**

### **Resultado Esperado:**

-   ✅ Vendedor criado com sucesso
-   ✅ CNPJ formatado automaticamente
-   ✅ CNPJ aparece na listagem com ícone 🏢
-   ✅ Todas as validações passaram

---

## ❌ **CENÁRIO 3: TESTE DE VALIDAÇÕES DE CNPJ**

### **3.1 CNPJ com Formato Inválido:**

**Teste:**

```
1. Marque "Possui CNPJ?"
2. Digite: 123456789 (formato incompleto)
3. Tente salvar
```

**Resultado:**

```
❌ Erro: "Formato inválido. Use: XX.XXX.XXX/XXXX-XX"
❌ Campo fica com borda vermelha
❌ Foco retorna para o campo CNPJ
```

### **3.2 CNPJ Obrigatório Não Preenchido:**

**Teste:**

```
1. Marque "Possui CNPJ?"
2. Deixe campo CNPJ vazio
3. Tente salvar
```

**Resultado:**

```
❌ Erro do servidor: "O CNPJ é obrigatório quando 'Possui CNPJ' está marcado"
❌ Status HTTP 422 (Unprocessable Entity)
```

### **3.3 Alternância de Checkbox:**

**Teste:**

```
1. Marque "Possui CNPJ?" → Campo aparece
2. Preencha CNPJ: 12.345.678/0001-90
3. Desmarque "Possui CNPJ?" → Campo desaparece + valor limpo
4. Marque novamente → Campo aparece vazio
```

**Resultado:**

```
✅ Campo CNPJ aparece/desaparece conforme esperado
✅ Valor é limpo quando desmarcado
✅ Campo fica obrigatório apenas quando marcado
```

---

## ✏️ **CENÁRIO 4: EDIÇÃO DE VENDEDOR EXISTENTE**

### **4.1 Adicionar CNPJ a Vendedor Existente:**

**Passo a Passo:**

1. **Na listagem, clique em "Editar" em um vendedor sem CNPJ**
2. **Modal abre com dados preenchidos:**

    ```
    Nome: João Silva (já preenchido)
    Email: joao@email.com (já preenchido)
    ...outros campos...
    Possui CNPJ?: ✗ (desmarcado - sem CNPJ)
    ```

3. **Marque "Possui CNPJ?"**
4. **Preencha o CNPJ:** `11222333000144`
5. **Clique em "Salvar"**

**Resultado:**

```
✅ Vendedor atualizado com sucesso
✅ CNPJ agora aparece na listagem: "CNPJ: 11.222.333/0001-44"
✅ Ícone 🏢 aparece ao lado do CNPJ
```

### **4.2 Remover CNPJ de Vendedor Existente:**

**Passo a Passo:**

1. **Edite um vendedor que possui CNPJ**
2. **Modal abre com dados preenchidos:**

    ```
    Possui CNPJ?: ✓ (marcado)
    CNPJ: 12.345.678/0001-90 (preenchido)
    ```

3. **Desmarque "Possui CNPJ?"**
4. **Campo CNPJ desaparece automaticamente**
5. **Clique em "Salvar"**

**Resultado:**

```
✅ Vendedor atualizado com sucesso
✅ CNPJ removido da listagem
✅ Linha do CNPJ não aparece mais no card
```

---

## 📞 **CENÁRIO 5: TESTE DE VALIDAÇÃO DE TELEFONE**

### **5.1 Telefone Celular:**

**Teste:**

```
Digite: 11999998888
Resultado: (11) 99999-8888 ✅
```

### **5.2 Telefone Fixo:**

**Teste:**

```
Digite: 1133334444
Resultado: (11) 3333-4444 ✅
```

### **5.3 Telefone Inválido:**

**Teste:**

```
Digite: 123456789 (muito curto)
Resultado: ❌ Erro de validação
Mensagem: "O telefone deve estar no formato (XX) XXXXX-XXXX..."
```

---

## ⏰ **CENÁRIO 6: DEFINIÇÃO DE HORÁRIOS**

### **Passo a Passo:**

1. **Na listagem de vendedores, clique em "Horário"**

2. **Preencha o formulário:**

    ```
    Vendedor: (pré-selecionado)
    Box: Selecione "A01 - Setor A - Entrada Principal"
    Dia da Semana: segunda
    Horário Início: 08:00
    Horário Fim: 17:00
    ```

3. **Clique em "Salvar"**

4. **Repita para outros dias:**
    ```
    Terça: 08:00 - 17:00
    Quarta: 08:00 - 17:00
    Quinta: 08:00 - 17:00
    Sexta: 08:00 - 16:00
    ```

### **Resultado:**

-   ✅ Horários aparecem no card do vendedor
-   ✅ Cada dia listado com horário e box
-   ✅ Sistema valida conflitos automaticamente

---

## 🚪 **CENÁRIO 7: CHECK-IN E CHECK-OUT**

### **7.1 Check-in de Vendedor:**

**Passo a Passo:**

1. **Acesse:** `http://localhost:8000/checkin`
2. **Preencha o formulário:**
    ```
    Vendedor: Selecione "Maria Silva"
    Box: Selecione "A01"
    ```
3. **Clique em "Registrar Entrada"**

**Resultado:**

```
✅ Check-in registrado: 2025-05-29 14:30:00
✅ Vendedor aparece na lista "Vendedores Ativos"
✅ Box A01 marcado como ocupado
✅ Dashboard atualiza métricas automaticamente
```

### **7.2 Check-out de Vendedor:**

**Passo a Passo:**

1. **Na lista "Vendedores Ativos", localize "Maria Silva"**
2. **Clique em "Check-out"**

**Resultado:**

```
✅ Check-out registrado: 2025-05-29 18:00:00
✅ Vendedor removido da lista "Vendedores Ativos"
✅ Box A01 fica disponível novamente
✅ Tempo de permanência: 3h 30min
```

---

## 📊 **CENÁRIO 8: CONSULTA DE RELATÓRIOS**

### **8.1 Dashboard em Tempo Real:**

**Acesse:** `http://localhost:8000/`

**Informações Disponíveis:**

```
📊 Total de Vendedores: 6
👥 Vendedores Ativos: 2
📦 Boxes Ocupados: 2/6
📅 Entradas Hoje: 5

🔄 Atualização automática a cada 30 segundos
```

### **8.2 Histórico Detalhado:**

**Acesse:** `http://localhost:8000/entries`

**Use os filtros:**

```
📅 Data: 29/05/2025
👤 Vendedor: "Maria Silva"
📦 Box: "A01"
🔄 Status: "Todos"
```

**Resultado:**

```
📋 Lista detalhada com:
- Horário de entrada
- Horário de saída
- Duração da permanência
- Box utilizado
- Status (in/out)
```

---

## 🔍 **CENÁRIO 9: TESTES DE CONFLITO**

### **9.1 Teste de Conflito de Horário:**

**Passo a Passo:**

1. **Crie horário:** João Silva, Box A01, Segunda, 08:00-17:00
2. **Tente criar:** Maria Silva, Box A01, Segunda, 12:00-18:00

**Resultado Esperado:**

```
❌ Erro: "Conflito de horário detectado para este box"
❌ Sistema impede a criação do horário conflitante
```

### **9.2 Teste de Email Duplicado:**

**Passo a Passo:**

1. **Tente criar vendedor com email já existente**
2. **Use:** joao@email.com (já existe no sistema)

**Resultado:**

```
❌ Erro: "O campo email já está sendo usado"
❌ Status HTTP 422
```

---

## 🎯 **CENÁRIO 10: DEMONSTRAÇÃO COMPLETA**

### **Fluxo Completo de Uso:**

**1. Manhã (Setup):**

```
08:00 - Administrador acessa o sistema
08:05 - Cadastra novo vendedor com CNPJ
08:10 - Define horários para a semana
08:15 - Sistema está pronto para operação
```

**2. Durante o Dia (Operação):**

```
09:00 - Vendedor 1 faz check-in (Box A01)
09:15 - Vendedor 2 faz check-in (Box B01)
12:00 - Consulta dashboard: 2 vendedores ativos
14:30 - Vendedor 1 faz check-out temporário
15:00 - Vendedor 1 retorna (novo check-in)
```

**3. Final do Dia (Fechamento):**

```
17:00 - Vendedor 2 faz check-out final
17:30 - Vendedor 1 faz check-out final
18:00 - Dashboard: 0 vendedores ativos
18:05 - Consulta relatório do dia
```

---

## 🔧 **COMANDOS ÚTEIS PARA TESTE**

### **Resetar Dados de Teste:**

```bash
php artisan migrate:fresh --seed
```

### **Criar Novo Vendedor via API:**

```bash
curl -X POST http://localhost:8000/api/vendors \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Teste API",
    "email": "teste@api.com",
    "phone": "(11) 99999-0000",
    "food_type": "Teste",
    "has_cnpj": true,
    "cnpj": "98.765.432/0001-10"
  }'
```

### **Consultar Vendedores via API:**

```bash
curl http://localhost:8000/api/vendors
```

---

## ✅ **CHECKLIST DE FUNCIONALIDADES**

### **CNPJ:**

-   [ ] Checkbox "Possui CNPJ?" funciona
-   [ ] Campo CNPJ aparece/desaparece
-   [ ] Formatação automática funciona
-   [ ] Validação de formato funciona
-   [ ] Validação condicional funciona
-   [ ] Exibição na listagem funciona
-   [ ] Edição preserva dados do CNPJ

### **Telefone:**

-   [ ] Formatação para celular funciona
-   [ ] Formatação para fixo funciona
-   [ ] Validação de formato funciona

### **Operações Básicas:**

-   [ ] Criar vendedor funciona
-   [ ] Editar vendedor funciona
-   [ ] Excluir vendedor funciona
-   [ ] Listagem mostra todos os dados

### **Check-in/Check-out:**

-   [ ] Check-in registra corretamente
-   [ ] Check-out registra corretamente
-   [ ] Dashboard atualiza em tempo real
-   [ ] Histórico registra movimentações

### **Horários:**

-   [ ] Criar horário funciona
-   [ ] Validação de conflito funciona
-   [ ] Exibição no card funciona

### **Validações:**

-   [ ] Email único funciona
-   [ ] Campos obrigatórios funcionam
-   [ ] Mensagens de erro aparecem
-   [ ] Status HTTP corretos retornados

---

## 🎉 **CONCLUSÃO DOS TESTES**

Se todos os cenários acima funcionarem corretamente, o sistema está completamente operacional e pronto para uso em produção.

### **Próximos Passos Sugeridos:**

1. **Teste com múltiplos usuários** simultâneos
2. **Teste de performance** com muitos registros
3. **Backup e restore** dos dados
4. **Configuração de produção** (MySQL, cache, etc.)
5. **Monitoramento** e logs de sistema

### **Suporte:**

Para dúvidas ou problemas nos testes, consulte:

-   README.md principal
-   FUNCIONALIDADES_DETALHADAS.md
-   Documentação do Laravel
-   Logs em `storage/logs/laravel.log`
