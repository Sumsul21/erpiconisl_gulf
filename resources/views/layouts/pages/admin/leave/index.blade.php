<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Leave Application List<span class="bg-blue-500 text-white rounded px-1 text-xs py-0.5"></span></h4>
                    @can('Role create')
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg_form"><i class="fa fa-plus"></i><span class="btn-icon-add" data-bs-toggle="modal"></span>Emergency Leave</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Employee Name</th>
                                    <th>Employee Code</th>
                                    <th>Email</th>
                                    <th>Number</th>
                                    <th class="text-right pr-4">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee as $key=> $row)
                                <tr>
                                    <td class="sorting_1"><img class="rounded-circle" src="{{asset('public')}}/images/profile/{{ $row->profile_photo_path }}" width="35" height="35" alt=""></td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->employee_code }}</td>
                                    <td>{{ $row->email}}</td>
                                    <td>{{ $row->contact_number}}</td>
                                    <td class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-success p-1 px-2 view_report" data-toggle="modal" data-id="{{ $row->id }}" data-target=".bd-example-modal-lg"><i class="fa fa-folder-open"></i><span class="btn-icon-add"></span>View</button>
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
    <!-- Leave Application Modal -->
    <div class="modal fade bd-example-modal-lg_form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @if (session()->has('success'))
                    <strong class="text-success">{{session()->get('success')}}</strong>
                @endif
                <form class="form-valide" data-action="{{ route('leave_application.store') }}" method="POST" enctype="multipart/form-data" id="add-user-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Emergency Leave Application</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Employee Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-7">
                                    <select class="form-control dropdwon_select" id="employeeName" name="emp_id">
                                        <option selected>Select</option>
                                        @foreach ($employee as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Employee Code</label>
                                <div class="col-lg-7">
                                    <label class="col-lg-7 col-form-label" id="employeeCode">GULF-XXXX</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Start Date
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-7">
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" placeholder="Enter Date.." value="{{old('start_date')}}" id="start_date">
                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">End Date
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-7">
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{old('end_date')}}" id="end_date">
                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Leave Type
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-7">
                                    <select class="form-control default-select" id="leave_type" name="mast_leave_id">
                                        <option disabled selected>Please select</option>
                                        @foreach ($leave_type as $row)
                                            <option value="{{$row->id}}">{{$row->leave_name}}</option>
                                        @endforeach
                                    </select> 
                                    @error('leave_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Contact Number
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-7">
                                    <input type="number" class="form-control @error('leave_contact') is-invalid @enderror" name="leave_contact" value="{{old('leave_contact')}}">
                                    @error('leave_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Leave Location</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control @error('leave_location') is-invalid @enderror" name="leave_location" placeholder="Enter location.." value="{{old('location')}}">
                                    @error('start_dates')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Leave Purpose</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control @error('purpose') is-invalid @enderror" name="purpose" placeholder="Enter purpose.." value="{{old('purpose')}}">
                                    @error('start_dates')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- View Leave Details-->
     <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Leave Application Details</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body pt-2">
                    <table class="table table-bordered table-responsive-sm leaves-table">
                        <div id="target-element"></div>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @push('script')
        <script>
            $(document).ready(function(){
                //---Save Data
                var form = '#add-user-form';
                $(form).on('submit', function(event){
                    event.preventDefault();

                    var url = $(this).attr('data-action');
                    var src = $('#redirect').attr('redirect-action');
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(response)
                        {
                            $(form).trigger("reset");
                            // alert(response.success);
                            // window.location.href = src;
                            // setTimeout(function() {
                            //     window.location.reload();
                            // }, 1000);
                            swal("Success Message Title", "Well done, you pressed a button", "success")
                            $('.bd-example-modal-lg_form').modal('hide');

                            //---Add Table Row
                            var row = '<tr id="row_todo_'+ response.id + '">';
                            row += '<td>' + response.name + '</td>';
                            row += '<td>' + response.leave_name + '</td>';
                            row += '<td>' + response.formattedDate1 + '</td>';
                            row += '<td>' + response.formattedDate2 + '</td>';
                            row += '<td>' + response.duration + '</td>';
                            row += '<td class="d-flex justify-content-end"> @if('+response.status == 0 +') <span class="badge light badge-warning"><i class="fa fa-circle text-warning mr-1"></i>Pending</span> @elseif ('+ response.qualification == 1+') <span class="badge light badge-success"><i class="fa fa-circle text-success mr-1"></i>Successful</span> @elseif ('+ response.qualification == 2+') <span class="badge light badge-danger"><i class="fa fa-circle text-danger mr-1"></i>Canceled</span> @endif' + '</td>';
                            
                            if($("#id").val()){
                                $("#row_todo_" + response.id).replaceWith(row);
                            }else{
                                $("#list_todo").prepend(row);
                            }
                            $("#form_todo").trigger('reset');
                            $("#leave_application_list").load(" #leave_application_list");
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li style="color:red">' + value + '</li>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Required data missing?',
                                html: '<ul>' + errorHtml + '</ul>',
                            });
                        }
                    });
                });
            });

            $(document).ready(function(){
                $.ajaxSetup({
                    headers:{
                        'x-csrf-token' : $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        <script>
            //----Current Date
            var d = new Date()
            var yr =d.getFullYear();
            var month = d.getMonth()+1
            if(month<10){month='0'+month}
            var date =d.getDate();
            if(date<10){date='0'+date}
            var c_date = yr+"-"+month+"-"+date;
            document.getElementById('start_date').value = c_date;
            document.getElementById('end_date').value = c_date;
        </script>
    @endpush
    
</x-app-layout>
<script>
    //Employee Name click show Code
    $('#employeeName').change(function(){
        var userId = $(this).val();
        $.ajax({
            url:'{{ route('get_employee_code') }}',
            method:'GET',
            dataType:"JSON",
            data:{userId},
            success:function(response){
                $('#employeeCode').html(response.employee_code);
            }
        });
    });
    //get Leave Details
    $(document).ready(function() {
        $('.table-responsive').on('click','.view_report',function(){
            let userId = $(this).data('id');
            $.ajax({
                url:'{{ route('get_emargency_leave_repot') }}',
                method:'GET',
                data:{userId:userId},
                success:function(response){
                    $('#target-element').html(response);
                }
            });
        });
    });
</script>

