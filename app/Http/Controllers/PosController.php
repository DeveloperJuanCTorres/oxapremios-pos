<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $sorteos = Raffle::where('active', 1)
            ->orderBy('date', 'asc')
            ->get();
        return view('pos', compact('sorteos'));
    }
}
