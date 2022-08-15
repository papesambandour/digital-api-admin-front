@section('title')
    {{title( 'SOUS SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\SousServices[] $sousServices ;
 */
?>
@section('page')
    <div id="app">
        <div class="page-wrapper" >
            <!-- Page-header start -->
            <div class="page-header card">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="icofont icofont-table bg-c-blue"></i>
                            <div class="d-inline">

                                @if(getPartnerI())
                                    <h4>Sous Services Permis pour {{partner()->name}}</h4>
                                <span>Donne la liste de tous les Sous Services permis pour le partenaire : <span style="color:green;font-weight: bold"> {{partner()->name}}</span>  </span>
                                @else
                                    <h4>Sous Services </h4>
                                 <span>Donne la liste de tous les Sous Services disponible </span>
                                @endif
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
                                    <x-partner col_l="3" col_s="3"/>
                                    <div class="col-sm-3">
                                        <button type="submit"
                                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                                class="icofont icofont-search"></i>Rechercher
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button onclick="window.location.href='/partner/service'" type="button"
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
                        <input type="hidden" id="_data_" value="{{json_encode($sousServices->items())}}">
                        <div class="table-wrapper">
                            <table class="fl-table">
                                <thead>
                                <tr>
                                    <th># Id</th>
                                    <th>Libelle</th>
                                    <th>Service</th>
                                    <th>Type Service</th>
                                    <th>Date</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sousServices as $sousService)
                                    <tr>
                                        <th scope="row">
                                            <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                                {{$sousService->id}}
                                            </span>
                                        </th>
                                        <td class="text-left"> <span class="currency"> {{ $sousService->name }} </span> </td>
                                        <td class="text-left"> <span class=""> {{ $sousService->service->name }} </span> </td>
                                        <td class="text-left"> <span class="currency"> {{ $sousService->typeService->name }} </span> </td>

                                        <td>
                                            {{ $sousService->created_at }}
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown-split-success">
                                                <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only"></span>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <div class="dropdown-divider"></div>
                                                    <button v-on:click='openModal("{{$sousService->id}}")' type="button"   class="dropdown-item waves-light waves-effect" >Configurer frais</button>
                                                    <button v-on:click='showDetails("{{$sousService->id}}")' type="button"   class="dropdown-item waves-light waves-effect" >Voir details</button>
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
                    {{ $sousServices->links('pagination::bootstrap-4') }}
                </div>

            </div>
            <!-- Contextual classes table ends -->
        </div>
        <!-- Page-body end -->

        {{--  MODAL START  --}}

        <div class="modal fade" id="modalFraisSouService" tabindex="-1" role="dialog" aria-labelledby="modalFraisSouServiceLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFraisSouServiceLabel"> @{{ title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        {{--  MODAL END  --}}
        {{--  MODAL DETAILS START  --}}

        <div class="modal  fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailsLabel"> Details Sous Service @{{ sousService.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                     <table class="table table-striped table-bordered table-hover table-details">
                         <tr v-for=" (value,key) in sousServiceMapping">
                             <td style="width: 50%">
                                 @{{ sousServiceMapping[key].name || key}}
                             </td>

                             <td  v-html="sousServiceMapping[key].value">

                             </td>
                         </tr>
                     </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="primary-api-digital btn btn-primary btn-outline-primary btn-block" data-dismiss="modal">Fermer</button>
{{--                        <button type="button" class="btn btn-primary">Save changes</button>--}}
                    </div>
                </div>
            </div>
        </div>
        {{--  MODAL DETAILS END  --}}
    </div>
@endsection

@section('js')

    <script>
        const app = new Vue({
            el: '#app',
            data: {
                page:1,
                title:"CONFIGURATION",
                sousServices: {},
                sousService: {},
                sousServiceMapping: {

                },

            },
            methods: {
              openModal(idService){
                  $('#modalFraisSouService').modal('show');
                  this.sousService= this.getSousService(idService);
              },
                showDetails(idService){
                  $('#modalDetails').modal('show');
                  this.sousService= this.getSousService(idService);
                  this.sousServiceMapping= this.mapping(this.sousService);
                    console.log(this.sousService.regex_message_validation)
              },
            mapping(sousService){
               return {
                   'id':{
                       name:'#ID',
                       value: sousService.id
                   },
                   'code':{
                       name:'Code',
                       value: sousService.code
                   },
                    'name':{
                        name:'Libelle',
                        value: sousService.name
                    },
                    'service':{
                        name:'Service',
                        value: sousService?.service?.name
                    },
                    'typeService':{
                        name:'Type Service',
                        value: sousService?.typeService?.name
                    },
                    'regex_phone':{
                        name:'Validation Phone',
                        value: sousService?.regex_phone
                    },
                    'regex_message_validation':{
                        name:'Message de validation',
                        value: sousService?.regex_message_validation
                    },
                    'position_validation_index':{
                        name:'Position des paramètres',
                        value: `<pre>${ JSON.stringify(JSON.parse(sousService?.position_validation_index), undefined, 2) } </pre>`
                    },
               }
            },
            getSousService(idService){
              return this.sousServices.find((sousService)=> +sousService.id === +idService);
            }
            },
            computed: {},
            created() {
            this.sousServices = JSON.parse($("#_data_").val());
            },
        });
    </script>
@endsection

@section('css')

@endsection
