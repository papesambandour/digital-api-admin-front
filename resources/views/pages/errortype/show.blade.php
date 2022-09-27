@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\ErrorType $entity ;
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
                            <h4> Details type erreur</h4>
                            <span class="currency">Code : {{$entity->code}}   </span>
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
                                    <th class="text-center col-md-8">{{$entity->id}}</th>
                                </tr>
                                <tr>
                                    <th> #Code</th>
                                    <td class="text-center">{{$entity->code}}</td>
                                </tr>
                                <tr>
                                    <th>Sous Service</th>
                                    <th class="text-center">{{@$entity->sousService->name ?: 'N\A'}}</th>
                                </tr>
                                <tr>
                                    <th> Index</th>
                                    <td class="text-center">{{$entity->index}} </td>
                                </tr>
                                <tr>
                                    <th> Regex</th>
                                    <th class="text-center">{{$entity->regex}}</th>
                                </tr>

                                <tr>
                                    <th> Message</th>
                                    <td class="text-center">{{$entity->message}}</td>
                                </tr>

                                <tr>
                                    <th> Message critique</th>
                                    <th class="text-center">
                                        @if($entity->is_critic== 1)
                                            <span class="statut-success">OUI</span>
                                        @else
                                            <span class="statut-infos">NON</span>
                                        @endif
                                    </th>
                                </tr>

                                <tr>
                                    <th> Message en JSON</th>
                                    <td class="text-center">
                                        @if($entity->is_critic== 1)
                                            <span class="statut-success">OUI</span>
                                        @else
                                            <span class="statut-infos">NON</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Date de creation</th>
                                    <th class="text-center">{{@$entity->errorType->message ?: "N\A"}}
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
