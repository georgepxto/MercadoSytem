# Feirante — instruções para Claude

## O projeto

Sistema Laravel 9 de controle de boxes e vendedores para mercados/feiras. Nome do produto: **Feirante**.

Repositório: `MercadoSytem/` (pasta dentro do monorepo `final/`).
Servidor local: `php artisan serve` → `http://127.0.0.1:8000`

## Arquitetura

### Multi-tenant
- Banco principal: `mercado_sistema` — guarda users, vendors, boxes, entries, schedules
- Cada usuário pode ter um banco isolado `mercado_user_N` (tenant), acessado via middleware `tenant.database`
- Middleware `TenantDatabaseMiddleware` troca a conexão `DB::connection('main')` por request
- Sempre usar `DB::connection('main')` explicitamente nas queries do banco principal

### Auth — dois guards
- `web` → usuários normais (model `User`), acessam `/dashboard` e rotas protegidas
- `dashboard_manager` → admins (model `DashboardManager`), acessam `/admin/*`

### Rotas
- `routes/web.php` — páginas, protegidas por `['auth', 'tenant.database']`
- `routes/api.php` — API JSON, protegidas por `['auth']`
- Checkin público: `GET /checkin/{token}` — sem autenticação, token = `qr_token` UUID do box

### Controllers principais
- `WebController` — páginas (dashboard, vendors, boxes, entries, analytics, export)
- `Api/EntryController` — CRUD de entradas + `statsWeek`, `statsPeriod`
- `Api/BoxController` — CRUD de boxes + `history($id)`
- `CheckinController` — check-in público via QR Code

## Stack frontend
- Bootstrap 5.3 + Bootstrap Icons via CDN
- Rubik (Google Fonts) — fonte principal
- Chart.js 4.4.0 via CDN
- Axios via CDN (autenticação por sessão + header `X-CSRF-TOKEN`)
- Tema claro/escuro via `data-theme="dark|light"` no `<body>`, persistido em `localStorage`

## CSS — variáveis de tema
```css
/* Dark (padrão) */
--bg-primary: #0F0E0A
--accent-color: #10B981   /* emerald */
--btn-primary: #10B981

/* Light */
--accent-color: #059669
--btn-primary: #059669
```

O `btn-primary` no dark mode usa `#059669` (não `#10B981`) para garantir contraste com texto branco.

## Banco de dados — tabelas relevantes

```
vendors      — id, name, email, phone, food_type, active, has_cnpj, cnpj
boxes        — id, name, number, location, available, monthly_price, qr_token (UUID)
entries      — id, vendor_id, box_id, entry_time (DATETIME), exit_time (DATETIME), entry_date (DATE)
schedules    — id, vendor_id, box_id, day_of_week, start_time, end_time
users        — id, name, email, password, has_dashboard_access, dashboard_name
```

`entry_time` e `exit_time` são DATETIME completo (`2026-06-11 08:30:00`), não só TIME.
No JS, sempre combinar com `entry_date` para montar datetime ou extrair a parte de tempo com split.

## Regras de segurança obrigatórias

- Zero concatenação de strings em SQL — sempre bindings parametrizados
- Credenciais e chaves apenas em `.env`, nunca hardcoded
- Validar e sanitizar todos os inputs no servidor antes de processar
- Nunca retornar mais dados do que o necessário ao cliente
- Sessão e permissões validadas no servidor, nunca só no cliente
- QR Codes usam UUID (`qr_token`) — não expor IDs sequenciais nas URLs públicas

## Convenções do projeto

- Sem comentários desnecessários no código
- Sem emojis na interface — usar sempre Bootstrap Icons (`bi bi-*`)
- Sem FontAwesome — foi migrado para Bootstrap Icons
- Sem classes Bootstrap 4 deprecadas (`font-weight-bold`, `no-gutters`, etc.)
- Sem autenticação manual — usar os guards Laravel existentes

## Alertas implementados

- **Permanência longa**: box ocupado há 4+ horas → chip vermelho pulsante no dashboard
- A lógica é client-side no dashboard e server-side no blade (PHP Carbon diff)

## Como testar mudanças

```bash
php artisan view:clear   # sempre após editar views
php artisan route:list   # verificar rotas novas
php -l app/Http/Controllers/NomeController.php  # syntax check
```
