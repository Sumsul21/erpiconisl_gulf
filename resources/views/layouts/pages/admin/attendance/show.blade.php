<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Attendance List<span class="bg-blue-500 text-info rounded px-1 text-xs py-0.5">({{ $user->name ?? '' }})</span></h4>
                    @can('Role create')                    
                    <a href="{{route('attendance.export')}}" class="btn btn-primary btn-xs py-1 my-1"><i class="fa fa-download"></i><span class="btn-icon-add"></span>Download</a>
                    @endcan
                </div>
                <div class="card-body">
                    <!-- Add your HTML markup here -->
                    {{-- <select id="month-filter">
                        <option value="5">January</option>
                        <option value="4">January2</option>
                    </select> --}}
                    <a href="{{url('get-procedure')}}" class="btn btn-primary btn-xs">Store Procedure</a>
                    <div class="table-responsive">
                        {{-- <table class="table table-bordered table-responsive-sm" style="min-width: 500px"> --}}
                        {{-- <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>SL NO</th>
                                    <th>Date</th>
                                    <th>In time</th>
                                    <th>Out time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->date }}</td>
                                        <td>{{ $row->in_time }}</td>
                                        <td>{{ $row->out_time }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
<script>
    $(document).ready(function() {
        // Function to trigger the AJAX request
        function filterData(month) {
            
            alert(month);
            $.ajax({
                url: "{{ route('filter.attendance') }}",
                method: 'POST',
                data: { month: month },
                success: function(response) {
                    alert('hi')
                    // Update the data container with the filtered data
                    $('#data-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('fail')
                }
            });
        }

        // Handle the change event of the month filter
        $('#month-filter').on('change', function() {
            var selectedMonth = $(this).val();
            filterData(selectedMonth);
        });
    });
</script>

