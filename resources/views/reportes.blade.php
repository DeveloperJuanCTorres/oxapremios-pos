@extends('layouts.app')
<link href="{{ asset('css/vistas.css')}}?v=1993.0.1" rel="stylesheet" />
<style>
    :root {
        --primary-color: #004ac6;
        --surface-bg: #faf8ff;
        --sidebar-width: 240px;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--surface-bg);
        color: #191b23;
        overflow-x: hidden;
    }

    /* Sidebar Styling */
    #sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: #ffffff;
        border-right: 1px solid #e1e2ed;
        z-index: 1030;
        display: flex;
        flex-direction: column;
        padding: 1.5rem 1rem;
    }

    #sidebar .nav-link {
        color: #505f76;
        padding: 0.625rem 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    #sidebar .nav-link:hover {
        background-color: #f3f3fe;
        color: var(--primary-color);
    }

    #sidebar .nav-link.active {
        background-color: #e7e7f3;
        color: var(--primary-color);
        font-weight: 700;
    }

    #sidebar .nav-link i {
        width: 20px;
        text-align: center;
    }

    /* Main Content */
    #main-content {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Header */
    header {
        height: 64px;
        background: #ffffff;
        border-bottom: 1px solid #e1e2ed;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    /* Cards */
    .kpi-card {
        border: 1px solid #c3c6d7;
        border-radius: 0.75rem;
        padding: 1.5rem;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .kpi-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #505f76;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 1.875rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .trend-up {
        color: #007d55;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .trend-down {
        color: #ba1a1a;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Table Customization */
    .table-container {
        background: #ffffff;
        border: 1px solid #c3c6d7;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f3f3fe;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
        color: #505f76;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e1e2ed;
    }

    .table tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #e1e2ed;
    }

    /* Badge styling */
    .badge-completed {
        background-color: #bdffdb;
        color: #002113;
    }

    .badge-refunded {
        background-color: #ffdad6;
        color: #93000a;
    }

    .badge-processing {
        background-color: #d0e1fb;
        color: #54647a;
    }

    /* Chart Area Placeholders */
    .chart-box {
        background: #ffffff;
        border: 1px solid #c3c6d7;
        border-radius: 0.75rem;
        padding: 1.5rem;
        min-height: 320px;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>
@section('content')


<div id="main-content">
    @include('partials.menu')
    @include('partials.header')
    <!-- Scrollable Content -->
    <div class="container-fluid p-4 overflow-auto scrollbar-hide">
        <!-- KPI Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-label">Ventas totales</div>
                    <div class="kpi-value">
                        S/ {{ number_format($ventasTotales,2) }}
                    </div>
                    <div class="trend-up"><i class="fa-solid fa-arrow-trend-up"></i> 12.5% vs last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-label">Tickets vendidos</div>
                    <div class="kpi-value">
                        {{ $ticketsVendidos }}
                    </div>
                    <div class="trend-up"><i class="fa-solid fa-arrow-trend-up"></i> 4.2% vs last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-label">Participantes</div>
                    <div class="kpi-value">
                        {{ $participantes }}
                    </div>
                    <div class="trend-down"><i class="fa-solid fa-arrow-trend-down"></i> 1.8% vs last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-label">Sorteos activos</div>
                    <div class="kpi-value">
                        {{ $sorteosActivos }}
                    </div>
                    <div class="small text-muted"><i class="fa-solid fa-boxes-stacked"></i> 482 SKUs in stock</div>
                </div>
            </div>
        </div>
        <!-- Filter Bar -->
        <!-- <div class="card border-0 shadow-sm mb-4 bg-light p-3">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex flex-wrap gap-2">
                        <div class="input-group input-group-sm w-auto">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-calendar"></i></span>
                            <select class="form-select border-start-0 ps-0 shadow-none">
                                <option>Last 30 Days</option>
                                <option>Last 7 Days</option>
                                <option>This Month</option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm w-auto">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-filter"></i></span>
                            <select class="form-select border-start-0 ps-0 shadow-none">
                                <option>All Registers</option>
                                <option>Terminal #01</option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm w-auto">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-layer-group"></i></span>
                            <select class="form-select border-start-0 ps-0 shadow-none">
                                <option>All Categories</option>
                                <option>Electronics</option>
                                <option>Apparel</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <button class="btn btn-sm btn-white border bg-white me-1 fw-bold"><i class="fa-solid fa-file-pdf text-danger me-1"></i> PDF</button>
                    <button class="btn btn-sm btn-white border bg-white fw-bold"><i class="fa-solid fa-file-excel text-success me-1"></i> Excel</button>
                </div>
            </div>
        </div> -->

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <form method="GET">

                    <div class="row">

                        <div class="col-md-3">

                            <label class="fw-bold mb-2">
                                Desde
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="desde"
                                value="{{ request('desde') }}">

                        </div>

                        <div class="col-md-3">

                            <label class="fw-bold mb-2">
                                Hasta
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="hasta"
                                value="{{ request('hasta') }}">

                        </div>

                        <div class="col-md-3">

                            <label class="fw-bold mb-2">
                                Vendedor
                            </label>

                            <select
                                class="form-select"
                                name="usuario">

                                <option value="">
                                    Todos
                                </option>

                                @foreach($vendedores as $v)

                                <option
                                    value="{{ $v->id }}"
                                    {{ request('usuario')==$v->id ? 'selected':'' }}>

                                    {{ $v->name }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-3">

                            <label class="fw-bold mb-2">
                                Método Pago
                            </label>

                            <select
                                class="form-select"
                                name="metodo">

                                <option value="">
                                    Todos
                                </option>

                                <option value="Yape">
                                    Yape
                                </option>

                                <option value="Plin">
                                    Plin
                                </option>

                                <option value="Transferencia">
                                    Transferencia
                                </option>

                                <option value="Efectivo">
                                    Efectivo
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="mt-4">

                        <button class="btn btn-primary">

                            <i class="fa fa-search"></i>

                            Buscar

                        </button>

                        <a
                            href="{{ route('reports') }}"
                            class="btn btn-secondary">

                            Limpiar

                        </a>

                    </div>

                </form>

            </div>

        </div>

        <!-- Table Section -->
        <div class="table-container mb-4">
            <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold m-0">Historial de ventas reciente</h6>
                <div class="input-group input-group-sm" style="max-width: 280px;">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input id="searchSales" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search sale ID, customer..." type="text" />
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Fecha &amp; Hora</th>
                            <th>Transacción ID</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Sorteo</th>
                            <th>Método</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="salesTableBody">
                        @foreach($ultimosTickets as $ticket)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                #{{ $ticket->id }}
                            </td>

                            <td>
                                {{ $ticket->nombres }}
                                {{ $ticket->apellidos }}
                            </td>

                            <td>
                                {{ $ticket->vendedor }}
                            </td>

                            <td>
                                {{ $ticket->sorteo }}
                            </td>

                            <td>
                                {{ $ticket->metodo_pago }}
                            </td>

                            <td>
                                {{ $ticket->cantidad }}
                            </td>

                            <td>
                                S/ {{ number_format($ticket->total_pagado,2) }}
                            </td>

                            <td>

                                @if($ticket->aprobado)

                                <span class="badge bg-success">
                                    Aprobado
                                </span>

                                @else

                                <span class="badge bg-danger">
                                    Pendiente
                                </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- <div class="card-footer bg-white p-3 border-top d-flex justify-content-between align-items-center">
                <small class="text-muted">Showing 1 to 5 of 1,204 entries</small>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div> -->
        </div>
        <!-- Charts Section -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="chart-box">
                    <h6 class="fw-bold mb-4">Top Sorteos</h6>

                    <canvas id="sorteosChart"></canvas>
                </div>
                <!-- <div class="chart-box">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold m-0">Top Selling Categories</h6>
                        <i class="fa-solid fa-circle-info text-muted"></i>
                    </div>
                    <div class="d-flex align-items-end justify-content-between h-100" style="padding-bottom: 40px;">
                        <div class="text-center" style="width: 15%;">
                            <div class="bg-primary bg-opacity-75 rounded-top" style="height: 180px;"></div>
                            <small class="text-muted d-block mt-2">Elec.</small>
                        </div>
                        <div class="text-center" style="width: 15%;">
                            <div class="bg-success bg-opacity-75 rounded-top" style="height: 130px;"></div>
                            <small class="text-muted d-block mt-2">Apparel</small>
                        </div>
                        <div class="text-center" style="width: 15%;">
                            <div class="bg-secondary bg-opacity-75 rounded-top" style="height: 90px;"></div>
                            <small class="text-muted d-block mt-2">Home</small>
                        </div>
                        <div class="text-center" style="width: 15%;">
                            <div class="bg-info bg-opacity-75 rounded-top" style="height: 60px;"></div>
                            <small class="text-muted d-block mt-2">Beauty</small>
                        </div>
                        <div class="text-center" style="width: 15%;">
                            <div class="bg-light border rounded-top" style="height: 30px;"></div>
                            <small class="text-muted d-block mt-2">Others</small>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="col-md-6">
                <div class="chart-box">
                    <h6 class="fw-bold mb-4">Ventas por Día</h6>

                    <canvas id="ventasChart"></canvas>
                </div>
                <!-- <div class="chart-box">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold m-0">Hourly Traffic Trend</h6>
                        <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <div class="bg-light rounded p-4 h-100 position-relative d-flex align-items-end">
                        <svg class="w-100" preserveaspectratio="none" style="height: 150px;" viewbox="0 0 400 100">
                            <path d="M0,80 Q50,40 100,70 T200,30 T300,50 T400,10 L400,100 L0,100 Z" fill="rgba(37, 99, 235, 0.1)"></path>
                            <path d="M0,80 Q50,40 100,70 T200,30 T300,50 T400,10" fill="none" stroke="#004ac6" stroke-width="2"></path>
                        </svg>
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-between">
                            <small class="text-muted">08:00</small>
                            <small class="text-muted">12:00</small>
                            <small class="text-muted">16:00</small>
                            <small class="text-muted">20:00</small>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="mt-auto py-2 px-4 border-top bg-light d-flex justify-content-between align-items-center">
        <small class="text-muted">v2.4.1 Build 882 | © 2024 RetailPro Systems</small>
        <div class="d-flex gap-3">
            <a class="text-decoration-none text-muted small" href="#">Support</a>
            <a class="text-decoration-none text-muted small" href="#">Status</a>
        </div>
    </footer>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ventasLabels = @json($ventasPorDia->pluck('fecha'));
    const ventasData = @json($ventasPorDia->pluck('total'));

    new Chart(
        document.getElementById('ventasChart'),
        {
            type: 'line',
            data: {
                labels: ventasLabels,
                datasets: [{
                    label: 'Ventas',
                    data: ventasData,
                    tension: .4
                }]
            }
        }
    );

    const sorteosLabels = @json($topSorteos->pluck('name'));
    const sorteosData = @json($topSorteos->pluck('vendidos'));

    new Chart(
        document.getElementById('sorteosChart'),
        {
            type: 'bar',
            data: {
                labels: sorteosLabels,
                datasets: [{
                    label: 'Tickets',
                    data: sorteosData
                }]
            }
        }
    );

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('searchSales');
        const rows = document.querySelectorAll('#salesTableBody tr');

        searchInput.addEventListener('keyup', function () {

            const search = this.value.toLowerCase().trim();

            rows.forEach(row => {

                const text = row.textContent.toLowerCase();

                if (text.includes(search)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }

            });

        });

    });
</script>
@endsection