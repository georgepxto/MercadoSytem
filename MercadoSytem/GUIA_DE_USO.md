# 📖 Guia de Uso Prático - Sistema de Gestão de Feira Alimentar

## 🎯 **Como Usar o Sistema - Guia Passo a Passo**

### 🏪 **1. Cadastrando um Novo Vendedor**

#### **Vendedor Pessoa Física (sem CNPJ):**

1. Acesse `http://localhost:8000/vendors`
2. Clique em "Novo Vendedor"
3. Preencha os dados:
    - **Nome**: "Maria Silva"
    - **Email**: "maria@email.com"
    - **Telefone**: Digite apenas números "11999998888" → Sistema formata para "(11) 99999-8888"
    - **Tipo de Comida**: "Pastéis e Salgados"
    - **Descrição**: "Especialista em pastéis caseiros"
    - **Ativo**: ✓ (marcado)
    - **Possui CNPJ?**: ✗ (desmarcado)
4. Clique em "Salvar"

#### **Vendedor Pessoa Jurídica (com CNPJ):**

1. Siga os passos 1-2 acima
2. Preencha os dados básicos
3. **Marque "Possui CNPJ?"** → Campo CNPJ aparece
4. **CNPJ**: Digite apenas números "12345678000190" → Sistema formata para "12.345.678/0001-90"
5. Clique em "Salvar"

### ⏰ **2. Definindo Horários para um Vendedor**

1. Na lista de vendedores, clique em "Horário" no card do vendedor
2. Preencha:
    - **Box**: Selecione "Box 1 - Entrada Principal"
    - **Dia da Semana**: "segunda"
    - **Horário Início**: "08:00"
    - **Horário Fim**: "17:00"
3. Clique em "Salvar"
4. Repita para outros dias da semana conforme necessário

### 🚪 **3. Fazendo Check-in de um Vendedor**

1. Acesse `http://localhost:8000/checkin`
2. No formulário de entrada:
    - **Vendedor**: Selecione "Maria Silva"
    - **Box**: Selecione "Box 1"
3. Clique em "Registrar Entrada"
4. O vendedor aparecerá na lista "Vendedores Ativos" com horário de entrada

### 🚪 **4. Fazendo Check-out de um Vendedor**

1. Na página de check-in, procure o vendedor na lista "Vendedores Ativos"
2. Clique em "Check-out" ao lado do nome do vendedor
3. O sistema registra automaticamente o horário de saída

### 📊 **5. Consultando o Dashboard**

1. Acesse `http://localhost:8000/` (página inicial)
2. Visualize:
    - **Total de Vendedores**: Quantos estão cadastrados
    - **Boxes Ocupados**: Quantos estão em uso no momento
    - **Entradas Hoje**: Quantas entradas foram registradas hoje
    - **Vendedores Ativos**: Lista dos que estão presentes

### 📈 **6. Consultando Histórico**

1. Acesse `http://localhost:8000/entries`
2. Use filtros:
    - **Data**: Selecione período específico
    - **Vendedor**: Filtre por vendedor específico
    - **Box**: Filtre por box específico
    - **Status**: "in" (dentro) ou "out" (saiu)

## 🔍 **Cenários Práticos de Uso**

### **Cenário 1: Abertura da Feira (Manhã)**

```
08:00 - Administrador acessa o sistema
08:15 - João Silva (Lanches) faz check-in no Box 1
08:30 - Maria Santos (Sushi) faz check-in no Box 3
08:45 - Dashboard mostra 2 vendedores ativos
```

### **Cenário 2: Durante o Dia (Meio-dia)**

```
12:00 - Novo vendedor "Pedro Açaí" é cadastrado com CNPJ
12:15 - Pedro faz check-in no Box 5
12:30 - João sai temporariamente (check-out)
13:00 - João retorna (novo check-in)
```

### **Cenário 3: Final do Dia (Tarde)**

```
17:00 - Maria Santos faz check-out
17:30 - João Silva faz check-out
18:00 - Administrador consulta relatório do dia
18:15 - Todos os vendedores fizeram check-out
```

## 🎨 **Interface Visual - O que Você Verá**

### **Cards de Vendedores:**

```
┌─────────────────────────────────────┐
│ [🅹] João Silva                     │
│      joao@email.com                 │
│                                     │
│ [Lanches] [Ativo]                  │
│                                     │
│ 📞 (11) 99999-1111                 │
│ 🏢 CNPJ: 12.345.678/0001-90       │  ← Aparece só se tiver CNPJ
│ Especialista em coxinhas...         │
│                                     │
│ Horários:                           │
│ [Segunda] 08:00-17:00 Box 1        │
│                                     │
│ [Editar] [Horário] [Excluir]       │
└─────────────────────────────────────┘
```

### **Dashboard:**

```
┌─────────────────────────────────────┐
│ 📊 Sistema de Gestão de Feira       │
├─────────────────────────────────────┤
│ [15] Vendedores  [3] Boxes Ocupados │
│ [8] Entradas Hoje [2] Ativos Agora  │
├─────────────────────────────────────┤
│ Atividades de Hoje:                 │
│ • 08:15 - João Silva entrou Box 1   │
│ • 08:30 - Maria Santos entrou Box 3 │
│ • 12:00 - Pedro Açaí entrou Box 5   │
├─────────────────────────────────────┤
│ Vendedores Ativos:                  │
│ • João Silva - Box 1 (desde 08:15) │
│ • Pedro Açaí - Box 5 (desde 12:00) │
└─────────────────────────────────────┘
```

## ⚠️ **Validações e Mensagens de Erro**

### **Erro de Telefone:**

```
❌ "Formato inválido. Use: (XX) XXXXX-XXXX para celular ou (XX) XXXX-XXXX para fixo"
✅ Solução: Digite apenas números, o sistema formata automaticamente
```

### **Erro de CNPJ:**

```
❌ "Formato inválido. Use: XX.XXX.XXX/XXXX-XX"
✅ Solução: Digite apenas 14 números, formatação é automática
```

### **Erro de Email Duplicado:**

```
❌ "O campo email já está sendo utilizado"
✅ Solução: Use um email diferente
```

### **Erro de CNPJ Obrigatório:**

```
❌ "O CNPJ é obrigatório quando 'Possui CNPJ' está marcado"
✅ Solução: Preencha o CNPJ ou desmarque a opção
```

## 🚀 **Dicas de Uso Eficiente**

### **1. Formatação Automática**

-   **Telefone**: Digite apenas números → `11999998888` vira `(11) 99999-8888`
-   **CNPJ**: Digite apenas números → `12345678000190` vira `12.345.678/0001-90`

### **2. Navegação Rápida**

-   **Dashboard**: Visão geral rápida da situação atual
-   **Check-in**: Para movimentação diária dos vendedores
-   **Vendedores**: Para cadastro e gerenciamento
-   **Histórico**: Para relatórios e análises

### **3. Atualizações em Tempo Real**

-   **Dashboard**: Atualiza automaticamente a cada 30 segundos
-   **Check-in**: Atualiza automaticamente a cada 15 segundos
-   Não precisa recarregar a página manualmente

### **4. Responsividade**

-   Funciona perfeitamente em **desktop**, **tablet** e **celular**
-   Interface se adapta automaticamente ao tamanho da tela
-   Todas as funcionalidades disponíveis em dispositivos móveis

## 📱 **Uso Mobile**

### **Em Smartphones:**

-   Cards de vendedores se reorganizam em coluna única
-   Formulários se ajustam para fácil digitação
-   Botões ficam maiores para facilitar o toque
-   Teclado numérico aparece automaticamente em campos de telefone/CNPJ

### **Em Tablets:**

-   Layout se adapta para melhor aproveitamento da tela
-   Mantém funcionalidades completas do desktop
-   Ideal para uso pelos administradores da feira

## 🎓 **Casos de Uso Avançados**

### **Gestão de Grandes Feiras:**

-   Cadastre múltiplos administradores (futuro)
-   Use relatórios para análise de ocupação
-   Configure horários específicos por dia da semana
-   Monitore padrões de frequência dos vendedores

### **Controle Financeiro (Extensão Futura):**

-   Base preparada para adicionar taxas por box
-   Histórico de ocupação para cobrança
-   Relatórios de permanência por vendedor

### **Análise de Dados:**

-   Use o histórico para identificar picos de movimento
-   Analise quais boxes são mais populares
-   Identifique padrões de horários dos vendedores

---

**💡 Dica Final**: O sistema foi projetado para ser intuitivo. Explore as funcionalidades, teste diferentes cenários e aproveite a flexibilidade para adaptar às necessidades específicas da sua feira!
