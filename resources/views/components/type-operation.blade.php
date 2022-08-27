@props(['col_l' => 2])
@props(['col_s' => 2])
<label class="col-sm-{{$col_l}} col-form-label">Types Operations</label>
<div class="col-sm-{{$col_s}}">
    <select name="{{getTypeOperationRequestName()}}" id="{{getTypeOperationRequestName()}}" class=""
            placeholder="Services">
        <option value="" selected> Tous les operations</option>

        @foreach($typeOperations as $typeOperation)
            <option @if(getTypeOperation() ==  $typeOperation) selected
                    @endif value="{{$typeOperation}}"> {{$typeOperation}} </option>
        @endforeach
    </select>
</div>

