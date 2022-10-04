@section('title')
    {{title( 'DASHBOARD' )}}
@endsection
@extends('layouts.main')
<?php
/**
 * @var \App\Models\SousServices[] $sousServices ;
 * @var \App\Models\Services[] $services ;
 */
?>
@section('page')

    <div class="row">
        <form class="col-md-12 col-xl-12">
            {{--START--}}
            <div class="form-group row">
                <x-partner />
                {{--                 DATE START                --}}
                <label class="col-sm-1 col-form-label">Date de début</label>
                <div class="col-sm-2">
                    <input value="{{request('date_start',gmdate('Y-m-d'))}}" name="date_start" id="date_start"
                           type="date"
                           class="form-control form-control-normal" placeholder="Date de début">
                </div>
                {{--                 DATE START                --}}

                {{--                 DATE START                --}}
                <label class="col-sm-1 col-form-label">Date de fin</label>
                <div class="col-sm-2">
                    <input value="{{request('date_end', gmdate('Y-m-d') )}}" name="date_end" id="date_end" type="date"
                           class="form-control form-control-normal" placeholder="Date de fin">
                </div>
                {{--                 DATE START                --}}
                <div class="col-sm-1">
                    <button type="submit"
                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                            class="icofont icofont-search"></i>Filtrer
                    </button>
                </div>
                <div class="col-sm-1">
                    <button onclick="window.location.href='/'" type="button"
                            class="success-api-digital btn btn-primary btn-outline-primary btn-block"><i
                            class="icofont icofont-delete"></i>
                    </button>
                </div>
            </div>
            {{--END--}}
        </form>
        <h1 class="h3 " style="width: 100%;display: block;text-align: left;font-size: 17px;color: #303549">Infos compte Intech API</h1>

        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Solde Intech (Systeme)</span>
                    <h4 class="currency">{{soldeIntechSystem()}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-blue f-16 icofont icofont-money-bag m-r-10"></i>Le solde total de intech API
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->

        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Solde Intech (Provider)</span>
                    <h4 class="currency">{{soldeIntechStock()}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-blue f-16 icofont icofont-money-bag m-r-10"></i>Le solde total de intech API
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->

        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Solde total des Partenaires</span>
                    <h4> {{balancePartners()}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-blue f-16 icofont icofont-calendar m-r-10"></i>
                                                                État actuelle
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Gain Intech API</span>
                    <h4> {{gainIntech()}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-blue f-16 icofont icofont-calendar m-r-10"></i>
                                                                {{period()}}
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="h3 " style="width: 100%;display: block;text-align: left;font-size: 17px;color: #303549">Statistiques sur les transactions</h1>

        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-ui-home  bg-c-green card1-icon"></i>
                    <span class="text-c-green f-w-600">Transactions Succès</span>
                    <h4>{{fMoney(amountState('SUCCESS'))}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-green f-16 icofont icofont-calendar m-r-10"></i>
                                                                 {{period()}}
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-warning-alt bg-c-pink card1-icon"></i>
                    <span class="text-c-pink f-w-600">Transactions Échec</span>
                    <h4>{{fMoney(amountState('FAILLED'))}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-pink f-16 icofont icofont-calendar m-r-10"></i>
                                                                 {{period()}}
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- card1 start -->
        <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-yellow card1-icon"></i>
                    <span class="text-c-yellow f-w-600">Transactions En cours</span>
                    <h4> {{fMoney(amountState('PENDING') + amountState('PROCESSING')) }} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-yellow f-16 icofont icofont-calendar m-r-10"></i>
                                                                {{period()}}
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->

        <!-- card1 end -->
        <!-- Statestics Start -->
        {{-- <div class="col-md-12 col-xl-8">
             <div class="card">
                 <div class="card-header">
                     <h5>Statestics</h5>
                     <div class="card-header-left ">
                     </div>
                     <div class="card-header-right">
                         <ul class="list-unstyled card-option">
                             <li><i class="icofont icofont-simple-left "></i></li>
                             <li><i class="icofont icofont-maximize full-card"></i></li>
                             <li><i class="icofont icofont-minus minimize-card"></i></li>
                             <li><i class="icofont icofont-refresh reload-card"></i></li>
                             <li><i class="icofont icofont-error close-card"></i></li>
                         </ul>
                     </div>
                 </div>
                 <div class="card-block">
                     <div id="statestics-chart" style="height:517px;"></div>
                 </div>
             </div>
         </div>--}}




        <!-- Email Sent End -->
        <!-- Data widget start -->

       <h1 class="h3 " style="width: 100%;display: block;text-align: left;font-size: 17px;color: #303549">Solde intech par services</h1>
       @foreach($services as $service)
            <div class="col-md-6 col-xl-4">
                <div class="card widget-card-1">
                    <div class="card-block-small">
                        <i class="icofont icofont-money bg-c-green card1-icon"></i>
                        <span class="text-c-green f-w-600">{{$service->name}}</span>
                        <h4> <span style="font-size: 15px;color: #93be52">Solde Systeme</span>  <span style="font-size: 16px;color: #303549">{{soldeServiceSystem($service->id) }} XOF</span> </h4>
                        <h4> <span style="font-size: 15px;color: #93be52">Solde Stock</span>  <span style="font-size: 16px;color: #303549">{{soldeServiceStock($service->id) }} XOF</span> </h4>
                        <hr style="display: block; border-bottom: 1px solid #93be52">
                        <h4> <span style="font-size: 15px;color: #93be52">Gain</span> <span style="font-size: 16px;color: #303549">{{  gainIntechByService($service->id) }} XOF <br>  {!! period2() !!} </span></h4>

                        <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-green f-16 icofont icofont-calendar m-r-10"></i>
                                                                État actuelle
                                                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-md-12 col-xl-12">
            <div class="card project-task">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5>Montant par sous services :
                            {{period()}}
                        </h5>
                    </div>

                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Libelle</th>
                                <th style="text-align: center">Gain</th>
                                <th style="text-align: center">Montants succès</th>
                                <th style="text-align: center">Montants Échec</th>
                                <th style="text-align: center">Montants En cours</th>
                                <th colspan="2" style="text-align: left">Taux de réussite</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sousServices as $sousService)
                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-blue d-inline-block text-center">{{logoFromName($sousService->name)}}</h6>
                                            <p class="d-inline-block m-l-20">{{$sousService->name}}</p>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <p class="d-inline-block currency" style="">{{  gainIntechSousByService($sousService->code) }}
                                            <span>XOF</span>
                                        </p>
                                    </td>
                                    @php
                                        $amountSuccess = amountSuccess($sousService->id);
                                        $amountFailled = amountFailled($sousService->id);
                                        $amountPending = amountPending($sousService->id);
                                        $percentageSuccess =  percent(percentageAmount($amountSuccess,$amountFailled,$amountPending));
                                        $percentageFailled =  percent(percentageAmount($amountFailled,$amountSuccess,$amountPending));
                                        $percentagePending =  percent(percentageAmount($amountPending,$amountSuccess,$amountFailled));
                                    @endphp
                                    <td style="text-align: center">
                                        <p class="d-inline-block currency" style="">{{money($amountSuccess)}}
                                            <span>XOF</span>
                                        </p>
                                    </td>

                                    <td style="text-align: center">
                                        <p class="d-inline-block currency" style="">{{money($amountFailled)}}
                                            <span>XOF</span>
                                        </p>
                                    </td>
                                    <td style="text-align: center">
                                        <p class="d-inline-block currency" style="">{{money($amountPending)}}
                                            <span>XOF</span>
                                        </p>
                                    </td>
                                    <td style="text-align: center" class="currency">
                                        {{$percentageSuccess}} %
                                    </td>
                                    <td style="width: 300px">
                                        <div class="progress d-inline-block" style="width: 100%">

                                            <div class="progress-bar bg-c-blue"
                                                 role="progressbar" aria-valuemin="0"
                                                 aria-valuemax="100" style="width:{{$percentageSuccess}}%">
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
        </div>


    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{asset('assets/pages/dashboard/custom-dashboard.js')}}"></script>
@endsection
