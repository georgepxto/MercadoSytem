@extends('layouts.app')

@section('title', 'Analytics — Feirante')
@section('page-title', 'Analytics')

@section('content')
<style>
.analytics-card { border: 1px solid var(--border-color); }
.chart-title {
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.25rem;
}
.chart-subtitle { font-size: 0.8rem; color: var(--text-muted); }
.period-badge {
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
    padding: 0.2rem 0.6rem; border-radius: 20px;
    background: rgba(16,185,129,0.12); color: #10B981;
}
.kpi-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.kpi-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.875rem;
    padding: 1rem 1.25rem;
}
.kpi-label { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.09em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.2rem; }
.kpi-value { font-size: 1.75rem; font-weight: 700; line-height: 1; color: var(--text-primary); }
.kpi-delta { font-size: 0.72rem; margin-top: 0.3rem; }
.kpi-delta.up { color: #10B981; }
.kpi-delta.down { color: #F87171; }
.kpi-delta.neutral { color: var(--text-muted); }
</style>

@php
    $delta = $prevPeriod > 0 ? round((($totalPeriod - $prevPeriod) / $prevPeriod) * 100, 1) : null;
    $deltaClass = $delta === null ? 'neutral' : ($delta > 0 ? 'up' : ($delta < 0 ? 'down' : 'neutral'));
    $deltaText  = $delta === null ? 'Sem dados anteriores' : ($delta >= 0 ? "+{$delta}% vs período anterior" : "{$delta}% vs período anterior");
@endphp

{{-- KPI strip --}}
<div class="kpi-row">
    <div class="kpi-card">
        <div class="kpi-label">Entradas ({{ $days }}d)</div>
        <div class="kpi-value">{{ number_format($totalPeriod) }}</div>
        <div class="kpi-delta {{ $deltaClass }}">{{ $deltaText }}</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Vendedores analisados</div>
        <div class="kpi-value">{{ $topVendors->count() }}</div>
        <div class="kpi-delta neutral">Top por entradas</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Boxes analisados</div>
        <div class="kpi-value">{{ $boxStats->count() }}</div>
        <div class="kpi-delta neutral">Com uso no período</div>
    </div>
    @if($avgStay->isNotEmpty())
    <div class="kpi-card">
        <div class="kpi-label">Perm. média (top)</div>
        <div class="kpi-value">{{ floor($avgStay->first()->avg_min / 60) }}h{{ $avgStay->first()->avg_min % 60 }}min</div>
        <div class="kpi-delta neutral">{{ $avgStay->first()->name }}</div>
    </div>
    @endif
</div>

<div class="row g-3 mb-3">
    {{-- Top vendors --}}
    <div class="col-lg-6">
        <div class="card analytics-card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <div class="chart-title">Top Vendedores</div>
                    <div class="chart-subtitle">Entradas nos últimos {{ $days }} dias</div>
                </div>
                <span class="period-badge">{{ $days }}d</span>
            </div>
            <div class="card-body" style="position:relative;height:240px;">
                <canvas id="topVendorsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Box occupancy --}}
    <div class="col-lg-6">
        <div class="card analytics-card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <div class="chart-title">Ocupação por Box</div>
                    <div class="chart-subtitle">Total de entradas por box</div>
                </div>
                <span class="period-badge">{{ $days }}d</span>
            </div>
            <div class="card-body" style="position:relative;height:240px;">
                <canvas id="boxOccupancyChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    {{-- Hour heatmap --}}
    <div class="col-lg-8">
        <div class="card analytics-card h-100">
            <div class="card-header">
                <div class="chart-title">Distribuição por Horário</div>
                <div class="chart-subtitle">Volume de entradas por hora do dia</div>
            </div>
            <div class="card-body" style="position:relative;height:220px;">
                <canvas id="hourChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Day of week --}}
    <div class="col-lg-4">
        <div class="card analytics-card h-100">
            <div class="card-header">
                <div class="chart-title">Dia da Semana</div>
                <div class="chart-subtitle">Entradas por dia</div>
            </div>
            <div class="card-body" style="position:relative;height:220px;">
                <canvas id="dowChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Avg stay --}}
@if($avgStay->isNotEmpty())
<div class="row g-3 mb-3">
    <div class="col-lg-8">
        <div class="card analytics-card">
            <div class="card-header">
                <div class="chart-title">Permanência Média por Vendedor</div>
                <div class="chart-subtitle">Minutos médios por visita (com saída registrada)</div>
            </div>
            <div class="card-body" style="position:relative;height:200px;">
                <canvas id="avgStayChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card analytics-card h-100">
            <div class="card-header">
                <div class="chart-title">Ranking de Permanência</div>
            </div>
            <div class="card-body p-0">
                @foreach($avgStay as $i => $v)
                <div class="d-flex align-items-center gap-3 px-3 py-2" style="{{ !$loop->last ? 'border-bottom:1px solid var(--border-color);' : '' }}">
                    <span style="font-size:0.68rem;font-weight:700;color:var(--text-muted);width:14px;">{{ $i+1 }}</span>
                    <div class="flex-grow-1">
                        <div style="font-size:0.82rem;font-weight:600;">{{ $v->name }}</div>
                    </div>
                    <span style="font-size:0.8rem;font-weight:700;color:var(--accent-color);">
                        {{ floor($v->avg_min/60) }}h{{ $v->avg_min % 60 }}min
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const dark = document.body.getAttribute('data-theme') !== 'light';
    const grid   = dark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const tick   = dark ? '#6B6254' : '#7A7366';
    const tip    = dark ? { bg:'#201C12', border:'rgba(255,255,255,0.09)', title:'#E8E4D9' }
                        : { bg:'#fff',    border:'rgba(0,0,0,0.09)',       title:'#1A1710' };
    const accent = ['#10B981','#34D399','#6EE7B7','#059669','#047857','#065F46'];
    const barOpts = (labels, data, colors) => ({
        type: 'bar',
        data: { labels, datasets:[{ data, backgroundColor: colors ?? accent[0], borderRadius: 5, borderSkipped: false }] },
        options: {
            responsive: true, maintainAspectRatio: false, indexAxis: 'y',
            plugins: { legend:{display:false}, tooltip:{ backgroundColor:tip.bg, borderColor:tip.border, borderWidth:1, titleColor:tip.title, bodyColor:accent[0] } },
            scales: {
                x: { grid:{color:grid}, ticks:{color:tick,font:{size:11,family:'Rubik'}} },
                y: { grid:{display:false}, ticks:{color:tick,font:{size:11,family:'Rubik'}} }
            }
        }
    });

    const vendorData = @json($topVendors);
    new Chart(document.getElementById('topVendorsChart'), barOpts(
        vendorData.map(v=>v.name),
        vendorData.map(v=>v.count),
        vendorData.map((_,i)=>accent[i%accent.length])
    ));

    const boxData = @json($boxStats);
    new Chart(document.getElementById('boxOccupancyChart'), barOpts(
        boxData.map(b=>`Box ${b.number}`),
        boxData.map(b=>b.count),
        accent[1]
    ));

    const hourData = @json($hourData);
    new Chart(document.getElementById('hourChart'), {
        type: 'bar',
        data: { labels: hourData.map(h=>h.label), datasets:[{
            data: hourData.map(h=>h.count),
            backgroundColor: hourData.map(h => {
                const max = Math.max(...hourData.map(x=>x.count));
                const ratio = max > 0 ? h.count/max : 0;
                return `rgba(16,185,129,${0.2 + ratio*0.65})`;
            }),
            borderRadius: 4, borderSkipped: false
        }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend:{display:false}, tooltip:{ backgroundColor:tip.bg, borderColor:tip.border, borderWidth:1, titleColor:tip.title, bodyColor:accent[0] } },
            scales: {
                x: { grid:{color:grid}, ticks:{color:tick,font:{size:10,family:'Rubik'}} },
                y: { beginAtZero:true, grid:{color:grid}, ticks:{color:tick,font:{size:11,family:'Rubik'},stepSize:1,precision:0} }
            }
        }
    });

    const dowData = @json($dayData);
    new Chart(document.getElementById('dowChart'), {
        type: 'bar',
        data: { labels: dowData.map(d=>d.label), datasets:[{
            data: dowData.map(d=>d.count),
            backgroundColor: accent[2], borderRadius: 5, borderSkipped: false
        }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend:{display:false}, tooltip:{ backgroundColor:tip.bg, borderColor:tip.border, borderWidth:1, titleColor:tip.title, bodyColor:accent[0] } },
            scales: {
                x: { grid:{display:false}, ticks:{color:tick,font:{size:11,family:'Rubik'}} },
                y: { beginAtZero:true, grid:{color:grid}, ticks:{color:tick,font:{size:11,family:'Rubik'},stepSize:1,precision:0} }
            }
        }
    });

    const stayData = @json($avgStay);
    if (stayData.length > 0) {
        new Chart(document.getElementById('avgStayChart'), barOpts(
            stayData.map(v=>v.name),
            stayData.map(v=>v.avg_min),
            stayData.map((_,i)=>accent[i%accent.length])
        ));
    }
})();
</script>
@endsection
