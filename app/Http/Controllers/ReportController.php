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
    public function index(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $tickets = DB::table('tickets')
            ->leftJoin('raffles', 'raffles.id', '=', 'tickets.sorteo_id')
            ->leftJoin('users', 'users.id', '=', 'tickets.created_by')
            ->select(
                'tickets.*',
                'raffles.name as sorteo',
                'users.name as vendedor'
            )
            ->when($desde, function ($q) use ($desde) {
                $q->whereDate('tickets.created_at', '>=', $desde);
            })
            ->when($hasta, function ($q) use ($hasta) {
                $q->whereDate('tickets.created_at', '<=', $hasta);
            });

        $baseQuery = clone $tickets;

        $ventasTotales = (clone $tickets)
            ->where('tickets.aprobado', 1)
            ->sum('tickets.total_pagado');

        $ticketsVendidos = (clone $tickets)
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

        $ultimosTickets = $baseQuery
            ->latest('tickets.id')
            ->paginate(20);

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
            'ultimosTickets'
        ));
    }
}
