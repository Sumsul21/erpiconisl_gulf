<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Complaint List</h4>
                    <a href="{{ route('warranty-customer-list.show') }}" class="btn btn-sm btn-success p-1 px-2"><i class="fa fa-plus"></i></i><span class="btn-icon-add"></span>Create</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display " style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Issue No</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th class="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->issue_no }}</td>
                                        <td>{{ $item->issue_date }}</td>
                                        <td>{{ $item->custo->name }}</td>
                                        <td>{{ $item->custo->phone }}</td>
                                        <td>@if($item->status == 0)
                                            <span class="badge light badge-warning">
                                                <i class="fa fa-circle text-warning mr-1"></i>Pending
                                            </span>
                                            @elseif($item->status == 1)
                                            <span class="badge light badge-success">
                                                <i class="fa fa-circle text-success mr-1"></i>Successful
                                            </span>
                                            @elseif($item->status == 2)
                                            <span class="badge light badge-danger">
                                                <i class="fa fa-circle text-danger mr-1"></i>Canceled
                                            </span>
                                            @endif
                                        </td>
                                        <td>

                                            <button type="button" id="view_compliant" data-toggle="modal" data-id="{{ $item->id }}"  data-target=".bd-example-modal-lg" class="btn btn-sm btn-info p-1 px-2" ><i class="fa fa-pencil"></i></i><span class="btn-icon-add"></span>view</button>
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


    <!-- view modal open-->

    <div class="modal fade bd-example-modal-lg" id="view-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        compliant view
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form class="form-valide" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body py-2 px-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label style="font-weight: bold">Customer Name : </label>
                                        <input type="text" readonly id="customerName" style="border: none">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4">Compliant Type : </label>
                                            <div class="col-md-8">
                                                <input type="text" readonly id="complianttype" style="border: none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table id="example3" class="display " style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>SL.NO</th>
                                                <th>Item Code</th>
                                                <th>Warrenty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td>#</td>
                                                    <td><input type="text" id="code" style="border: none"></td>
                                                    <td><input type="text" id="warranty" style="border: none"></td>
                                                </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <label for="" class="col-md-2 col-form-label text-right" style="font-weight: bold;margin-top:20px">Remarks:</label>
                                            <div class="col-md-10">
                                                <textarea name="remarks" id="remarks"  rows="3" class="form-control"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer" style="height:50px">
                                <button type="submit" class="btn btn-sm btn-primary submit_btn">submit</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    $(document).on('click', '#view_compliant', function(){
     var compliant_id = $(this).data('id');
     alert(compliant_id);

     $.ajax({
            url:'{{ route('get-compliant-show')}}',
            method:'GET',
            dataType:"JSON",
            data:{'compliant_id':compliant_id},
            success:function(response){
                console.log(response);
                $('#customerName').val(response.viewCompliant.custo.name);
                $('#complianttype').val(response.viewCompliant.compliant_type.name);
                $('#remarks').val(response.viewCompliant.remarks);
                $('#code').val(response.viewCompliant.note);
                $('#warranty').val(response.viewCompliant.with_warranty == 1?'Yes':'no');


            }
        });
 });
</script>
