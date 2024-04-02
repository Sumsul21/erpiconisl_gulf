<x-app-layout>
    <!-- Leave Application -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @if (session()->has('success'))
                    <strong class="text-success">{{session()->get('success')}}</strong>
                @endif
                <form class="form-valide" data-action="{{ route('leave_application.store') }}" method="POST" enctype="multipart/form-data" id="add-user-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Self Leave Application</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Employee Name</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" value="{{auth()->user()->name}}" disabled>
                                    <input type="hidden" name="employee_name" class="form-control" value="{{auth()->user()->name}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">Employee Code</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" value="{{auth()->user()->employee_code}}" disabled>
                                    <input type="hidden" name="emp_id" class="form-control" value="{{auth()->user()->id}}">
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Leave Application List<span class="bg-blue-500 text-white rounded px-1 text-xs py-0.5"></span></h4>
                    @can('Role create')
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i><span class="btn-icon-add" data-bs-toggle="modal"></span>Create</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <th>Employee Name</th>
                                <th>Leave Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th class="text-right">Status</th>
                            </thead>
                            <tbody id="list_todo">
                                @foreach($data as $row)
                                    <tr id="row_todo_{{ $row->id}}">
                                        <td>{{ $row->user->name}}</td>
                                        <td>{{ $row->mastLeave->leave_name}}</td>
                                        <td>{{date("j F, Y", strtotime($row->start_date))}}</td>
                                        <td>{{date("j F, Y", strtotime($row->end_date))}}</td>
                                        <td>{{ $row->duration}}</td>
                                        <td class="d-flex justify-content-end">
                                            @if($row->status == 3)
                                            <span class="badge light badge-danger">
                                                <i class="fa fa-circle text-danger mr-1"></i>Canceled
                                            </span>
                                            @elseif($row->status == 2)
                                            <span class="badge light badge-success">
                                                <i class="fa fa-circle text-success mr-1"></i>Successful
                                            </span>
                                            @else
                                            <span class="badge light badge-warning">
                                                <i class="fa fa-circle text-warning mr-1"></i>Pending
                                            </span>
                                            @endif
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
                        $('.bd-example-modal-lg').modal('hide');

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
    
        if(month<10){
            month='0'+month
        }
    
        var date =d.getDate();
        if(date<10)
        {
            date='0'+date
        }
        var c_date = yr+"-"+month+"-"+date;
        document.getElementById('start_date').value = c_date;
        document.getElementById('end_date').value = c_date;
    </script>
</x-app-layout>