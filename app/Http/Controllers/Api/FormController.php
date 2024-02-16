<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function Form(){
        return view('pages.tambah-data.form_input');
    }
}
