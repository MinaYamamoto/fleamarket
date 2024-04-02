<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function adminindex() {
        return view('admin/admin');
    }

    public function admindestroy() {
        return view('admin/admin');
    }
}
