@section('title')
    {{title( 'SOUS SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Services[] $services ;
 */
?>
@section('page')
    <div id="app">

        <div class="page-wrapper">
            <div class="col-md-12">
                @if(Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif
            </div>

            <div class="col-md-12">
                @if(Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif
            </div>
            <!-- Page-header start -->
            <div class="page-header card">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="icofont icofont-table bg-c-blue"></i>
                            <div class="d-inline">

                                @if(getPartnerI())
                                    <h4>Services Permis pour {{partner()->name}}</h4>
                                    <span>Donne la liste de tous les Sous Services permis pour le partenaire : <span
                                            style="color:green;font-weight: bold"> {{partner()->name}}</span>  </span>
                                @else
                                    <h4>Services </h4>
                                    <span>Donne la liste de tous les Services disponible </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{--IMPORT BUTTON START--}}
                        <button onclick="exportExcel('import-excel','Services')"    type="button" id="import-excel"
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
                                    <x-partner col_l="3" col_s="3"/>
                                    <div class="col-sm-3">
                                        <button type="submit"
                                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block">
                                            <i
                                                class="icofont icofont-search"></i>Rechercher
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button onclick="window.location.href='/service'" type="button"
                                                class="warning-api-digital btn btn-primary btn-outline-primary btn-block">
                                            <i
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
                                    <th>Libelle</th>
                                    <th>Statut</th>
                                    <th>Operateur</th>
                                    <th>Categorie Service</th>
                                    <th>Solde Système</th>
                                    <th>Solde Stock</th>
                                    <th>Date</th>
{{--                                    <th>Options</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($services as $service)
                                    <tr>
                                        <th scope="row">
                                            <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                                {{$service->id}}
                                            </span>
                                        </th>
                                        <td class="text-left"><span class="currency"> {{ $service->name }} </span> </td>
                                        <td class="text-left">

                                            @if($service->state == STATE['ACTIVED'])
                                                <span class="currency">
                                                {{ $service->state }}
                                            </span>
                                            @else
                                                <span >
                                                {{ $service->state }}
                                            </span>
                                            @endif
                                        </td>
                                        <td class="text-center"><span class="currency"> {{ $service->operator->name }} </span>
                                        </td>
                                        <td class="text-center"><span class=""> {{ $service->categoriesService->name }} </span>
                                        </td>
                                        <td class="text-right"><span class="currency"> {{ soldeServiceSystem($service->id) }} XOF </span>
                                        </td>
                                        <td class="text-right "><span class="currency"> {{ soldeServiceStock($service->id) }} XOF</span>
                                        </td>

                                        <td>
                                            {{ $service->created_at }}
                                        </td>
                                       {{-- <td>
                                            <div class="btn-group dropdown-split-success">
                                                <button
                                                    style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px"
                                                    type="button"
                                                    class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only"></span>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                     style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <div class="dropdown-divider"></div>
                                                    <a  href="/sous_services/"
                                                             class="dropdown-item waves-light waves-effect pointer">
                                                        Voir sous services
                                                    </a>

                                                </div>
                                            </div>
                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div style="float: right">
                    {{ $services->links('pagination::bootstrap-4') }}
                </div>

            </div>
            <!-- Contextual classes table ends -->
        </div>
        <!-- Page-body end -->


@endsection



@section('css')

@endsection
