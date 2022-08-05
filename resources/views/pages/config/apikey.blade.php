@section('title')
    {{title( 'CLEE APIs' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\PartenerComptes[] $apisKeys ;
 */
?>
@section('page')

    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="col-md-12">
            @if(Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
        </div>
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Mes clefs APIs</h4>
                            <span>Donne la liste de toutes les clés APIs du partenaire  </span>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <form id="addKey" style=" float: right" action="/partner/apikey/addkey" method="POST">
                        @csrf
                        <button onclick='addKey("addKey")' type="button" class="primary-api-digital btn btn-primary btn-outline-primary btn-block " >
                            <i  title="Ajouter un clef" class="ti-plus " ></i>
                            <span style=""> Ajouter une clé</span>
                        </button>
                    </form>
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
                                <label class="col-sm-2 col-form-label">Date de début</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_start}}" name="date_start" id="date_start" type="date"
                                           class="form-control form-control-normal" placeholder="Date de début">
                                </div>
                                {{--                 DATE START                --}}

                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Date de fin</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button onclick="window.location.href='/partner/apikey'" type="button"
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
                                <th>Clef</th>
                                <th>Actions</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($apisKeys as $apisKey)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$apisKey->id}}
                                        </span>
                                    </th>
                                    <td class="text-left"> <span class="currency " style="text-align: left !important;"> {{ $apisKey->name }} </span> </td>

                                    <td>
                                        <span class="currency" style="font-size: 25px">
                                               **********************************************
                                        </span>

                                    </td>
                                    <td style="width: 200px">
                                        <i onclick='showKey("{{$apisKey->app_key}}","{{$apisKey->name}}")' title="Voir le clef API" class="ti-eye " style="font-size: 25px;cursor: pointer;padding: 5px"></i>

                                        <form id="{{$apisKey->id}}" style="display: inline" action="/partner/apikey/regenerateKey/{{$apisKey->id}}" method="POST">
                                            @csrf
                                            <button type="button" style="margin: 0; padding: 0;border: none;background: transparent ">
                                                <i onclick='regenerateAppKey("{{$apisKey->id}}")'  title="Régénérer votre clef API " class="ti-reload " style="color: #fc6180;font-size: 25px;cursor: pointer; padding: 5px"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        {{ $apisKey->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="float: right">
                {{ $apisKeys->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
<script>
    function showKey(appKey,appName) {
        Notiflix
            .Report
            .info(
                appName,
                `<br>${appKey}<br>`,
                'FERMER',
                {
                    svgSize: '42px',
                    messageMaxLength: appKey.length,
                    plainText: true,
                },
            );
    }
    function regenerateAppKey(idForm) {
        let msg='Voulez-vous régénération votre clé API ?';
        Notiflix
            .Confirm
            .show('Régénération clé API ',msg,
                'Oui',
                'Non',
                () => {document.getElementById(idForm).submit()},
                () => {console.log('If you say so...');},
                { messageMaxLength: msg.length + 90,},);
    }
    function addKey(idForm) {
        let msg='Voulez-vous ajouter un nouveau clef API ?';
        Notiflix
            .Confirm
            .show('Ajout clé API ',msg,
                'Oui',
                'Non',
                () => {document.getElementById(idForm).submit()},
                () => {console.log('If you say so...');},
                { messageMaxLength: msg.length + 90,},);
    }
</script>
@endsection

@section('css')
@endsection
