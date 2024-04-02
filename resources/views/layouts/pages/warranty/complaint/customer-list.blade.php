<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> All Customer List</h4>
                    <a href="{{ route('warranty-complaint.index') }}" class="btn btn-sm btn-danger p-1 px-2 d-inline"><i class="fa fa-reply"></i></i><span class="btn-icon-add"></span>Back</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display " style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>SL.NO</th>
                                    <th>Customer Name</th>
                                    <th>Customer Number</th>
                                    <th>Address</th>
                                    <th>Customer Type</th>
                                    <th class="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allCustomer as $item )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->mastCustomerType->name }}</td>
                                            <td>
                                                <button type="button" id="add_item" data-toggle="modal" data-id="{{ $item->id }}" data-target=".bd-example-modal-lg" class="btn btn-sm btn-success p-1 px-2" ><i class="fa fa-plus"></i></i><span class="btn-icon-add"></span>Add New</button>
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

   <!-- add new click than modal open-->

   <div class="modal fade bd-example-modal-lg" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                   customer purchase List
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
                <div class="modal-body">
                    <form class="form-valide" action="{{ route('warranty-complaint.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body py-2 px-4">
                            <div class="row">
                                <input type="hidden" name="mast_customer_id" id="customeId" value="">
                                <input type="hidden" name="issue_date" id="date" value="">
                                <input type="hidden" name="" ISSUE id="" value="">
                                <div class="col-md-6">
                                    <label style="font-weight: bold">Customer Name : </label>
                                    <input type="" id="customerName" style="border: none" name="">

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-md-4">Compliant Type : </label>
                                        <div class="col-md-8">
                                           <select name="mast_complaint_type_id" id="" class="form-control">
                                                <option value="" selected disabled>--> Select a compliant type --> </option>
                                            @foreach ($compliantType as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                           </select>
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
                                            <th>Item Name</th>
                                            <th>Serial No</th>
                                            <th>Sale Date</th>
                                            <th>Instalation Location</th>
                                            <th>Warrenty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="delivary_data">

                                    </tbody>
                                </table>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="" class="col-md-2 col-form-label text-right"  style="font-weight: bold;margin-top:20px">Note:</label>
                                        <div class="col-md-10">
                                            <textarea name="note" id=""  rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="" class="col-md-2 col-form-label text-right" style="font-weight: bold;margin-top:20px">Remarks:</label>
                                        <div class="col-md-10">
                                            <textarea name="remarks" id=""  rows="3" class="form-control"></textarea>
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
       $(document).on('click', '#add_item', function(){
        var addNew_id = $(this).data('id');
        alert(addNew_id);
        $.ajax({
            url:'{{ route('get-customer-details')}}',
            method:'GET',
            dataType:"JSON",
            data:{'addNew_id':addNew_id},
            success:function(response){
                console.log(response);
                // alert(response.customerNameId);
                $('#customerName').val(response.customerName);
                $('#customeId').val(response.customerNameId);


                var tableBody = $('#delivary_data');
                 tableBody.empty();
                var delivaryData = response.getDelivary;
                $.each(delivaryData, function(index, item) {
                 var row = '<tr id="row_todo_'+ item.id + '">';
                row += '<td>' +  '<input type="checkbox" name="" value="">' + '</td>';
                row += '<td>' + item.item_code.part_no + '</td>';
                row += '<td>' + item.item_code.mast_item_group.part_name + '</td>';
                row += '<td>' + item.serial_no + '</td>';
                row += '<td>' + item.sale_date.inv_date + '</td>';
                row += '<td>' + item.warranty + '</td>';
                row += '<td><input type="text" name="warenty" value="' + item.warranty_status + '"></td>';
                row += '</tr>';
                tableBody.append(row);
            });

            },
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
    document.getElementById('date').value = c_date;
</script>





