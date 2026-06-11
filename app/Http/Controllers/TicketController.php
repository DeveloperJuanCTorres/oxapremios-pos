<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDACIONES
            |--------------------------------------------------------------------------
            */

            $request->validate([

                'sorteo_id'   => 'required|exists:raffles,id',

                'dni'         => 'required|string|max:20',

                'nombres'     => 'required|string|max:150',

                'apellidos'   => 'required|string|max:150',

                'telefono'    => 'required|string|max:20',

                'departamento'=> 'required|string|max:100',

                'cantidad'    => 'required|integer|min:1',

                'metodo_pago' => 'required|string|max:50',

                'email'       => 'nullable|email|max:150',

                'observacion' => 'nullable|string|max:500',

            ]);

            /*
            |--------------------------------------------------------------------------
            | OBTENER SORTEO
            |--------------------------------------------------------------------------
            */

            $sorteo = Raffle::findOrFail($request->sorteo_id);

            /*
            |--------------------------------------------------------------------------
            | CALCULAR TOTAL
            |--------------------------------------------------------------------------
            */

            $cantidad = (int) $request->cantidad;

            $totalPagado = $cantidad * $sorteo->price;

            /*
            |--------------------------------------------------------------------------
            | GENERAR NÚMERO OPERACIÓN
            |--------------------------------------------------------------------------
            */

            $ticketNumber = 'POS-' . strtoupper(uniqid());

            /*
            |--------------------------------------------------------------------------
            | CREAR REGISTRO
            |--------------------------------------------------------------------------
            */

            $ticket = Ticket::create([

                'sorteo_id' => $sorteo->id,

                'user_id' => Auth::id(),

                'ticket_number' => $ticketNumber,

                'dni' => $request->dni,

                'nombres' => strtoupper($request->nombres),

                'apellidos' => strtoupper($request->apellidos),

                'telefono' => $request->telefono,

                'departamento' => $request->departamento,

                'cantidad' => $cantidad,

                'email' => $request->email,

                'metodo_pago' => $request->metodo_pago,

                'monto' => $sorteo->price,

                'total_pagado' => $totalPagado,

                'observacion' => $request->observacion,

                'canal_venta' => 'POS',

                'created_by' => Auth::id(),

                'aprobado' => 1,

                'comprobante' => null,

            ]);

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Venta registrada correctamente',

                'ticket_id' => $ticket->id

            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);
        }
    }

    public function print($id)
    {
        $ticket = Ticket::with('sorteo')->findOrFail($id);

        return view('partials.print', compact('ticket'));
    }

    public function reimprimir(Ticket $ticket)
    {
        $ticket->load('sorteo');

        return view('partials.print', compact('ticket'));
    }
}