<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of Post resource by search criteria.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $customers = Customer::search($request->q)->get();
        
        return view('frontend.search', compact('customers'));
    }
}
