<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        return view('admin.informasiterkini.index', [
            'title'  => 'Informasi',
            'active' => 'informasi'
        ]);
    }

}
