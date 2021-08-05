<?php

namespace Googlemarketer\Contact\Http\Controllers\Associate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Associate\Associate;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       $associate = auth()->guard('associate')->user();
        return view('associate.dashboard.show', compact('associate'));
    }
}
