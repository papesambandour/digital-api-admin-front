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
        <div class="page-wrapper">
            <!-- Page-header start -->
            <div class="page-header card">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="icofont icofont-table bg-c-blue"></i>
                            <div class="d-inline">

                                @if(getPartnerI())
                                    <h4>Sous Services Permis pour {{partner()->name}}</h4>
                                    <span>Donne la liste de tous les Sous Services permis pour le partenaire : <span
                                            style="color:green;font-weight: bold"> {{partner()->name}}</span>  </span>
                                @else
                                    <h4>Sous Services </h4>
                                    <span>Donne la liste de tous les Sous Services disponible </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @if( !partnerDetail())
                        <button v-on:click="showModalAddService()" type="button"
                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                            <i title="Ajouter un clef" class="ti-plus "></i>
                            <span style=""> Ajouter une sous services</span>
                        </button>
                            @endif
                        @if(getPartnerI())
                            <button v-on:click="addSubServiceModal()" type="button"
                                    class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                                <i title="Ajouter un clef" class="ti-plus "></i>
                                <span style=""> Configurer sous services pour <span class="currency"> {{partner()->name}}</span></span>
                            </button>
                        @endif
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
                                        <button onclick="window.location.href='/sous-service'" type="button"
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
                        {{--                        {{dd($sousServices->items())}}--}}
                        <input type="hidden" id="_data_sous_services" value="{{json_encode($sousServices->items())}}">
                        <input type="hidden" id="_data_type_services" value="{{json_encode($typeServices)}}">
                        <input type="hidden" id="_data_services" value="{{json_encode($services)}}">
                        <input type="hidden" id="_data_partner" value="{{json_encode(partner())}}">
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
                                        <td class="text-left"><span class="currency"> {{ $sousService->name }} </span>
                                        </td>
                                        <td class="text-left"><span class=""> {{ $sousService->service->name }} </span>
                                        </td>
                                        <td class="text-left"><span
                                                class="currency"> {{ $sousService->typeService->name }} </span></td>

                                        <td>
                                            {{ $sousService->created_at }}
                                        </td>
                                        <td>
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
                                                    <button v-on:click='showDetails("{{$sousService->id}}")'
                                                            type="button"
                                                            class="dropdown-item waves-light waves-effect pointer">Voir
                                                        details
                                                    </button>
                                                    @if(partner())
                                                        <button
                                                            v-on:click='configCommissionModal("{{$sousService->id}}")'
                                                            type="button"
                                                            class="dropdown-item waves-light waves-effect pointer">
                                                            Configurer frais <span class="currency"> {{partner()->name}}</span></button>

                                                    @endif
                                                    <button v-on:click='showModalUpdateService("{{$sousService->id}}")'
                                                            type="button"
                                                            class="dropdown-item waves-light waves-effect pointer">
                                                        Modifier le service
                                                    </button>

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

        {{--  MODAL FRAIX START  --}}

        <div class="modal fade" id="modalFraisSouService" tabindex="-1" role="dialog"
             aria-labelledby="modalFraisSouServiceLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFraisSouServiceLabel">
                            Configuration des frais du service
                            <span class="currency">
                                @{{ sousService.name  }}
                            </span>

                            pour le partenaire
                            <span class="currency">
                                @{{ partners.name }}
                            </span>

                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form v-on:submit.prevent="addCommission()" class="modal-body">
                        <table class="fl-table">
                            <thead>
                            <tr>
                                <th>Montant de debut</th>
                                <th>Montant de fin</th>
                                <th>Taux frais</th>
                                <th>Montant frais</th>
                                <th>Taux commission</th>
                                <th>Montant commission</th>
                                <th>Options</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="commission in commissions">
                                <td>@{{ commission.amount_start }}</td>
                                <td>@{{ commission.amount_end }}</td>
                                <td>@{{ commission.taux_fee }}</td>
                                <td>@{{ commission.amount_fee }}</td>
                                <td>@{{ commission.taux_commission }}</td>
                                <td>@{{ commission.amount_commssion }}</td>
                                <td>
                                    <button v-if="isTheLastComm(commission)" class="warning-api-digital btn btn-primary btn-outline-primary btn-block"
                                            type="button" v-on:click="deleteCommission(commission,$event)">
                                        <i class="ti-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="hr">
                        <div style="margin-top:50px" v-if="!isLast()">
                            <div class="form-group row" >
                                <label for="amount_start" class="col-sm-3 col-form-label">Montant de debut</label>
                                <div class="col-sm-3">
                                    <input :min="getMinStart()" :max="getMinStart()" name="amount_start" id="amount_start" v-model="commission.amount_start"
                                           type="number"
                                           class="form-control form-control-normal" placeholder="Montant de debut">
                                </div>


                                <label for="amount_start" class="col-sm-3 col-form-label">Montant de fin</label>
                                <div class="col-sm-3">
                                    <input :min="getMinEnd()" name="amount_end" id="amount_end" v-model="commission.amount_end" type="number"
                                           class="form-control form-control-normal" placeholder="Montant de fin">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="taux_fee" class="col-sm-3 col-form-label">Taux frais</label>
                                <div class="col-sm-3">
                                    <input name="taux_fee" id="taux_fee" v-model="commission.taux_fee" type="number"
                                           class="form-control form-control-normal" placeholder="Taux frais">
                                </div>

                                <label for="amount_fee" class="col-sm-3 col-form-label">Montant frais</label>
                                <div class="col-sm-3">
                                    <input name="amount_fee" id="amount_fee" v-model="commission.amount_fee" type="number"
                                           class="form-control form-control-normal" placeholder="Montant frais">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="taux_commission" class="col-sm-3 col-form-label">Taux commission</label>
                                <div class="col-sm-3">
                                    <input name="taux_commission" id="taux_commission" v-model="commission.taux_commission"
                                           type="number"
                                           class="form-control form-control-normal" placeholder="Taux commission">
                                </div>
                                <label for="amount_commssion" class="col-sm-3 col-form-label">Montant commission</label>
                                <div class="col-sm-3">
                                    <input name="amount_commssion" id="amount_commssion"
                                           v-model="commission.amount_commssion" type="number"
                                           class="form-control form-control-normal" placeholder="Montant frais">
                                </div>

                            </div>
                            <div class="text-center">
                                <button :disabled="isLast()" class="primary-api-digital btn btn-primary btn-outline-primary "
                                        type="submit" >
                                    <i class="ti-plus"></i> Ajouter une ligne de frais
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button  style="margin: 0 !important;" type="button"
                                class="btn btn-secondary btn-outline-secondary btn-block" data-dismiss="modal">Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--  MODAL FRAIX END  --}}

        {{--  MODAL ADD UPDATE START  --}}
        <div class="modal fade" id="modalEditAdd" tabindex="-1" role="dialog" aria-labelledby="modalEditAddLabel"
             aria-hidden="true">
            <form v-on:submit.prevent="submit('edit')" class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditAddLabel">Modification du service @{{ sousService.name
                            }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{--INPUT ITEM--}}
                        {{--                        <div class="form-group row" v-for="(formBuilder,key) in sousServiceMapping"  v-html="formItemBuilder(formBuilder,key,sousService)">--}}
                        <div class="form-group row" v-for="(formBuilder,key) in sousServiceMapping">
                            {{--                 DATE START                --}}
                            <label v-if="(formBuilder.edit || formBuilder.add) " class="col-sm-4 col-form-label">@{{
                                formBuilder.name }}</label>
                            <div class="col-sm-8">
                                <input :disabled="(!formBuilder.add && isAdd) || (!formBuilder.edit && !isAdd) "
                                       :id="formBuilder.key" :name="formBuilder.key"
                                       v-if="(formBuilder.edit || formBuilder.add) && formBuilder.type === 'text'"
                                       v-model="sousService[formBuilder.key]"
                                       :type="formBuilder.input"
                                       class="form-control form-control-normal sensible" :placeholder="formBuilder.name">
                                <textarea :disabled="(!formBuilder.add && isAdd) || (!formBuilder.edit && !isAdd) "
                                          :id="formBuilder.key" :name="formBuilder.key" rows="5"
                                          v-if="(formBuilder.edit || formBuilder.add) && formBuilder.type === 'textarea'"
                                          v-model="sousService[formBuilder.key]"
                                          :type="formBuilder.input"
                                          class="form-control form-control-normal" :placeholder="formBuilder.name">
                                </textarea>
                                <select :disabled="(!formBuilder.add && isAdd) || (!formBuilder.edit && !isAdd) "
                                        v-select2 :id="formBuilder.key" :name="formBuilder.key" multiple
                                        v-if="(formBuilder.edit || formBuilder.add) && formBuilder.type === 'select' && formBuilder.multiple"
                                        v-model="sousService[formBuilder.key]"
                                        class="form-control form-control-normal" :placeholder="formBuilder.name">
                                    {{--                                    <option  value="">Please select one</option>--}}
                                    <option v-for="(item,key) in formBuilder.items" :value="item.value"> @{{ item.name
                                        }}
                                    </option>
                                </select>
                                <select :disabled="(!formBuilder.add && isAdd) || (!formBuilder.edit && !isAdd) "
                                        v-select2 :id="formBuilder.key" :name="formBuilder.key"
                                        v-if="(formBuilder.edit || formBuilder.add) && formBuilder.type === 'select' && !formBuilder.multiple"
                                        v-model="sousService[formBuilder.key]"
                                        class="form-control form-control-normal" :placeholder="formBuilder.name">
                                    {{--                                    <option  value="">Please select one</option>--}}
                                    <option v-for="(item,key) in formBuilder.items" :value="item.value">
                                        @{{ item.name }}
                                    </option>
                                </select>
                                <div v-if=" formBuilder?.no_valid" class="invalid-feedback "> @{{
                                    formBuilder.no_valid}}
                                </div>

                            </div>

                        </div>
                        {{--INPUT ITEM--}}
                    </div>
                    <div class="modal-footer">
                        <button style="margin: 0 !important;" type="submit"
                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block"
                        >Enregistrer
                        </button>
                        <button style="margin: 0 !important;" type="button"
                                class="btn btn-secondary btn-outline-secondary btn-block" data-dismiss="modal">Fermer
                        </button>
                    </div>
                </div>
            </form>
        </div>
        {{--  MODAL ADD UPDATE END  --}}

        {{--  MODAL DETAILS START  --}}
        <div class="modal  fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailsLabel"> Details Sous Service @{{ sousService.name
                            }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered table-hover table-details">
                            <tr v-for=" (value,key) in sousServiceMapping">
                                <td class="primary-text font-weight-bold" style="width: 50%">
                                    @{{ sousServiceMapping[key].name}}
                                </td>

                                <td class="currency" v-html="sousServiceMapping[key].value">

                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="primary-api-digital btn btn-primary btn-outline-primary btn-block"
                                data-dismiss="modal">Fermer
                        </button>
                        {{--                        <button type="button" class="btn btn-primary">Save changes</button>--}}
                    </div>
                </div>
            </div>
        </div>
        {{--  MODAL DETAILS END  --}}


        {{--  MODAL DETAILS START  --}}
        <div class="modal  fade" id="addSubServiceModal" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <form v-on:submit.prevent="saveSubServicePermit()"  class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailsLabel"> Services Autorisés pour le partenaire @{{ partners.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

         {{-- ---------------------------------------------------------------------------------------------------------------------------------- --}}

                        <div class="form-group row" >
                            {{--                 DATE START                --}}
                            <label class="col-sm-12 col-form-label">Services Autorisés</label>
                            <hr>
                            <div class="col-sm-12">
                                <select v-if="init" multiple v-select2 id="_autorise_service"
                                        v-model="sousServicePartners"
                                        class="form-control form-control-normal" placeholder="Services autorisé">
                                    {{--                                    <option  value="">Please select one</option>--}}
                                    <option v-for="(ss,key) in allSousServices" :value="ss.id">
                                        @{{ ss.name }}
                                    </option>
                                </select>

                            </div>


          {{-- ---------------------------------------------------------------------------------------------------------------------------------- --}}

                    </div>
                    <div class="modal-footer">
                        <button style="margin: 0 !important;" type="submit"
                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block"
                        >Enregistrer
                        </button>
                        <button style="margin: 0 !important;" type="button"
                                class="btn btn-secondary btn-outline-secondary btn-block" data-dismiss="modal">Fermer
                        </button>
                    </div>
                </div>
            </form>
        </div>
        {{--  MODAL DETAILS END  --}}
    </div>
@endsection

@section('js')
    <script src="/assets/js/components/sous_services.js">

    </script>
@endsection

@section('css')

@endsection
