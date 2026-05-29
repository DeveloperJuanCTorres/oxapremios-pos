<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | USUARIO LOGUEADO
        |--------------------------------------------------------------------------
        */

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | HOY
        |--------------------------------------------------------------------------
        */

        $hoy = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | KPIS
        |--------------------------------------------------------------------------
        */

        $ventasHoy = Ticket::where('created_by', $userId)
            ->whereDate('created_at', $hoy)
            ->sum('total_pagado');

        $ticketsHoy = Ticket::where('created_by', $userId)
            ->whereDate('created_at', $hoy)
            ->sum('cantidad');

        $transaccionesHoy = Ticket::where('created_by', $userId)
            ->whereDate('created_at', $hoy)
            ->count();

        $ticketPromedio = $transaccionesHoy > 0
            ? $ventasHoy / $transaccionesHoy
            : 0;

        /*
        |--------------------------------------------------------------------------
        | ULTIMAS VENTAS
        |--------------------------------------------------------------------------
        */

        $ultimasVentas = Ticket::with('sorteo')
            ->where('created_by', $userId)
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SORTEOS MÁS VENDIDOS
        |--------------------------------------------------------------------------
        */

        $topSorteos = Ticket::select(
                'sorteo_id',
                DB::raw('SUM(cantidad) as total')
            )
            ->where('created_by', $userId)
            ->groupBy('sorteo_id')
            ->with('sorteo')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | METODOS DE PAGO
        |--------------------------------------------------------------------------
        */

        $metodosPago = Ticket::select(
                'metodo_pago',
                DB::raw('COUNT(*) as total')
            )
            ->where('created_by', $userId)
            ->groupBy('metodo_pago')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | VENTAS ÚLTIMOS 7 DÍAS
        |--------------------------------------------------------------------------
        */

        $ventasSemana = Ticket::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total_pagado) as total')
            )
            ->where('created_by', $userId)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return view('home', compact(
            'ventasHoy',
            'ticketsHoy',
            'transaccionesHoy',
            'ticketPromedio',
            'ultimasVentas',
            'topSorteos',
            'metodosPago',
            'ventasSemana'
        ));
    }
}
