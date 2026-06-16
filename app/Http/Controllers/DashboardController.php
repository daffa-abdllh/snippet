<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard with their notes list.
     */
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();

        return view('dashboard', compact('notes'));
    }
}
