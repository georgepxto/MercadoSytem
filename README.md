# 🏪 Sistema de Gestão de Feira Alimentar (MercadoSystem)

> **Um sistema completo e moderno desenvolvido em Laravel para gestão de feiras alimentares com controle avançado de vendedores, boxes, horários, produtos e pedidos.**

[![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)](https://mysql.com)

## 📋 **Visão Geral do Sistema**

O **MercadoSystem** é uma plataforma web completa e responsiva que oferece gestão integrada para feiras alimentares, incluindo:

- 🏪 **Gestão de Vendedores** com suporte a CNPJ condicional
- 📦 **Controle de Boxes** com alocação dinâmica
- ⏰ **Sistema de Horários** com cronogramas semanais
- 🚪 **Check-in/Check-out** em tempo real
- 🛒 **Catálogo de Produtos** por vendedor
- 📋 **Sistema de Pedidos** completo
- 👥 **Gestão Multi-tenant** com autenticação separada
- 📊 **Dashboard Analytics** com métricas em tempo real

Desenvolvido com foco na **usabilidade**, **escalabilidade** e **eficiência operacional**.

## 🔄 **Principais Recursos e Inovações**

### ✅ **Sistema Multi-tenant Avançado**

- **Isolamento de Dados**: Cada usuário possui seu próprio banco de dados
- **Autenticação Dupla**: Sistema separado para administradores e usuários finais
- **Gestão Granular**: Controle de acesso individual por usuário

### ✅ **Funcionalidades de E-commerce**

- **Catálogo de Produtos**: Sistema completo de produtos por vendedor
- **Categorização**: Organização hierárquica de produtos
- **Gestão de Pedidos**: Fluxo completo de pedidos com status tracking
- **Preços Dinâmicos**: Controle flexível de preços por produto

### ✅ **Interface Moderna e Responsiva**

- **Design Mobile-First**: Otimizado para dispositivos móveis
- **Tema Adaptativo**: Suporte a modo claro/escuro
- **UX Intuitiva**: Interface clean com foco na produtividade
- **Atualizações em Tempo Real**: Dados sempre sincronizados

### ✅ **Correção de Timezone Recente**

- **Problema Resolvido**: Horários de entrada/saída alinhados com fuso brasileiro
- **Configuração**: Timezone setado para `America/Sao_Paulo` (UTC-3)
- **Impacto**: Todos os registros de horário agora são precisos

## 🚀 **Início Rápido**

```bash
# 1. Clone e navegue para o projeto
git clone <url-do-repositorio>
cd MercadoSytem

# 2. Instale dependências
composer install

# 3. Configure ambiente
cp .env.example .env
php artisan key:generate

# 4. Configure banco de dados MySQL no arquivo .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=mercado_system
# DB_USERNAME=seu_usuario
# DB_PASSWORD=sua_senha

# 5. Execute migrações e seeders
php artisan migrate --seed

# 5. Inicie o servidor
php artisan serve

# 6. Acesse o sistema
# URL: http://127.0.0.1:8000
# Login Admin: admin@admin.com / password
```

## 🎯 **Funcionalidades Principais**

### 🏪 **Sistema de Vendedores Avançado**

- ✅ **Cadastro Completo**: Nome, email, telefone, especialidade culinária
- ✅ **CNPJ Inteligente**: Sistema condicional com formatação automática
- ✅ **Validação Dupla**: Frontend (JavaScript) + Backend (Laravel)
- ✅ **Status Management**: Controle de vendedores ativos/inativos
- ✅ **Relacionamentos**: Integração com produtos, horários e pedidos

### 📦 **Gestão de Boxes Dinâmica**

- ✅ **Cadastro Flexível**: Numeração, localização, preços mensais
- ✅ **Alocação Inteligente**: Atribuição automática baseada em disponibilidade
- ✅ **Monitoramento Real-time**: Status de ocupação em tempo real
- ✅ **Histórico Completo**: Rastreamento de uso e ocupação

### 🛒 **E-commerce Integrado**

- ✅ **Catálogo de Produtos**: Sistema completo por vendedor
- ✅ **Categorização**: Organização hierárquica de produtos
- ✅ **Gestão de Estoque**: Controle de disponibilidade
- ✅ **Sistema de Pedidos**: Fluxo completo com status tracking

## 📖 **Navegação do Documento**

| Seção                                              | Descrição                         |
| -------------------------------------------------- | --------------------------------- |
| [🎯 Funcionalidades](#-funcionalidades-principais) | Recursos principais do sistema    |
| [🛠 Tecnologias](#-stack-tecnológico)               | Stack e ferramentas utilizadas    |
| [🚀 Instalação](#-instalação-e-configuração)       | Guia completo de setup            |
| [🏗 Arquitetura](#-arquitetura-do-sistema)          | Estrutura e organização do código |
| [🔌 API](#-documentação-da-api)                    | Endpoints e integração            |
| [🖥 Interface](#-interface-e-funcionalidades-web)   | Páginas e recursos da UI          |
| [🔐 Segurança](#-segurança-e-autenticação)         | Recursos de proteção              |
| [📊 Performance](#-performance-e-otimização)       | Otimizações implementadas         |

## ✨ **Principais Funcionalidades**

### 🏪 **Gestão de Vendedores**

- **Cadastro Completo**: Nome, email, telefone com validação e formatação automática
- **CNPJ Opcional**: Sistema de CNPJ condicional com validação e formatação automática (XX.XXX.XXX/XXXX-XX)
- **Tipos de Comida**: Categorização por especialidade culinária
- **Status de Atividade**: Controle de vendedores ativos/inativos
- **Descrição Personalizada**: Campo livre para informações adicionais
- **Operações CRUD**: Criar, visualizar, editar e excluir vendedores

### ⏰ **Sistema de Horários Inteligente**

- ✅ **Cronograma Semanal**: Definição de horários por dia da semana
- ✅ **Validação de Conflitos**: Prevenção automática de sobreposições
- ✅ **Flexibilidade Total**: Horários customizáveis por vendedor/box
- ✅ **Integração com Check-in**: Sincronização com controle de entrada

### 🚪 **Controle de Entrada/Saída Premium**

- ✅ **Check-in Rápido**: Interface otimizada para registro de entrada
- ✅ **Auto Check-out**: Sistema automático de saída
- ✅ **Histórico Detalhado**: Registro completo de movimentações
- ✅ **Filtros Avançados**: Busca por múltiplos critérios

### 👥 **Sistema Multi-tenant**

- ✅ **Isolamento Completo**: Cada usuário possui dados isolados
- ✅ **Autenticação Dupla**: Admin + usuários com permissões específicas
- ✅ **Gestão Centralizada**: Painel administrativo dedicado
- ✅ **Escalabilidade**: Suporte a múltiplos mercados/feiras

### 📊 **Dashboard e Analytics**

- ✅ **Métricas em Tempo Real**: Dados atualizados automaticamente
- ✅ **Visualizações Interativas**: Cards e gráficos informativos
- ✅ **Relatórios Customizados**: Filtros por período e critérios
- ✅ **Exportação de Dados**: Relatórios em múltiplos formatos

## 🔧 **Características Técnicas**

### **Validações e Formatações Automáticas**

- **Telefone**: Formatação automática para (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
- **CNPJ**: Formatação automática para XX.XXX.XXX/XXXX-XX com validação de formato
- **Email**: Validação de formato e unicidade
- **Horários**: Validação de conflitos e sobreposições

### **Interface do Usuário**

- **Design Responsivo**: Funciona perfeitamente em desktop, tablet e mobile
- **Bootstrap 5.3**: Interface moderna e intuitiva
- **Ícones Bootstrap**: Iconografia consistente e profissional
- **Feedback Visual**: Mensagens de sucesso, erro e validação em tempo real

### **API RESTful**

- **Endpoints Completos**: Operações CRUD para todas as entidades
- **Validação de Dados**: Validação robusta em todas as requisições
- **Respostas JSON**: Comunicação padronizada entre frontend e backend
- **Códigos HTTP**: Uso correto de status codes (200, 201, 422, 404, etc.)

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

### **Backend Framework**

- **Laravel 9.x** - Framework PHP robusto e moderno
- **PHP 8.0+** - Linguagem de programação de alta performance
- **Eloquent ORM** - Mapeamento objeto-relacional elegante
- **Laravel Sanctum** - Autenticação API segura

### **Frontend & UI**

- **Bootstrap 5.3** - Framework CSS responsivo
- **Blade Templates** - Sistema de templates do Laravel
- **Bootstrap Icons** - Biblioteca de ícones consistente
- **JavaScript Vanilla** - JS puro para interatividade

### **Base de Dados**

- **MySQL 8.0+** - Sistema de banco de dados principal
- **Laravel Migrations** - Controle de versão do banco
- **Database Seeders** - Dados de exemplo e teste

### **Recursos Avançados**

- **Multi-tenancy** - Isolamento de dados por usuário
- **API RESTful** - Comunicação padronizada
- **Real-time Updates** - Atualizações automáticas
- **Mobile Responsive** - Design adaptativo

### **Ferramentas de Desenvolvimento**

- **Composer** - Gerenciador de dependências PHP
- **Artisan CLI** - Interface de linha de comando
- **Laravel Tinker** - REPL interativo
- **Laravel Pint** - Code formatting

## 🏗 **Arquitetura do Sistema**

### **Estrutura Geral do Projeto**

```
MercadoSytem/
├── 📁 app/                           # Lógica da aplicação
│   ├── 📁 Http/Controllers/          # Controladores
│   │   ├── 📁 Api/                   # Controllers da API REST
│   │   │   ├── VendorController.php  # CRUD de vendedores
│   │   │   ├── BoxController.php     # CRUD de boxes
│   │   │   ├── ProductController.php # CRUD de produtos
│   │   │   ├── OrderController.php   # Gestão de pedidos
│   │   │   ├── ScheduleController.php# Gestão de horários
│   │   │   └── EntryController.php   # Check-in/Check-out
│   │   ├── 📁 Auth/                  # Autenticação
│   │   │   ├── LoginController.php   # Login de usuários
│   │   │   └── DashboardManagerController.php # Admin
│   │   └── WebController.php         # Interface web
│   ├── 📁 Models/                    # Modelos de dados
│   │   ├── User.php                  # Usuários do sistema
│   │   ├── DashboardManager.php      # Administradores
│   │   ├── Vendor.php                # Vendedores (com CNPJ)
│   │   ├── Box.php                   # Boxes/Estandes
│   │   ├── Product.php               # Produtos
│   │   ├── Category.php              # Categorias
│   │   ├── Order.php                 # Pedidos
│   │   ├── OrderItem.php             # Itens do pedido
│   │   ├── Schedule.php              # Horários
│   │   └── Entry.php                 # Entradas/Saídas
│   ├── 📁 Providers/                 # Service Providers
│   │   └── TenantServiceProvider.php # Multi-tenancy
│   └── 📁 Http/Middleware/           # Middlewares
├── 📁 database/                      # Base de dados
│   ├── 📁 migrations/                # Estrutura do banco
│   │   ├── create_users_table.php
│   │   ├── create_dashboard_managers_table.php
│   │   ├── create_vendors_table.php
│   │   ├── add_cnpj_fields_to_vendors_table.php
│   │   ├── create_boxes_table.php
│   │   ├── create_categories_table.php
│   │   ├── create_products_table.php
│   │   ├── create_orders_table.php
│   │   ├── create_order_items_table.php
│   │   ├── create_schedules_table.php
│   │   └── create_entries_table.php
│   ├── 📁 seeders/                   # Dados de exemplo
│   │   ├── UserSeeder.php
│   │   ├── DashboardManagerSeeder.php
│   │   ├── VendorSeeder.php
│   │   ├── BoxSeeder.php
│   │   ├── CategorySeeder.php
│   │   ├── ProductSeeder.php
│   │   ├── OrderSeeder.php
│   │   ├── ScheduleSeeder.php
│   │   └── EntrySeeder.php
│   └── 📁 factories/                 # Model Factories
├── 📁 resources/views/               # Templates Blade
│   ├── 📁 layouts/
│   │   ├── app.blade.php             # Layout principal
│   │   └── admin.blade.php           # Layout admin
│   ├── 📁 admin/                     # Páginas admin
│   │   ├── dashboard.blade.php       # Dashboard admin
│   │   └── users.blade.php           # Gestão de usuários
│   ├── 📁 auth/
│   │   └── login.blade.php           # Página de login
│   ├── dashboard.blade.php           # Dashboard principal
│   ├── vendors.blade.php             # Gestão de vendedores
│   ├── boxes.blade.php               # Gestão de boxes
│   ├── checkin.blade.php             # Check-in/Check-out
│   └── entries.blade.php             # Histórico de entradas
├── 📁 routes/                        # Definição de rotas
│   ├── web.php                       # Rotas web
│   ├── api.php                       # Rotas da API
│   ├── console.php                   # Comandos Artisan
│   └── channels.php                  # Broadcasting
├── 📁 config/                        # Configurações
│   ├── app.php                       # Configuração geral
│   ├── database.php                  # Configuração do banco
│   └── auth.php                      # Configuração de auth
└── 📁 public/                        # Assets públicos
    ├── index.php                     # Ponto de entrada
    └── test-cnpj.html               # Página de teste CNPJ
```

### **Padrões Arquiteturais Implementados**

#### **🏛 MVC (Model-View-Controller)**

- **Models**: Camada de dados com Eloquent ORM
- **Views**: Templates Blade com componentes reutilizáveis
- **Controllers**: Lógica de negócio separada por domínio

#### **🔌 API RESTful**

- **Recursos CRUD**: Operações padronizadas para todas as entidades
- **Status Codes**: Códigos HTTP apropriados (200, 201, 422, 404)
- **Response Format**: JSON estruturado e consistente
- **Validation**: Validação robusta em todas as requisições

#### **🏢 Multi-tenancy**

- **Database per Tenant**: Isolamento completo de dados
- **Dynamic Connection**: Troca automática de conexão por usuário
- **Middleware Integration**: Seleção transparente de tenant

#### **🎯 Service Layer Pattern**

- **Business Logic**: Lógica de negócio centralizada
- **Reusability**: Código reutilizável entre controllers
- **Testability**: Facilita testes unitários e de integração

## 🗄 **Estrutura do Banco de Dados**

### **Esquema Relacional Completo**

```sql
-- Tabela principal de usuários do sistema
users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    has_dashboard_access BOOLEAN DEFAULT false,
    dashboard_name VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Administradores do sistema (multi-tenant)
dashboard_managers (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Vendedores com suporte a CNPJ
vendors (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20),
    food_type VARCHAR(255),
    description TEXT NULL,
    active BOOLEAN DEFAULT true,
    has_cnpj BOOLEAN DEFAULT false,
    cnpj VARCHAR(18) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Boxes/Estandes da feira
boxes (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    number VARCHAR(10) UNIQUE,
    location VARCHAR(255),
    description TEXT NULL,
    available BOOLEAN DEFAULT true,
    monthly_price DECIMAL(10,2) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Categorias de produtos
categories (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) UNIQUE,
    description TEXT NULL,
    active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Produtos por vendedor
products (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT NULL,
    price DECIMAL(10,2),
    vendor_id BIGINT REFERENCES vendors(id),
    category_id BIGINT REFERENCES categories(id),
    available BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Pedidos de clientes
orders (
    id BIGINT PRIMARY KEY,
    customer_name VARCHAR(255),
    customer_email VARCHAR(255),
    customer_phone VARCHAR(255),
    vendor_id BIGINT REFERENCES vendors(id),
    total_amount DECIMAL(10,2),
    status ENUM('pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Itens dos pedidos
order_items (
    id BIGINT PRIMARY KEY,
    order_id BIGINT REFERENCES orders(id),
    product_id BIGINT REFERENCES products(id),
    quantity INTEGER,
    price DECIMAL(10,2),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Horários de trabalho
schedules (
    id BIGINT PRIMARY KEY,
    vendor_id BIGINT REFERENCES vendors(id),
    box_id BIGINT REFERENCES boxes(id),
    day_of_week VARCHAR(20),
    start_time TIME,
    end_time TIME,
    active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Controle de entrada/saída
entries (
    id BIGINT PRIMARY KEY,
    vendor_id BIGINT REFERENCES vendors(id),
    box_id BIGINT REFERENCES boxes(id),
    entry_time DATETIME,
    exit_time DATETIME NULL,
    entry_date DATE,
    notes TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)
```

### **Relacionamentos e Integridade**

#### **Relacionamentos Principais**

- `User` → **has_dashboard_access** (controle de acesso)
- `Vendor` → **hasMany** `Products`, `Orders`, `Schedules`, `Entries`
- `Box` → **hasMany** `Schedules`, `Entries`
- `Category` → **hasMany** `Products`
- `Order` → **hasMany** `OrderItems`, **belongsTo** `Vendor`
- `Product` → **belongsTo** `Vendor`, `Category`
- `Schedule` → **belongsTo** `Vendor`, `Box`
- `Entry` → **belongsTo** `Vendor`, `Box`

#### **Índices para Performance**

```sql
-- Índices otimizados para consultas frequentes
CREATE INDEX idx_vendors_active ON vendors(active);
CREATE INDEX idx_vendors_email ON vendors(email);
CREATE INDEX idx_boxes_available ON boxes(available);
CREATE INDEX idx_products_vendor ON products(vendor_id);
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_orders_vendor ON orders(vendor_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_entries_date ON entries(entry_date);
CREATE INDEX idx_entries_vendor ON entries(vendor_id);
CREATE INDEX idx_schedules_vendor ON schedules(vendor_id, day_of_week);
```

## 🚀 **Instalação e Configuração**

### **📋 Pré-requisitos**

#### **Software Necessário**

- ✅ **PHP 8.0+** com extensões: `pdo`, `mysql`, `mbstring`, `openssl`
- ✅ **MySQL 8.0+** - Banco de dados principal
- ✅ **Composer** (gerenciador de dependências PHP)
- ✅ **Git** (controle de versão)
- ✅ **Node.js & NPM** (opcional, para assets)

#### **Verificação do Ambiente**

```bash
# Verificar versão do PHP
php --version

# Verificar extensões necessárias
php -m | grep -E "(pdo|mysql|mbstring|openssl)"

# Verificar Composer
composer --version
```

### **🛠 Instalação Passo a Passo**

#### **1. Clone e Configuração Inicial**

```bash
# Clone o repositório
git clone <url-do-repositorio>
cd MercadoSytem

# Instalar dependências PHP
composer install

# Configurar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

#### **2. Configuração do Banco de Dados**

```bash
# Crie o banco de dados MySQL
mysql -u root -p
CREATE DATABASE mercado_system;
exit

# Configure o arquivo .env
# Edite as configurações do MySQL no arquivo .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=mercado_system
# DB_USERNAME=seu_usuario
# DB_PASSWORD=sua_senha

# Executar migrações e seeders
php artisan migrate --seed
```

#### **3. Configuração Avançada (Opcional)**

**Configuração de timezone:**

```env
# Já configurado para Brasil
APP_TIMEZONE=America/Sao_Paulo
```

#### **4. Inicialização do Sistema**

```bash
# Limpar caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Iniciar servidor de desenvolvimento
php artisan serve

# Sistema estará disponível em:
# http://127.0.0.1:8000
```

### **👤 Credenciais Padrão**

#### **Administrador do Sistema**

- **Email**: `admin@admin.com`
- **Senha**: `admin123`
- **Acesso**: Painel administrativo completo

#### **Usuário de teste**

- **Email**: `contato@mercadofatima.com`
- **Senha**: `12345678`

### **🗂 Dados de Exemplo Incluídos**

O sistema vem pré-carregado com:

- ✅ **6 Vendedores** (alguns com CNPJ, outros sem)
- ✅ **8 Boxes** com diferentes características
- ✅ **15+ Produtos** distribuídos por categorias
- ✅ **Horários** pré-configurados para a semana
- ✅ **Entradas de Exemplo** para demonstração
- ✅ **Categorias** de alimentos organizadas
- ✅ **Pedidos de Teste** com diferentes status

### **🧪 Teste Rápido do Sistema**

Após instalação, teste estas funcionalidades:

```bash
# 1. Acesse o dashboard principal
curl http://127.0.0.1:8000/dashboard

# 2. Teste API de vendedores
curl http://127.0.0.1:8000/api/vendors

# 3. Teste API de boxes
curl http://127.0.0.1:8000/api/boxes
```

**Interface Web:**

1. 🏠 **Dashboard** - `/dashboard` - Visão geral do sistema
2. 👥 **Vendedores** - `/vendors` - Gestão completa de vendedores
3. 📦 **Boxes** - `/boxes` - Administração de boxes
4. ⏰ **Check-in** - `/checkin` - Controle de entrada/saída
5. 📊 **Histórico** - `/entries` - Relatórios e consultas

### **🐛 Resolução de Problemas Comuns**

#### **Erro de Permissão (Laravel)**

```bash
# Ajustar permissões no Linux/Mac
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# No Windows (PowerShell como Admin)
icacls storage /grant Everyone:F /t
icacls bootstrap\cache /grant Everyone:F /t
```

#### **Erro de Banco de Dados**

```bash
# Verificar conexão MySQL
php artisan tinker
DB::connection()->getPdo();

# Recriar migrações se necessário
php artisan migrate:fresh --seed
```

#### **Erro de Chave de Aplicação**

```bash
# Regenerar chave
php artisan key:generate --force
```

#### **Cache de Configuração**

```bash
# Limpar todos os caches
php artisan optimize:clear
```

## 🔌 **Documentação da API**

### **🌐 Visão Geral da API**

A API do MercadoSystem segue os padrões REST com respostas JSON estruturadas, autenticação segura e validação robusta. Todas as rotas da API estão protegidas por middleware de autenticação e multi-tenancy.

**Base URL**: `http://localhost:8000/api`
**Autenticação**: Laravel Sanctum
**Content-Type**: `application/json`

### **📊 Estrutura de Resposta Padrão**

```json
// Sucesso (200/201)
{
    "data": { ... },
    "message": "Operação realizada com sucesso",
    "timestamp": "2025-06-27T10:30:00Z"
}

// Erro de Validação (422)
{
    "message": "Os dados fornecidos são inválidos",
    "errors": {
        "campo": ["mensagem de erro"]
    }
}

// Erro Não Encontrado (404)
{
    "message": "Recurso não encontrado"
}
```

### **👥 Vendedores API (`/api/vendors`)**

#### **Listar Vendedores**

```http
GET /api/vendors
GET /api/vendors?available=1  # Apenas ativos
```

**Resposta:**

```json
[
    {
        "id": 1,
        "name": "João Silva",
        "email": "joao@exemplo.com",
        "phone": "(11) 99999-9999",
        "food_type": "Comida Japonesa",
        "description": "Especialista em sushi",
        "active": true,
        "has_cnpj": true,
        "cnpj": "12.345.678/0001-90",
        "created_at": "2025-06-27T10:00:00Z",
        "schedules": [...],
        "entries": [...]
    }
]
```

#### **Criar Vendedor**

```http
POST /api/vendors
Content-Type: application/json

{
    "name": "Maria Santos",
    "email": "maria@exemplo.com",
    "phone": "(11) 98888-8888",
    "food_type": "Comida Vegana",
    "description": "Especializada em pratos veganos",
    "active": true,
    "has_cnpj": false
}
```

#### **Buscar Vendedor**

```http
GET /api/vendors/{id}
```

#### **Atualizar Vendedor**

```http
PUT /api/vendors/{id}
PATCH /api/vendors/{id}
```

#### **Excluir Vendedor**

```http
DELETE /api/vendors/{id}
```

### **📦 Boxes API (`/api/boxes`)**

#### **Listar Boxes**

```http
GET /api/boxes
GET /api/boxes?available=1  # Apenas disponíveis
```

**Resposta:**

```json
[
    {
        "id": 1,
        "name": "Box Premium A1",
        "number": "A1",
        "location": "Setor Norte - Entrada Principal",
        "description": "Box amplo com boa visibilidade",
        "available": true,
        "monthly_price": "1500.00",
        "schedules": [...],
        "entries": [...]
    }
]
```

#### **Criar Box**

```http
POST /api/boxes
Content-Type: application/json

{
    "name": "Box Central B5",
    "number": "B5",
    "location": "Setor Central",
    "description": "Box estratégico no centro da feira",
    "available": true,
    "monthly_price": 1200.00
}
```

### **🛒 Produtos API (`/api/products`)**

#### **Listar Produtos**

```http
GET /api/products
GET /api/vendors/{vendor_id}/products  # Por vendedor
GET /api/categories/{category_id}/products  # Por categoria
```

**Resposta:**

```json
[
  {
    "id": 1,
    "name": "Temaki de Salmão",
    "description": "Temaki fresco com salmão grelhado",
    "price": "15.90",
    "vendor_id": 1,
    "category_id": 3,
    "available": true,
    "vendor": {
      "name": "João Silva",
      "food_type": "Comida Japonesa"
    },
    "category": {
      "name": "Comida Oriental"
    }
  }
]
```

#### **Criar Produto**

```http
POST /api/products
Content-Type: application/json

{
    "name": "Sushi Combo",
    "description": "Combo com 12 peças variadas",
    "price": 45.90,
    "vendor_id": 1,
    "category_id": 3,
    "available": true
}
```

### **📋 Pedidos API (`/api/orders`)**

#### **Criar Pedido**

```http
POST /api/orders
Content-Type: application/json

{
    "customer_name": "Cliente Exemplo",
    "customer_email": "cliente@exemplo.com",
    "customer_phone": "(11) 99999-9999",
    "vendor_id": 1,
    "items": [
        {
            "product_id": 1,
            "quantity": 2,
            "price": 15.90
        },
        {
            "product_id": 3,
            "quantity": 1,
            "price": 45.90
        }
    ]
}
```

#### **Atualizar Status do Pedido**

```http
PATCH /api/orders/{id}

{
    "status": "preparing"  // pending, confirmed, preparing, ready, delivered, cancelled
}
```

### **⏰ Horários API (`/api/schedules`)**

#### **Criar Horário**

```http
POST /api/schedules
Content-Type: application/json

{
    "vendor_id": 1,
    "box_id": 1,
    "day_of_week": "segunda",
    "start_time": "08:00",
    "end_time": "16:00",
    "active": true
}
```

#### **Buscar por Vendedor/Box**

```http
GET /api/schedules/vendor/{vendor_id}
GET /api/schedules/box/{box_id}
```

### **🚪 Entradas API (`/api/entries`)**

#### **Check-in (Registrar Entrada)**

```http
POST /api/entries
Content-Type: application/json

{
    "vendor_id": 1,
    "box_id": 1,
    "notes": "Chegada pontual"
}
```

#### **Check-out (Registrar Saída)**

```http
PUT /api/entries/{id}/checkout
POST /api/entries/{id}/checkout
```

#### **Consultar Entradas**

```http
GET /api/entries
GET /api/entries/today  # Entradas de hoje
GET /api/entries/vendor/{vendor_id}  # Por vendedor
GET /api/entries/box/{box_id}  # Por box

# Com filtros
GET /api/entries?vendor_id=1&date_from=2025-06-01&date_to=2025-06-30
```

### **📚 Categorias API (`/api/categories`)**

#### **Operações Básicas**

```http
GET /api/categories           # Listar todas
POST /api/categories          # Criar nova
GET /api/categories/{id}      # Buscar específica
PUT /api/categories/{id}      # Atualizar
DELETE /api/categories/{id}   # Excluir
```

### **🔒 Autenticação e Middleware**

#### **Headers Necessários**

```http
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

#### **Obter Token (Laravel Sanctum)**

```http
POST /login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### **📝 Códigos de Status HTTP**

| Código | Significado           | Uso                        |
| ------ | --------------------- | -------------------------- |
| `200`  | OK                    | Operação bem-sucedida      |
| `201`  | Created               | Recurso criado com sucesso |
| `204`  | No Content            | Exclusão bem-sucedida      |
| `400`  | Bad Request           | Requisição inválida        |
| `401`  | Unauthorized          | Não autenticado            |
| `403`  | Forbidden             | Sem permissão              |
| `404`  | Not Found             | Recurso não encontrado     |
| `422`  | Unprocessable Entity  | Erro de validação          |
| `500`  | Internal Server Error | Erro interno do servidor   |

### **🧪 Exemplos de Uso com cURL**

```bash
# Listar vendedores
curl -H "Authorization: Bearer {token}" \
     -H "Accept: application/json" \
     http://localhost:8000/api/vendors

# Criar novo produto
curl -X POST \
     -H "Authorization: Bearer {token}" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"name":"Açaí Premium","price":12.50,"vendor_id":1,"category_id":2}' \
     http://localhost:8000/api/products

# Check-in de vendedor
curl -X POST \
     -H "Authorization: Bearer {token}" \
     -H "Content-Type: application/json" \
     -d '{"vendor_id":1,"box_id":3}' \
     http://localhost:8000/api/entries
```

## 🎯 **Validações Implementadas**

### **Telefone**

- **Formato**: `(XX) XXXXX-XXXX` para celular ou `(XX) XXXX-XXXX` para fixo
- **Validação**: Regex `/^\(\d{2}\) \d{4,5}-\d{4}$/`
- **Formatação**: Automática durante digitação

### **CNPJ**

- **Formato**: `XX.XXX.XXX/XXXX-XX`
- **Validação**: Regex `/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/`
- **Formatação**: Automática durante digitação
- **Condicional**: Obrigatório apenas se "Possui CNPJ" estiver marcado

### **Email**

- **Validação**: Formato válido de email
- **Unicidade**: Não permite emails duplicados

### **Horários**

- **Conflitos**: Impede sobreposição de horários no mesmo box
- **Formato**: Validação de horário válido (HH:MM)

## 🖥 **Interface e Funcionalidades Web**

### **🏠 Dashboard Principal (`/dashboard`)**

**Visão Geral em Tempo Real**

- 📊 **Métricas Dinâmicas**: Total de vendedores ativos, boxes ocupados, entradas do dia
- 📈 **Cards Informativos**: Estatísticas atualizadas automaticamente
- ⚡ **Auto-refresh**: Atualização a cada 30 segundos
- 🎯 **Resumo de Atividades**: Movimentações recentes do dia
- 📱 **Layout Responsivo**: Adaptado para mobile e desktop

**Funcionalidades Disponíveis:**

- ✅ Contadores em tempo real de vendedores ativos
- ✅ Status de ocupação de boxes
- ✅ Lista das últimas entradas/saídas
- ✅ Navegação rápida para outras seções

### **🚪 Check-in/Check-out (`/checkin`)**

**Interface de Controle de Acesso**

- ⚡ **Check-in Rápido**: Formulário otimizado para registro de entrada
- 📋 **Seleção Inteligente**: Dropdowns com vendedores ativos e boxes disponíveis
- 👥 **Lista de Presentes**: Vendedores atualmente na feira com botão de check-out
- 🔄 **Atualizações Automáticas**: Refresh a cada 15 segundos
- ⏰ **Registro Automático**: Horários capturados automaticamente

**Fluxo de Uso:**

1. **Entrada**: Selecionar vendedor → Escolher box → Confirmar
2. **Saída**: Clicar no botão "Check-out" ao lado do vendedor presente
3. **Visualização**: Lista em tempo real de quem está presente

### **👥 Gestão de Vendedores (`/vendors`)**

**Interface Completa de Administração**

- 🎴 **Cards Visuais**: Cada vendedor em card individual com foto/avatar
- 📝 **Informações Completas**: Nome, email, telefone, CNPJ (quando aplicável)
- 🏷 **Badges Informativos**: Status ativo/inativo, tipo de comida
- ⚙ **Ações Rápidas**: Editar, adicionar horário, gerenciar produtos, excluir
- 📅 **Cronogramas**: Exibição dos horários semanais de cada vendedor

**Recursos Especiais:**

- ✅ **CNPJ Condicional**: Campo aparece apenas quando necessário
- ✅ **Formatação Automática**: Telefone e CNPJ formatados em tempo real
- ✅ **Validação Dupla**: Frontend + Backend para máxima segurança
- ✅ **Filtros Avançados**: Busca por nome, tipo de comida, status

### **📦 Gestão de Boxes (`/boxes`)**

**Administração de Espaços**

- 📋 **Lista Organizada**: Todos os boxes com informações detalhadas
- 🏷 **Identificação Clara**: Número, nome, localização
- 💰 **Preços**: Valores mensais de aluguel quando aplicável
- 🔴🟢 **Status Visual**: Indicadores de ocupação em tempo real
- 📊 **Métricas**: Histórico de uso e ocupação

**Funcionalidades:**

- ✅ **Cadastro Flexível**: Nome, número, localização, preço
- ✅ **Status de Disponibilidade**: Controle ativo/inativo
- ✅ **Associação com Vendedores**: Visualização de horários e ocupação
- ✅ **Histórico Completo**: Acesso ao histórico de uso

### **📊 Histórico de Entradas (`/entries`)**

**Central de Relatórios e Consultas**

- 🔍 **Filtros Avançados**: Por data, vendedor, box, período
- 📅 **Período Customizado**: Seleção de datas início e fim
- 📋 **Tabela Detalhada**: Horários de entrada/saída, tempo de permanência
- 📤 **Exportação**: Capacidade de exportar dados (CSV, PDF)
- 🔎 **Busca Inteligente**: Sistema de busca por múltiplos critérios

**Informações Exibidas:**

- ✅ Nome do vendedor e box utilizado
- ✅ Data e horário de entrada
- ✅ Data e horário de saída (quando aplicável)
- ✅ Tempo total de permanência
- ✅ Observações e notas adicionais

### **🏪 Catálogo de Produtos (Integrado)**

**Gestão de Produtos por Vendedor**

- 🛒 **Catálogo Completo**: Produtos organizados por vendedor
- 🏷 **Categorização**: Sistema hierárquico de categorias
- 💰 **Controle de Preços**: Gestão flexível de valores
- 📦 **Status de Estoque**: Disponível/Indisponível
- 📸 **Suporte a Imagens**: Upload de fotos dos produtos

### **👑 Painel Administrativo (`/admin`)**

**Gestão Multi-tenant**

- 👥 **Gestão de Usuários**: Criar, editar, ativar/desativar usuários
- 🔐 **Controle de Acesso**: Gerenciar permissões de dashboard
- 📊 **Métricas Globais**: Estatísticas de todos os usuários
- ⚙ **Configurações**: Parâmetros globais do sistema

**Funcionalidades Administrativas:**

- ✅ **Criação de Usuários**: Cadastro de novos usuários do sistema
- ✅ **Gestão de Acesso**: Conceder/revogar acesso ao dashboard
- ✅ **Personalização**: Definir nomes personalizados para o dashboard
- ✅ **Monitoramento**: Acompanhar uso e atividade dos usuários

### **🎨 Características da Interface**

#### **Design System**

- 🎨 **Bootstrap 5.3**: Framework CSS moderno e responsivo
- 🖼 **Bootstrap Icons**: Iconografia consistente e profissional
- 🎯 **Design Clean**: Interface limpa focada na usabilidade
- 📱 **Mobile First**: Otimizado para dispositivos móveis

#### **Experiência do Usuário**

- ⚡ **Performance**: Carregamento rápido e otimizado
- 🔄 **Feedback Visual**: Mensagens de sucesso/erro em tempo real
- 🎭 **Animations**: Transições suaves e profissionais
- 🖱 **Interatividade**: Elementos responsivos ao hover/click

#### **Acessibilidade**

- ♿ **WCAG Compliance**: Seguindo diretrizes de acessibilidade
- ⌨ **Navegação por Teclado**: Suporte completo
- 🔍 **Alto Contraste**: Cores adequadas para visibilidade
- 📱 **Touch Friendly**: Elementos otimizados para touch

#### **Temas e Personalização**

- 🌓 **Modo Claro/Escuro**: Suporte a temas adaptativos
- 🎨 **Cores Customizáveis**: Esquema de cores personalizável
- 📐 **Layout Flexível**: Adaptação automática ao conteúdo
- 🖼 **Branding**: Espaço para logotipos e identidade visual

## 🔐 **Segurança e Autenticação**

### **🛡 Sistema de Autenticação Multi-camada**

#### **Autenticação Dupla**

- 👑 **Dashboard Managers**: Administradores com acesso completo ao sistema
- 👤 **Users**: Usuários finais com acesso a dashboards específicos
- 🔐 **Guards Separados**: Isolamento completo entre níveis de acesso
- 🎫 **Laravel Sanctum**: Tokens seguros para API

#### **Controle de Acesso Granular**

```php
// Middleware de proteção aplicado
'auth'              // Autenticação obrigatória
'tenant.database'   // Isolamento de banco de dados
'auth:dashboard_manager'  // Acesso administrativo
```

### **🏢 Arquitetura Multi-tenant**

#### **Isolamento de Dados**

- 📊 **Database per Tenant**: Cada usuário possui banco isolado
- 🔄 **Dynamic Connection**: Troca automática de conexão
- 🛡 **Data Security**: Impossibilidade de acesso a dados de outros usuários
- 🎯 **Tenant Resolution**: Identificação automática do tenant

#### **Fluxo de Multi-tenancy**

```
1. Login do usuário → 2. Identificação do tenant → 3. Conexão com BD específico
4. Operações isoladas → 5. Logout → 6. Limpeza de sessão
```

### **🔒 Proteções Implementadas**

#### **Proteção CSRF**

- 🛡 **Todos os Formulários**: Proteção automática contra CSRF
- 🎫 **Tokens Únicos**: Geração automática de tokens por sessão
- ⏰ **Expiração**: Tokens com tempo de vida limitado

#### **Validação de Dados**

- 🔍 **Input Validation**: Sanitização rigorosa de entradas
- 📝 **Form Requests**: Validação estruturada no backend
- 🚫 **SQL Injection**: Proteção via Eloquent ORM
- 🔐 **XSS Protection**: Escape automático de output

#### **Proteção de Senhas**

```php
// Hash seguro com bcrypt
'password' => Hash::make($password)

// Verificação segura
Hash::check($input, $hashedPassword)
```

### **🔑 Gestão de Sessões**

#### **Configuração Segura**

- ⏰ **Tempo de Vida**: Sessões com expiração configurável
- 🍪 **Cookies Seguros**: HttpOnly e Secure flags
- 🔄 **Regeneração**: IDs de sessão regenerados no login
- 🚫 **Logout Seguro**: Invalidação completa da sessão

#### **Prevenção de Ataques**

- 🔒 **Session Fixation**: Regeneração automática de ID
- ⏰ **Session Timeout**: Logout automático por inatividade
- 🔄 **Concurrent Sessions**: Controle de sessões múltiplas

### **🛡 Middleware de Segurança**

#### **Middleware Personalizado**

```php
// TenantServiceProvider - Isolamento de dados
class TenantServiceProvider {
    public function switchDatabase($user) {
        // Lógica de troca de banco de dados
    }
}

// Middleware de verificação de acesso
class CheckDashboardAccess {
    public function handle($request, $next) {
        if (!auth()->user()->hasDashboardAccess()) {
            return redirect('/login')->withErrors(['access' => 'Acesso negado']);
        }
        return $next($request);
    }
}
```

### **🔐 Autenticação API**

#### **Laravel Sanctum**

- 🎫 **Token-based**: Autenticação por tokens pessoais
- ⏰ **Expiração**: Tokens com tempo de vida configurável
- 🔄 **Revogação**: Possibilidade de revogar tokens
- 📱 **SPA Support**: Suporte para Single Page Applications

#### **Exemplo de Uso**

```php
// Gerar token
$token = $user->createToken('api-token')->plainTextToken;

// Usar token nas requisições
curl -H "Authorization: Bearer {token}" /api/vendors
```

### **🔍 Auditoria e Logs**

#### **Logs de Segurança**

- 📝 **Login Attempts**: Registro de tentativas de login
- 🚫 **Failed Logins**: Log de falhas de autenticação
- 🔄 **Tenant Switches**: Registro de trocas de tenant
- 📊 **API Calls**: Log de chamadas da API

#### **Monitoramento**

```php
// Logs automáticos
Log::info('User login', ['user_id' => $user->id]);
Log::warning('Failed login attempt', ['email' => $email]);
Log::error('Unauthorized access attempt', ['ip' => $request->ip()]);
```

### **🛡 Configurações de Segurança**

#### **Headers de Segurança**

```php
// Configurações no .env
SECURE_HEADERS=true
CONTENT_SECURITY_POLICY=strict
X_FRAME_OPTIONS=DENY
X_CONTENT_TYPE_OPTIONS=nosniff
```

#### **Configuração de Banco**

```env
# Conexão segura
DB_CONNECTION=mysql
DB_SSL_MODE=REQUIRED
DB_SSL_CERT=path/to/cert.pem
```

### **🔧 Boas Práticas Implementadas**

#### **Desenvolvimento Seguro**

- ✅ **Principle of Least Privilege**: Usuários com mínimo acesso necessário
- ✅ **Defense in Depth**: Múltiplas camadas de proteção
- ✅ **Input Validation**: Validação em todas as camadas
- ✅ **Output Encoding**: Escape adequado de saídas

#### **Operacional**

- ✅ **Regular Updates**: Manutenção de dependências atualizada
- ✅ **Security Patches**: Aplicação regular de patches
- ✅ **Backup Strategy**: Backups seguros e regulares
- ✅ **Access Reviews**: Revisão periódica de acessos

### **🚨 Resposta a Incidentes**

#### **Detecção**

- 🔍 **Monitoring**: Monitoramento ativo de logs
- 🚨 **Alertas**: Notificações automáticas de eventos suspeitos
- 📊 **Analytics**: Análise de padrões de acesso

#### **Resposta**

- 🔒 **Account Lockout**: Bloqueio automático de contas suspeitas
- 🔄 **Token Revocation**: Revogação imediata de tokens comprometidos
- 📝 **Incident Logging**: Registro detalhado de incidentes

## ⚡ **Performance e Otimização**

### **🚀 Otimizações de Backend**

#### **Database Performance**

- 📊 **Índices Estratégicos**: Índices otimizados para consultas frequentes
- 🔄 **Eager Loading**: Carregamento otimizado de relacionamentos
- 📝 **Query Optimization**: Consultas SQL eficientes com Eloquent
- 💾 **Connection Pooling**: Gerenciamento eficiente de conexões

```php
// Exemplo de eager loading otimizado
$vendors = Vendor::with(['schedules.box', 'entries', 'products.category'])
    ->where('active', true)
    ->get();
```

#### **Caching Strategy**

- 🗄 **Route Caching**: Cache de rotas para produção
- 🖼 **View Caching**: Compilação de templates Blade
- ⚙ **Config Caching**: Cache de configurações
- 📊 **Query Caching**: Cache de consultas frequentes

```bash
# Comandos de otimização para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### **🎯 Otimizações de Frontend**

#### **Asset Optimization**

- 📦 **Bootstrap CDN**: Carregamento otimizado do Bootstrap
- 🖼 **Icon Optimization**: Bootstrap Icons otimizados
- ⚡ **Lazy Loading**: Carregamento sob demanda de componentes
- 🗜 **CSS/JS Minification**: Assets minificados em produção

#### **JavaScript Performance**

- 🚫 **Minimal Dependencies**: JavaScript vanilla para máxima performance
- 🔄 **Async Operations**: Operações assíncronas com fetch/axios
- ⏰ **Debounced Updates**: Throttling de atualizações em tempo real
- 💾 **Local Caching**: Cache local de dados frequentes

### **📱 Responsividade e Mobile**

#### **Mobile-First Design**

- 📱 **Touch Optimization**: Elementos otimizados para touch
- 🖼 **Responsive Images**: Imagens adaptativas por device
- ⚡ **Fast Loading**: Carregamento otimizado para mobile
- 📐 **Flexible Layouts**: Layouts que se adaptam ao conteúdo

#### **Progressive Enhancement**

- 🔧 **Core Functionality**: Funcionalidade básica sem JavaScript
- ⚡ **Enhanced Experience**: Recursos avançados com JavaScript
- 📶 **Offline Capability**: Funcionalidade básica offline
- 🔄 **Graceful Degradation**: Degradação elegante em dispositivos limitados

### **🏗 Arquitetura Escalável**

#### **Code Organization**

- 📁 **Modular Structure**: Código organizado em módulos
- 🔧 **Service Layer**: Lógica de negócio centralizada
- 🎯 **Single Responsibility**: Classes com responsabilidade única
- 🔄 **Dependency Injection**: Injeção de dependência para testabilidade

#### **Multi-tenant Optimization**

- 💾 **Efficient Connection Switching**: Troca eficiente de conexões
- 📊 **Shared Resources**: Recursos compartilhados quando possível
- 🔐 **Isolated Processing**: Processamento isolado por tenant
- ⚡ **Optimized Queries**: Consultas otimizadas por tenant

### **📊 Monitoramento e Métricas**

#### **Performance Monitoring**

- ⏱ **Response Time Tracking**: Monitoramento de tempo de resposta
- 💾 **Memory Usage**: Monitoramento de uso de memória
- 📊 **Database Performance**: Métricas de performance do banco
- 🔍 **Error Tracking**: Rastreamento de erros e exceções

#### **Real-time Updates**

- 🔄 **Efficient Polling**: Polling otimizado para atualizações
- ⚡ **Minimal Payload**: Transferência mínima de dados
- 📡 **Smart Refresh**: Atualização inteligente apenas quando necessário
- 💾 **Client-side Caching**: Cache no lado do cliente

### **🛠 Configurações de Produção**

#### **Server Optimization**

```env
# Configurações otimizadas para produção
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

# Cache e sessões
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Database
DB_CONNECTION=mysql
DB_HOST=servidor-db
DB_PERSISTENT=true
```

#### **Web Server Configuration**

```nginx
# Exemplo de configuração Nginx otimizada
server {
    listen 443 ssl http2;
    root /var/www/MercadoSytem/public;

    # Compressão
    gzip on;
    gzip_types text/css application/javascript;

    # Cache de assets
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass php-fpm;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### **📈 Métricas de Performance**

#### **Benchmarks Típicos**

- ⚡ **Página Inicial**: < 500ms tempo de carregamento
- 📊 **API Responses**: < 200ms tempo médio de resposta
- 💾 **Database Queries**: < 50ms por consulta otimizada
- 🔄 **Real-time Updates**: < 2s intervalo de atualização

#### **Otimizações Específicas**

- 🎯 **Dashboard**: Lazy loading de widgets não críticos
- 👥 **Vendedores**: Paginação otimizada para listas grandes
- 📦 **Produtos**: Cache de categorias e filtros
- 📊 **Relatórios**: Processamento assíncrono para grandes volumes

### **🔧 Ferramentas de Desenvolvimento**

#### **Performance Tools**

```bash
# Laravel Telescope (desenvolvimento)
composer require laravel/telescope --dev
php artisan telescope:install

# Laravel Debugbar (desenvolvimento)
composer require barryvdh/laravel-debugbar --dev

# Performance testing
composer require phpunit/phpunit --dev
```

#### **Monitoring Tools**

- 📊 **Laravel Horizon**: Monitoramento de filas
- 🔍 **Laravel Telescope**: Debug e profiling
- 📈 **New Relic**: APM em produção
- 🔍 **Sentry**: Error tracking e performance

## 📱 **Compatibilidade e Suporte**

### **🌐 Navegadores Suportados**

#### **Desktop**

- ✅ **Chrome 90+** - Suporte completo e otimizado
- ✅ **Firefox 88+** - Funcionalidade completa
- ✅ **Safari 14+** - Compatibilidade total
- ✅ **Edge 90+** - Suporte moderno
- ⚠️ **Internet Explorer** - Não suportado (descontinuado)

#### **Mobile**

- ✅ **Chrome Mobile** - Performance otimizada
- ✅ **Safari iOS** - Totalmente compatível
- ✅ **Samsung Internet** - Suporte completo
- ✅ **Firefox Mobile** - Funcionalidade completa

### **📱 Dispositivos e Resoluções**

#### **Breakpoints Responsivos**

```css
/* Mobile First - Bootstrap 5.3 */
/* xs: <576px    - Smartphones */
/* sm: ≥576px    - Smartphones grandes */
/* md: ≥768px    - Tablets */
/* lg: ≥992px    - Desktop pequeno */
/* xl: ≥1200px   - Desktop grande */
/* xxl: ≥1400px  - Desktop extra grande */
```

#### **Dispositivos Testados**

- 📱 **Smartphones**: iPhone 12+, Samsung Galaxy S21+, Google Pixel
- 📟 **Tablets**: iPad Air, Samsung Galaxy Tab, Surface Pro
- 💻 **Laptops**: 13" - 17" (1366x768 até 1920x1080)
- 🖥 **Desktops**: Full HD até 4K (3840x2160)

### **⚙ Requisitos de Sistema**

#### **Servidor (Produção)**

```yaml
Minimum Requirements:
  - PHP: 8.0+
  - Memory: 512MB RAM
  - Storage: 1GB disk space
  - Database: MySQL 5.7+ / PostgreSQL 12+ / SQLite 3.8+

Recommended:
  - PHP: 8.1+
  - Memory: 2GB RAM
  - Storage: 5GB SSD
  - Database: MySQL 8.0+ / PostgreSQL 14+
  - Web Server: Nginx 1.18+ / Apache 2.4+
```

#### **Cliente (Browser)**

```yaml
Minimum:
  - JavaScript: ES6 (ES2015)
  - CSS: CSS3 support
  - Storage: 50MB local storage
  - Network: 1Mbps connection

Optimal:
  - Modern browser (2+ years old)
  - Broadband connection (10+ Mbps)
  - Hardware acceleration enabled
```

### **🔧 Extensibilidade e Customização**

#### **Temas e Personalização**

- 🎨 **CSS Variables**: Customização via variáveis CSS
- 🖼 **Bootstrap Themes**: Suporte a temas personalizados
- 🏷 **Brand Colors**: Cores da marca configuráveis
- 📐 **Layout Options**: Layouts flexíveis e configuráveis

#### **Módulos Extensíveis**

```php
// Exemplo de extensão personalizada
namespace App\Extensions;

class CustomReportGenerator {
    public function generateMonthlyReport($vendorId) {
        // Lógica personalizada para relatórios
    }
}
```

### **🛠 Desenvolvimento e Extensão**

#### **Adicionando Novas Funcionalidades**

**1. Novos Modelos**

```bash
# Criar novo modelo
php artisan make:model CustomFeature -m

# Criar controller
php artisan make:controller CustomFeatureController --resource

# Criar seeder
php artisan make:seeder CustomFeatureSeeder
```

**2. Novas Rotas**

```php
// routes/web.php
Route::middleware(['auth', 'tenant.database'])->group(function () {
    Route::resource('custom-features', CustomFeatureController::class);
});

// routes/api.php
Route::middleware(['auth', 'tenant.database'])->group(function () {
    Route::apiResource('custom-features', Api\CustomFeatureController::class);
});
```

**3. Novas Views**

```blade
{{-- resources/views/custom-features/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Sua funcionalidade personalizada -->
</div>
@endsection
```

### **🔄 Migração e Upgrade**

#### **Processo de Upgrade**

```bash
# Backup do banco de dados
php artisan db:backup

# Atualizar dependências
composer update

# Executar migrações
php artisan migrate

# Limpar caches
php artisan optimize:clear

# Recriar caches
php artisan optimize
```

#### **Versionamento**

- 📦 **Semantic Versioning**: Seguindo padrão SemVer
- 🔄 **Migration Scripts**: Scripts automáticos de migração
- 💾 **Backup Strategy**: Backups automáticos antes de upgrades
- 📝 **Changelog**: Documentação detalhada de mudanças

### **🐛 Debugging e Troubleshooting**

#### **Ferramentas de Debug**

```bash
# Habilitar debug mode (apenas desenvolvimento)
APP_DEBUG=true

# Logs detalhados
LOG_LEVEL=debug

# Laravel Telescope (desenvolvimento)
composer require laravel/telescope --dev
php artisan telescope:install

# Debug de queries
DB_LOG_QUERIES=true
```

#### **Problemas Comuns e Soluções**

**Problema: Página em branco**

```bash
# Solução: Verificar logs e permissões
tail -f storage/logs/laravel.log
chmod -R 755 storage bootstrap/cache
```

**Problema: Erro 500**

```bash
# Solução: Limpar caches e verificar configuração
php artisan config:clear
php artisan view:clear
php artisan optimize:clear
```

**Problema: Multi-tenancy não funciona**

```bash
# Solução: Verificar middleware e configuração de banco
php artisan config:cache
# Verificar arquivo .env e configurações de database
```

### **📞 Suporte e Comunidade**

#### **Recursos de Suporte**

- 📚 **Documentação**: Documentação completa e atualizada
- 🐛 **Issue Tracking**: Sistema de tickets para bugs
- 💬 **Fórum**: Comunidade ativa de desenvolvedores
- 📧 **Email Support**: Suporte direto para problemas críticos

#### **Links Úteis**

- 🔗 **Laravel Docs**: https://laravel.com/docs
- 🔗 **Bootstrap Docs**: https://getbootstrap.com/docs
- 🔗 **PHP Manual**: https://php.net/manual
- 🔗 **Composer Docs**: https://getcomposer.org/doc

### **🚀 Roadmap e Futuras Funcionalidades**

#### **Próximas Versões**

- 📱 **App Mobile**: Aplicativo móvel nativo
- 📊 **Analytics Avançado**: Dashboard com mais métricas
- 🔔 **Notificações**: Sistema de notificações em tempo real
- 💳 **Pagamentos**: Integração com gateways de pagamento
- 📤 **Exportação Avançada**: Relatórios em mais formatos
- 🌐 **Multi-idioma**: Suporte a múltiplos idiomas

---

## 📄 **Informações do Projeto**

### **📊 Status e Versioning**

**Versão Atual**: `3.0.0` 🚀  
**Última Atualização**: Junho 2025  
**Status**: ✅ Produção Ready  
**Licença**: MIT License

[![Version](https://img.shields.io/badge/version-3.0.0-blue.svg)](https://github.com/user/MercadoSytem)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20.svg)](https://laravel.com)

### **🎯 Funcionalidades Destacadas da Versão 3.0**

#### **🆕 Novidades Implementadas**

- ✅ **Sistema Multi-tenant Completo**: Isolamento total de dados por usuário
- ✅ **E-commerce Integrado**: Catálogo de produtos + sistema de pedidos
- ✅ **Autenticação Dupla**: Admin managers + usuários com permissões granulares
- ✅ **CNPJ Inteligente**: Sistema condicional com formatação automática
- ✅ **API RESTful Robusta**: Endpoints completos para todas as funcionalidades
- ✅ **Dashboard Analytics**: Métricas em tempo real com auto-refresh
- ✅ **Interface Moderna**: Design responsivo com Bootstrap 5.3
- ✅ **Timezone Brasil**: Correção completa para fuso horário brasileiro

#### **🔧 Melhorias Técnicas**

- ✅ **Performance Otimizada**: Consultas eficientes + caching strategy
- ✅ **Segurança Reforçada**: CSRF, XSS, SQL Injection protection
- ✅ **Validação Dupla**: Frontend + Backend para máxima confiabilidade
- ✅ **Mobile-First**: Design otimizado para dispositivos móveis
- ✅ **Escalabilidade**: Arquitetura preparada para crescimento

### **🏆 Casos de Uso Ideais**

#### **Feira Alimentar Tradicional**

- 👥 **50-200 Vendedores**: Gestão eficiente de vendedores
- 📦 **30-100 Boxes**: Controle de alocação e ocupação
- ⏰ **Horários Flexíveis**: Cronogramas personalizados
- 📊 **Relatórios Diários**: Controle de movimentação

#### **Food Court / Praça de Alimentação**

- 🏪 **Múltiplas Lojas**: Cada vendedor com catálogo próprio
- 🛒 **Sistema de Pedidos**: Clientes fazem pedidos online
- 💳 **Controle Financeiro**: Gestão de preços e vendas
- 📱 **Acesso Mobile**: Interface otimizada para tablets

#### **Mercado Municipal**

- 🏢 **Gestão Centralizada**: Administração única para múltiplos vendedores
- 📈 **Analytics Avançado**: Métricas de performance e ocupação
- 🔐 **Multi-usuário**: Diferentes níveis de acesso
- 📋 **Conformidade**: Registros detalhados para auditorias

### **💡 Filosofia de Desenvolvimento**

#### **Princípios Aplicados**

- 🎯 **User-Centric Design**: Interface focada na experiência do usuário
- 🔧 **Clean Code**: Código limpo, organizado e bem documentado
- 🛡 **Security First**: Segurança como prioridade desde o design
- 📱 **Mobile Ready**: Desenvolvido pensando em dispositivos móveis
- ⚡ **Performance Matters**: Otimização constante de performance
- 🔄 **Maintainable**: Código fácil de manter e estender

#### **Padrões Seguidos**

- 📐 **PSR Standards**: Seguindo padrões PSR-4, PSR-12
- 🏗 **SOLID Principles**: Aplicação dos princípios SOLID
- 🔄 **DRY (Don't Repeat Yourself)**: Evitando duplicação de código
- 🎯 **KISS (Keep It Simple, Stupid)**: Simplicidade na implementação

### **🤝 Contribuição e Desenvolvimento**

#### **Como Contribuir**

```bash
# 1. Fork do projeto
git clone https://github.com/seu-usuario/MercadoSytem.git

# 2. Criar branch para feature
git checkout -b feature/nova-funcionalidade

# 3. Fazer alterações e commit
git commit -m "feat: adiciona nova funcionalidade"

# 4. Push e Pull Request
git push origin feature/nova-funcionalidade
```

#### **Guidelines de Contribuição**

- 📝 **Code Standards**: Seguir PSR-12 e Laravel conventions
- 🧪 **Tests**: Incluir testes para novas funcionalidades
- 📚 **Documentation**: Atualizar documentação quando necessário
- 🐛 **Bug Reports**: Usar template de issue para reportar bugs

### **📜 Licença e Termos**

```
Copyright (c) 2025 MercadoSystem

#### **Tecnologias e Ferramentas**

-   🏗 **Laravel Framework**: Base sólida e elegante
-   🎨 **Bootstrap**: Framework CSS responsivo
-   🛡 **Laravel Sanctum**: Autenticação API segura
-   💾 **SQLite/MySQL**: Sistemas de banco robustos
-   🔧 **Composer**: Gerenciamento de dependências

#### **Comunidade**

-   👥 **Laravel Community**: Suporte e inspiração constante
-   🌟 **Open Source Contributors**: Pela inovação contínua
-   🧪 **Beta Testers**: Por ajudarem a refinar o sistema
-   💼 **Early Adopters**: Por confiarem no projeto

---

<div align="center">

### 🚀 **Pronto para revolucionar a gestão da sua feira?**

_MercadoSystem v3.0 - Gestão Inteligente para Feiras Modernas_

</div>
```
