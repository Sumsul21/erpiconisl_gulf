<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Working Station List<span class="bg-blue-500 text-white rounded px-1 text-xs py-0.5"></span></h4>
                    {{-- @can('Role create') --}}
                    <a href="{{ route('mast_working_station.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i><span class="btn-icon-add"></span>Create</a>
                    {{-- @endcan --}}
                </div>
                <div class="card-body"> 
                    <p class="text-center text-success">{{Session::has('message') ? Session::get('message') : ''}}</p>
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Working Station Name</th>
                                    <th>Contact Number</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>status</th>
                                    <th class="text-right pr-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($station as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>										
                                    <td>{{ $data->working_station_name }}</td>										
                                    <td>{{ $data->contact_number }}</td>										
                                    <td>{{ $data->location }}</td>										
                                    <td>{{ $data->description }}</td>										
                                    <td>{{ $data->status == 1 ? 'active' : 'inactive'  }}</td>																			
                                    <td class="float-right">                                
                                        <a href="{{ route('mast_working_station.edit', $data->id) }}" class="btn btn-success btn-sm">Edit</a>
                                        <a href="{{ route('mast_working_station.show', $data->id) }}" class="btn btn-info btn-sm">View</a>                                                              
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
</x-app-layout>
