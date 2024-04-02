<x-app-layout>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        .head th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 5px;

        }
        .body tr td{
            border: 1px solid #dddddd;
            text-align: left;
             padding: 5px;
        }
        </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Job Card list</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display">
                            <thead>
                                <tr style="text-align: center">
                                    <th>Tecnician name</th>
                                    <th>Tecnician Id</th>
                                    <th>Job No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tecnician as $item )
                                <tr style="text-align: center">
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->user->employee_code }}</td>
                                    <td>1/3</td>
                                    <td>
                                        <button type="button" id="tech_data" data-toggle="modal" data-id="{{ $item->id }}"  data-target=".bd-example-modal-lg" class="btn btn-sm btn-success p-1 px-2" ><i class="fa fa-pencil"></i></i><span class="btn-icon-add"></span>Add</button>
                                        <button type="button" id="edit_data" data-toggle="modal" data-id=""  data-target="" class="btn btn-sm btn-info p-1 px-2" ><i class="fa fa-pencil"></i></i><span class="btn-icon-add"></span>view</button>
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


    <!-- add modal open-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                   Technician New List
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
                <div class="modal-body">
                    <form class="form-valide" data-action="" method="POST" enctype="multipart/form-data" id="add-user-form">
                        @csrf
                        <div class="modal-body py-2 px-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Date
                                        </label>
                                        <div class="col-md-9">
                                          <input type="date" class="form-control" id="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">New Complian &nbsp;
                                            <input type="checkbox">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-5 col-form-label" style="margin-left: -25px">Technician Name
                                        </label>
                                        <div class="col-md-7" style="margin-left: -19px; margin-top:5px">
                                          <input type="text" placeholder="" id="techName" style="border: none">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" style="margin-left: -13px">Job No
                                        </label>
                                        <div class="col-md-6">
                                          <input type="text"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <table>
                                    <thead class="head">
                                        <tr style="background-color:darkseagreen;color:black">
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Compliant Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody class="body">
                                        @foreach ($compliant as $item )
                                            <tr>
                                                <td>{{ $item->issue_date }}</td>
                                                <td>{{ $item->custo->name }}</td>
                                                <td>{{ $item->remarks }}</td>
                                                <td>{{ $item->status == 0 ? 'new':'' }}</td>
                                                <td><button type="button" >assign work</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                            </div>


                        </div>
                        <div class="modal-footer" style="height:50px">
                            <button type="submit" class="btn btn-sm btn-primary submit_btn">Submit</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>

</x-app-layout>


<script>
    $(document).on('click', '#tech_data', function(){
       var id = $(this).data('id');
       alert(id);

       $.ajax({
           url:'{{ route('technician.add')}}',
           method:'GET',
           dataType:"JSON",
           data:{'id':id},
           success:function(response){
               console.log(response);
               $('#techName').val(response.name);
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
    document.getElementById('date').value = c_date;
</script>
