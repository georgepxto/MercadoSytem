# Feirante

Sistema web de controle de boxes e vendedores para mercados e feiras alimentares. Desenvolvido em Laravel 9.

[![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)

## O que é

Feirante é um sistema de gestão operacional para feiras e mercados municipais. Controla quem está em qual box, quando entrou, há quanto tempo está, e gera relatórios de movimentação.

## Funcionalidades

- **Dashboard** — visão geral em tempo real: boxes ocupados, entradas do dia, gráfico 7/30/90d, alertas de permanência longa (4h+)
- **Boxes** — cadastro de boxes com QR Code único para check-in público sem login
- **Vendedores** — cadastro completo com horários semanais por box
- **Check-in / Check-out** — via interface web ou QR Code no celular
- **Histórico** — filtros por data, vendedor e box; exportação CSV
- **Analytics** — top vendedores, distribuição por horário, dia da semana, permanência média
- **Multi-tenant** — cada conta tem banco de dados isolado
- **Admin** — painel separado para criar e gerenciar contas de usuário
- **Tema claro/escuro**

## Stack

- **Backend**: Laravel 9, PHP 8.x, MySQL
- **Frontend**: Bootstrap 5.3, Bootstrap Icons, Rubik (Google Fonts)
- **Gráficos**: Chart.js 4.4
- **HTTP**: Axios (CDN)
- **Auth**: dois guards — `web` (usuários) e `dashboard_manager` (admin)

## Instalação

```bash
git clone https://github.com/georgepxto/MercadoSytem.git
cd MercadoSytem

composer install
cp .env.example .env
php artisan key:generate
```

Configure o `.env` com suas credenciais MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mercado_sistema
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
php artisan serve
```

Acesse `http://127.0.0.1:8000`.

## Credenciais padrão

| Tipo | Email | Senha |
|------|-------|-------|
| Admin | `admin@admin.com` | `password` |
| Usuário | `user@user.com` | `password` |

## Estrutura de rotas principais

| Rota | Descrição |
|------|-----------|
| `GET /dashboard` | Dashboard principal |
| `GET /vendors` | Gestão de vendedores |
| `GET /boxes` | Gestão de boxes |
| `GET /entries` | Histórico de entradas |
| `GET /entries/export` | Exportar CSV (aceita filtros) |
| `GET /analytics` | Página de analytics |
| `GET /checkin/{token}` | Check-in público via QR Code |
| `GET /admin/dashboard` | Painel administrativo |

## API

Todas as rotas sob `/api/*` requerem autenticação de sessão + header `X-CSRF-TOKEN`.

```
GET  /api/entries/stats/week
GET  /api/entries/stats/period?days=7|30|90
GET  /api/boxes/{id}/history
GET  /api/entries?vendor_id=&box_id=&date_from=&date_to=
POST /api/entries
PUT  /api/entries/{id}/checkout
GET  /api/vendors
GET  /api/boxes
```

## Segurança

- Todas as queries usam bindings parametrizados (zero concatenação SQL)
- Credenciais exclusivamente em `.env` — nunca no código
- Validação e sanitização de inputs no servidor em todas as rotas
- QR Codes usam UUID v4 (`qr_token`) — URLs não sequenciais e não adivinháveis
- Sessão validada no servidor em cada requisição
- Respostas de erro não expõem detalhes internos
