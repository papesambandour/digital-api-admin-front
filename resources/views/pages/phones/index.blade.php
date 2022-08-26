@section('title')
    {{title( 'VERSEMENT' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Phones[] $phones ;
 */
?>
@section('page')

    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Les Providers</h4>
                            <span>Donne la liste de tous API providers utilisé dans INTECH API </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
            <!-- Contextual classes table starts -->
            <div class="card">
                <div class="card-header">
                    <h5>Filtres</h5>
                    <div class="card-block">
                        <form>
                            <div class="form-group row">
                                {{--                 DATE START                --}}
                                <label class="col-sm-3 col-form-label">Date de début</label>
                                <div class="col-sm-3">
                                    <input value="{{$date_start}}" name="date_start" id="date_start" type="date"
                                           class="form-control form-control-normal" placeholder="Date de début">
                                </div>
                                {{--                 DATE START                --}}

                                {{--                 DATE START                --}}
                                <label class="col-sm-3 col-form-label">Date de fin</label>
                                <div class="col-sm-3">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>

                            </div>
                            <div class="form-group row">
                                {{--                 DATE START                --}}
                                {{--                 DATE START                --}}
                                <label class="col-sm-3 col-form-label">Montant min</label>
                                <div class="col-sm-3">
                                    <input value="{{$amount_min}}" name="amount_min" id="amount_min" type="text"
                                           class="form-control form-control-normal" placeholder="Montant min">
                                </div>


                                <label class="col-sm-3 col-form-label">Montant max</label>
                                <div class="col-sm-3">
                                    <input value="{{$amount_max}}" name="amount_max" id="amount_max" type="text"
                                           class="form-control form-control-normal" placeholder="Montant max">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Partenaires</label>
                                <div class="col-sm-3">
                                    <select name="_sous_services_id" id="_sous_services_id" class=""
                                            placeholder="Services">
                                        <option value="" selected> Tous les partenaires</option>

                                        @foreach($services as $service)
                                            <optgroup label="{{$service->name}}" ></optgroup>
                                            @foreach(getSousServicesByServiceId($service->id) as $sousService)
                                               <option value="{{$sousService->id}}"> {{$sousService->name}} </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/phones'" type="button"
                                            class="warning-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-delete"></i>Annuler
                                    </button>
                                </div>
                            </div>

                            <div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                            <tr>
                                <th># Id</th>
                                <th>Identifiant</th>
                                <th>Solde</th>
                                <th>Solde Api</th>
                                <th>Sous Services</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($phones as $phone)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$phone->id}}
                                        </span>
                                    </th>
                                    <td> <span class="currency"> {{ $phone->number }} </span> </td>
                                    <td> <span class="currency"> {{ $phone->solde}} XOF</span> </td>

                                    <td> <span class="statut-success">{{$phone->solde_api}} XOF </span> </td>
                                    <td>
                                        <span class="currency">  {{@$phone->sousServicesPhones[0]->sousService->name ?: 'Pas encore souscrit '}}</span>

                                    </td>
                                    <td>
                                        <span class="currency">  {{$phone->service->name}}</span>

                                    </td>
                                    <td>
                                        {{ $phone->created_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown-split-success">

                                            <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="/phones/verser/{{$phone->id}}">Verser</a>
                                                <a class="dropdown-item waves-light waves-effect" href="/phones/versement/{{$phone->id}}">Versement</a>
                                                <a class="dropdown-item waves-light waves-effect" href="/phones/souscription-service/{{$phone->id}}">Souscription Services</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="float: right">
                {{ $phones->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
    <script>
        $('#_sous_services_id').select2();
    </script>
@endsection

@section('css')
@endsection
