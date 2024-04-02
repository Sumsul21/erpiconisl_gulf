<?php

namespace App\Http\Controllers\Warranty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warranty\Complaint;

class ServiceBillController extends Controller
{
    public function index()
    {
        $service = Complaint::get();
        return view('layouts.pages.warranty.service_bill.index', compact('service'));
    }
    public function getBill(Request $request)
    {
        $services = Complaint::where('id', $request->id)->get();
        dd($services);
        return response()->json([
            'services' => $services,
        ]);
    }
}
