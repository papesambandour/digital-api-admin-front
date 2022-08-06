@props(['col_l' => 2])
@props(['col_s' => 2])
<label class="col-sm-{{$col_l}} col-form-label">Partenaires</label>
<div class="col-sm-{{$col_s}}">
    <select name="_partener_" id="_partener_" class=""
            placeholder="Services">
        <option value="" selected> Tous les partenaires</option>

        @foreach($partners as $partner)
            <option @if(getPartnerI() ==  $partner->id) selected
                    @endif value="{{$partner->id}}"> {{$partner->name}} </option>
        @endforeach
    </select>
</div>

