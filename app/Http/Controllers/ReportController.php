<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if (!auth()->check() || auth()->user()->role_id != 3) {
            abort(403, 'No autorizado');
        }


        $desde = $request->desde;
        $hasta = $request->hasta;
        $usuario = $request->usuario;
        $metodo = $request->metodo;

        // $tickets = DB::table('tickets')
        //     ->leftJoin('raffles', 'raffles.id', '=', 'tickets.sorteo_id')
        //     ->leftJoin('users', 'users.id', '=', 'tickets.created_by')
        //     ->select(
        //         'tickets.*',
        //         'raffles.name as sorteo',
        //         'users.name as vendedor'
        //     )
        //     ->when($desde, function ($q) use ($desde) {
        //         $q->whereDate('tickets.created_at', '>=', $desde);
        //     })
        //     ->when($hasta, function ($q) use ($hasta) {
        //         $q->whereDate('tickets.created_at', '<=', $hasta);
        // });

        $tickets = DB::table('tickets')
            ->leftJoin('raffles', 'raffles.id', '=', 'tickets.sorteo_id')
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->select(
                'tickets.*',
                'raffles.name as sorteo',
                'users.name as vendedor'
            )

            ->when($desde, function ($q) use ($desde) {
                $q->whereDate('tickets.created_at','>=',$desde);
            })

            ->when($hasta, function ($q) use ($hasta) {
                $q->whereDate('tickets.created_at','<=',$hasta);
            })

            ->when($usuario,function($q) use($usuario){
                $q->where('tickets.user_id',$usuario);
            })

            ->when($metodo,function($q) use($metodo){
                $q->where('tickets.metodo_pago',$metodo);
        });

        $baseQuery = clone $tickets;

        $ventasTotales = (clone $baseQuery)
            ->where('tickets.aprobado', 1)
            ->sum('tickets.total_pagado');

        $ticketsVendidos = (clone $baseQuery)
            ->where('tickets.aprobado', 1)
            ->count();

        $participantes = DB::table('tickets')
            ->where('aprobado', 1)
            ->distinct('dni')
            ->count('dni');

        $sorteosActivos = DB::table('raffles')
            ->where('active', 1)
            ->count();

        $ticketPromedio = DB::table('tickets')
            ->where('aprobado', 1)
            ->avg('total_pagado');

        $topSorteos = DB::table('tickets')
            ->join('raffles', 'raffles.id', '=', 'tickets.sorteo_id')
            ->where('tickets.aprobado', 1)
            ->select(
                'raffles.name',
                DB::raw('COUNT(*) as vendidos')
            )
            ->groupBy('raffles.id', 'raffles.name')
            ->orderByDesc('vendidos')
            ->limit(5)
            ->get();

        $ventasPorDia = DB::table('tickets')
            ->where('aprobado', 1)
            ->select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total_pagado) as total')
            )
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $metodosPago = DB::table('tickets')
            ->where('aprobado', 1)
            ->select(
                'metodo_pago',
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(total_pagado) as total')
            )
            ->groupBy('metodo_pago')
            ->get();

        $canalesVenta = DB::table('tickets')
            ->where('aprobado', 1)
            ->select(
                'canal_venta',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('canal_venta')
            ->get();

        $ultimosTickets = (clone $baseQuery)
            ->latest('tickets.id')
            ->get();

        $vendedores = DB::table('users')
            ->join('tickets', 'tickets.user_id', '=', 'users.id')
            ->select('users.id', 'users.name')
            ->distinct()
            ->orderBy('users.name')
            ->get();

        $totalLista = (clone $baseQuery)->sum('tickets.total_pagado');

        return view('reportes', compact(
            'ventasTotales',
            'ticketsVendidos',
            'participantes',
            'sorteosActivos',
            'ticketPromedio',
            'topSorteos',
            'ventasPorDia',
            'metodosPago',
            'canalesVenta',
            'ultimosTickets',
            'vendedores',
            'totalLista'
        ));
    }
}
