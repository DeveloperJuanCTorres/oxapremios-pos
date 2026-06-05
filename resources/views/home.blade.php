@extends('layouts.app')
<link href="{{ asset('css/vistas.css')}}?v=1993.0.1" rel="stylesheet" />
<style>
    .ticket-badge{
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
        color:#fff;
        padding:8px 14px;
        border-radius:12px;
        font-weight:700;
        font-size:14px;
        letter-spacing:.5px;
        box-shadow:0 4px 10px rgba(37,99,235,.25);
        display:inline-flex;
        align-items:center;
        gap:6px;
    }

    .ticket-badge i{
        font-size:12px;
        opacity:.8;
    }
</style>
@section('content')

@include('partials.menu')
<!-- Main Content -->
<div class="main-content">
    
    @include('partials.header')
    <!-- Dashboard Body -->
    <div class="container-fluid p-4 flex-grow-1">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Dashboard</h2>
                <p class="text-muted small mb-0">Seguimiento del rendimiento empresarial en tiempo real.</p>
            </div>
            <!-- <div class="btn-group border rounded-3 p-1 bg-white">
                <button class="btn btn-primary btn-sm px-3 rounded-2">Today</button>
                <button class="btn btn-light btn-sm px-3 rounded-2 text-muted">Week</button>
                <button class="btn btn-light btn-sm px-3 rounded-2 text-muted">Month</button>
            </div> -->
        </div>
        <!-- KPI Row -->
        <div class="row g-4 mb-4">
            <!-- Daily Sales -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="kpi-icon-wrapper" style="background: rgba(0, 74, 198, 0.1); color: var(--primary-brand);">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                        </div>
                        <span class="trend-badge text-success">
                            <i class="fa-solid fa-arrow-trend-up"></i> +12.5%
                        </span>
                    </div>
                    <small class="text-uppercase text-muted fw-bold ls-1" style="font-size: 10px;">Ventas Diarias</small>
                    <h3 class="fw-bold mt-1">S/ {{ number_format($ventasHoy,2) }}</h3>
                </div>
            </div>
            <!-- Transactions -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="kpi-icon-wrapper" style="background: rgba(80, 95, 118, 0.1); color: var(--secondary-text);">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <span class="trend-badge text-success">
                            <i class="fa-solid fa-arrow-trend-up"></i> +4.2%
                        </span>
                    </div>
                    <small class="text-uppercase text-muted fw-bold ls-1" style="font-size: 10px;">Transacciones Totales</small>
                    <h3 class="fw-bold mt-1">{{ $ticketsHoy }}{{ $ticketsHoy }}</h3>
                </div>
            </div>
            <!-- Average Ticket -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="kpi-icon-wrapper" style="background: rgba(0, 125, 85, 0.1); color: #007d55;">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>
                        <span class="trend-badge text-danger">
                            <i class="fa-solid fa-arrow-trend-down"></i> -2.1%
                        </span>
                    </div>
                    <small class="text-uppercase text-muted fw-bold ls-1" style="font-size: 10px;">Ticket Promedio</small>
                    <h3 class="fw-bold mt-1">S/ {{ number_format($ticketPromedio,2) }}</h3>
                </div>
            </div>
        </div>
        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <!-- Sales Trend -->
            <div class="col-lg-8">
                <div class="card h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Tendencia de ventas</h5>
                        <div class="d-flex gap-3">
                            <small class="text-muted d-flex align-items-center gap-1"><span class="rounded-circle" style="width:8px; height:8px; background:var(--primary-brand);"></span> Actual</small>
                            <small class="text-muted d-flex align-items-center gap-1"><span class="rounded-circle" style="width:8px; height:8px; background:var(--outline-color);"></span> Target</small>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                    </div>
                    <div class="d-flex justify-content-between mt-2 px-3 small text-muted">
                        <span>08:00</span><span>12:00</span><span>16:00</span><span>20:00</span>
                    </div>
                </div>
            </div>
            <!-- Categories -->
            <div class="col-lg-4">
                <div class="card h-100 p-4">
                    <h5 class="fw-bold mb-4">
                        Sorteos Más Vendidos
                    </h5>

                    <div class="d-flex flex-column gap-4">

                    @foreach($topSorteos as $item)

                    <div>

                        <div class="d-flex justify-content-between mb-1 small">

                            <span class="fw-medium">
                                {{ $item->sorteo->name ?? 'Sorteo' }}
                            </span>

                            <span class="text-muted">
                                {{ $item->total }} tickets
                            </span>

                        </div>

                        <div class="progress" style="height: 8px;">

                            <div
                                class="progress-bar"
                                style="width: {{ min($item->total * 10,100) }}%; background-color: var(--primary-brand);">

                            </div>

                        </div>

                    </div>

                    @endforeach

                    </div>
                </div>
            </div>
        </div>
        <!-- Transactions Table -->
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Transacciones Recientes</h5>
                <a class="text-primary text-decoration-none small fw-bold" href="#">View History <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="px-4 py-3">Hora</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">M. Pago</th>
                            <th class="px-4 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($ultimasVentas as $venta)

                        <tr>

                            <td class="px-4 py-3 font-monospace small">
                                #{{ $venta->id }}
                            </td>

                            <td class="px-4 py-3 font-monospace small">
                                {{ $venta->nombres }} {{ $venta->apellidos }}
                            </td> 

                            <td class="px-4 py-3 text-muted small">
                                {{ $venta->created_at->format('H:i A') }}
                            </td>

                            <td class="px-4 py-3 fw-bold">
                                S/ {{ number_format($venta->total_pagado,2) }}
                            </td>

                            <td class="px-4 py-3">

                                <span
                                    class="status-pill"
                                    style="background: rgba(78, 222, 163, 0.1); color: #006242;">

                                    <span
                                        class="status-dot"
                                        style="background: #006242;"></span>

                                    {{ strtoupper($venta->metodo_pago) }}

                                </span>

                            </td>

                            <td class="px-4 py-3 text-end">

                                <button
                                    class="btn btn-link text-muted p-1"
                                    onclick='verTicket(@json($venta))'>

                                    <i class="fa-solid fa-eye"></i>

                                </button>

                                <button
                                    class="btn btn-link text-success p-1"
                                    onclick="reimprimirTicket({{ $venta->id }})"
                                    title="Reimprimir ticket">

                                    <i class="fa-solid fa-print"></i>

                                </button>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5 text-muted">
                                No hay ventas registradas
                            </td>

                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer>
        <div>v2.4.1 Build 882 | © 2024 RetailPro Systems</div>
        <div class="d-flex gap-4">
            <a class="text-decoration-none text-muted" href="#">Support</a>
            <a class="text-decoration-none text-muted" href="#">Status</a>
        </div>
    </footer>
</div>
<!-- FAB -->
<button 
    class="fab"
    onclick="window.location.href='{{ route('pos') }}'">

    <i class="fa-solid fa-plus fa-lg"></i>

</button>


<!-- =========================================
MODAL DETALLE TICKET
========================================= -->

<div class="modal fade" id="ticketModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">

                <div>

                    <h4 class="fw-bold mb-1">
                        Detalle del Ticket
                    </h4>

                    <small class="text-muted">
                        Información completa de la venta
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>

            </div>

            <!-- BODY -->
            <div class="modal-body p-4">

                <div class="row g-4">

                    <!-- LEFT -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Ticket
                            </small>

                            <div id="modal_ticket" class="d-flex flex-wrap gap-2">
                            </div>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Fecha
                            </small>

                            <div class="detail-value" id="modal_fecha">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- CLIENTE -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Cliente
                            </small>

                            <div class="detail-value" id="modal_cliente">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- DNI -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Documento
                            </small>

                            <div class="detail-value" id="modal_dni">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- TELEFONO -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Teléfono
                            </small>

                            <div class="detail-value" id="modal_telefono">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- DEPARTAMENTO -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Departamento
                            </small>

                            <div class="detail-value" id="modal_departamento">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- SORTEO -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Sorteo
                            </small>

                            <div class="detail-value" id="modal_sorteo">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- CANTIDAD -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Cantidad
                            </small>

                            <div class="detail-value" id="modal_cantidad">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- METODO -->
                    <div class="col-md-6">

                        <div class="detail-card">

                            <small class="detail-label">
                                Método Pago
                            </small>

                            <div class="detail-value" id="modal_pago">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- TOTAL -->
                    <div class="col-md-6">

                        <div class="detail-card bg-primary text-white">

                            <small class="opacity-75">
                                Total Pagado
                            </small>

                            <div class="fs-3 fw-bold" id="modal_total">
                                -
                            </div>

                        </div>

                    </div>

                    <!-- OBSERVACION -->
                    <div class="col-12">

                        <div class="detail-card">

                            <small class="detail-label">
                                Observación
                            </small>

                            <div class="detail-value" id="modal_observacion">
                                Sin observaciones
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const ventasSemana = @json($ventasSemana);

    const labels = ventasSemana.map(item => item.fecha);

    const data = ventasSemana.map(item => item.total);

    /*
    |--------------------------------------------------------------------------
    | CONTENEDOR CHART
    |--------------------------------------------------------------------------
    */

    const chartContainer = document.querySelector('.chart-placeholder');

    chartContainer.innerHTML = `
        <div style="position:relative;height:320px;width:100%;">
            <canvas id="ventasChart"></canvas>
        </div>
    `;

    const ctx = document.getElementById('ventasChart');

    /*
    |--------------------------------------------------------------------------
    | CHART
    |--------------------------------------------------------------------------
    */

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [{

                label: 'Ventas',

                data: data,

                borderWidth: 3,

                tension: 0.4,

                fill: true,

                pointRadius: 4,

                pointHoverRadius: 6,

                backgroundColor: 'rgba(37,99,235,0.12)',

                borderColor: '#2563eb',

                pointBackgroundColor: '#2563eb',

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },

                    ticks: {

                        callback: function(value) {
                            return 'S/ ' + value;
                        }
                    }
                },

                x: {

                    grid: {
                        display: false
                    }
                }
            }
        }
    });

</script>

<script>

    function verTicket(venta){

        let ticketsHtml = '';

        for(let i = 1; i <= venta.cantidad; i++){

            const ticket = String(venta.id)
                .padStart(6, '0') + i;

            ticketsHtml += `
                <span class="ticket-badge">
                    <i class="fa-solid fa-ticket"></i>
                    #${ticket}
                </span>
            `;
        }

        document.getElementById('modal_ticket').innerHTML =
            ticketsHtml;

        document.getElementById('modal_fecha').innerText =
            new Date(venta.created_at).toLocaleString();

        document.getElementById('modal_cliente').innerText =
            venta.nombres + ' ' + venta.apellidos;

        document.getElementById('modal_dni').innerText =
            venta.dni;

        document.getElementById('modal_telefono').innerText =
            venta.telefono;

        document.getElementById('modal_departamento').innerText =
            venta.departamento;

        document.getElementById('modal_sorteo').innerText =
            venta.sorteo?.name ?? '-';

        document.getElementById('modal_cantidad').innerText =
            venta.cantidad;

        document.getElementById('modal_pago').innerText =
            venta.metodo_pago.toUpperCase();

        document.getElementById('modal_total').innerText =
            'S/ ' + parseFloat(venta.total_pagado).toFixed(2);

        document.getElementById('modal_observacion').innerText =
            venta.observacion ?? 'Sin observaciones';

        new bootstrap.Modal(document.getElementById('ticketModal')).show();
    }

    function reimprimirTicket(id)
    {
        window.open(
            `/tickets/${id}/reimprimir`,
            '_blank'
        );
    }

</script>
@endsection