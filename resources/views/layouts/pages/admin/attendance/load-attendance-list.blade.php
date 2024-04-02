<table class="table table-bordered table-responsive-sm" style="min-width: 500px">
    <thead>
        <tr>
            <th>SL#</th>
            <th>Employee ID</th>
            <th>Username</th>
            <th>Day</th>
            <th>Date</th>
            <th>In time</th>
            <th>Out time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->employee_code }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('D') }}</td>
                <td>{{ $row->date }}</td>
                <td>{{ \Carbon\Carbon::parse($row->in_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($row->out_time)->format('g:i A') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="dataTables_info">Showing {{ count($data) }} entries</div>
