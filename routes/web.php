<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ReportsController;
//--HR & Admin
use App\Http\Controllers\Admin\BackViewController;
use App\Http\Controllers\Admin\InfoEmployeeController;
use App\Http\Controllers\Admin\LeaveApplicationController;
use App\Http\Controllers\Admin\ManualAttendanceController;
//--Inventory
use App\Http\Controllers\Inventory\PurchaseController;
use App\Http\Controllers\Inventory\StoreTransferController;
//--Sales
use App\Http\Controllers\Sales\SalesQuotationController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Sales\SalesReturnController;
//--Warranty
use App\Http\Controllers\Warranty\ComplaintIssueController;
use App\Http\Controllers\Warranty\RequisitionController;
use App\Http\Controllers\Warranty\ServiceBillController;

//--Master Data
use App\Http\Controllers\Master\MastDepartmentController;
use App\Http\Controllers\Master\MastDesignationController;
use App\Http\Controllers\Master\MastLeaveController;
use App\Http\Controllers\Master\MastEmployeeTypeController;

use App\Http\Controllers\Master\MastUnitController;
use App\Http\Controllers\Master\MastItemCategoryController;
use App\Http\Controllers\Master\MastItemGroupController;
use App\Http\Controllers\Master\MastItemRegisterController;

use App\Http\Controllers\Master\MastCompliantTypeController;
use App\Http\Controllers\Master\MastTechnicianController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('auth.login');
});

//==================// Location //==================//
Route::get('/location', [LocationController::class, 'index'])->name('location');
Route::get('/get-districts', [LocationController::class, 'getDistricts'])->name('get_districts');
Route::get('/get-upazila', [LocationController::class, 'getUpazilas'])->name('get_upazila');
Route::get('/get-thana', [LocationController::class, 'getThanas'])->name('get_thana');


//____________________// START \\_________________//
Route::middleware([ 'auth:sanctum','verified', config('jetstream.auth_session')])->group(function () {
    Route::get('/dashboard', [BackViewController::class, 'dashboard'])->name('dashboard')->middleware('auth');
    Route::get('/coming_soon', [BackViewController::class, 'coming_soon'])->name('coming_soon')->middleware('auth');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});


Route::group(['middleware' => ['auth']], function(){
    /**______________________________________________________________________________________________
     * HR & ADMIN => Employee Register
     * ______________________________________________________________________________________________
     */
    //--Employee List
    Route::get('info_employee/list', [InfoEmployeeController::class, 'employee_list'])->name('info_employee.list');
    Route::get('info_employee/details/{id}', [InfoEmployeeController::class, 'employee_details'])->name('info_employee.details');
    Route::get('info_employee/edit/{id}', [InfoEmployeeController::class, 'employee_edit'])->name('info_employee.edit');
    Route::post('info_employee/update/{id}', [InfoEmployeeController::class, 'employee_update'])->name('info_employee.update');
    //--Employee Register
    Route::get('employee/register/create', [InfoEmployeeController::class, 'employee_create'])->name('employee_register.create');
    Route::post('employee/register/store', [InfoEmployeeController::class, 'employee_register'])->name('employee_register.store');
    Route::get('employee/register/destroy/{id}', [InfoEmployeeController::class, 'employee_destroy'])->name('employee_register.destroy');
    Route::post('/change-password/{id}', [InfoEmployeeController::class, 'profileUpdate'])->name('change.password');
    //--Personal Information
    Route::get('employee/info_prsonal/create/{id}', [InfoEmployeeController::class, 'personal_create'])->name('info_employee_prsonal.create');
    Route::post('employee/info_prsonal/store/{id}', [InfoEmployeeController::class, 'personal_store'])->name('info_employee_prsonal.store');
    //--Related Information
    Route::get('employee/info_related/create/{id}', [InfoEmployeeController::class, 'related_create'])->name('info_employee_related.create');
    Route::post('employee/info_related/store/{id}', [InfoEmployeeController::class, 'related_store'])->name('info_employee_related.store');
    
    Route::delete('info_related/education/destroy/{id}', [InfoEmployeeController::class, 'info_education_destroy'])->name('info_education.destroy');
    Route::delete('info_related/experience/destroy/{id}', [InfoEmployeeController::class, 'info_experience_destroy'])->name('info_experience.destroy');
    Route::delete('info_related/info_bank/destroy/{id}', [InfoEmployeeController::class, 'info_bank_destroy'])->name('info_bank.destroy');
    Route::delete('info_related/info_nominee/destroy/{id}', [InfoEmployeeController::class, 'info_nominee_destroy'])->name('info_nominee.destroy');

    /**______________________________________________________________________________________________
     * HR & ADMIN => Leave 
     * ______________________________________________________________________________________________
     */
    Route::get('leave/self', [LeaveApplicationController::class, 'leave_application'])->name('leave_self.create');
    Route::get('get/employee_code', [LeaveApplicationController::class, 'getEmployeeCode'])->name('get_employee_code');
    Route::post('leave_application/store', [LeaveApplicationController::class, 'store'])->name('leave_application.store');
    Route::get('emergency_leave/application', [LeaveApplicationController::class, 'emergency_leave'])->name('emergency_leave.create');
    Route::post('leave_application/store', [LeaveApplicationController::class, 'store'])->name('leave_application.store');
    Route::get('get/emargency_leave_repot', [LeaveApplicationController::class,'getLeaveApplication_report'])->name('get_emargency_leave_repot');
    //--Leave Department Approve
    Route::get('dept/approve_list', [LeaveApplicationController::class, 'dept_approve_list'])->name('dept_approve_list.create');
    Route::PATCH('leave_dept/approve/{id}', [LeaveApplicationController::class, 'dept_approve'])->name('leave_dept.approve');
    //--Leave HR Approve
    Route::get('hr/approve_list', [LeaveApplicationController::class, 'hr_approve_list'])->name('hr_approve_list.create');
    Route::PATCH('leave_hr/approve/{id}', [LeaveApplicationController::class, 'hr_approve'])->name('leave_hr.approve');
    Route::PATCH('leave_application/canceled/{id}', [LeaveApplicationController::class, 'decline'])->name('leave_application.canceled');

    /**______________________________________________________________________________________________
     * HR & ADMIN => Attendances
     * ______________________________________________________________________________________________
     */
    // Route::resource('manual_attendances', ManualAttendanceController::class);
    Route::get('manual_attendances/index', [ManualAttendanceController::class, 'index'])->name('manual_attendances.index');
    Route::post('manual_attendances/store', [ManualAttendanceController::class, 'store'])->name('manual_attendances.store');
    Route::post('attendances/attendanceId_store', [ManualAttendanceController::class, 'setUpAttendanceID'])->name('setup-attendance-store');
    Route::get('attendance/approve_list', [ManualAttendanceController::class, 'attendance_approve_list'])->name('attendance_approve.create');
    Route::PATCH('attendance/approve/{id}', [ManualAttendanceController::class, 'attendance_approve'])->name('attendance.approve');
    Route::PATCH('attendance/canceled/{id}', [ManualAttendanceController::class, 'decline'])->name('attendance.canceled');
    Route::get('get/get_attendance_repot/{id}', [ManualAttendanceController::class,'getAttendanceRepot'])->name('get_attendance_repot');
    Route::get('get/attendance/filter', [ManualAttendanceController::class, 'filterDate'])->name('get-attendance-filter');

    //--Attendances Imports or Exports Excel
    Route::get('attendance/import', [ManualAttendanceController::class, 'importAttendance'])->name('attendance.import');
    Route::post('attendance/upload', [ManualAttendanceController::class, 'uploadAttendance'])->name('attendance.upload');    
    Route::get('attendance/export', [ManualAttendanceController::class, 'exportAttendance'])->name('attendance.export'); 
    
    /**______________________________________________________________________________________________
     * Inventory => GRN
     * ______________________________________________________________________________________________
     */
    Route::get('inv/grn-purchase/index', [MovementController::class, 'grnPurchaseIndex'])->name('grn-purchase.index');
    Route::get('inv/grn-purchase/details/{id}', [MovementController::class, 'grnPurchaseDetails'])->name('grn-purchase-details');
    Route::post('inv/grn/purchase/store', [MovementController::class, 'grnPurchaseStore'])->name('grn-purchase.store');
    Route::get('inv/get-purchase/details', [MovementController::class, 'getPurchaseDetails'])->name('get_purchase_details');

    Route::get('inv/check-serial-number', [MovementController::class, 'checkSerialNumber'])->name('checkSerialNumber');
    Route::get('inv/purchase-parsial/{id}/details', [MovementController::class, 'parsialPurchaseDetails'])->name('purchase-details-parsial');
    Route::get('report/purchase-receive/{id}/pdf/download', [MovementController::class, 'generatePurchaseReceive'])->name('report-purchase-receive-parsial.download');
    /**______________________________________________________________________________________________
     * Inventory => Sales Delivery
     * ______________________________________________________________________________________________
     */
    Route::get('inv/sales-delivery/index', [MovementController::class, 'salesDeliveryIndex'])->name('sales-delivery.index');
    Route::get('inv/sales-delivery/details/{id}', [MovementController::class, 'salesDeliveryDetails'])->name('sales-delivery-details');
    Route::post('inv/sales-delivery/store', [MovementController::class, 'salesDeliveryStore'])->name('sales-delivery.store');
    Route::get('inv/get-sales-delivery/details', [MovementController::class, 'getSalesDetails'])->name('get_sales_details');
    
    Route::get('inv/sales-delivery-parsial/{id}/details', [MovementController::class, 'parsialSalesDeliveryDetails'])->name('sales-delivery-details-parsial');
    Route::get('inv/get-serial-no', [MovementController::class,'getSerialNumber'])->name('get-serial-no');
    Route::get('get-sales-delivery/slno', [MovementController::class,'getSalesDeliverySlNo'])->name('get-sales-delivery-slno');
    Route::get('report/sales-delivery/{id}/pdf/download', [MovementController::class, 'generateSalesDeliver'])->name('report-sales-delivery-parsial.download');
    /**______________________________________________________________________________________________
     * Inventory => Requstion Delivery
     * ______________________________________________________________________________________________
     */
    Route::get('inv/requstion-delivery/index', [MovementController::class, 'requstionDeliveryIndex'])->name('requstion-delivery.index');
    Route::get('inv/requstion-delivery/details/{id}', [MovementController::class, 'requstionDeliveryDetails'])->name('requstion-delivery-details');
    Route::post('inv/requstion-delivery/store', [MovementController::class, 'requstionDeliveryStore'])->name('requstion-delivery.store');
    Route::get('inv/get-requstion-delivery/details', [MovementController::class, 'getStoreTransferDetails'])->name('get_store_transfer_details');
    
    Route::get('inv/requstion-delivery-parsial/{id}/details', [MovementController::class, 'parsialRequstionDeliveryDetails'])->name('requstion-delivery-details-parsial');
    Route::get('report/requstion-delivery/{id}/pdf/download', [MovementController::class, 'generateRequstionDeliver'])->name('report-requstion-delivery.download');
    /**______________________________________________________________________________________________
     * Inventory => Purchase
     * ______________________________________________________________________________________________
     */
    Route::get('/purchase/cat_id={cat_id}',[PurchaseController::class,'index'])->name('inv_purchase.index');
    Route::post('/purchase/store/cat_id={cat_id}', [PurchaseController::class, 'store'])->name('inv_purchase.store');
    Route::get('purchase/edit',[PurchaseController::class,'edit'])->name('inv_purchase_edit');
    Route::delete('inv_purchase/destroy/{id}', [PurchaseController::class, 'inv_purchase_destroy'])->name('inv_purchase.destroy');
    Route::delete('inv_approve_purchase/{id}', [PurchaseController::class, 'approve_purchase'])->name('inv_approve_purchase');
    Route::get('/get-delete-master/purchase',[PurchaseController::class,'getDeleteMaster'])->name('getDelete-master-purchase');
    //--Purchase Approve
    Route::get('inv_purchase/approve_list', [PurchaseController::class, 'purchase_approve_list'])->name('inv_purchase_approve.create');
    Route::PATCH('inv_purchase/approve/{id}', [PurchaseController::class, 'approve_purchase'])->name('inv_purchase.approve');
    Route::PATCH('inv_purchase/canceled/{id}', [PurchaseController::class, 'decline'])->name('inv_purchase.canceled');
    Route::get('inv/get-purchase/approve/details', [PurchaseController::class, 'getPurchaseApproveDetails'])->name('get_purchase_approve_details');
    
    Route::get('/get-part-id',[PurchaseController::class,'getPartNumber'])->name('get-part-id');
    Route::get('/get-part-number',[PurchaseController::class,'getPartNo'])->name('get-part-number');
    Route::get('get/edit-part-id',[PurchaseController::class,'getEditPartNo'])->name('edit-part-id');
    /**______________________________________________________________________________________________
     * Inventory => Store Transfer
     * ______________________________________________________________________________________________
     */
    Route::get('store/transfer/cat_id={cat_id}',[StoreTransferController::class,'index'])->name('store_transfer.index');
    Route::post('store/transfer/store/cat_id={cat_id}', [StoreTransferController::class, 'store'])->name('store_transfer.store');
    Route::get('store/transfer/edit',[StoreTransferController::class,'edit'])->name('store_transfer.edit');
    Route::delete('store/transfer/destroy/{id}', [StoreTransferController::class, 'storeDetailsDestroy'])->name('store_transfer.destroy');
    Route::get('/get-delete-master/storeTransfer',[StoreTransferController::class,'getDeleteMaster'])->name('getDelete-master-storeTransfer');
    
    //--Store Transfer Approve
    Route::get('store/transfer/approve_list', [StoreTransferController::class, 'storeTransferApprove'])->name('store_transfer_approve.create');
    Route::PATCH('store/transfer/approve/{id}', [StoreTransferController::class, 'approve'])->name('store_transfer.approve');
    Route::PATCH('store/transfer/canceled/{id}', [StoreTransferController::class, 'decline'])->name('store_transfer.canceled');
    Route::get('get/store-transfer/approve/details', [StoreTransferController::class, 'getStoreTransferApproveDetails'])->name('get_store_transfer_approve_details');
    /**______________________________________________________________________________________________
     * Inventory => Reports
     * ______________________________________________________________________________________________
     */
     Route::get('report-purchase/recived',[ReportsController::class,'purchaseReceive'])->name('report-purchase-recived');
     Route::get('report-sales/delivery',[ReportsController::class,'salesDelivery'])->name('report-sales-delivery');
     Route::get('report-requstion/delivery',[ReportsController::class,'requstionDelivery'])->name('report-requstion-delivery');
    /**______________________________________________________________________________________________
     * Sales => Sales Quotation
     * ______________________________________________________________________________________________
     */
    Route::get('sales_quotation/cat_id={cat_id}',[SalesQuotationController::class,'index'])->name('sales_quotation.index');
    Route::post('sales_quotation/store/cat_id={cat_id}', [SalesQuotationController::class, 'store'])->name('sales_quotation.store');
    Route::get('sales_quotation/edit',[SalesQuotationController::class,'edit'])->name('sales_quotation.edit');
    Route::delete('sales_quotation/destroy/{id}', [SalesQuotationController::class, 'sales_destroy'])->name('sales_quotation.destroy');
    Route::get('/get-delete-master/sales_quotation',[SalesQuotationController::class,'getDeleteMaster'])->name('getDelete-master-sales_quotation');
    //--Sales Approve
    Route::get('sales_quotation/approve_list', [SalesQuotationController::class, 'sales_approve_list'])->name('sales_quotation_approve.create');
    Route::PATCH('sales_quotation/approve/{id}', [SalesQuotationController::class, 'approve'])->name('sales_quotation.approve');
    Route::PATCH('sales_quotation/canceled/{id}', [SalesQuotationController::class, 'decline'])->name('sales_quotation.canceled');
    Route::get('sales_quotation/get-sales/approve/details', [SalesQuotationController::class, 'getSalesApproveDetails'])->name('get_sales_quotation_approve_details');
    //--Get Data
    Route::get('get-customer/data',[SalesQuotationController::class,'getCustomerData'])->name('get-customer-data');

    /**______________________________________________________________________________________________
     * Sales => Sales
     * ______________________________________________________________________________________________
     */
     Route::get('sales/cat_id={cat_id}',[SalesController::class,'index'])->name('sales.index');
     Route::post('sales/store/cat_id={cat_id}', [SalesController::class, 'store'])->name('sales.store');
     Route::get('sales/edit',[SalesController::class,'edit'])->name('sales.edit');
     Route::delete('sales/destroy/{id}', [SalesController::class, 'sales_destroy'])->name('sales.destroy');
     Route::get('/get-delete-master/sales',[SalesController::class,'getDeleteMaster'])->name('getDelete-master-sales');
     //--Sales Approve
    Route::get('sales/approve_list', [SalesController::class, 'sales_approve_list'])->name('sales_approve.create');
    Route::PATCH('sales/approve/{id}', [SalesController::class, 'approve'])->name('sales.approve');
    Route::PATCH('sales/canceled/{id}', [SalesController::class, 'decline'])->name('sales.canceled');
    Route::get('sales/get-sales/approve/details', [SalesController::class, 'getSalesApproveDetails'])->name('get_sales_approve_details');
    /**______________________________________________________________________________________________
     * Sales => Sales Return
     * ______________________________________________________________________________________________
     */
     Route::get('sales/sales-return/index',[SalesReturnController::class,'index'])->name('sales-return.index');
     Route::post('sales/sales-return/store', [SalesReturnController::class, 'store'])->name('sales-return.store');
     Route::get('sales/get/sales-delivery/details',[SalesReturnController::class,'getSalesDeliveryDetails'])->name('get_sales_delivery_details');     
    /**______________________________________________________________________________________________
     * Sales => Sales Receive
     * ______________________________________________________________________________________________
     */
     Route::get('sales/sales-receive/index',[MovementController::class,'salesReceiveIndex'])->name('sales-receive.index');
     Route::get('sales/sales-receive/details/{id}',[MovementController::class,'salesReceiveDetails'])->name('sales-receive-details');
     Route::post('sales/sales-receive/store', [MovementController::class, 'salesReceiveStore'])->name('sales-receive.store');

     Route::get('sales/get-sales-return/details', [MovementController::class, 'getSalesReturnDetails'])->name('get_sales_return_details'); 
     Route::get('sales/get-sales-receive-page/details', [MovementController::class, 'getSalesReceivePage'])->name('get-sales-receive-page'); 
    /**______________________________________________________________________________________________
     * Warranty & Service => Complaint issue
     * ______________________________________________________________________________________________
     */
    Route::get('warranty/complaint-issue/index',[ComplaintIssueController::class,'index'])->name('warranty-complaint.index');
    Route::get('warranty/customer-list/show',[ComplaintIssueController::class,'showCustomerList'])->name('warranty-customer-list.show');
    Route::post('warranty/complaint-issue/store',[ComplaintIssueController::class,'store'])->name('warranty-complaint.store');

    Route::get('get/warranty/complaint-issue/show',[ComplaintIssueController::class,'getCompliantData'])->name('get-compliant-show');
    Route::get('get/warranty/customer-details',[ComplaintIssueController::class,'getCustomerDetails'])->name('get-customer-details');
    /**______________________________________________________________________________________________
     * Warranty & Service => Job Card
     * ______________________________________________________________________________________________
     */
    Route::get('job_card',[JobCardController::class,'movementIndex'])->name('job_card');
    Route::get('technician_add',[JobCardController::class,'technicianAdd'])->name('technician.add');
    /**______________________________________________________________________________________________
     * Warranty & Service => Technician Movement
     * ______________________________________________________________________________________________
     */
    Route::get('warranty/technician-movement/index ',[TechnicianMovementController::class,'movementIndex'])->name('technician-movement.index');

    /**______________________________________________________________________________________________
     * Warranty & Service => Tools Requisition
     * ______________________________________________________________________________________________
     */
    Route::get('warranty/tools-requisition/index',[RequisitionController::class,'indexTools'])->name('tools-requisition.index');
    Route::post('warranty/tools-requisition/store', [RequisitionController::class, 'storeTools'])->name('tools-requisition.store');

    Route::get('requisition/edit',[RequisitionController::class,'edit'])->name('inv_requisition_edit');
    Route::delete('inv_purchase/destroy/{id}', [RequisitionController::class, 'inv_purchase_destroy'])->name('inv_purchase.destroy');

    /**______________________________________________________________________________________________
     * Warranty & Service => Spare Part Requisition
     * ______________________________________________________________________________________________
     */
    Route::get('warranty/sparepart-requisition/index',[RequisitionController::class,'indexSparePart'])->name('spare-parts-requisition.index');
    Route::post('warranty/sparepart-requisition/store', [RequisitionController::class, 'storeTools'])->name('sparepart-requisition.store');
    /**______________________________________________________________________________________________
     * Warranty & Service => Service Bill
     * ______________________________________________________________________________________________
     */
    Route::get('warranty/service-bill/index',[ServiceBillController::class,'index'])->name('service-bill.index');

    Route::get('/get_bill',[ServiceBillController::class,'getBill'])->name('get-bill');
    Route::get('get/selse-edit-part-id',[ServiceBillController::class,'getSalesDetails'])->name('selse-edit-part-id');

});

Route::group(['middleware' => ['auth']], function(){
    /**______________________________________________________________________________________________
     * HR & ADMIN MASTER
     * ______________________________________________________________________________________________
     */
    Route::resource('mast_department', MastDepartmentController::class);
    Route::resource('mast_designation', MastDesignationController::class);
    Route::resource('mast_leave', MastLeaveController::class);
    Route::resource('must_employee_category', MastEmployeeTypeController::class);
    
    /**______________________________________________________________________________________________
     * INVENTORY MASTER
     * ______________________________________________________________________________________________
     */
    Route::resource('mast_unit', MastUnitController::class);
    Route::resource('mast_item_category', MastItemCategoryController::class);
    Route::resource('mast_item_group', MastItemGroupController::class);
    Route::resource('mast_item_register', MastItemRegisterController::class);
    Route::get('get-part/name',[MastItemRegisterController::class,'getPartName'])->name('get-part-name');
    Route::get('/pdf/download', [MastItemRegisterController::class, 'generateBarcode'])->name('item_pdf.download');
    Route::get('/item_export/excel', [MastItemRegisterController::class, 'export'])->name('item_export.excel');
    /**______________________________________________________________________________________________
     * SALES MASTER
     * ______________________________________________________________________________________________
     */
    Route::get('customer/cat_id={cat_id}',[SalesController::class,'indexCustomer'])->name('customer.index');
    Route::get('customer/create/cat_id={cat_id}',[SalesController::class,'createCustomer'])->name('customer.create');
    Route::post('customer/store',[SalesController::class,'storeCustomer'])->name('customer.store');
    /**______________________________________________________________________________________________
     * WARRENTY MASTER
     * ______________________________________________________________________________________________
     */
    Route::resource('mast_compliant_type', MastCompliantTypeController::class);
    // Setup Technician

    // Technician Update
    Route::get('technician.index',[MastTechnicianController::class,'technicianInformation'])->name('tecnician.index');
    Route::get('get-designation-Name',[MastTechnicianController::class,'getDesignation'])->name('get-designation-Name');
    Route::post('submit.technician',[MastTechnicianController::class,'updateDesignation'])->name('submit.technician');
    Route::get('technician.edit',[MastTechnicianController::class,'technicianEdit'])->name('technician.edit');
    Route::post('update.designation',[MastTechnicianController::class,'updateTechnician'])->name('update.designation');
    
});
/**______________________________________________________________________________________________
 * Dwonload File => PDF, EXCEL ETC
 * ______________________________________________________________________________________________
 */

/**______________________________________________________________________________________________
 * Dwonload File => PDF, EXCEL ETC
 * ______________________________________________________________________________________________
 */


//__________________________ TEST AJAX MODEL_____________________________//
use App\Http\Controllers\TodoController;
Route::get('/todos', [TodoController::class, 'index']);
Route::get('todos/{todo}/edit', [TodoController::class, 'edit']);
Route::post('todos/store', [TodoController::class, 'store']);
Route::delete('todos/destroy/{todo}', [TodoController::class, 'destroy']);

Route::get('get-procedure', function () {$id = 1; $post = DB::select("CALL get_users_by_id(".$id.")");dd($post);});