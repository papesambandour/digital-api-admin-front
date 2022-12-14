@section('title')
    {{title( 'VERSEMENT' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\OperationParteners[] $versements ;
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
                            <h4>Les Versements services providers</h4>
                            <span>Donne la liste de tous les versements des services providers </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{--IMPORT BUTTON START--}}
                    <button onclick="exportExcel('import-excel','Versement Services Providers')"    type="button" id="import-excel"
                            class="primary-api-digital btn btn-primary btn-outline-primary import-excel">
                        <i title="" class="ti-import "></i>
                        <span style=""> Exporter Excel</span>
                        <i hidden id="import-excel-sniper" class="fas fa-spinner fa-pulse"></i>
                    </button>
                    {{--IMPORT BUTTON END--}}
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
                                <label class="col-sm-3 col-form-label">Services Providers</label>
                                <div class="col-sm-3">
                                    <select name="phones_id" id="phones_id" class=""
                                            placeholder="Services">
                                        <option value="" selected> Tous les services providers</option>

                                        @foreach($phones as $phone)
                                            <option @if($phones_id ==  $phone->id) selected
                                                    @endif value="{{$phone->id}}">

                                                ({{$phone->id}})   {{$phone->number }}
                                                - {{@$phone->sousServicesPhones[0]->sousService->name ?: 'Pas encore souscrit a un sous service'}}


                                            </option>
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
                                    <button onclick="window.location.href='/versement-phones'" type="button"
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
                                <th>Montant</th>
                                <th>Services Provider</th>
                                <th>Operation de </th>
                                <th>Utilisateur Responsable  </th>
                                <th>Justificatif  </th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($versements as $versement)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$versement->id}}
                                        </span>
                                    </th>
                                    <td> <span class="currency"> {{ $versement->amount }} XOF</span> </td>
                                    <td> <span class="currency">

                                        ({{$versement->phone->id}})   {{$versement->phone->number }}
                                                - {{@$versement->phone->sousServicesPhones[0]->sousService->name ?: 'Pas encore souscrit a un sous service'}}
                                        </span> </td>

                                    <td> <span class="statut-success">{{$versement->type_operation}} </span> </td>
                                    <td> <span class="statut-success">{{@$versement->user->f_name ?: 'unknown'}} {{@$versement->user->l_name ?: 'unknown'}} </span> </td>
                                    <td>
                                        @if($versement->link)
                                            <a class="currency" href="{{$versement->link}}" target="_blank">Voir </a>
                                        @else
                                            N\A
                                        @endif
                                    </td>
                                    <td>
                                        {{ $versement->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="float: right">
                {{ $versements->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
    <script>
        $("#phones_id").select2();
    </script>
@endsection

@section('css')
@endsection
