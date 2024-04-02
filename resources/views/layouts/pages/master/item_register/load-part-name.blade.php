<option value="" selected disabled>Please Select Part Name</option>
@foreach ($getpartName as $row)
    <option value="{{$row->id}}" {{ old('mast_item_group_id') == $row->id ? 'selected' : '' }}>{{ $row->part_name}}</option>
    @endforeach