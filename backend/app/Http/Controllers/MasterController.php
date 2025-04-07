<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function items()
    {
        return view('master.items');
    }

    public function office()
    {
        return view('master.office');
    }

    public function yard()
    {
        return view('master.yard');
    }

    public function shelf()
    {
        return view('master.shelf');
    }

    public function carType()
    {
        return view('master.car_type');
    }
} 