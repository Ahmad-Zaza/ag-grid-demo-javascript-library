<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function __construct()
    {

    }

    public function viewDataTable(){
        return response()->view("main", []);
    }

    public function viewTestDataTable(){
        return response()->view('test', []);
    }
}
