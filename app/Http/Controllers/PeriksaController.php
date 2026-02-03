<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeriksaController extends Controller
{
    public function index()
    {
        return view('pages.periksa.index');
    }

    public function create()
    {
        return view('pages.periksa.create');
    }
}
