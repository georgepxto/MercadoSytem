# 🏪 Sistema de Gestão de Feira Alimentar

Um sistema completo desenvolvido em Laravel para gerenciar vendedores de feira alimentar, alocação de boxes, controle de entrada/saída e gestão de horários de trabalho.

## 📋 **Visão Geral do Sistema**

Este é um sistema web moderno e responsivo que permite a administração completa de uma feira alimentar, oferecendo controle detalhado sobre vendedores, boxes, horários e movimentação diária. Desenvolvido com foco na usabilidade e eficiência operacional.

## 🚀 **Início Rápido**

```bash
# 1. Clone e instale
git clone <url-do-repositorio>
cd food-market-system
composer install

# 2. Configure e execute
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# 3. Inicie o servidor
php artisan serve
# Acesse: http://127.0.0.1:8000
```

## 📖 **Navegação**

| Seção                                               | Descrição                   |
| --------------------------------------------------- | --------------------------- |
| [🏪 Funcionalidades](#-principais-funcionalidades)  | Lista completa de recursos  |
| [🛠 Stack Tecnológico](#-stack-tecnológico)          | Tecnologias utilizadas      |
| [🚀 Instalação](#-instalação-e-configuração)        | Guia de instalação completo |
| [🔌 API](#-api-endpoints)                           | Documentação da API REST    |
| [🎯 Validações](#-validações-implementadas)         | Regras de validação         |
| [🖥 Interface](#-interface-web---páginas-principais) | Páginas e funcionalidades   |

## ✨ **Principais Funcionalidades**

### 🏪 **Gestão de Vendedores**

-   **Cadastro Completo**: Nome, email, telefone com validação e formatação automática
-   **CNPJ Opcional**: Sistema de CNPJ condicional com validação e formatação automática (XX.XXX.XXX/XXXX-XX)
-   **Tipos de Comida**: Categorização por especialidade culinária
-   **Status de Atividade**: Controle de vendedores ativos/inativos
-   **Descrição Personalizada**: Campo livre para informações adicionais
-   **Operações CRUD**: Criar, visualizar, editar e excluir vendedores

### 📦 **Gestão de Boxes**

-   **Cadastro de Boxes**: Numeração, localização e capacidade
-   **Alocação Dinâmica**: Atribuição flexível de vendedores aos boxes
-   **Status de Ocupação**: Monitoramento em tempo real
-   **Histórico de Uso**: Controle completo de ocupação

### ⏰ **Sistema de Horários**

-   **Cronograma Semanal**: Definição de horários por dia da semana
-   **Atribuição Box-Vendedor**: Vinculação específica por período
-   **Horários Flexíveis**: Definição de início e fim customizáveis
-   **Conflito de Horários**: Validação automática para evitar sobreposições

### 🚪 **Controle de Entrada e Saída**

-   **Check-in Rápido**: Registro de entrada com seleção de vendedor e box
-   **Check-out Automático**: Sistema de saída com cálculo de permanência
-   **Histórico Completo**: Registro detalhado de todas as movimentações
-   **Filtros Avançados**: Busca por data, vendedor, box ou status

### 📊 **Dashboard e Relatórios**

-   **Visão Geral**: Métricas em tempo real do funcionamento da feira
-   **Atividades do Dia**: Resumo das atividades correntes
-   **Vendedores Ativos**: Lista de vendedores presentes no momento
-   **Ocupação de Boxes**: Status atual de todos os boxes
-   **Atualizações Automáticas**: Refresh automático dos dados

## 🔧 **Características Técnicas**

### **Validações e Formatações Automáticas**

-   **Telefone**: Formatação automática para (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
-   **CNPJ**: Formatação automática para XX.XXX.XXX/XXXX-XX com validação de formato
-   **Email**: Validação de formato e unicidade
-   **Horários**: Validação de conflitos e sobreposições

### **Interface do Usuário**

-   **Design Responsivo**: Funciona perfeitamente em desktop, tablet e mobile
-   **Bootstrap 5.3**: Interface moderna e intuitiva
-   **Ícones Bootstrap**: Iconografia consistente e profissional
-   **Feedback Visual**: Mensagens de sucesso, erro e validação em tempo real

### **API RESTful**

-   **Endpoints Completos**: Operações CRUD para todas as entidades
-   **Validação de Dados**: Validação robusta em todas as requisições
-   **Respostas JSON**: Comunicação padronizada entre frontend e backend
-   **Códigos HTTP**: Uso correto de status codes (200, 201, 422, 404, etc.)

## 💻 **Como o Sistema Funciona**

### **Fluxo Principal de Uso:**

1. **Cadastro de Vendedores**

    - Administrador cadastra vendedores com suas informações
    - Sistema valida e formata automaticamente telefone e CNPJ
    - Vendedor fica disponível para alocação em boxes

2. **Definição de Horários**

    - Administrador define horários semanais para cada vendedor
    - Especifica dias da semana, horários e boxes correspondentes
    - Sistema valida conflitos automaticamente

3. **Operação Diária**

    - Vendedores fazem check-in ao chegar à feira
    - Sistema registra entrada com horário e box
    - Durante o dia, é possível visualizar quem está presente
    - Ao final, vendedores fazem check-out

4. **Monitoramento e Relatórios**
    - Dashboard mostra situação atual da feira
    - Histórico permite análise de padrões de uso
    - Relatórios ajudam na gestão e planejamento

### **Cenários de Uso Específicos:**

#### **Cadastro de Vendedor com CNPJ:**

1. Clique em "Novo Vendedor"
2. Preencha nome, email, telefone (formatação automática)
3. Marque "Possui CNPJ?" se aplicável
4. Digite apenas números do CNPJ (formatação automática)
5. Adicione tipo de comida e descrição
6. Sistema valida e salva automaticamente

#### **Check-in de Vendedor:**

1. Acesse página de Check-in
2. Selecione vendedor no dropdown
3. Escolha box disponível
4. Clique em "Registrar Entrada"
5. Sistema registra horário automaticamente

#### **Consulta de Histórico:**

1. Acesse "Histórico de Entradas"
2. Use filtros por data, vendedor ou box
3. Visualize relatório detalhado
4. Exporte dados se necessário

## 🛠 **Stack Tecnológico**

-   **Backend**: Laravel 11.x (PHP Framework)
-   **Database**: SQLite (configurável para MySQL/PostgreSQL)
-   **Frontend**: Bootstrap 5.3.0 + Blade Templates
-   **JavaScript**: Axios para comunicação com API
-   **Ícones**: Bootstrap Icons
-   **Validação**: Laravel Validation + JavaScript cliente
-   **API**: RESTful com respostas JSON padronizadas

## 📁 **Estrutura do Projeto**

```
food-market-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/                          # Controladores da API
│   │   │   ├── VendorController.php      # Gestão de vendedores
│   │   │   ├── BoxController.php         # Gestão de boxes
│   │   │   ├── ScheduleController.php    # Gestão de horários
│   │   │   └── EntryController.php       # Controle entrada/saída
│   │   └── WebController.php             # Interface web
│   └── Models/
│       ├── Vendor.php                    # Modelo de vendedor (com CNPJ)
│       ├── Box.php                       # Modelo de box
│       ├── Schedule.php                  # Modelo de horário
│       └── Entry.php                     # Modelo de entrada/saída
├── database/
│   ├── migrations/                       # Estrutura do banco
│   │   ├── create_vendors_table.php      # Tabela de vendedores
│   │   ├── add_cnpj_fields_to_vendors.php # Campos de CNPJ
│   │   ├── create_boxes_table.php        # Tabela de boxes
│   │   ├── create_schedules_table.php    # Tabela de horários
│   │   └── create_entries_table.php      # Tabela de entradas
│   ├── seeders/                          # Dados de exemplo
│   └── database.sqlite                   # Banco de dados SQLite
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                 # Layout principal
│   ├── dashboard.blade.php               # Página inicial/dashboard
│   ├── checkin.blade.php                 # Check-in/Check-out
│   ├── vendors.blade.php                 # Gestão de vendedores
│   ├── boxes.blade.php                   # Gestão de boxes
│   └── entries.blade.php                 # Histórico de entradas
├── routes/
│   ├── api.php                           # Rotas da API
│   └── web.php                           # Rotas web
└── public/
    ├── test-cnpj.html                    # Página de teste CNPJ
    └── assets/                           # CSS, JS, imagens
```

## 🗄 **Estrutura do Banco de Dados**

### **Tabelas Principais:**

#### **vendors** (Vendedores)

```sql
- id (PK)
- name (varchar 255)          # Nome do vendedor
- email (varchar 255, unique) # Email único
- phone (varchar 20)          # Telefone formatado
- food_type (varchar 255)     # Tipo de comida
- description (text, nullable) # Descrição
- active (boolean)            # Status ativo/inativo
- has_cnpj (boolean)          # Possui CNPJ?
- cnpj (varchar 18, nullable) # CNPJ formatado
- created_at, updated_at
```

#### **boxes** (Boxes/Estandes)

```sql
- id (PK)
- number (varchar 10, unique) # Número do box
- location (varchar 255)      # Localização
- capacity (integer)          # Capacidade
- active (boolean)            # Status ativo/inativo
- created_at, updated_at
```

#### **schedules** (Horários)

```sql
- id (PK)
- vendor_id (FK → vendors)    # Vendedor
- box_id (FK → boxes)         # Box
- day_of_week (varchar 20)    # Dia da semana
- start_time (time)           # Horário início
- end_time (time)             # Horário fim
- created_at, updated_at
```

#### **entries** (Entradas/Saídas)

```sql
- id (PK)
- vendor_id (FK → vendors)    # Vendedor
- box_id (FK → boxes)         # Box
- entry_time (datetime)       # Horário entrada
- exit_time (datetime, null)  # Horário saída
- status (enum: in/out)       # Status atual
- created_at, updated_at
```

### **Relacionamentos:**

-   `Vendor` tem muitos `Schedules` e `Entries`
-   `Box` tem muitos `Schedules` e `Entries`
-   `Schedule` pertence a um `Vendor` e um `Box`
-   `Entry` pertence a um `Vendor` e um `Box`

## 🚀 **Instalação e Configuração**

### **Pré-requisitos**

-   PHP 8.1 ou superior
-   Composer (gerenciador de dependências PHP)
-   Node.js & NPM (opcional, para compilação de assets)
-   Git (para clonagem do repositório)

### **Passos de Instalação**

1. **Clone o projeto**

    ```bash
    git clone <url-do-repositorio>
    cd food-market-system
    ```

2. **Instale as dependências PHP**

    ```bash
    composer install
    ```

3. **Configuração do ambiente**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configuração do banco de dados**
   O projeto usa SQLite por padrão. O arquivo já está criado em `database/database.sqlite`.

5. **Execute as migrações e popule com dados de exemplo**

    ```bash
    php artisan migrate --seed
    ```

6. **Inicie o servidor de desenvolvimento**

    ```bash
    php artisan serve
    ```

7. **Acesse a aplicação**
   Abra seu navegador em `http://127.0.0.1:8000`

### **Dados de Exemplo**

O sistema vem com dados pré-carregados:

-   **5+ Vendedores**: Incluindo alguns com CNPJ
-   **6 Boxes**: Diferentes tamanhos e localizações
-   **Horários Semanais**: Cronogramas pré-definidos
-   **Registros de Entrada**: Histórico de movimentação

### **Teste Rápido do Sistema**

Após a instalação, você pode testar rapidamente:

1. **Acesse `/vendors`** - Veja os vendedores cadastrados (alguns com CNPJ)
2. **Clique em "Novo Vendedor"** - Teste o cadastro com CNPJ
3. **Acesse `/checkin`** - Faça check-in de um vendedor
4. **Acesse `/dashboard`** - Visualize as métricas em tempo real
5. **Acesse `/entries`** - Consulte o histórico de movimentações

### **Exemplos de Uso da Funcionalidade CNPJ**

#### **Cadastro de Vendedor Pessoa Física:**

-   Nome: "Maria Silva"
-   Email: "maria@exemplo.com"
-   Telefone: Digite "11999998888" → Formata para "(11) 99999-8888"
-   Tipo: "Pastéis e Salgados"
-   **Possui CNPJ?**: ❌ Desmarcado

#### **Cadastro de Vendedor Pessoa Jurídica:**

-   Nome: "Restaurante Sabor & Cia"
-   Email: "contato@sabor.com"
-   Telefone: Digite "1133334444" → Formata para "(11) 3333-4444"
-   Tipo: "Comida Italiana"
-   **Possui CNPJ?**: ✅ Marcado
-   **CNPJ**: Digite "12345678000190" → Formata para "12.345.678/0001-90"

#### **Validações Automáticas:**

-   ✅ **CNPJ válido**: "12.345.678/0001-90" → Aceita
-   ❌ **CNPJ inválido**: "123456789" → Erro: "Formato inválido"
-   ❌ **CNPJ obrigatório**: Checkbox marcado + campo vazio → Erro: "CNPJ é obrigatório"

## 🔌 **API Endpoints**

### **Vendedores (/api/vendors)**

```http
GET    /api/vendors          # Listar todos os vendedores
POST   /api/vendors          # Criar novo vendedor
GET    /api/vendors/{id}     # Detalhes de um vendedor
PUT    /api/vendors/{id}     # Atualizar vendedor
DELETE /api/vendors/{id}     # Excluir vendedor
```

**Exemplo de Payload (Vendedor com CNPJ):**

```json
{
    "name": "João Silva",
    "email": "joao@exemplo.com",
    "phone": "(11) 99999-9999",
    "food_type": "Comida Japonesa",
    "description": "Especialista em sushi",
    "active": true,
    "has_cnpj": true,
    "cnpj": "12.345.678/0001-90"
}
```

### **Boxes (/api/boxes)**

```http
GET    /api/boxes           # Listar todos os boxes
POST   /api/boxes           # Criar novo box
GET    /api/boxes/{id}      # Detalhes de um box
PUT    /api/boxes/{id}      # Atualizar box
DELETE /api/boxes/{id}      # Excluir box
```

### **Horários (/api/schedules)**

```http
GET    /api/schedules       # Listar todos os horários
POST   /api/schedules       # Criar novo horário
GET    /api/schedules/{id}  # Detalhes de um horário
PUT    /api/schedules/{id}  # Atualizar horário
DELETE /api/schedules/{id}  # Excluir horário
```

### **Entradas (/api/entries)**

```http
GET    /api/entries                    # Listar todas as entradas
POST   /api/entries                    # Registrar entrada (check-in)
GET    /api/entries/{id}               # Detalhes de uma entrada
PUT    /api/entries/{id}               # Atualizar entrada
DELETE /api/entries/{id}               # Excluir entrada
PUT    /api/entries/{id}/checkout      # Registrar saída (check-out)
GET    /api/entries/today              # Entradas de hoje
GET    /api/entries/vendor/{vendor_id} # Entradas por vendedor
GET    /api/entries/box/{box_id}       # Entradas por box
```

## 🎯 **Validações Implementadas**

### **Telefone**

-   **Formato**: `(XX) XXXXX-XXXX` para celular ou `(XX) XXXX-XXXX` para fixo
-   **Validação**: Regex `/^\(\d{2}\) \d{4,5}-\d{4}$/`
-   **Formatação**: Automática durante digitação

### **CNPJ**

-   **Formato**: `XX.XXX.XXX/XXXX-XX`
-   **Validação**: Regex `/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/`
-   **Formatação**: Automática durante digitação
-   **Condicional**: Obrigatório apenas se "Possui CNPJ" estiver marcado

### **Email**

-   **Validação**: Formato válido de email
-   **Unicidade**: Não permite emails duplicados

### **Horários**

-   **Conflitos**: Impede sobreposição de horários no mesmo box
-   **Formato**: Validação de horário válido (HH:MM)

## 🖥 **Interface Web - Páginas Principais**

### **Dashboard (/)**

-   **Visão Geral**: Métricas em tempo real da feira
-   **Atividades de Hoje**: Resumo das movimentações do dia
-   **Atualizações**: Refresh automático a cada 30 segundos
-   **Cards Informativos**: Total de vendedores, boxes ocupados, entradas hoje

### **Check-in/Check-out (/checkin)**

-   **Formulário Rápido**: Check-in com seleção de vendedor e box
-   **Lista de Ativos**: Vendedores presentes com botão de check-out
-   **Atualizações**: Refresh automático a cada 15 segundos
-   **Status Visual**: Indicadores de presença em tempo real

### **Gestão de Vendedores (/vendors)**

-   **Cards Visuais**: Cada vendedor em card individual
-   **Informações Completas**: Nome, email, telefone, CNPJ (se houver), tipo de comida
-   **Ações Rápidas**: Editar, adicionar horário, excluir
-   **Status Visual**: Badges de ativo/inativo e tipo de comida
-   **Horários**: Exibição dos cronogramas de cada vendedor

### **Gestão de Boxes (/boxes)**

-   **Lista Organizada**: Todos os boxes com status de ocupação
-   **Informações**: Número, localização, capacidade
-   **Status em Tempo Real**: Ocupado/livre com indicadores visuais
-   **Histórico**: Acesso ao histórico de uso de cada box

### **Histórico de Entradas (/entries)**

-   **Filtros Avançados**: Por data, vendedor, box ou status
-   **Tabela Detalhada**: Horários de entrada e saída
-   **Exportação**: Capacidade de export dos dados
-   **Busca**: Sistema de busca integrado

## 🔒 **Recursos de Segurança**

-   **Proteção CSRF**: Todos os formulários protegidos
-   **Validação de Dados**: Sanitização e validação rigorosa
-   **ORM Eloquent**: Proteção contra SQL Injection
-   **Estrutura Preparada**: Ready para implementação de autenticação

## ⚡ **Performance e Otimização**

-   **Consultas Eficientes**: Uso otimizado de relacionamentos Eloquent
-   **JavaScript Mínimo**: Atualizações em tempo real sem overhead
-   **Bootstrap Otimizado**: Carregamento eficiente de CSS/JS
-   **Indexação**: Campos-chave indexados no banco de dados

## 📱 **Compatibilidade**

-   **Navegadores Modernos**: Chrome, Firefox, Safari, Edge
-   **Design Responsivo**: Funciona em mobile, tablet e desktop
-   **Progressive Enhancement**: Funcionalidade básica sem JavaScript

## 🛠 **Desenvolvimento e Extensão**

### **Adicionando Novas Funcionalidades**

1. Criar modelos com relacionamentos
2. Adicionar migrações para mudanças no banco
3. Criar controladores API seguindo o padrão existente
4. Adicionar rotas em `routes/api.php` e `routes/web.php`
5. Criar views Blade seguindo a estrutura existente

### **Configuração de Banco de Dados Alternativo**

Para MySQL/PostgreSQL, atualize o `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_market
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

## 📞 **Suporte e Documentação**

Para dúvidas ou problemas:

1. Consulte a documentação do Laravel: https://laravel.com/docs
2. Revise os endpoints da API documentados acima
3. Examine os dados de exemplo e relacionamentos

---

## 📄 **Informações do Projeto**

**Versão**: 2.0.0  
**Última Atualização**: Maio 2025  
**Framework**: Laravel 11.x  
**Licença**: MIT License

**Funcionalidades Recentes Adicionadas**:

-   ✅ **Sistema de CNPJ Completo**: Checkbox condicional + formatação automática + validação dupla
-   ✅ **Formatação Inteligente**: Telefone e CNPJ formatados em tempo real durante digitação
-   ✅ **Exibição Condicional**: CNPJ aparece na listagem apenas quando presente
-   ✅ **Validações Robustas**: Frontend (JavaScript) + Backend (Laravel) com mensagens em português
-   ✅ **Interface Intuitiva**: Campos aparecem/desaparecem conforme necessário
-   ✅ **Compatibilidade Total**: Funciona com todos os recursos existentes do sistema

## 🎯 **Funcionalidades Destacadas do Sistema**

### **Sistema de CNPJ Avançado**

O sistema implementa uma funcionalidade completa de CNPJ que inclui:

#### **Interface Dinâmica:**

-   **Checkbox "Possui CNPJ?"**: Controla a exibição do campo CNPJ
-   **Campo Condicional**: CNPJ aparece somente quando necessário
-   **Formatação Automática**: Digite apenas números → Sistema formata automaticamente
-   **Validação em Tempo Real**: Feedback imediato durante a digitação

#### **Exemplo de Uso:**

```
1. Marque "Possui CNPJ?" → Campo CNPJ aparece
2. Digite: "12345678000190"
3. Sistema formata: "12.345.678/0001-90"
4. Validação: ✅ Formato correto
5. Salvar: Dados persistidos no banco
```

#### **Validações Implementadas:**

-   **Formato**: Deve seguir XX.XXX.XXX/XXXX-XX
-   **Obrigatoriedade**: Requerido apenas quando checkbox marcado
-   **Regex**: `/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/`
-   **Mensagens**: Erros em português com instruções claras

### **Sistema de Telefone Inteligente**

-   **Detecção Automática**: Celular (9 dígitos) vs Fixo (8 dígitos)
-   **Formatação Dinâmica**: (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
-   **Validação Dual**: Frontend + Backend

### **Dashboard em Tempo Real**

-   **Métricas Ao Vivo**: Vendedores ativos, boxes ocupados, entradas do dia
-   **Auto-refresh**: Atualização automática a cada 30 segundos
-   **Cards Informativos**: Dados consolidados e organizados

### **Gestão de Horários Avançada**

-   **Cronograma Semanal**: Definição por dia da semana
-   **Validação de Conflitos**: Evita sobreposição de horários
-   **Flexibilidade Total**: Horários personalizáveis por vendedor

Este sistema oferece uma solução completa e profissional para gestão de feiras alimentares, com foco na usabilidade, segurança e eficiência operacional.
