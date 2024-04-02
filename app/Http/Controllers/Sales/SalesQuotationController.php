<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\MastItemCategory;
use App\Models\Master\MastItemGroup;
use App\Models\Master\MastItemRegister;
use App\Models\Master\MastUnit;
use App\Models\Master\MastWorkStation;
use App\Models\Master\MastCustomer;
use App\Models\Master\MastCustomerType;
use App\Models\Sales\Sales;
use App\Models\Sales\Quotation;
use App\Models\Sales\QuotationDetails;
use App\Helpers\Helper;

class SalesQuotationController extends Controller
{
    public function index($type)
    {   
        $item_group = MastItemGroup::where('mast_item_category_id', $type)->orderBy('part_name', 'asc')->get();
        $customer = MastCustomer::where('status', 1)->where('mast_customer_type_id', $type)->get();
        $customer_type = MastCustomerType::where('status', 1)->get();
        $item_category = MastItemCategory::where('status', 1)->get();
        
        $data=Quotation::where('mast_item_category_id', $type)->orderBy('id', 'desc')->latest()->get();
        return view('layouts.pages.sales.sales_quotation.index',compact('type','data','item_group','customer','customer_type','item_category'));
    }
    public function store(Request $request, $type)
    {
        $invoice_codes = Helper::IDGenerator(new Quotation, 'quot_no', 5, 'GIAL'); /* Generate id */
        
        $sal_id=$request->sal_id;
        if(isset($sal_id)){
            $sales = Quotation::findOrFail($sal_id);
        }else{
            $validator = Validator::make($request->all(), [
                'inv_date' => 'required',
                'mast_customer_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $sales = new Quotation();
            $sales->quot_no = $invoice_codes;
        }
        $sales->quot_date = $request->inv_date;
        $sales->vat = $request->vat;
        $sales->tax = $request->tax;
        $sales->remarks = $request->remarks;
        $sales->status = 0;
        $sales->is_sales = 0;
        $sales->mast_item_category_id = $type;
        $sales->mast_customer_id = $request->mast_customer_id;
        $sales->user_id = Auth::user()->id;
        $sales->save();

        if (isset($request->moreFile[0]['item_id']) && !empty($request->moreFile[0]['item_id'])) {
            foreach($request->moreFile as $item){
                $data = new QuotationDetails();
                $data->mast_item_register_id = $item['item_id'];
                $data->qty = $item['qty'];
                $data->status = 0;
                $data->price = $item['price'];
                
                $data->status = 1;
                if(isset($sal_id)){
                    $data->quotation_id = $sal_id;
                }else{
                    $data->quotation_id = $sales->id;
                }
                $data->user_id = Auth::user()->id;
                $data->save();
            }
        }
        if (isset($request->editFile[0]['item_id']) && !empty($request->editFile[0]['item_id'])) {
            foreach($request->editFile as $item){
                $data = QuotationDetails::findOrFail($item['id']);

                $data->mast_item_register_id = $item['item_id'];
                $data->qty = $item['qty'];
                $data->price = $item['price'];
                $data->status = 0;
                if(isset($sal_id)){
                    $data->quotation_id = $sal_id;
                }else{
                    $data->quotation_id = $sales->id;
                }
                $data->user_id = Auth::user()->id;
                $data->save();
            }
        }

        if(isset($sal_id)){
            $new_sales = Quotation::where('id', $sal_id)->first();
        }else{
            $new_sales = Quotation::where('id', $sales->id)->first();
        }
        $mastCustomer = $new_sales->mastCustomer;
        $mastItemCategory = $new_sales->mastItemCategory;
        $quotationDetails = $new_sales->quotationDetails;

        $total = 0;
        foreach ($quotationDetails as $key => $value) {
            $total += $value->qty * $value->price;
        }

        return response()->json([
            'sales' => $sales,
            'mastCustomer' => $mastCustomer,
            'mastItemCategory' => $mastItemCategory,
            'total' => $total,
        ]);
    }
    public function edit(Request $request)
    {
        $sales_details = QuotationDetails::where('quotation_id', $request->id)
        ->join('mast_item_registers', 'mast_item_registers.id', 'quotation_details.mast_item_register_id')
        ->join('mast_item_groups', 'mast_item_groups.id', 'mast_item_registers.mast_item_group_id')
        ->join('quotations', 'quotations.id', 'quotation_details.quotation_id')
        ->join('mast_units', 'mast_units.id', 'mast_item_registers.unit_id')        
        ->select('quotation_details.*','mast_item_registers.id as item_rg_id','mast_item_registers.part_no','mast_item_registers.box_qty','mast_units.unit_name','mast_item_groups.part_name','mast_item_groups.id as item_groups_id')
        ->get();
        
        $customer_type = MastCustomerType::where('status', 1)->get();
        $customer_type_id = Quotation::where('quotations.id', $request->id)
        ->join('mast_customers', 'mast_customers.id', 'quotations.mast_customer_id')
        ->join('mast_customer_types', 'mast_customer_types.id', 'mast_customers.mast_customer_type_id')
        ->select('mast_customer_types.id')
        ->first();
        $customer = MastCustomer::where('status', 1)->where('mast_customer_type_id', $customer_type_id->id)->get();
        
        $data=Quotation::where('id', $request->id)->first();
        return response()->json([
            'data' => $data,
            'customer' => $customer,
            'customer_type' => $customer_type,
            'customer_type_id' => $customer_type_id,
            'sales_details' => $sales_details,
        ]);
    }
    public function sales_destroy($id)
    {
        $data=Quotation::find($id);
        // $subTotal = $data->qty*$data->price;
        $data->delete();
        // return response()->json($subTotal);
        return response()->json('success');
    }
    /*=====================================
     *   Approve Sales
     *=====================================
     */
    function sales_approve_list () {
        $data= Quotation::where('status', 0)->orderBy('id', 'desc')->latest()->get();
        return view('layouts.pages.sales.sales_quotation.sales_approve',compact('data'));
    }
    public function getSalesApproveDetails(Request $request)
    {
        $data = QuotationDetails::all();
        // $data = QuotationDetails::where('quotation_details.quotation_id', $request->id)
        // ->join('quotations', 'quotations.id', 'quotation_details.quotation_id')
        // ->join('mast_item_registers', 'mast_item_registers.id', 'quotation_details.mast_item_register_id')
        // ->join('mast_item_groups', 'mast_item_groups.id', 'mast_item_registers.mast_item_group_id')
        // ->join('mast_item_categories', 'mast_item_categories.id', 'sales.mast_item_category_id')
        // ->select('quotation_details.*','quotations.quot_no','quotations.quot_date','mast_item_registers.part_no','mast_item_groups.part_name','mast_item_categories.cat_name')
        // ->get();

        $store = MastWorkStation::where('id', Auth::user()->id)->first();
        $sales = Quotation::where('quotations.id', $request->id)
        ->join('mast_customers', 'mast_customers.id', 'quotations.mast_customer_id')
        ->select('quotations.*','mast_customers.name')
        ->first();
        return response()->json([
            'data' => $data,
            'sales' => $sales,
            'store' => $store->store_name,
        ]);
    }
    public function approve($id)
    {
        $data = Quotation::findOrFail($id);
        $data->status = 1;
        $data->save();

        $notification=array('messege'=>'Leave approve successfully!','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function decline($id){
        $data = Quotation::findOrFail($id);
        $data->status = 2;
        $data->save();

        $notification=array('messege'=>'Canceled successfully!','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
    

    //-----------------------------------------
    public function getCustomerData(Request $request)
    {
        $data = MastCustomer::where('status', 1)->where('mast_customer_type_id', $request->part_id)->get();
        return view('layouts.pages.sales.sales.load-customer',compact('data'));
    }
    public function getDeleteMaster(Request $request)
    {
        $data=Quotation::find($request->id);
        $data->delete();
        return response()->json('success');
    }
}
