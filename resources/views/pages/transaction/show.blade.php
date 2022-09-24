@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Transactions $transaction ;
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
                <p class="alert alert-error">{{ Session::get('error') }}</p>
            @endif
        </div>
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4> Details transaction</h4>
                            <span class="currency">Transaction numéro : {{$transaction->id}}   </span>
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

                </div>
                <div class="card-block table-border-style">
                    <div class="table-wrapper">
                        <table class="fl-table " >
                            <thead>
                                <tr>
                                    <th class="col-md-4"># ID</th>
                                    <th class="text-center col-md-8">{{$transaction->id}}</th>
                                </tr>
                                <tr>
                                    <th> #Ref</th>
                                    <td class="text-center">{{$transaction->transaction_id}}</td>
                                </tr>
                                <tr>
                                    <th> Service</th>
                                    <th class="text-center">{{$transaction->service_name}}</th>
                                </tr>
                                <tr>
                                    <th> Sous Service</th>
                                    <td class="text-center">{{$transaction->sous_service_name}} </td>
                                </tr>
                                <tr>
                                    <th> Montant transaction</th>
                                    <th class="text-center">{{$transaction->amount}}</th>
                                </tr>

                                <tr>
                                    <th> Numéro client</th>
                                    <td class="text-center">{{$transaction->phone}}</td>
                                </tr>
                                <tr>
                                    <th>Statut Transaction</th>
                                    <th class="text-center">{{$transaction->statut}}</th>
                                </tr>
                                <tr>
                                    <th>Type Opération Transaction</th>
                                    <td class="text-center"><span class="currency">{{$transaction->type_operation}}</span> </td>
                                </tr>
                                <tr>
                                    <th>Partenaire</th>
                                    <th class="text-center">{{$transaction->partener_name}} </th>
                                </tr>
                                <tr>
                                    <th>Commission</th>
                                    <td class="text-center">{{$transaction->commission_amount}} </td>
                                </tr>
                                <tr>
                                    <th>Frais</th>
                                    <th class="text-center">{{$transaction->fee_amount}} </th>
                                </tr>
                                <tr>
                                    <th>Date de creation</th>
                                    <td class="text-center">{{$transaction->created_at}} </td>
                                </tr>
                                <tr>
                                    <th>Date de creation</th>
{{--                                    <td class="text-center">{{$transaction->erorr_types->message}} </td>--}}
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
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
