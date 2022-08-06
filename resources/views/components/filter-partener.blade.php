<label class="col-sm-2 col-form-label">Services</label>
<div class="col-sm-2">
    <select name="_partener_" id="_partener_" class=""
            placeholder="Services">
        <option value="" selected> Sélectionnez un service</option>

        @foreach($partners as $partner)
            <option @if(getPartnerI() ==  $partner->id) selected
                    @endif value="{{$partner->id}}"> {{$partner->name}} </option>
        @endforeach
    </select>
</div>

