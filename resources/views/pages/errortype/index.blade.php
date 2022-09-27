@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\ErrorType[] $entities ;
 */
?>
@section('page')

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
                            <h4> Type erreurs</h4>
                            <span>Donne la liste de tous les types erreurs   </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                        <button onclick="window.location.href='/error_type/create'" type="button"
                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                            <i title="Ajouter un clef" class="ti-plus "></i>
                            <span style=""> Ajouter un type erreur</span>
                        </button>

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
                                <div class="col-sm-3">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/error_type'" type="button"
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
                                <th>Code</th>
                                <th>Index</th>
                                <th>Regex</th>
                                <th>Message Critique</th>
                                <th>Message en json</th>
                                <th>Sous Services</th>
                                <th>Date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entities as $entity)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$entity->id}}
                                        </span>
                                    </th>
                                    <td class="text-center"><span class="currency"> {{ $entity->code }} </span> </td>
                                    <td class="text-center">{{$entity->index}} </td>
                                    <td class="text-center">{{$entity->regex}} </td>
                                    <td class="text-center">
                                    @if($entity->is_critic== 1)
                                        <span class="statut-success">OUI</span>
                                    @else
                                       <span class="statut-infos">NON</span>
                                    @endif
                                    </td>
                                    <td class="text-center">
                                        @if($entity->is_json== 1)
                                            <span class="statut-success">OUI</span>
                                        @else
                                            <span class="statut-infos">NON</span>
                                        @endif
                                    </td>
                                    <td class="currency">
                                        {{ @$entity->sousService->name ?: 'N\A' }}
                                    </td>
                                    <td>
                                        {{ $entity->created_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown-split-success">

                                            <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="/error_type/{{$entity->id}}">Voir infos</a>
                                                <a class="dropdown-item waves-light waves-effect" href="/error_type/{{$entity->id}}/edit">Modifier infos</a>
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
                {{ $entities->links('pagination::bootstrap-4') }}
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
