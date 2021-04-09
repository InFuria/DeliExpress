<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        try {

            return view('general.dashboard.index');

        } catch (\Exception $e) {
            \Log::error('General\DashboardController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }
}
