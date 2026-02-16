<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;

class PeriksaController extends Controller
{
    public function index()
    {
        $periksas = Periksa::all();
        return view('pages.periksa.index', compact('periksas'));
    }

    public function create()
    {
        return view('pages.periksa.create');
    }
}
