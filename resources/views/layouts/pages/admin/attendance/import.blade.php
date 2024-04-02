<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- card header -->
                <div class="card-header">
                    <h4 class="card-title">Import Attendance</h4>
                    {{-- <a href="{{route('manual_attendances.index')}}" class="btn btn-sm btn-primary"><i class="fa fa-reply"></i><span class="btn-icon-add"></span>Back</a> --}}
                </div>
                <!-- card body -->
                <form method="POST" action="{{route('attendance.upload')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                        
                            <div class="col-md-12 mb-3 mt-3">
                                <p>Please Upload CSV in Given Format <a href="{{ asset('public/attendance.csv') }}" style="color:red;" target="_blank">Sample CSV Format</a></p>
                                {{-- <p>Please Upload CSV in Given Format <a href="{{ asset('files/sample-data-sheet.csv') }}" target="_blank">Sample CSV Format</a></p> --}}
                            </div>
                            {{-- File Input --}}
                            <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>File Input (Datasheet)</label>
                                <input  type="file" class="form-control form-control-user @error('file') is-invalid @enderror" id="exampleFile" name="file" value="{{ old('file') }}">
                                @error('file')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                        </div>
                    </div>
        
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Upload Users</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>