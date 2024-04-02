<?php

namespace App\Http\Controllers\Warranty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MastCustomer;
use App\Models\deliverie;
use App\Models\Warranty\Complaint;
use App\Models\Master\MastComplaintType;
use App\Models\Inventory\Delivery;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;

class ComplaintIssueController extends Controller
{
    public function index()
    {
        $data = Complaint::with('custo')->get();
        return view('layouts.pages.warranty.complaint.index',compact('data'));
    }
    public function showCustomerList()
    {
        $allCustomer = MastCustomer::with('mastCustomerType')->latest()->get();
        $compliantType = MastComplaintType::all();
        return view('layouts.pages.warranty.complaint.customer-list',compact('allCustomer','compliantType'));
    }

    public function store(Request $request)
    {
        $IDGenarator = Helper::IDGenerator(new Complaint,'issue_no', 5, "ISSUE");
        $data = new Complaint();
        $data->note = $request->note;
        $data->remarks = $request->remarks;
        $data->mast_complaint_type_id = $request->mast_complaint_type_id;
        $data->mast_customer_id = $request->mast_customer_id;
        $data->issue_date = $request->issue_date;
        $data->with_warranty = $request->warenty == 'Yes' ? 1 : 0 ;
        $data->issue_no = $IDGenarator;
        $data->user_id = Auth::user()->id;
        $data->save();

        return redirect()->route('complaint-issue');
    }


    /**__________________________________________________________________________________
     * Ajax Call Data => Show
     * __________________________________________________________________________________
     */
    public function getCompliantData(Request $request)
    {
        $viewCompliant = Complaint::with('custo')->with('compliantType')->where('id',$request->compliant_id)->first()->toArray();
        return response()->json([
            'viewCompliant' => $viewCompliant,
        ]);
    }

    public function getCustomerDetails(Request $request)
    {
        $getDelivary = Delivery::with('itemCode')->with('customerName')->with('itemCode.mastItemGroup')->with('saleDate')->where('mast_customer_id', $request->addNew_id)->get()->toArray();
        $customerNamer = Delivery::with('customerName')->where('mast_customer_id', $request->addNew_id)->first();

        foreach($getDelivary as $data){
            $previousDate =  date('Y-m-d', strtotime(str_replace('/','-',$data['deli_date'])));
            $previousDate = Carbon::parse($previousDate);
            $todayDate = Carbon::today();
            $monthDifference = $todayDate->diffInDays($previousDate);
            $total_day = $data['item_code']['warranty'] * 30;
            $data['warranty_status'] = $monthDifference <= $total_day ? 'Yes' : 'No';
        }

        return response()->json([
            'getDelivary' => $getDelivary,
            'customerName' => $customerNamer->customerName->name,
            'customerNameId' => $customerNamer->customerName->id,

        ]);
    }

}
