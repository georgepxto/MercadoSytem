@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Controle')
@section('page-title', 'Dashboard')

@section('content')
<style>
.stat-card {
    border: 1px solid var(--border-color);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.stat-card:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
.stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem; flex-shrink: 0;
}
.stat-label {
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.09em;
    text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.2rem;
}
.stat-value {
    font-size: 1.9rem; font-weight: 700; line-height: 1; color: var(--text-primary);
}
.stat-delta { font-size: 0.7rem; font-weight: 600; margin-top: 0.3rem; }
.stat-delta.up { color: #10B981; }
.stat-delta.down { color: #F87171; }
.stat-delta.neutral { color: var(--text-muted); }
.box-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.55rem;
}
.box-chip {
    border-radius: 10px; padding: 0.55rem 0.4rem;
    text-align: center; border: 1px solid; cursor: default;
    transition: transform 0.12s;
}
.box-chip:hover { transform: scale(1.03); }
.box-chip.occupied { border-color: rgba(251,191,36,0.3); background: rgba(251,191,36,0.07); }
.box-chip.free { border-color: rgba(16,185,129,0.22); background: rgba(16,185,129,0.05); }
.box-chip.unavailable { border-color: var(--border-color); background: transparent; opacity: 0.4; }
.box-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; margin-bottom: 0.2rem; }
.box-chip.occupied .box-dot { background: #FCD34D; }
.box-chip.free .box-dot { background: #10B981; }
.box-chip.unavailable .box-dot { background: var(--text-muted); }
.box-num { font-size: 0.75rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.01em; }
.box-vendor-label {
    font-size: 0.62rem; color: var(--text-muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 88px; display: block; margin: 0 auto;
}
.box-chip.free .box-vendor-label { color: #10B981; }
.box-chip.long-stay { border-color: rgba(248,113,113,0.35) !important; background: rgba(248,113,113,0.07) !important; cursor: pointer; }
.box-chip.long-stay .box-dot { background: #F87171 !important; animation: pulse-red 1.4s ease-in-out infinite; }
.box-chip.occupied { cursor: pointer; }
@keyframes pulse-red {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(248,113,113,0.5); }
    50% { opacity: 0.6; box-shadow: 0 0 0 4px rgba(248,113,113,0); }
}
.period-btn { font-size: 0.72rem; font-weight: 600; padding: 0.25rem 0.7rem; border-radius: 6px; border: 1px solid var(--border-color); background: transparent; color: var(--text-muted); cursor: pointer; transition: all 0.15s; }
.period-btn:hover { border-color: var(--accent-color); color: var(--accent-color); }
.period-btn.active { background: var(--accent-color); border-color: var(--accent-color); color: #fff; }
.time-chip {
    display: inline-block; font-family: 'Rubik', monospace;
    font-size: 0.78rem; font-weight: 600; letter-spacing: 0.04em;
    padding: 0.15rem 0.55rem; border-radius: 6px;
    background: var(--bg-tertiary); color: var(--text-secondary);
}
</style>

@php
    $delta = $todayTotal - $lastWeekTotal;
    $deltaSign = $delta > 0 ? '+' : '';
    $deltaClass = $delta > 0 ? 'up' : ($delta < 0 ? 'down' : 'neutral');
    $occupied = $allBoxes->where('is_occupied', true)->count();
@endphp

{{-- Stat cards --}}
<div class="row mb-4 g-3">
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="stat-icon" style="background:rgba(16,185,129,0.12);color:#10B981;">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="stat-label">Vendedores</div>
                    <div class="stat-value">{{ $totalVendors }}</div>
                    <div class="stat-delta neutral">Ativos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#818CF8;">
                    <i class="bi bi-grid-3x3"></i>
                </div>
                <div>
                    <div class="stat-label">Total Boxes</div>
                    <div class="stat-value">{{ $totalBoxes }}</div>
                    <div class="stat-delta {{ $occupied > 0 ? 'up' : 'neutral' }}">
                        {{ $occupied > 0 ? $occupied . ' ocupado' . ($occupied > 1 ? 's' : '') : 'Todos livres' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="stat-icon" style="background:rgba(251,191,36,0.12);color:#FCD34D;">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <div class="stat-label">Ativos Agora</div>
                    <div class="stat-value">{{ $activeEntries }}</div>
                    <div class="stat-delta neutral">Em operação</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3 p-3">
                <div class="stat-icon" style="background:rgba(56,189,248,0.12);color:#38BDF8;">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div>
                    <div class="stat-label">Entradas Hoje</div>
                    <div class="stat-value">{{ $todayTotal }}</div>
                    <div class="stat-delta {{ $deltaClass }}">
                        {{ $deltaSign }}{{ $delta }} vs semana passada
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart + Box grid --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-graph-up" style="color:var(--accent-color);font-size:0.9rem;"></i>
                    <span class="fw-semibold" style="font-size:0.875rem;" id="chartTitle">Entradas — Últimos 7 dias</span>
                </div>
                <div class="d-flex gap-1">
                    <button class="period-btn active" data-days="7">7d</button>
                    <button class="period-btn" data-days="30">30d</button>
                    <button class="period-btn" data-days="90">90d</button>
                </div>
            </div>
            <div class="card-body" style="height:220px;position:relative;padding:1rem 1rem 0.5rem;">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-grid-3x3" style="color:var(--accent-color);font-size:0.9rem;"></i>
                <span class="fw-semibold" style="font-size:0.875rem;">Status dos Boxes</span>
            </div>
            <div class="card-body">
                @if($allBoxes->count() > 0)
                <div class="box-grid">
                    @foreach($allBoxes as $b)
                    @php
                        $chipClass = $b->is_occupied ? 'occupied' : (($b->available ?? true) ? 'free' : 'unavailable');
                        $isLongStay = false;
                        if ($b->is_occupied && $b->entry_time) {
                            $entryCarbon = \Carbon\Carbon::parse($b->entry_time);
                            $isLongStay = $entryCarbon->diffInHours(\Carbon\Carbon::now()) >= 4;
                            if ($isLongStay) $chipClass = 'long-stay';
                        }
                    @endphp
                    <div class="box-chip {{ $chipClass }}"
                         data-box-id="{{ $b->id }}"
                         title="{{ $b->is_occupied ? ($b->active_vendor ?? 'Ocupado') : 'Livre' }}"
                         @if($b->is_occupied) onclick="openBoxModal({{ $b->id }}, '{{ addslashes($b->name ?? 'Box '.$b->number) }}')" @endif>
                        <span class="box-dot"></span>
                        <div class="box-num">Box {{ $b->number }}</div>
                        <span class="box-vendor-label">
                            @if($b->is_occupied && $b->active_vendor)
                                {{ \Illuminate\Support\Str::limit($b->active_vendor, 10) }}
                                @if($isLongStay)<br><small style="color:#F87171;font-size:0.55rem;">longa perm.</small>@endif
                            @else
                                Livre
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex gap-3 mt-3" style="font-size:0.68rem;color:var(--text-muted);">
                    <span><span class="box-dot" style="background:#10B981;"></span> Livre</span>
                    <span><span class="box-dot" style="background:#FCD34D;"></span> Ocupado</span>
                </div>
                @else
                <div class="text-center py-3">
                    <i class="bi bi-grid-3x3 mb-2" style="font-size:2rem;color:var(--text-muted);opacity:0.25;display:block;"></i>
                    <p class="text-muted small mb-0">Nenhum box cadastrado</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Today's activity --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-activity" style="color:var(--accent-color);font-size:0.9rem;"></i>
            <span class="fw-semibold" style="font-size:0.875rem;">Atividade de Hoje</span>
        </div>
        <span style="font-size:0.75rem;color:var(--text-muted);">
            {{ \Carbon\Carbon::today()->locale('pt_BR')->isoFormat('ddd, D [de] MMM') }}
        </span>
    </div>
    <div class="card-body p-0">
        @if($todayEntries->count() > 0)
        <div class="table-responsive d-none d-lg-block">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="padding-left:1.25rem;">Vendedor</th>
                        <th>Box</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todayEntries as $entry)
                    @php
                        $isActive = !$entry->exit_time;
                        $isLongEntry = $isActive && $entry->entry_time->diffInHours(\Carbon\Carbon::now()) >= 4;
                        $rowBg = $isLongEntry ? 'background:rgba(248,113,113,0.05);' : ($isActive ? 'background:rgba(16,185,129,0.04);' : '');
                    @endphp
                    <tr style="{{ $rowBg }}">
                        <td style="padding-left:1.25rem;vertical-align:middle;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initials">{{ substr($entry->vendor->name, 0, 1) }}</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:0.875rem;">{{ $entry->vendor->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $entry->vendor->food_type }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="vertical-align:middle;"><span class="badge bg-secondary">{{ $entry->box->number }}</span></td>
                        <td style="vertical-align:middle;"><span class="time-chip">{{ $entry->entry_time->format('H:i') }}</span></td>
                        <td style="vertical-align:middle;">
                            @if($entry->exit_time)
                                <span class="time-chip">{{ $entry->exit_time->format('H:i') }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="vertical-align:middle;">
                            @if($entry->exit_time)
                                <span class="badge bg-secondary">Finalizado</span>
                            @elseif($isLongEntry)
                                <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i>Longa perm.</span>
                            @else
                                <span class="badge bg-success">Ativo</span>
                            @endif
                        </td>
                        <td style="vertical-align:middle;text-align:right;padding-right:1.25rem;">
                            @if(!$entry->exit_time)
                                <button class="btn btn-sm btn-warning" onclick="checkOut({{ $entry->id }})">
                                    <i class="bi bi-box-arrow-right me-1"></i>Check-out
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-lg-none p-3">
            @foreach($todayEntries as $entry)
            <div class="card mb-2" style="border-left:2px solid {{ $entry->exit_time ? 'var(--border-color)' : '#10B981' }} !important;{{ !$entry->exit_time ? 'background:rgba(16,185,129,0.04)' : '' }}">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-initials">{{ substr($entry->vendor->name, 0, 1) }}</div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.875rem;">{{ $entry->vendor->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $entry->vendor->food_type }}</div>
                            </div>
                        </div>
                        @if($entry->exit_time)
                            <span class="badge bg-secondary">Finalizado</span>
                        @else
                            <span class="badge bg-success">Ativo</span>
                        @endif
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        <span class="badge bg-secondary">Box {{ $entry->box->number }}</span>
                        <span class="time-chip">{{ $entry->entry_time->format('H:i') }}</span>
                        @if($entry->exit_time)<span class="time-chip">{{ $entry->exit_time->format('H:i') }}</span>@endif
                    </div>
                    @if(!$entry->exit_time)
                    <div class="mt-2">
                        <button class="btn btn-sm btn-warning w-100" onclick="checkOut({{ $entry->id }})">
                            <i class="bi bi-box-arrow-right me-1"></i>Fazer Check-out
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-calendar-x mb-3" style="font-size:2.5rem;color:var(--text-muted);opacity:0.25;display:block;"></i>
            <h6 style="color:var(--text-secondary);">Nenhuma atividade hoje</h6>
            <p class="text-muted small mb-3">Não há registros de entrada para hoje.</p>
            <a href="{{ route('checkin') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Fazer Check-in
            </a>
        </div>
        @endif
    </div>
</div>
{{-- Box detail modal --}}
<div class="modal fade" id="boxModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="boxModalTitle">Detalhes do Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="boxModalBody" style="min-height:160px;">
                <div class="text-center py-4"><div class="spinner-border spinner-border-sm" style="color:var(--accent-color);"></div></div>
            </div>
            <div class="modal-footer" id="boxModalFooter" style="display:none;">
                <button class="btn btn-warning btn-sm" id="boxCheckoutBtn">
                    <i class="bi bi-box-arrow-right me-1"></i>Fazer Check-out
                </button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function checkOut(entryId) {
        modernToast.confirm('Confirma o check-out deste vendedor?', 'Confirmar Check-out', () => {
            axios.post(`/api/entries/${entryId}/checkout`)
                .then(() => { modernToast.success('Check-out realizado!'); location.reload(); })
                .catch(e => { modernToast.error('Erro: ' + (e.response?.data?.message || e.message)); });
        });
    }

    let activeEntryForCheckout = null;

    function openBoxModal(boxId, boxName) {
        document.getElementById('boxModalTitle').textContent = boxName;
        document.getElementById('boxModalBody').innerHTML = '<div class="text-center py-4"><div class="spinner-border spinner-border-sm" style="color:var(--accent-color);"></div></div>';
        document.getElementById('boxModalFooter').style.display = 'none';
        activeEntryForCheckout = null;
        new bootstrap.Modal(document.getElementById('boxModal')).show();

        axios.get(`/api/boxes/${boxId}/history`)
            .then(r => {
                const d = r.data;
                const cur = d.current_entry;
                let html = '';
                if (cur) {
                    activeEntryForCheckout = cur.id;
                    document.getElementById('boxModalFooter').style.display = '';
                    const entryDt = (cur.entry_date && cur.entry_time)
                        ? new Date(cur.entry_date + 'T' + cur.entry_time)
                        : null;
                    const mins = entryDt && !isNaN(entryDt) ? Math.floor((Date.now() - entryDt.getTime()) / 60000) : null;
                    const dur = mins !== null && mins >= 0 ? `${Math.floor(mins/60)}h ${mins%60}min` : '';
                    html += `<div class="d-flex align-items-center gap-3 mb-3 p-3 rounded" style="background:rgba(16,185,129,0.07);border:1px solid rgba(16,185,129,0.15);">
                        <div class="avatar-initials" style="width:42px;height:42px;font-size:1rem;">${cur.vendor_name.charAt(0)}</div>
                        <div>
                            <div class="fw-semibold">${cur.vendor_name}</div>
                            <div class="text-muted" style="font-size:0.8rem;">${cur.food_type ?? ''}</div>
                            <div style="font-size:0.78rem;margin-top:0.2rem;">
                                <span class="time-chip">${cur.entry_time?.substring(0,5) ?? ''}</span>
                                ${dur ? `<span class="text-muted ms-2">${dur}</span>` : ''}
                            </div>
                        </div>
                        <span class="badge bg-success ms-auto">Ativo</span>
                    </div>`;
                }
                if (d.recent_entries && d.recent_entries.length > 0) {
                    html += `<p class="text-muted mb-2" style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Histórico recente</p>
                    <div class="table-responsive"><table class="table table-hover mb-0" style="font-size:0.82rem;">
                    <thead><tr><th>Vendedor</th><th>Data</th><th>Entrada</th><th>Saída</th></tr></thead><tbody>`;
                    d.recent_entries.forEach(e => {
                        const date = new Date(e.entry_date).toLocaleDateString('pt-BR',{day:'2-digit',month:'2-digit'});
                        html += `<tr>
                            <td>${e.vendor_name}</td>
                            <td>${date}</td>
                            <td>${e.entry_time?.substring(0,5) ?? '—'}</td>
                            <td>${e.exit_time?.substring(0,5) ?? '<span class="badge bg-success" style="font-size:0.65rem;">Ativo</span>'}</td>
                        </tr>`;
                    });
                    html += '</tbody></table></div>';
                }
                if (!cur && (!d.recent_entries || d.recent_entries.length === 0)) {
                    html = '<div class="text-center py-3 text-muted">Sem histórico para este box.</div>';
                }
                document.getElementById('boxModalBody').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('boxModalBody').innerHTML = '<div class="text-center py-3 text-muted">Erro ao carregar dados.</div>';
            });
    }

    document.getElementById('boxCheckoutBtn').addEventListener('click', () => {
        if (!activeEntryForCheckout) return;
        checkOut(activeEntryForCheckout);
        bootstrap.Modal.getInstance(document.getElementById('boxModal'))?.hide();
    });

    (function buildChart() {
        let currentStats = @json($weeklyStats);
        let currentDays = 7;

        function makeChart(stats) {
            const dark = document.body.getAttribute('data-theme') !== 'light';
            const grid = dark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
            const tick = dark ? '#6B6254' : '#7A7366';
            const fill = dark ? 'rgba(16,185,129,0.09)' : 'rgba(16,185,129,0.07)';
            const tip  = dark ? { bg: '#201C12', border: 'rgba(255,255,255,0.09)', title: '#E8E4D9' }
                              : { bg: '#fff',    border: 'rgba(0,0,0,0.09)',       title: '#1A1710' };

            const canvas = document.getElementById('weeklyChart');
            const existing = Chart.getChart(canvas);
            if (existing) existing.destroy();

            const ctx = canvas.getContext('2d');
            const grad = ctx.createLinearGradient(0, 0, 0, 180);
            grad.addColorStop(0, fill);
            grad.addColorStop(1, 'transparent');

            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: stats.map(d => d.label),
                    datasets: [{
                        data: stats.map(d => d.count),
                        borderColor: '#10B981',
                        backgroundColor: grad,
                        borderWidth: 2,
                        pointRadius: stats.length <= 7 ? 4 : 2,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: dark ? '#171510' : '#fff',
                        pointBorderWidth: 2,
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: tip.bg,
                            borderColor: tip.border,
                            borderWidth: 1,
                            titleColor: tip.title,
                            bodyColor: '#10B981',
                            callbacks: {
                                title: items => stats[items[0].dataIndex].date,
                                label: i => ` ${i.raw} entrada${i.raw !== 1 ? 's' : ''}`,
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: grid }, ticks: { color: tick, font: { size: 11, family: 'Rubik' }, maxTicksLimit: 12 } },
                        y: {
                            beginAtZero: true, grid: { color: grid },
                            ticks: { color: tick, font: { size: 11, family: 'Rubik' }, stepSize: 1, precision: 0 }
                        }
                    }
                }
            });
        }

        makeChart(currentStats);
        document.getElementById('themeToggle').addEventListener('click', () => setTimeout(() => makeChart(currentStats), 320));

        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const days = parseInt(this.dataset.days);
                if (days === currentDays) return;
                currentDays = days;
                document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const titles = {7:'Entradas — Últimos 7 dias', 30:'Entradas — Últimos 30 dias', 90:'Entradas — Últimos 90 dias'};
                document.getElementById('chartTitle').textContent = titles[days];
                axios.get(`/api/entries/stats/period?days=${days}`)
                    .then(r => { currentStats = r.data; makeChart(currentStats); })
                    .catch(() => modernToast.error('Erro ao carregar dados do gráfico.'));
            });
        });
    })();

    setInterval(() => location.reload(), 60000);
</script>
@endsection
