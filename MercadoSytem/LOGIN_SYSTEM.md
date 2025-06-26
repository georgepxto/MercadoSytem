# Sistema de Login - Mercado Fátima

## Implementação Realizada

O sistema de login foi implementado com as seguintes funcionalidades:

### 1. **Estrutura de Usuários**

-   **Usuário Comum**: Acesso ao dashboard específico do mercado
-   **Administrador Único**: Entidade superior que controla todos os usuários e dashboards

### 2. **Funcionalidades Implementadas**

#### **Sistema de Autenticação Unificado**

-   **Tela única de login**: Uma só tela para todos os tipos de usuário
-   **Detecção automática**: O sistema detecta automaticamente se é admin ou usuário comum
-   Verificação de acesso ao dashboard
-   Logout seguro
-   Proteção de rotas com middleware

#### **Administrador Único**

-   **Acesso:** `http://127.0.0.1:8000/login` (mesma tela que usuários comuns)
-   **Credenciais:**
    -   Email: `admin@admin.com`
    -   Senha: `admin123`
-   **Funcionalidades:**
    -   Entidade superior única
    -   Criar novos usuários comuns
    -   Editar usuários existentes
    -   Controlar acesso ao dashboard (conceder/revogar)
    -   Personalizar nome da dashboard para cada usuário
    -   Excluir usuários
    -   Visualizar estatísticas completas

#### **Usuário Comum - MercadoFatima**

-   **Credenciais de Acesso:**
    -   Email: `contato@mercadofatima.com`
    -   Senha: `fatima123`
    -   Dashboard: `MercadoFatima`
-   **Funcionalidades:**
    -   Acesso ao dashboard principal
    -   Gestão de vendedores, boxes e histórico
    -   Check-in/Check-out de vendedores

### 3. **Estrutura do Sistema**

#### **Modelos**

-   `User`: Usuário comum com campos específicos para dashboard
-   `DashboardManager`: Administrador do sistema

#### **Controllers**

-   `LoginController`: Gerencia autenticação
-   `DashboardManagerController`: Funcionalidades administrativas
-   `WebController`: Dashboard do usuário (protegido por middleware)

#### **Rotas**

-   `/login`: Página de login única para todos os usuários
-   `/dashboard`: Dashboard do usuário (protegida)
-   `/admin/*`: Rotas administrativas (protegidas)

#### **Views**

-   `auth/login.blade.php`: Tela de login única para todos os tipos de usuário
-   `admin/dashboard.blade.php`: Dashboard administrativo
-   `admin/users.blade.php`: Gerenciamento de usuários
-   `layouts/admin.blade.php`: Layout para páginas administrativas

### 4. **Funcionalidades de Segurança**

-   Middleware de autenticação
-   Verificação de acesso ao dashboard
-   Proteção CSRF
-   Senhas criptografadas
-   Guards separados para usuários e administradores

### 5. **Como Usar**

#### **Login Unificado:**

1. Acesse `http://127.0.0.1:8000/login`
2. **Para usuário comum**: Use `contato@mercadofatima.com` / `fatima123` - será direcionado para `/dashboard`
3. **Para administrador**: Use `admin@admin.com` / `admin123` - será direcionado para `/admin/dashboard`

#### **Funcionalidades do Administrador:**

-   **Painel Principal**: Estatísticas e visão geral do sistema
-   **Gerenciar Usuários**: Criar, editar, ativar/desativar e excluir usuários
-   **Controle de Acesso**: Conceder ou revogar acesso ao dashboard para cada usuário
-   **Personalização**: Definir nomes personalizados para as dashboards dos usuários

### 6. **Recursos Visuais**

-   Interface moderna e responsiva
-   Design consistente com Bootstrap 5
-   Sidebar personalizada para cada usuário
-   Alertas e notificações
-   Cards informativos
-   Tabelas responsivas

### 7. **Configuração do Banco de Dados**

#### **MySQL Configuration:**

-   Database: `mercado_sistema`
-   Host: `127.0.0.1`
-   Port: `3306`
-   User: `root`
-   Password: (vazio)

#### **Tabela users (modificada):**

-   `dashboard_name`: Nome personalizado da dashboard
-   `user_type`: Tipo do usuário (common/admin)
-   `has_dashboard_access`: Controle de acesso

#### **Tabela dashboard_managers (nova):**

-   Dados dos administradores do sistema
-   Controle independente de autenticação

### 8. **Instalação e Configuração**

#### **Pré-requisitos:**

1. PHP 8.x
2. MySQL Server rodando
3. Composer instalado

#### **Passos para instalação:**

1. Clone o repositório
2. Execute `composer install`
3. Configure o arquivo `.env` com as credenciais do MySQL
4. Execute `php artisan key:generate`
5. Execute `php artisan migrate`
6. Execute `php artisan db:seed --class=DashboardManagerSeeder`
7. Execute `php artisan db:seed --class=UserSeeder`
8. Execute `php artisan serve`

O sistema está completamente funcional e permite o controle granular de acesso às dashboards, com a entidade superior (Dashboard Manager) tendo controle total sobre os usuários comuns e seus acessos.
