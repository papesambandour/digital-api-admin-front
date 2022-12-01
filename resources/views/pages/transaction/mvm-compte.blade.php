@section('title')
    {{title( 'VERSEMENT' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\OperationParteners[] $mouvements ;
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

                            @if(getPartnerI())
                                <h4>Les mouvements compte pour  {{partner()->name}}</h4>
                                <span>Donne la liste de toutes les entrées et sorties du compte : <span style="color:green;font-weight: bold"> {{partner()->name}}</span>  </span>
                            @else
                                <h4>Mouvement Compte </h4>
                                <span>Donne la liste de toutes les entrées et sorties des comptes partenaires </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{--IMPORT BUTTON START--}}
                    <button onclick="exportExcel('import-excel','Mouvements Comptes ')"    type="button" id="import-excel"
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
                                <x-partner col_l="3" col_s="3"/>
                                <x-operation col_l="3" col_s="3"/>
                            </div>
                            <div class="form-group row">

                                <x-type-operation col_l="3" col_s="3"/>
                                <div class="col-sm-3">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/mvm-compte'" type="button"
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
                                <th>Solde Avant</th>
                                <th>Solde Apres</th>
                                <th>Partenaire</th>
                                <th>Operation de </th>
                                <th>Provenance </th>
                                <th>Justificatif  </th>
                                <th>Transaction  </th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mouvements as $mouvement)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$mouvement->id}}
                                        </span>
                                    </th>
                                    <td> <span class="currency"> {{ ($mouvement->amount) }} XOF</span> </td>
                                    <td> <span class="currency"> {{ number($mouvement->solde_befor) }} XOF</span> </td>
                                    <td> <span class="currency"> {{ number($mouvement->solde_after) }} XOF</span> </td>
                                    <td> <span class="currency"> {{ $mouvement->partener->name }} </span> </td>

                                    <td> <span class="statut-success">{{$mouvement->type_operation}} </span> </td>
                                    <td> <span class="statut-infos" >{{$mouvement->operation}} </span> </td>
                                    <td>
                                        @if($mouvement->link)
                                            <a class="currency" href="{{$mouvement->link}}" target="_blank">Voir </a>
                                        @else
                                            N\A
                                        @endif
                                    </td>
                                    <td>
                                        @if($mouvement->transactions_id)
                                            <a class="currency" href="/transaction/details/{{$mouvement->transactions_id}}" >Voir </a>
                                        @else
                                            N\A
                                        @endif
                                    </td>
                                    <td>
                                        {{ $mouvement->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="float: right">
                {{ $mouvements->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')

@endsection

@section('css')
@endsection
