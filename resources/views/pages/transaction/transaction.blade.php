@section('title')
    {{title( 'TRANSACTIONS' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Transactions[] $transactions ;
 * @var \App\Models\SousServices[] $sous_services ;
 */
?>
@section('page')
<section id="app">
    <div  class="page-wrapper">
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
                            <h4>{{$title}}</h4>
                            <span>{{$subTitle}} </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <button v-on:click="downloadVirementExcel()"    type="button" id="import-virement-bank"
                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                        <i title="" class="ti-download "></i>
                        <span style=""> Exporter les virements bancaires en cours</span>
                        <i hidden id="spinner_import" class="fas fa-spinner fa-pulse"></i>
                    </button>
                    <button v-on:click="importDankTransaction()"  type="button" id="import-virement-bank"
                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                        <i title="" class="ti-upload "></i>
                        <span style=""> Importer les virements bancaires en cours</span>
                        <i hidden id="spinner_import" class="fas fa-spinner fa-pulse"></i>
                    </button>
                    {{--IMPORT BUTTON START--}}
                    <button onclick="exportExcel('import-excel','Transaction')"    type="button" id="import-excel"
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
                                {{--                 DATE START                --}}
                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Transaction ID</label>
                                <div class="col-sm-2">
                                    <input value="{{$search_in_any_id_transaction}}" name="search_in_any_id_transaction"
                                           id="search_in_any_id_transaction" type="text"
                                           class="form-control form-control-normal" placeholder="Transaction ID">
                                </div>
                                {{--                 DATE START                --}}
                            </div>
                            <div class="form-group row">
                                <x-sous-service col_l="2" col_s="2"/>

                                <x-type-operation col_l="2" col_s="2"/>

                                <label class="col-sm-2 col-form-label">Numéro de téléphone</label>
                                <div class="col-sm-2">
                                    <input value="{{$phone}}" name="phone" id="phone" type="text"
                                           class="form-control form-control-normal" placeholder="Numéro de téléphone">
                                </div>

                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Montant min</label>
                                <div class="col-sm-2">
                                    <input value="{{$amount_min}}" name="amount_min" id="amount_min" type="text"
                                           class="form-control form-control-normal" placeholder="Montant min">
                                </div>


                                <label class="col-sm-2 col-form-label">Montant max</label>
                                <div class="col-sm-2">
                                    <input value="{{$amount_max}}" name="amount_max" id="amount_max" type="text"
                                           class="form-control form-control-normal" placeholder="Montant max">
                                </div>

                                <x-partner />

                                <label class="col-sm-2 col-form-label">Statut transaction </label>
                                <div class="col-sm-2">
                                    <select multiple name="statut[]" id="statut" class=""
                                            placeholder="Services">
                                        @foreach($statuts as $s)
                                            <option @if( in_array($s,$statut)) selected
                                                    @endif value="{{$s}}"> {{$s}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button onclick="window.location.href='/transaction'" type="button"
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
                                <th># Transaction Id</th>
                                <th>Numéro </th>
                                <th>Montant</th>
                                <th>Type Operation</th>
                                <th>Partenaire</th>
                                <th>Commission</th>
                                <th>Frais</th>
                                <th>Services</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Erreur Type </th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                {{--class="{{status($transaction->statut)}}"--}}
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$transaction->id}}
                                        </span>
                                    </th>
                                    <td>{{ $transaction->transaction_id }} </td>
                                    <td>{{ $transaction->phone }} </td>
                                    <td class="currency">{{ $transaction->amount }} <span>XOF</span></td>
                                    <td> <span class="statut-success">{{$transaction->type_operation}} </span> </td>
                                    <td class="currency" title="{{ $transaction->partener->name}} : {{ $transaction->partener->email}}">{{ $transaction->partener_name }} <span></span></td>
                                    <td class="currency">{{ $transaction->commission_amount }} <span>XOF</span></td>
                                    <td class="currency">{{ $transaction->fee_amount }} <span>XOF</span></td>
                                    <td>{{ $transaction->sous_service_name }}</td>
                                    <td>
                                        <span class="{{status($transaction->{STATUS_TRX_NAME})}}">
                                        {{ $transaction->{STATUS_TRX_NAME} }}
                                        </span>
                                        <details>
                                            <summary>voir message</summary>
                                            <p>
                                                {{$transaction->error_message}}
                                            </p>
                                        </details>
                                    </td>
                                    <td>
                                        {{ $transaction->created_at }}
                                    </td>
                                    <td>
                                        @if($transaction->error_types_id)
                                            {{ $transaction->error_types_id }}
                                            <details>
                                                <summary>voir message</summary>
                                                <p>
                                                    {{@$transaction->errorType->message ?: "N\A"}}
                                                </p>
                                            </details>
                                         @endif
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown-split-success">

                                            <button readonly="readonly" style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item text-center">Options</a>
                                                <div class="dropdown-divider"></div>

                                                <button class="dropdown-item text-center " onclick="window.location.href= '/transaction/details/{{$transaction->id}}'">Details</button>
                                                @if(checkRefundable($transaction) )
                                                <button v-on:click='openModal("{{$transaction->id}}","refund")' type="button"
                                                        class="dropdown-item text-center">
                                                    <span style=""> Rembourser la transaction</span>
                                                </button>
                                                @endif
                                                @if(checkFailableOrSuccessable($transaction))
                                                    <button v-on:click='openModal("{{$transaction->id}}","success")' type="button"
                                                            class="dropdown-item text-center ">
                                                        <span style=""> Valider la transaction</span>
                                                    </button>
                                                @endif
                                                @if(checkFailableOrSuccessable($transaction))
                                                    <button v-on:click='openModal("{{$transaction->id}}","failed")' type="button"
                                                            class="dropdown-item text-center">
                                                        <span style=""> Annuler la transaction </span>
                                                    </button>
                                                @endif
                                                @if(retroTransactionAdmin($transaction) )
                                                    <button v-on:click='openModal("{{$transaction->id}}","retro")' type="button"
                                                            class="dropdown-item text-center">
                                                        <span style=""> Retro transaction</span>
                                                    </button>
                                                @endif
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
                {{ $transactions->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->

        {{--  MODAL FRAIX START  --}}

        <div class="modal fade" id="importTRXBank" tabindex="-1" role="dialog"
             aria-labelledby="modalFraisSouServiceLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFraisSouServiceLabel">
                            Configuration des frais du service
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form {{--v-on:submit.prevent="addCommission()" --}}class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date de début</label>
                            <form class="col-sm-4">
                                <input multiple @change="parseToJson" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  id="importedFile" name="importedFile" type="file"
                                       class="form-control form-control-normal" placeholder="Transaction a importer">
                            </form>
                        </div>

                      <div class="table-responsive">
                          <table class="fl-table " style="width: 100%;overflow: auto">
                              <thead>
                              <tr>
                                  <th>RIB</th>
                                  <th>Nom</th>
                                  {{--                                <th>Adresse 1</th>--}}
                                  {{--                                <th>Adresse 2</th>--}}
                                  {{--                                <th>Adresse 3</th>--}}
                                  <th>Motif</th>
                                  <th>Montant</th>
                                  <th>Transaction ID</th>
                                  <th>Statut </th>
                                  <th>Reason</th>
                                  <th>Statut Traitement</th>
                                  <th>Reason Traitement</th>

                              </tr>
                              </thead>
                              <tbody>
                              <tr v-for="trx in transactionImports" :class="{ isOk: trx.statut === 'SUCCESS' ||trx.statut ==='FAILED' ,isNotOk: trx.statut !== 'SUCCESS' && trx.statut !=='FAILED' , failedImport: trx?.statutTreatment === 'FAILED'}">
                                  <td>@{{ trx.rib }}</td>
                                  <td>@{{ trx.name }}</td>
                                  {{--                                <td>@{{ trx.address1 }}</td>--}}
                                  {{--                                <td>@{{ trx.address2 }}</td>--}}
                                  {{--                                <td>@{{ trx.address3 }}</td>--}}
                                  <td>@{{ trx.motif }}</td>
                                  <td>@{{ trx.amount }}</td>
                                  <td>@{{ trx.trxId }}</td>
                                  <td class="statut">@{{ trx.statut }}</td>
                                  <td>@{{ trx.reason }}</td>
                                  <td>@{{ trx.statutTreatment }}</td>
                                  <td>@{{ trx.messageTreatment }}</td>
                              </tr>

                              {{-- <tr v-for="commission in commissions">
                                   <td>@{{ commission.amount_start }}</td>
                               </tr>--}}
                              </tbody>
                          </table>
                      </div>

                    </form>
                    <div class="modal-footer">
                        <button :disabled="!importOk" v-on:click="updateTransactions()"  style="margin: 0 !important;" type="button"
                                 class="btn btn-primary btn-outline-secondary btn-block" >Importer
                        </button>
                        <button :disabled="requesting"  style="margin: 0 !important;" type="button"
                                 class="btn btn-secondary btn-outline-secondary btn-block" data-dismiss="modal">Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--  MODAL FRAIX END  --}}
    </div>

    <!-- Page-body end -->
    {{--  MODAL VALIDER/ANULER transaction START  --}}
    <div class="modal fade" id="modalTransaction" tabindex="-1" role="dialog"
         aria-labelledby="modalTransactionLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransactionLabel">
                        @{{titleTransaction}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form :action="url_transaction" method="POST"  class="modal-body">
                    @csrf
                    <div >
                        <div v-if="typeAction == 'failed' || typeAction == 'success' " class="form-group row">
                            <label for="comment" class="col-sm-12 col-form-label">Commentaire</label>
                            <div class="col-sm-12">
                                <textarea required v-model="comment" rows="10" name="comment" id="comment"
                                          class="form-control form-control-normal" placeholder="Commentaire"></textarea>
                            </div>

                        </div>
                        <div v-if="typeAction === 'retro'" class="form-group row">
                            <label class="col-sm-12 col-form-label">Sous Services</label>
                            <div class="col-sm-12">
                                <select  required  name="codeService" id="codeService" class="form-control"
                                        placeholder="Sous Services text-center">
                                    <option value="" selected> ------Select------</option>
                                    <option v-for="sousService in sousServices" :value="sousService.code"> @{{sousService.name}} </option>
                                </select>
                            </div>

                        </div>
                        <div v-if="typeAction === 'retro'" class="form-group row">
                            <label class="col-sm-12 col-form-label">Montant</label>
                            <div class="col-sm-12">
                                <input  required  name="amount" id="amount" class="form-control"
                                         placeholder="Montant">
                            </div>

                        </div>
                        <div v-if="typeAction === 'retro'" class="form-group row">
                            <label class="col-sm-12 col-form-label">Motif</label>
                            <div class="col-sm-12">
                                <input  required  name="motif" id="motif" class="form-control"
                                        placeholder="Motif">
                            </div>

                        </div>
                        <div class="text-center">
                            <button  class="primary-api-digital btn btn-primary btn-outline-primary "
                                     type="submit" >
                                <i class="ti-plus"></i> @{{ btnMessage }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  MODAL FRAIX END  --}}
</section>
@endsection

@section('js')

    <script>
        const app = new Vue({
            el: '#app',
            data: {
                transactionImports:[],
                importOk:false,
                requesting:false,
                url_transaction:'',
                titleTransaction:'',
                message:'',
                comment:'',
                btnMessage:'',
                idTransaction:'',
                typeAction:'',
                codeService:'',
                amount:'',
                motif:'',
                sousServices:'',
            },
            methods:{
               async openModal(id,type){
                    this.idTransaction = id;
                    this.typeAction = type;
                    if(type ==='success'){
                        this.url_transaction = `/transaction/success/${id}`;
                        this.titleTransaction = `Validation Transaction numéro ${id}`;
                        this.btnMessage = "Validation la transaction"
                    }
                    if(type ==='failed'){
                        this.url_transaction = `/transaction/failed/${id}`;
                        this.titleTransaction = `Annulation Transaction numéro ${id}`;
                        this.btnMessage = "Annuler la transaction";
                    }
                    if(type ==='refund'){
                        this.url_transaction = `/transaction/refund/${id}`;
                        this.titleTransaction =    `Remboursement Transaction numéro ${id}`;
                        this.btnMessage = "Remboursement la transaction"
                    }
                    if(type ==='retro'){
                        this.url_transaction = `/transaction/retro-admin/${id}`;
                        this.titleTransaction =    `Rétro-transaction ${id}`;
                        this.btnMessage = "Faire la rétro transaction";
                        this.sousServices = await HttpClient.get(`/transaction/sous-service/${id}`) ;
                        $("#codeService").select2();
                    }
                    $('#modalTransaction').modal('show');
                },
                downloadVirementExcel(){
                    document.getElementById('spinner_import').removeAttribute('hidden');
                    document.getElementById('import-virement-bank').setAttribute('disabled', 'disabled')
                    HttpClient.get('/transaction/export-virement-bank')
                        .then((res)=>{
                            if(res.code ===200){
                                let date= Helper.nowDMY()
                                Helper.downloadPDF(res.data,`virement-intech-api-du-${date}.xlsx`);
                            }else {
                                alert(res.msg);
                            }
                            document.getElementById('import-virement-bank').removeAttribute('disabled')
                            document.getElementById('spinner_import').setAttribute('hidden','hidden');

                        }).catch(async (error)=>{
                        document.getElementById('import-virement-bank').removeAttribute('disabled')
                        document.getElementById('spinner_import').setAttribute('hidden','hidden');
                        //console.log(  error);
                        alert( error.message);
                    })

                },
                refund(idForm) {
                    let msg='Voulez-vous confirmer le remboursement ?';
                    Notiflix
                        .Confirm
                        .show('Remboursement ',msg,
                            'Oui',
                            'Non',
                            () => {document.getElementById(idForm).submit()},
                            () => {console.log('If you say so...');},
                            { messageMaxLength: msg.length + 90,},);
                },
                importDankTransaction(){
                    $("#importTRXBank").modal('show');
                },
                 parseToJson($event) {
                     // console.log('ii',$event)
                    try {
                        let fileInput = $event.target.files[0];
                        let name = $event.target.files[0].name;
                        console.log("FILE AND EXTENSION", name)
                        let reader = new FileReader();
                        let first=0 ;
                        let init =false;
                        let tabs= [];
                        reader.onload = async () => {
                            const rawExcel= reader?.result;
                            const wb = XLSX.read(rawExcel, {type: 'binary'});
                            const wsname = wb.SheetNames[0];
                            const ws = wb.Sheets[wsname];
                            const clients = XLSX.utils.sheet_to_json(ws, {header: 1});
                            let cpt=0;
                            let isOk = true;
                            clients.map((c) => {
                                console.log('c',c)
                                let line = {};
                                if(c.length && cpt){
                                    line.rib = c[0]?.toString()?.trim() || 'N\A';
                                    line.name = c[1]?.toString()?.trim() || 'N\A';
                                    line.address1 = c[2]?.toString()?.trim() || 'N\A';
                                    line.address2 = c[3]?.toString()?.trim() || 'N\A';
                                    line.address3 = c[4]?.toString()?.trim() || 'N\A';
                                    line.motif = c[5]?.toString()?.trim() || 'N\A';
                                    line.amount = +c[6]?.toString().trim() || 'N\A';
                                    line.trxId = c[7]?.toString()?.trim() || 'N\A';
                                    line.statut = c[8]?.toString()?.trim() || 'N\A';
                                    line.reason = c[9]?.toString()?.trim() || 'N\A';
                                    line.checked = true;
                                    if(line.statut !== 'SUCCESS' && line.statut !== 'FAILED'){
                                        isOk= false;
                                    }
                                    if(cpt && line.rib){
                                        tabs.push(line);
                                    }
                                }
                                cpt++;
                            });
                            console.log('CLIENT',tabs);
                            this.transactionImports =  tabs ;
                            this.importOk = this.transactionImports.length > 0 && isOk;
                        };
                        reader.readAsBinaryString(fileInput);
                    } catch (e) {
                        alert('Fichier non comptatible');
                    }
                },

                async updateTransactions() {
                    this.requesting = true;
                    let rest = await HttpClient.put('/transaction/import-virement-bank',{
                        trx: this.transactionImports?.map((trx)=>{
                            return {
                                statut: trx.statut,
                                id: trx.trxId,
                                message: trx.reason,
                            }
                        }),
                    });
                    if(rest.code === 201) {
                        let tabs = [];
                        rest.data.map((item)=>{
                            let trx = this.transactionImports?.find((tr)=> tr.trxId == item.id);
                            console.log('jj', trx);

                             trx.statutTreatment= item.statutTreatment;
                            trx.messageTreatment= item.messageTreatment;
                            tabs.push(trx);
                        })
                        this.transactionImports = [...tabs];
                        Notiflix
                            .Report
                            .info(
                                "SUCCESS",
                                'Transactions mise a jour avec success',
                                'FERMER',
                                {
                                    svgSize: '42px',
                                    messageMaxLength: 10000,
                                    plainText: true,
                                },
                            );
                    }else{
                        Notiflix
                            .Report
                            .info(
                                'Erreur',
                                rest.msg ||  `Une erreur est survenue`,
                                'FERMER',
                                {
                                    svgSize: '42px',
                                    messageMaxLength: 100000,
                                    plainText: true,
                                },
                            );
                    }
                  //  this.requesting = false;
                }
            },
            computed: {},
            async created() {
                $(document).ready(function () {
                    $('#sous_services_id').select2();
                    $('#statut').select2();
                });
            }
        });


    </script>
@endsection

@section('css')
  <style>
      .modal-xl{
          min-width: 90% !important;
      }
      .isOk td{
          color: green;
      }
      .isNotOk td{
          color: red;
      }
      .isNotOk td.statut{
          color: white;
          background: red;
      }
      .failedImport td{
          color: orange !important;
      }
  </style>
@endsection
