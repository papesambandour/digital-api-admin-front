@props(['col_id' => ''])
@props(['col_l' => 2])
@props(['col_s' => 2])
@props(['col_require' => false])
@props(['col_name' => 'Tous les sous services'])

<label class="col-sm-{{$col_l}} col-form-label">Sous Services</label>
<div class="col-sm-{{$col_s}}">
    <select @if($col_require) required @endif name="_sous_services_id" id="_sous_services_id" class=""
            placeholder="Services">
        <option value="" selected> Tous les sous services</option>
        @foreach($services as $service)
            <optgroup label="{{$service->name}}" ></optgroup>
            @foreach(getSousServicesByServiceId($service->id) as $sousService)
                <option @if($col_id == $sousService->id  or getSousServiceId() == $sousService->id) selected @endif value="{{$sousService->id}}"> {{$sousService->name}} </option>
            @endforeach
        @endforeach
    </select>
</div>
