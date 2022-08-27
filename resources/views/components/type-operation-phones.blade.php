@props(['col_l' => 2])
@props(['col_s' => 2])
<label class="col-sm-{{$col_l}} col-form-label">Operations</label>
<div class="col-sm-{{$col_s}}">
    <select name="{{getOperationRequestName()}}" id="{{getOperationRequestName()}}" class=""
            placeholder="Operations">
        <option value="" selected> Tous les operations</option>

        @foreach($operations as $operation)
            <option @if(getOperation() ==  $operation) selected
                    @endif value="{{$operation}}"> {{$operation}} </option>
        @endforeach
    </select>
</div>

