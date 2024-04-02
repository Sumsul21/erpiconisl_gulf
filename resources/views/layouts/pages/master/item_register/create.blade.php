<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- card header -->
                <div class="card-header">
                    <h4 class="card-title">Item Register</h4>
                    <a href="{{ route('mast_item_register.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-reply"></i><span class="btn-icon-add"></span>Back</a>
                </div>
                <!-- card body -->
                <div class="card-body">
                    <div class="form-validation">
                        <!-- this is for validation checking message -->
                        @if (session()->has('success'))
                            <strong class="text-success">{{session()->get('success')}}</strong>
                        @endif
                        <!-- this is from -->
                        <form class="form-valide mr-3" action="{{route('mast_item_register.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Box Code
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control  @error('box_code') is-invalid @enderror" name="box_code" value="{{old('box_code')}}" min="1" required>
                                                @error('box_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Gulf Code
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control @error('gulf_code') is-invalid @enderror" name="gulf_code" value="{{old('gulf_code')}}" min="1" required>
                                                @error('gulf_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Part Number
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control @error('part_no') is-invalid @enderror" name="part_no" value="{{old('part_no')}}" required>
                                                @error('part_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Box Quantity
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control @error('box_qty') is-invalid @enderror" name="box_qty" value="{{old('box_qty')}}" required>
                                                @error('box_qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Product Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control dropdwon_select" name="" id="productName" required>
                                                    <option value="" selected disabled>Please Select product Name</option>
                                                    <option value="1">AC</option>
                                                    <option value="2">AC Spare parts</option>
                                                    <option value="3">Car spare parts</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Part Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control dropdwon_select" id="loadPartName" name="mast_item_group_id" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Unit Type
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control dropdwon_select" name="unit_id" required>
                                                    <option value="" selected disabled>Please Select Unit Name</option>
                                                    @foreach ($unit as $row)
                                                        <option value="{{$row->id}}"{{ old('unit_id') == $row->id ? 'selected' : '' }}>{{ $row->unit_name}}</option>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Price
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}" step="any" required>
                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="image" class="col-md-4 col-form-label">Image</label>
                                            <div class="col-md-8">
                                                <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror">
                                                @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4 col-form-label">Warranty
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <select name="warranty" class="form-control default-select @error('warranty') is-invalid @enderror">
                                                    <option selected disabled>Choose...</option>
                                                    <option value="1">One Month</option>
                                                    <option value="2">Two Month</option>
                                                    <option value="3">Three Month</option>
                                                    <option value="6">Six Month</option>
                                                    <option value="12">1 Years</option>
                                                    <option value="24">2 Years</option>
                                                    <option value="36">3 Years</option>
                                                    <option value="48">4 Years</option>
                                                    <option value="60">5 Years</option>
                                                    <option value="72">6 Years</option>
                                                    <option value="84">7 Years</option>
                                                    <option value="96">8 Years</option>
                                                    <option value="108">9 Years</option>
                                                    <option value="120">10 Years</option>
                                                </select>
                                                @error('warranty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-md-4 col-form-label">Description</label>
                                            <div class="col-md-8">
                                                <textarea name="description" class="text form-control @error('description') is-invalid @enderror" rows="1">{{old('description')}}</textarea>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm float-right">Submit</button>
                                </div>
                            </div>

                        <form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).on('change','#productName',function () {
        var productId = $(this).val();
        $.ajax({
            url:'{{route('get-part-name')}}',
            method:'GET',
            dataType:"html",
            data:{'part_name': productId},
            success: function(data){
                console.log(data)
                    $('#loadPartName').html(data);
                 }
        });
    });
</script>