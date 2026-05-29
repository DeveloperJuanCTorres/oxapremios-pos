@extends('layouts.app')

<link href="{{ asset('css/vistas.css')}}?v=3000.0.1" rel="stylesheet" />

@section('content')

@include('partials.menu')

<div class="main-wrapper">

    @include('partials.header')

    <main class="content-area overflow-hidden w-100">

        <div class="row g-0 h-100">

            <!-- =========================================
            LEFT SIDE - SORTEOS
            ========================================== -->
            <div class="col-xl-8 h-100 d-flex flex-column overflow-hidden px-0">

                <!-- Header -->
                <div class="px-4 pt-4 pb-3 border-bottom bg-white">

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                        <div>
                            <h2 class="fw-bold mb-1">
                                Panel Punto de Venta
                            </h2>

                            <p class="text-muted mb-0">
                                Venta rápida de tickets para sorteos
                            </p>
                        </div>

                        <div class="d-flex gap-2">

                            <button class="btn btn-light border rounded-pill px-3">
                                <i class="fa-solid fa-chart-line me-2"></i>
                                Reportes
                            </button>

                            <button class="btn btn-primary rounded-pill px-4">
                                <i class="fa-solid fa-ticket me-2"></i>
                                Nueva Venta
                            </button>

                        </div>

                    </div>

                    <!-- Buscador -->
                    <div class="mt-4 position-relative">

                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <input
                            type="text"
                            class="form-control ps-5 rounded-4 border-0 shadow-sm"
                            placeholder="Buscar sorteo..."
                            style="height: 54px; background: #f5f7fb;">

                    </div>

                </div>

                <!-- GRID SORTEOS -->
                <div class="raffles-scroll p-4 custom-scrollbar">

                    <div class="row g-4">

                        @foreach($sorteos as $sorteo)

                        <div class="col-md-6 col-xl-4">

                            <div
                                class="raffle-card h-100"
                                onclick="seleccionarSorteo(
                                    '{{ $sorteo->id }}',
                                    '{{ $sorteo->name }}',
                                    '{{ number_format($sorteo->price,2,'.','') }}',
                                    '{{ asset('https://oxapremiostreff.com/storage/' . str_replace('\\', '/', $sorteo->image)) }}'
                                )">

                                <!-- IMAGE -->
                                <div class="raffle-image">

                                    <img
                                        src="{{ asset('https://oxapremiostreff.com/storage/' . str_replace('\\', '/', $sorteo->image)) }}"
                                        alt="{{ $sorteo->name }}">

                                    <div class="raffle-overlay"></div>

                                    <div class="raffle-badge">
                                        ACTIVO
                                    </div>

                                </div>

                                <!-- BODY -->
                                <div class="p-3">

                                    <div class="mb-2">

                                        <h5 class="fw-bold mb-1 text-truncate-2">
                                            {{ $sorteo->name }}
                                        </h5>

                                        <small class="text-muted">
                                            Sorteo disponible
                                        </small>

                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-3">

                                        <div>

                                            <small class="text-muted d-block">
                                                Ticket
                                            </small>

                                            <div class="fw-bold text-primary fs-4">
                                                S/ {{ number_format($sorteo->price,2) }}
                                            </div>

                                        </div>

                                        <button
                                            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:48px;height:48px;">

                                            <i class="fa-solid fa-plus"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <!-- =========================================
            RIGHT SIDE - FORMULARIO
            ========================================== -->
            <div class="col-xl-4 h-100 px-0">

                <div class="sales-panel">

                    <!-- HEADER -->
                    <div class="sales-header">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>

                                <h4 class="fw-bold mb-1">
                                    Registrar Venta
                                </h4>

                                <small class="text-muted">
                                    Completa los datos del cliente
                                </small>

                            </div>

                            <div class="sales-icon">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>

                        </div>

                    </div>

                    <!-- FORM SCROLL -->
                    <div class="sales-body custom-scrollbar">

                        <form
                            id="formVenta"
                            action="{{ route('tickets.store') }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <!-- SORTEO -->
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Sorteo seleccionado
                                </label>

                                <div class="selected-raffle">

                                    <img
                                        id="preview_sorteo"
                                        src="https://placehold.co/80x80"
                                        alt="">

                                    <div class="flex-grow-1">

                                        <h6 id="nombre_sorteo" class="fw-bold mb-1">
                                            Selecciona un sorteo
                                        </h6>

                                        <small class="text-muted">
                                            Ticket seleccionado
                                        </small>

                                    </div>

                                    <div class="fw-bold text-primary fs-5" id="precio_sorteo">
                                        S/ 0.00
                                    </div>

                                </div>

                                <input type="hidden" name="sorteo_id" id="sorteo_id">

                            </div>

                            <!-- DOCUMENTO -->
                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Tipo Documento
                                    </label>

                                    <select
                                        class="form-select custom-input"
                                        name="tipo_documento"
                                        required>

                                        <option value="dni">DNI</option>
                                        <option value="ce">Carnet Extranjería</option>
                                        <option value="pasaporte">Pasaporte</option>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Nº Documento
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        name="dni"
                                        required>

                                </div>

                            </div>

                            <!-- NOMBRES -->
                            <div class="row g-3 mt-1">

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Nombres
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        name="nombres"
                                        required>

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Apellidos
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        name="apellidos"
                                        required>

                                </div>

                            </div>

                            <!-- UBICACION -->
                            <div class="row g-3 mt-1">

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Departamento
                                    </label>

                                    <select
                                        class="form-select custom-input"
                                        name="departamento"
                                        required>

                                        <option value="">Seleccionar</option>
                                        <option>Lima</option>
                                        <option>Lambayeque</option>
                                        <option>Piura</option>
                                        <option>Cajamarca</option>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        WhatsApp
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        name="telefono"
                                        required>

                                </div>

                            </div>

                            <!-- TICKETS -->
                            <div class="mt-4">

                                <label class="form-label fw-semibold">
                                    Cantidad Tickets
                                </label>

                                <div class="ticket-counter">

                                    <button type="button" id="btnMenos">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>

                                    <input
                                        type="number"
                                        id="cantidad"
                                        name="cantidad"
                                        value="1"
                                        min="1"
                                        readonly>

                                    <button type="button" id="btnMas">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>

                                </div>

                            </div>

                            <!-- METODO PAGO -->
                            <div class="mt-4">

                                <label class="form-label fw-semibold">
                                    Método de Pago
                                </label>

                                <select
                                    class="form-select custom-input"
                                    name="metodo_pago"
                                    required>

                                    <option value="yape">Yape</option>
                                    <option value="plin">Plin</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>

                                </select>

                            </div>

                            <!-- MONTO -->
                            <div class="mt-4">

                                <label class="form-label fw-semibold">
                                    Monto Pagado
                                </label>

                                <input
                                    type="text"
                                    class="form-control custom-input fw-bold text-success"
                                    id="monto_total"
                                    name="monto"
                                    readonly>

                            </div>

                            <!-- OBSERVACION -->
                            <div class="mt-4">

                                <label class="form-label fw-semibold">
                                    Observación
                                </label>

                                <textarea
                                    class="form-control custom-input"
                                    rows="4"
                                    name="observacion"
                                    placeholder="Observación de la venta..."></textarea>

                            </div>

                            <!-- BUTTON -->
                            <div class="mt-4">

                                <button
                                    type="submit"
                                    class="btn-save-sale">

                                    <i class="fa-solid fa-check-circle me-2"></i>
                                    Registrar Venta

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

<style>

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    .container,
    .container-fluid{
        max-width:100%!important;
        padding:0!important;
    }

    .row{
        margin:0!important;
    }

    [class*="col-"]{
        padding-left:0!important;
        padding-right:0!important;
    }

    html,
    body{
        overflow:hidden;
        height:100%;
    }

    .main-wrapper{
        margin-left:240px;
        width:calc(100vw - 240px);
        height:100vh;
        overflow:hidden;
        background:#f4f7fb;
        display:flex;
        flex-direction:column;
    }

    .content-area{
        flex:1;
        width:100%;
        overflow:hidden;
        padding:0;
    }

    .content-area > .row{
        height:100%;
        width:100%;
        margin:0;
    }

    /* COLUMNAS */
    .content-area .col-xl-8{
        padding:0;
        border-right:1px solid #e5e7eb;
    }

    .content-area .col-xl-4{
        padding:0;
    }

    /* SCROLL IZQUIERDA */
    .raffles-scroll{
        height:calc(100vh - 150px);
        overflow-y:auto;
        overflow-x:hidden;
    }

    /* PANEL DERECHO */
    .sales-panel{
        height:calc(100vh - 64px);
        display:flex;
        flex-direction:column;
        background:#fff;
    }

    /* SOLO ESTA PARTE SCROLLEA */
    .sales-body{
        flex:1;
        overflow-y:auto;
        overflow-x:hidden;
        padding:24px;
    }

    /* EVITAR ANCHO MAXIMO BOOTSTRAP */
    .container,
    .container-fluid{
        max-width:100%!important;
        width:100%!important;
        padding-left:0!important;
        padding-right:0!important;
    }

    /* FIX ROW */
    .row{
        --bs-gutter-x:0;
    }

    /* RESPONSIVE */
    /* =========================================
    RESPONSIVE MOBILE & TABLET
    ========================================= */

    @media(max-width:1200px){

        html,
        body{
            overflow:auto;
            height:auto;
        }

        .main-wrapper{
            margin-left:0;
            width:100%;
            height:auto;
            min-height:100vh;
            overflow:visible;
        }

        .content-area{
            overflow:visible;
            height:auto;
        }

        .content-area > .row{
            display:flex;
            flex-direction:column;
            height:auto;
        }

        /* COLUMNAS */
        .content-area .col-xl-8,
        .content-area .col-xl-4{
            width:100%;
            min-width:100%;
            max-width:100%;
            flex:0 0 100%;
        }

        .content-area .col-xl-8{
            border-right:none;
        }

        /* HEADER */
        .px-4.pt-4.pb-3.border-bottom.bg-white{
            padding:20px !important;
        }

        .px-4.pt-4.pb-3.border-bottom.bg-white .d-flex{
            flex-direction:column;
            align-items:flex-start !important;
        }

        .px-4.pt-4.pb-3.border-bottom.bg-white .d-flex.gap-2{
            width:100%;
            display:grid !important;
            grid-template-columns:1fr 1fr;
        }

        .px-4.pt-4.pb-3.border-bottom.bg-white .btn{
            width:100%;
        }

        /* GRID */
        .raffles-scroll{
            height:auto;
            overflow:visible;
            padding:20px !important;
        }

        .raffles-scroll .row{
            row-gap:20px !important;
        }

        .raffles-scroll .col-md-6,
        .raffles-scroll .col-xl-4{
            width:100%;
            max-width:100%;
            flex:0 0 100%;
        }

        /* CARD */
        .raffle-image{
            height:240px;
        }

        /* PANEL DERECHO */
        .sales-panel{
            height:auto;
            min-height:auto;
            border-left:none;
            border-top:1px solid #e5e7eb;
        }

        .sales-header{
            padding:20px;
        }

        .sales-body{
            overflow:visible;
            padding:20px;
        }

        /* FORM */
        .sales-body .row{
            row-gap:16px;
        }

        .sales-body .col-md-6{
            width:100%;
            flex:0 0 100%;
            max-width:100%;
        }

        .custom-input{
            font-size:16px;
        }

        /* SELECTED RAFFLE */
        .selected-raffle{
            align-items:flex-start;
            flex-direction:column;
        }

        .selected-raffle img{
            width:100%;
            height:180px;
        }

        /* COUNTER */
        .ticket-counter{
            height:56px;
        }

        .ticket-counter input{
            font-size:22px;
        }

        /* BUTTON */
        .btn-save-sale{
            height:56px;
            font-size:16px;
        }

    }

    /* =========================================
    EXTRA SMALL DEVICES
    ========================================= */

    @media(max-width:576px){

        .px-4.pt-4.pb-3.border-bottom.bg-white{
            padding:16px !important;
        }

        .raffles-scroll{
            padding:16px !important;
        }

        .sales-header{
            padding:16px;
        }

        .sales-body{
            padding:16px;
        }

        h2{
            font-size:22px;
        }

        .raffle-image{
            height:220px;
        }

        .selected-raffle{
            padding:12px;
            border-radius:18px;
        }

        .selected-raffle img{
            height:160px;
        }

        .ticket-counter{
            padding:0 10px;
        }

        .ticket-counter button{
            width:38px;
            height:38px;
        }

    }

    /* =========================================
    CARDS
    ========================================= */

    .raffle-card{
        background:#fff;
        border-radius:24px;
        overflow:hidden;
        cursor:pointer;
        transition:.3s ease;
        border:1px solid #edf1f7;
        box-shadow:0 10px 30px rgba(0,0,0,.04);
    }

    .raffle-card:hover{
        transform:translateY(-6px);
        box-shadow:0 20px 45px rgba(0,0,0,.08);
    }

    .raffle-image{
        position:relative;
        height:220px;
        overflow:hidden;
    }

    .raffle-image img{
        width:100%;
        height:100%;
        object-fit:cover;
        transition:.4s ease;
    }

    .raffle-card:hover img{
        transform:scale(1.08);
    }

    .raffle-overlay{
        position:absolute;
        inset:0;
        background:linear-gradient(to top, rgba(0,0,0,.7), transparent);
    }

    .raffle-badge{
        position:absolute;
        top:14px;
        right:14px;
        background:#16a34a;
        color:#fff;
        padding:6px 14px;
        border-radius:999px;
        font-size:11px;
        font-weight:700;
        letter-spacing:1px;
    }

    /* =========================================
    RIGHT PANEL
    ========================================= */

    .sales-panel{
        background:#fff;
        height:100%;
        display:flex;
        flex-direction:column;
        border-left:1px solid #e8edf5;
    }

    .sales-header{
        padding:24px;
        border-bottom:1px solid #eef2f7;
    }

    .sales-icon{
        width:50px;
        height:50px;
        border-radius:16px;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
    }

    .sales-body{
        flex:1;
        overflow-y:auto;
        overflow-x:hidden;
        padding:24px;

        padding-bottom:120px;
    }

    /* =========================================
    FORM
    ========================================= */

    .custom-input{
        height:52px;
        border-radius:16px;
        border:1px solid #e5e7eb;
        background:#f9fafb;
        box-shadow:none!important;
    }

    .custom-input:focus{
        border-color:#2563eb;
        background:#fff;
    }

    textarea.custom-input{
        height:auto;
    }

    .selected-raffle{
        display:flex;
        align-items:center;
        gap:14px;
        background:#f8fafc;
        border:1px solid #e5e7eb;
        padding:14px;
        border-radius:20px;
    }

    .selected-raffle img{
        width:80px;
        height:80px;
        object-fit:cover;
        border-radius:16px;
    }

    .ticket-counter{
        height:60px;
        border-radius:20px;
        background:#f8fafc;
        border:1px solid #e5e7eb;
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:0 14px;
    }

    .ticket-counter button{
        width:42px;
        height:42px;
        border:none;
        border-radius:14px;
        background:#fff;
        transition:.2s ease;
    }

    .ticket-counter button:hover{
        background:#2563eb;
        color:#fff;
    }

    .ticket-counter input{
        border:none;
        background:transparent;
        width:80px;
        text-align:center;
        font-size:28px;
        font-weight:700;
    }

    .btn-save-sale{
        width:100%;
        height:60px;
        border:none;
        border-radius:20px;
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        color:#fff;
        font-weight:700;
        font-size:18px;
        transition:.3s ease;
    }

    .btn-save-sale:hover{
        transform:translateY(-2px);
        box-shadow:0 15px 35px rgba(37,99,235,.3);
    }

    /* =========================================
    SCROLL
    ========================================= */

    .custom-scrollbar::-webkit-scrollbar{
        width:7px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb{
        background:#cbd5e1;
        border-radius:999px;
    }

    .custom-scrollbar::-webkit-scrollbar-track{
        background:transparent;
    }

    /* =========================================
    RESPONSIVE
    ========================================= */

    @media(max-width:1200px){

        .content-area{
            overflow:auto;
        }

        .sales-panel{
            height:auto;
            min-height:100vh;
        }

    }

    /* =========================================
    FIX BOTON REGISTRAR VENTA MOBILE
    ========================================= */

    @media(max-width:1200px){

        .sales-panel{
            position:relative;
            z-index:1;
        }

        .btn-save-sale{
            position:sticky;
            bottom:0;
            z-index:50;

            box-shadow:
                0 -10px 30px rgba(255,255,255,.95),
                0 10px 30px rgba(37,99,235,.25);

            margin-top:20px;
        }

    }

</style>


<script>

    let precioActual = 0;

    function seleccionarSorteo(id,nombre,precio,imagen){

        document.getElementById('sorteo_id').value = id;

        document.getElementById('nombre_sorteo').innerText = nombre;

        document.getElementById('precio_sorteo').innerText = 'S/ ' + precio;

        document.getElementById('preview_sorteo').src = imagen;

        precioActual = parseFloat(precio);

        calcularTotal();
    }

    const cantidad = document.getElementById('cantidad');

    document.getElementById('btnMas').onclick = () => {

        cantidad.value = parseInt(cantidad.value) + 1;

        calcularTotal();
    };

    document.getElementById('btnMenos').onclick = () => {

        if(parseInt(cantidad.value) > 1){

            cantidad.value = parseInt(cantidad.value) - 1;

            calcularTotal();
        }
    };

    function calcularTotal(){

        const total = precioActual * parseInt(cantidad.value);

        document.getElementById('monto_total').value = 'S/ ' + total.toFixed(2);
    }

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const formVenta = document.getElementById('formVenta');

        formVenta.addEventListener('submit', function (e) {

            e.preventDefault();

            const formData = new FormData(formVenta);

            fetch(formVenta.action, {

                method: 'POST',

                body: formData,

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }

            })

            .then(response => response.json())

            .then(data => {

                if(data.success){

                    Swal.fire({

                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true

                    });

                    window.open(
                        `/tickets/${data.ticket_id}/print`,
                        '_blank'
                    );

                    formVenta.reset();

                    document.getElementById('nombre_sorteo').innerText = 'Selecciona un sorteo';

                    document.getElementById('precio_sorteo').innerText = 'S/ 0.00';

                    document.getElementById('preview_sorteo').src = 'https://placehold.co/80x80';

                    document.getElementById('cantidad').value = 1;

                    document.getElementById('monto_total').value = '';

                    precioActual = 0;

                }else{

                    Swal.fire({

                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 4000

                    });                    

                }

            })

            .catch(error => {

                console.log(error);

                Swal.fire({

                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al registrar venta',
                    showConfirmButton: false,
                    timer: 4000

                });

            });

        });

    });

</script>

@endsection