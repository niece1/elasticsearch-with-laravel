<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class HomeController extends Controller
{
    /**
     * Display post listing and featured post.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return view('frontend.index', compact('customers'));
    }
}
