<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Profile extends Controller
{
    public function index()
    {
        return view('pages/profile');
    }
}