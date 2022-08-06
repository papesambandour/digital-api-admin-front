@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Parteners[] $partners ;
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
                            <h4> Partenaires</h4>
                            <span>Donne la liste de tous les partenaires   </span>
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
                                <label class="col-md-3 col-form-label">Date de fin</label>
                                <div class="col-sm-3">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-partner col_l="3" col_s="3"/>
                                <div class="col-sm-3">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/partners'" type="button"
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
                                <th>Libelle</th>
                                <th>Email</th>
                                <th>Solde</th>
                                <th>État</th>
                                <th>Date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partners as $partner)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$partner->id}}
                                        </span>
                                    </th>
                                    <td class="text-center"><span class="currency"> {{ $partner->name }} </span></td>
                                    <td class="text-center">{{$partner->email}} </td>
                                    <td class="text-center"><span class="currency"> {{ $partner->solde }} XOF</span>
                                    </td>

                                    <td>
                                        {{ $partner->state }}
                                    </td>
                                    <td>
                                        {{ $partner->created_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown-split-success">

                                            <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Verser</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Versements</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Afficher ses transactions</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Dashboard</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Services Permis</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Lister les services</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#">Gain Générer à partir du partenaires</a>
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
                {{ $partners->links('pagination::bootstrap-4') }}
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
