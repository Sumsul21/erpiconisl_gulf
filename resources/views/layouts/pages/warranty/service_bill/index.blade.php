<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Service Bill</h4>
                </div>
                <div class="card-body">           
                    <div class="form-group row">
                        <label class="col-md-2 mt-2"><h5>Start Date: </h5></label>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="end_date" placeholder="Enter Date.." id="date">
                        </div>
                        <label class="col-md-2 mt-2"><h5>End Date: </h5></label>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="end_date" placeholder="Enter Date.." id="dateTwo">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example3" class="display " style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Issue No</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Mobile</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="text-center">Service Bill</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @foreach($service as $data)
                                    <tr>
                                        <td>{{ $data->issue_no}}</td>
                                        <td>{{ $data->issue_date}}</td>
                                        <td>{{ $data->complaintType->name}}</td>
                                        <td>{{ $data->complaintType->phone}}</td>
                                        <td>{{ $data->remarks}}</td>
                                        <td>@if($data->status == 0)
                                              <span class="badge light badge-warning">
                                                <i class="fa fa-circle text-warning mr-1"></i>Pending
                                              </span>
                                                @elseif($data->status == 1)
                                                <span class="badge light badge-success">
                                                    <i class="fa fa-circle text-success mr-1"></i>Successful
                                                </span>
                                                @elseif($data->status == 2)
                                             <span class="badge light badge-danger">
                                             <i class="fa fa-circle text-danger mr-1"></i>Canceled
                                            </span>
                                            @endif
                                            </td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-sm btn-primary p-1 px-2" id="service_bill" data-id="{{ $data->id }}"><i class="fa fa-folder-open"></i></i><span class="btn-icon-add"></span>View</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Service Bill
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-valide" data-action="" method="POST" enctype="multipart/form-data" id="add-user-form">
                    @csrf
                    <div class="modal-body py-2">
                        <div class="row" id="main-row-data">
                            <input type="hidden" name="pur_id" id="pur_id">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Complaint ID</label>
                                    <div class="col-md-7">
                                        <label class="col-md-5 col-form-label" id="inv_no">GULF-XXXXX</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Customer Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        {{-- <option value="{{$data->id}}">{{$data->complaintType->name}}</option> --}}
                                        <label class="col-md-5 col-form-label" id="inv_no">Serniabat</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Complaint Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="date" name="inv_date" id="inv_date" class="form-control" value="{{ old('date') ? old('date'):  date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Technician Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <label class="col-md-5 col-form-label" id="inv_no">Raju Khan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Requisition No.</label>
                                    <div class="col-md-7">
                                        <label class="col-md-5 col-form-label" id="inv_no">GL-56789</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Requisition Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="date" name="inv_date" id="inv_date" class="form-control" value="{{ old('date') ? old('date'):  date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="" class="col-md-2">Technician Visits</label>
                                    <div class="col-md-10">
                                        <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control" style="width: 95%; margin-left: 45px;"></textarea>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!--=====//Table//=====-->
                                <div class="table-responsive">
                                    <table id="items-table" class="table table-bordered">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th width="20%">Date</th>
                                                <th width="20%">Technician Name</th>
                                                <th width="35%">Observe Details</th>
                                                <th width="20%">Action
                                                    <button type="button"  title="Add"
                                                    onclick=""
                                                    class="btn btn-icon btn-outline-warning border-0 btn-xs mr-2 new_add">
                                                    <span class="fa fa-plus"></span>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <tr>
                                                <td>07/20/2023</td>
                                                <td>Car Spare Parts</td>
                                                <td>Gas Change</td>
                                                <td>
                                                    <div style="display: flex">
                                                        <button id="new_add" type="button" title="Add" onclick="" class="btn btn-icon btn-outline-warning border-0 btn-xs mr-2 new_add">
                                                            <span class="fa fa-plus"></span>
                                                        </button>

                                                        <button type='button' id="cut_new" title="Remove"
                                                                data-row='row1'
                                                                onclick=""
                                                                class='btn btn-icon btn-outline-danger btn-xs border-0 mr-2 cut_new'>
                                                            <span class='fa fa-trash'></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!--=====//Table//=====-->
                                <div class="table-responsive">
                                    <table id="items-table" class="table table-bordered">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th width="15%">Item Code</th>
                                                <th width="15%">Item Name</th>
                                                <th width="10%">Pkg</th>
                                                <th width="10%">Unit</th>
                                                <th width="10%">Price</th>
                                                <th width="10%">Qty</th> 
                                                <th width="15%">Total</th> 
                                                <th width="15%" class="text-center table_action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <tr>
                                                <td>GL-5678</td>
                                                <td>Car Spare Parts</td>
                                                <td>1*4</td>
                                                <td>Box</td>
                                                <td>500</td>
                                                <td>10</td>
                                                <td>5000</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger" id="" data-id=""><i class="fa fa-trash" ></i><span class="btn-icon-add"></span>Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="height:50px">
                        <button type="button" class="btn btn-sm btn-danger light" data-dismiss="modal">Print</button>
                        <button type="submit" class="btn btn-sm btn-primary submit_btn">Submit</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>


<script>

    $(document).on('click','#service_bill',function () {
        var item_id = $(this).data('id');
        alert(item_id);

        $.ajax({
            url:'{{ route('get-bill')}}',
            method:'GET',
            dataType:"JSON",
            data:{'item_id':item_id},
            success:function(response){
                console.log(response);
                $('#complaintType').val(response.complaintType.name);
                // $('#complianttype').val(response.viewCompliant.compliant_type.name);
                // $('#remarks').val(response.viewCompliant.remarks);
                // $('#code').val(response.viewCompliant.note);
                // $('#warranty').val(response.viewCompliant.with_warranty == 1?'Yes':'no');

            }
        });
    });
    

</script>


<script>
    var d = new Date()
    var yr =d.getFullYear();
    var month = d.getMonth()+1

    if(month<10){
        month='0'+month
    }

    var date =d.getDate();
    if(date<10)
    {
        date='0'+date
    }

    var c_date = yr+"-"+month+"-"+date;
    
    document.getElementById('dateTwo').value = c_date;
</script>


<script>
    var d = new Date();
    var yr = d.getFullYear();
    var month = d.getMonth() + 1;

    if (month < 10) {
        month = '0' + month;
    }

    var date = '01'; // Always set the date to 01 for the first day of the month

    var c_date = yr + '-' + month + '-' + date;
    document.getElementById('date').value = c_date;
</script>


<script>


    $("#audit-design-matrix-table").on("click", "#new_add", function() {
        $('#audit-design-matrix-table > tbody:last').append(
        `<tr class="audit_design_matrix_row">
        <td><input type="text" name="" class="form-control"></td>
                <td>
                    <div style="display: flex">
                         <button id="new_add" type="button" title="Add"
                        onclick=""
                        class="btn btn-icon btn-outline-warning border-0 btn-xs mr-2 new_add">
                        <span class="fa fa-plus"></span>
                        </button>

                        <button type='button' title="Remove"
                     data-row='row1'
                         onclick=""
                         class='btn btn-icon btn-outline-danger btn-xs border-0 mr-2 cut_new'>
                        <span class='fa fa-trash'></span>
                        </button>
                        </div>
                 </td>
        </tr>`
    );
    });

    $("#audit-design-matrix-table").on("click", "#cut_new", function() {
        $(this).closest("tr").remove();
    });

</script>