<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Ticket POS</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        @page{
            size:80mm auto;
            margin:0;
        }

        body{

            width:80mm;
            font-family:monospace;
            background:#fff;
            color:#000;

            padding:4mm;

            font-size:12px;
            line-height:1.4;

        }

        .center{
            text-align:center;
        }

        .bold{
            font-weight:bold;
        }

        .ticket-header{
            margin-bottom:10px;
        }

        .logo{
            width:70px;
            margin:0 auto 8px;
            display:block;
        }

        .store-name{
            font-size:18px;
            font-weight:700;
        }

        .line{
            border-top:1px dashed #000;
            margin:10px 0;
        }

        .row{
            display:flex;
            justify-content:space-between;
            gap:10px;
            margin-bottom:4px;
        }

        .label{
            font-weight:bold;
        }

        .ticket-box{
            margin-top:8px;
        }

        .total{
            font-size:16px;
            font-weight:bold;
        }

        .footer{
            margin-top:14px;
            text-align:center;
        }

        .small{
            font-size:11px;
        }

        .ticket-number{
            font-size:14px;
            font-weight:bold;
            margin-top:8px;
        }

    </style>

</head>

<body>

    <!-- HEADER -->
    <div class="ticket-header center">

        {{-- LOGO --}}
        {{-- <img src="{{ asset('images/logo.png') }}" class="logo"> --}}

        <div class="store-name">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 100%;">
        </div>

        <div>
            Ticket de Sorteo
        </div>

        <div class="small">
            Sistema POS
        </div>

    </div>

    <div class="line"></div>

    <!-- TICKET -->
    <div class="center ticket-number">
        {{ $ticket->ticket_number }}
    </div>

    <div class="line"></div>

    <!-- DATOS -->
    <div class="ticket-box">

        <div class="row">
            <span class="label">Fecha:</span>
            <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="row">
            <span class="label">Cliente:</span>
        </div>

        <div>
            {{ $ticket->nombres }} {{ $ticket->apellidos }}
        </div>

        <br>

        <div class="row">
            <span class="label">Documento:</span>
            <span>{{ $ticket->dni }}</span>
        </div>

        <div class="row">
            <span class="label">WhatsApp:</span>
            <span>{{ $ticket->telefono }}</span>
        </div>

        <div class="line"></div>

        <div class="row">
            <span class="label">Sorteo:</span>
        </div>

        <div>
            {{ $ticket->sorteo->name }}
        </div>

        <br>

        <div class="row">
            <span class="label">Cantidad:</span>
            <span>{{ $ticket->cantidad }}</span>
        </div>

        <div class="row">
            <span class="label">Método:</span>
            <span>{{ strtoupper($ticket->metodo_pago) }}</span>
        </div>

        <div class="line"></div>

        <div class="row total">
            <span>TOTAL</span>
            <span>S/ {{ number_format($ticket->total_pagado,2) }}</span>
        </div>

    </div>

    <div class="line"></div>

    <!-- FOOTER -->
    <div class="footer">

        <div class="bold">
            ¡Gracias por participar!
        </div>

        <div class="small">
            Conserva este ticket
        </div>

    </div>

    <script>

        window.onload = () => {

            window.print();

            setTimeout(() => {
                window.close();
            }, 800);

        };

    </script>

</body>
</html>

