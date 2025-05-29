# 📋 Funcionalidades Detalhadas - Sistema de Gestão de Feira Alimentar

## 🎯 **Resumo Executivo**

Este documento detalha todas as funcionalidades implementadas no Sistema de Gestão de Feira Alimentar, desenvolvido em Laravel. O sistema oferece controle completo sobre vendedores, boxes, horários e movimentação diária, com foco especial nas funcionalidades de CNPJ e validações automáticas.

---

## 🏪 **1. GESTÃO DE VENDEDORES**

### **1.1 Cadastro e Edição**

#### **Campos Obrigatórios:**

-   **Nome**: Texto livre, máximo 255 caracteres
-   **Email**: Validação de formato + unicidade no sistema
-   **Telefone**: Formatação automática para (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
-   **Tipo de Comida**: Categorização livre (ex: "Comida Japonesa", "Lanches")

#### **Campos Opcionais:**

-   **Descrição**: Texto livre para informações adicionais
-   **Status Ativo/Inativo**: Controle de disponibilidade
-   **CNPJ**: Sistema condicional avançado (detalhado na seção 1.2)

#### **Operações Disponíveis:**

-   ✅ **Criar**: Novo vendedor com validação completa
-   ✅ **Visualizar**: Listagem em cards com todas as informações
-   ✅ **Editar**: Atualização de dados com preservação de histórico
-   ✅ **Excluir**: Remoção com validação de dependências

### **1.2 Sistema de CNPJ Avançado**

#### **Funcionalidade Condicional:**

```
┌─ Checkbox "Possui CNPJ?"
│  ├─ ❌ Desmarcado → Campo CNPJ oculto
│  └─ ✅ Marcado → Campo CNPJ visível + obrigatório
```

#### **Formatação Automática:**

-   **Entrada**: Usuario digita apenas números
-   **Processamento**: Sistema formata em tempo real
-   **Resultado**: XX.XXX.XXX/XXXX-XX

**Exemplo:**

```
Digite: 12345678000190
Resultado: 12.345.678/0001-90
```

#### **Validações Implementadas:**

**1. Validação de Formato (Frontend):**

```javascript
Regex: /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;
Erro: "Formato inválido. Use: XX.XXX.XXX/XXXX-XX";
```

**2. Validação Condicional (Backend):**

```php
Regra: 'required_if:has_cnpj,true'
Erro: "O CNPJ é obrigatório quando 'Possui CNPJ' está marcado"
```

**3. Validação de Formato (Backend):**

```php
Regex: /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/
Erro: "O CNPJ deve estar no formato XX.XXX.XXX/XXXX-XX"
```

#### **Exibição na Interface:**

-   **Listagem**: CNPJ aparece com ícone 🏢 apenas se presente
-   **Formulários**: Campo condicional baseado no checkbox
-   **Edição**: Carrega dados existentes automaticamente

---

## 📦 **2. GESTÃO DE BOXES**

### **2.1 Estrutura de Boxes**

#### **Informações por Box:**

-   **Número**: Identificador único (ex: "A01", "B02")
-   **Localização**: Descrição da posição (ex: "Setor A - Entrada Principal")
-   **Capacidade**: Número de pessoas/espaço disponível
-   **Status**: Ativo/Inativo

#### **Funcionalidades:**

-   ✅ **Cadastro**: Criação de novos boxes
-   ✅ **Status em Tempo Real**: Ocupado/Livre
-   ✅ **Histórico**: Registro de todas as ocupações
-   ✅ **Alocação**: Vinculação com vendedores via horários

---

## ⏰ **3. SISTEMA DE HORÁRIOS**

### **3.1 Cronograma Semanal**

#### **Estrutura de Horário:**

-   **Vendedor**: Quem trabalha
-   **Box**: Onde trabalha
-   **Dia da Semana**: segunda, terça, etc.
-   **Horário Início**: HH:MM
-   **Horário Fim**: HH:MM

#### **Validações de Conflito:**

```
Regra: Não permitir sobreposição de horários no mesmo box
Exemplo de Conflito:
- Vendedor A: Box 1, Segunda, 08:00-17:00
- Vendedor B: Box 1, Segunda, 12:00-18:00 ❌ CONFLITO
```

### **3.2 Flexibilidade de Horários**

#### **Cenários Suportados:**

-   **Horário Fixo**: Mesmo horário todos os dias
-   **Horário Variável**: Horários diferentes por dia
-   **Múltiplos Boxes**: Vendedor pode ter boxes diferentes por dia
-   **Horários Parciais**: Trabalho em períodos específicos

---

## 🚪 **4. CONTROLE DE ENTRADA E SAÍDA**

### **4.1 Sistema de Check-in/Check-out**

#### **Processo de Check-in:**

1. **Seleção de Vendedor**: Dropdown com vendedores ativos
2. **Seleção de Box**: Dropdown com boxes disponíveis
3. **Registro Automático**: Sistema registra data/hora automaticamente
4. **Validação**: Verifica disponibilidade e conflitos

#### **Processo de Check-out:**

1. **Lista de Ativos**: Mostra vendedores presentes
2. **Botão Check-out**: Clique simples para saída
3. **Cálculo Automático**: Tempo de permanência calculado
4. **Atualização de Status**: Box fica disponível novamente

### **4.2 Monitoramento em Tempo Real**

#### **Informações Disponíveis:**

-   **Vendedores Ativos**: Quem está presente agora
-   **Boxes Ocupados**: Status atual de cada box
-   **Horário de Entrada**: Quando cada vendedor chegou
-   **Tempo de Permanência**: Duração da estadia

---

## 📊 **5. DASHBOARD E RELATÓRIOS**

### **5.1 Dashboard Principal**

#### **Métricas em Tempo Real:**

-   **Total de Vendedores**: Quantos estão cadastrados
-   **Vendedores Ativos**: Quantos estão presentes agora
-   **Boxes Ocupados**: Status atual dos boxes
-   **Entradas Hoje**: Quantas entradas foram registradas

#### **Atualizações Automáticas:**

-   **Intervalo**: A cada 30 segundos
-   **Tecnologia**: JavaScript com Axios
-   **Eficiência**: Consultas otimizadas ao banco

### **5.2 Histórico de Entradas**

#### **Filtros Disponíveis:**

-   **Por Data**: Período específico
-   **Por Vendedor**: Histórico individual
-   **Por Box**: Ocupação de box específico
-   **Por Status**: Entradas ativas ou finalizadas

#### **Informações Detalhadas:**

-   **Data/Hora Entrada**: Quando chegou
-   **Data/Hora Saída**: Quando saiu (se aplicável)
-   **Duração**: Tempo total de permanência
-   **Box Utilizado**: Qual box foi ocupado

---

## 🔧 **6. VALIDAÇÕES E FORMATAÇÕES**

### **6.1 Sistema de Telefone**

#### **Formatação Inteligente:**

```javascript
// Detecção automática do tipo
Celular (9 dígitos): (XX) XXXXX-XXXX
Fixo (8 dígitos): (XX) XXXX-XXXX

// Exemplo de uso
Digite: 11999998888
Resultado: (11) 99999-8888
```

#### **Validação Regex:**

```javascript
Padrão: /^\(\d{2}\) \d{4,5}-\d{4}$/
Aceita: (11) 99999-8888 ✅
Aceita: (11) 3333-4444 ✅
Rejeita: 11999998888 ❌
```

### **6.2 Sistema de Email**

#### **Validações Implementadas:**

-   **Formato**: Validação padrão de email
-   **Unicidade**: Não permite emails duplicados
-   **Sanitização**: Remoção de caracteres especiais

### **6.3 Sistema de Horários**

#### **Validações de Tempo:**

```php
// Formato obrigatório
Padrão: HH:MM (24 horas)
Aceita: 08:00, 17:30, 23:59 ✅
Rejeita: 8:00, 17h30, 25:00 ❌
```

#### **Validações de Conflito:**

```php
// Evita sobreposições
Regra: Mesmo box + mesmo dia + horários sobrepostos = ERRO
Mensagem: "Conflito de horário detectado para este box"
```

---

## 🖥 **7. INTERFACE DO USUÁRIO**

### **7.1 Design Responsivo**

#### **Tecnologias:**

-   **Bootstrap 5.3**: Framework CSS moderno
-   **Bootstrap Icons**: Iconografia consistente
-   **Design Mobile-First**: Funciona em todos os dispositivos

#### **Componentes Principais:**

-   **Cards**: Exibição de vendedores e boxes
-   **Modais**: Formulários de cadastro/edição
-   **Alerts**: Feedback de ações e erros
-   **Badges**: Status e categorização

### **7.2 Experiência do Usuário**

#### **Feedback Visual:**

-   **Sucesso**: Mensagens verdes de confirmação
-   **Erro**: Mensagens vermelhas com instruções
-   **Loading**: Indicadores de processamento
-   **Validação**: Feedback em tempo real

#### **Navegação Intuitiva:**

-   **Menu Principal**: Acesso rápido a todas as seções
-   **Breadcrumbs**: Localização atual no sistema
-   **Botões de Ação**: Ações claras e visíveis
-   **Atalhos**: Acesso rápido a funções principais

---

## 🔌 **8. API RESTFUL**

### **8.1 Arquitetura da API**

#### **Padrões Seguidos:**

-   **REST**: Verbos HTTP corretos (GET, POST, PUT, DELETE)
-   **JSON**: Comunicação padronizada
-   **Status Codes**: Códigos HTTP apropriados
-   **Validação**: Entrada e saída de dados

#### **Segurança:**

-   **CSRF Protection**: Proteção contra ataques
-   **Validation**: Sanitização de dados
-   **Error Handling**: Tratamento de erros padronizado

### **8.2 Endpoints Principais**

#### **Vendedores:**

```http
GET    /api/vendors          # Listar
POST   /api/vendors          # Criar
GET    /api/vendors/{id}     # Detalhar
PUT    /api/vendors/{id}     # Atualizar
DELETE /api/vendors/{id}     # Excluir
```

#### **Outros Endpoints:**

-   `/api/boxes` - Gestão de boxes
-   `/api/schedules` - Gestão de horários
-   `/api/entries` - Controle de entradas

---

## 📱 **9. COMPATIBILIDADE E PERFORMANCE**

### **9.1 Navegadores Suportados**

-   ✅ **Chrome**: Versão 90+
-   ✅ **Firefox**: Versão 88+
-   ✅ **Safari**: Versão 14+
-   ✅ **Edge**: Versão 90+

### **9.2 Dispositivos Suportados**

-   ✅ **Desktop**: 1920x1080 e superiores
-   ✅ **Tablet**: 768x1024 (iPad e similares)
-   ✅ **Mobile**: 375x667 (iPhone e similares)

### **9.3 Otimizações**

-   **Consultas Otimizadas**: Uso de relacionamentos Eloquent
-   **JavaScript Mínimo**: Apenas o necessário carregado
-   **Cache**: Estratégias de cache implementadas
-   **Indexação**: Campos importantes indexados

---

## 🛠 **10. EXTENSIBILIDADE**

### **10.1 Arquitetura Modular**

#### **Estrutura Preparada Para:**

-   **Autenticação**: Sistema de login/logout
-   **Permissões**: Diferentes níveis de acesso
-   **Relatórios**: Exports e análises avançadas
-   **Notificações**: Alertas e lembretes
-   **Integrações**: APIs externas

### **10.2 Banco de Dados Flexível**

#### **Migrations Organizadas:**

-   **Versionamento**: Controle de mudanças no banco
-   **Rollback**: Possibilidade de reverter alterações
-   **Seeders**: Dados de exemplo e produção
-   **Relacionamentos**: Estrutura preparada para crescimento

---

## 📊 **11. DADOS E EXEMPLOS**

### **11.1 Dados Pré-carregados**

#### **Vendedores de Exemplo:**

```
João Silva - Lanches e Salgados
Maria Santos - Comida Japonesa
Carlos Pizza - Pizzaria
Ana Doces - Confeitaria
Pedro Grill - Churrasco
Empresa CNPJ - 12.345.678/0001-90 (com CNPJ)
```

#### **Boxes de Exemplo:**

```
A01 - Setor A - Entrada Principal
A02 - Setor A - Entrada Principal
B01 - Setor B - Centro
B02 - Setor B - Centro
C01 - Setor C - Fundos
C02 - Setor C - Fundos
```

### **11.2 Cenários de Teste**

#### **Teste de CNPJ:**

1. **Pessoa Física**: Sem CNPJ (checkbox desmarcado)
2. **Pessoa Jurídica**: Com CNPJ válido (12.345.678/0001-90)
3. **Validação**: Teste de formatos inválidos
4. **Edição**: Adicionar/remover CNPJ de vendedor existente

#### **Teste de Horários:**

1. **Horário Normal**: Segunda a sexta, 8h às 17h
2. **Conflito**: Tentar sobrepor horários no mesmo box
3. **Múltiplos Boxes**: Vendedor em boxes diferentes por dia
4. **Edição**: Alterar horários existentes

---

## 🎯 **CONCLUSÃO**

O Sistema de Gestão de Feira Alimentar oferece uma solução completa e profissional para administração de feiras, com destaque para:

### **Pontos Fortes:**

-   ✅ **Interface Intuitiva**: Fácil de usar para qualquer usuário
-   ✅ **Validações Robustas**: Dados sempre consistentes
-   ✅ **Funcionalidade CNPJ**: Sistema condicional avançado
-   ✅ **Tempo Real**: Informações sempre atualizadas
-   ✅ **Flexibilidade**: Adaptável a diferentes cenários
-   ✅ **Extensibilidade**: Preparado para crescimento

### **Tecnologias Modernas:**

-   ✅ **Laravel 11.x**: Framework PHP robusto
-   ✅ **Bootstrap 5.3**: Interface moderna
-   ✅ **SQLite/MySQL**: Banco de dados flexível
-   ✅ **JavaScript ES6**: Interatividade moderna
-   ✅ **API REST**: Comunicação padronizada

O sistema está pronto para uso em produção e pode ser facilmente adaptado para diferentes tipos de feiras e mercados.
