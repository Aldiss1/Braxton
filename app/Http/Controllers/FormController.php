<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function form(){
        return view('pages.tambah-data.form_input');
    }
}
