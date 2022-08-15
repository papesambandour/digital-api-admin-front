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
                            <h4>{{$title}}</h4>
                            <span>{{$subTitle}} </span>
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
                                    <input value="{{$external_transaction_id}}" name="external_transaction_id"
                                           id="external_transaction_id" type="text"
                                           class="form-control form-control-normal" placeholder="Transaction ID">
                                </div>
                                {{--                 DATE START                --}}
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Services</label>
                                <div class="col-sm-2">
                                    <select name="sous_services_id" id="sous_services_id" class=""
                                            placeholder="Services">
                                        <option value="" selected> Tous les services</option>

                                        @foreach($sous_services as $sous_service)
                                            <option @if($sous_services_id ==  $sous_service->id) selected
                                                    @endif value="{{$sous_service->id}}"> {{$sous_service->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Statut transaction </label>
                                <div class="col-sm-2">
                                    <select name="statut" id="statut" class=""
                                            placeholder="Services">
                                        <option value="" selected> Sélectionnez une statut</option>

                                        @foreach($statuts as $s)
                                            <option @if($statut ==  $s) selected
                                                    @endif value="{{$s}}"> {{$s}} </option>
                                        @endforeach
                                    </select>
                                </div>

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
                                <th># Transaction Id</th>
                                <th>Numéro </th>
                                <th>Montant</th>
                                <th>Partenaire</th>
                                <th>Commission</th>
                                <th>Frais</th>
                                <th>Services</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                {{--class="{{status($transaction->statut)}}"--}}
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$transaction->external_transaction_id}}
                                        </span>
                                    </th>
                                    <td>{{ $transaction->phone }} </td>
                                    <td class="currency">{{ $transaction->amount }} <span>XOF</span></td>
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
                                        <div class="btn-group dropdown-split-success">

                                            <button readonly="readonly" style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item text-center">Options</a>
                                                <div class="dropdown-divider"></div>
                                                <form id="{{$transaction->id}}" action="/transaction/{{$transaction->id}}" method="POST">
                                                    @csrf
                                                    <button style="cursor: pointer" onclick='refund("{{$transaction->id}}")' type="button" class="dropdown-item text-center" >Rembourser</button>
                                                </form>
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
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#sous_services_id').select2();
            $('#statut').select2();
        });

        function refund(idForm) {
            let msg='Voulez-vous confirmer le remboursement ?';
            Notiflix
                .Confirm
                .show('Remboursement ',msg,
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
