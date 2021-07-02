<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\SubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SubscriptionRequest $request)
    {
        Subscription::create($request->all());
    }
}
