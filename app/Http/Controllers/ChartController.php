<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Request2;
use App\Models\AjaxCrud;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        $indicadores = AjaxCrud::select (DB::raw("select * from indicadores where codigoIndicador = 'UF'"))
            ->whereYear('fechaIndicador', date('Y'))
            ->groupBy(DB::raw("Month(fechaIndicador)"))
            ->pluck('select');

        $months = AjaxCrud::select (DB::raw("Month(fechaIndicador) as month"))
            ->whereYear('fechaIndicador', date('Y'))
            ->groupBy(DB::raw("Month(fechaIndicador)"))
            ->pluck('month');

        $datas = array(0,0,0,0,0,0,0,0,0,0,0,0,);
        foreach($months as $index => $month)
        {
            $datas[$month] = $indicadores[$index];
        }

        return view('ajax', compact('datas'));
    }


}