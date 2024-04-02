<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\InfoPersonal;
use App\Models\Master\MastDesignation;
use App\Models\Setup;
use App\Models\User;

class MastTechnicianController extends Controller
{
    public function technicianInformation()
    {
        $technicianId = Setup::first();
        $employ_id = InfoPersonal::where('mast_designation_id', $technicianId->services_technician)->pluck('emp_id');
        $tecnicianName = User::whereNotIn('id', $employ_id)->get();
        
        $technician = InfoPersonal::with('user')->with('mastDepartment')->with('mastDesignation')->where('mast_designation_id', $technicianId->services_technician)->get();
        return view('layouts.pages.master.technician.index', compact('technician','tecnicianName'));
    }
    public function technicianEdit(Request $request)
    {
        $technicianId = Setup::first();
        $getTechnicianData = InfoPersonal::with('user')->with('mastDepartment')->with('mastDesignation')->where('mast_designation_id', $technicianId->services_technician)->where('id',$request->id)->first()->toArray();
        $designation = MastDesignation::all();

            return response()->json([
                'getTechnicianData' => $getTechnicianData,
                'designation' => $designation,

            ]);
    }

    public function updateTechnician(Request $request)
    {
        $updateDesignation = InfoPersonal::find($request->sal_id);
        $updateDesignation->mast_designation_id  = $request->designation;
        $updateDesignation->save();
        return response()->json('success');
    }


    public function getDesignation(Request $request)
    {
        $desig =  InfoPersonal::with('mastDesignation')->where('emp_id',$request->id)->first()->toArray();
        $designation = MastDesignation::all();
        return response()->json([
            'desig' => $desig,
            'designation' => $designation,
        ]);
    }

    public function updateDesignation(Request $request)
    {
        InfoPersonal::updateOrCreate(
            ['emp_id' => $request->employee_id],
            [
                'mast_designation_id' => $request->designationId,
                'updated_at' => $request->assignDate,
            ]
        );
        return response()->json('success');
    }
}
