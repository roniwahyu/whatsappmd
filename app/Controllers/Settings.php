<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Settings extends Controller
{
    public function index()
    {
        return view('pages/settings');
    }
}