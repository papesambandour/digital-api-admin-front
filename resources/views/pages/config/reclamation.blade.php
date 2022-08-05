@section('title')
    {{title( 'RECLAMATIONS' )}}
@endsection

@extends('layouts.main')

@section('page')

    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Reclamations</h4>
                            <span>Gestions des tickets de reclamations des clients </span>
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
                    <h5>Le services est en cours de development</hh5>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-wrapper">

                    </div>

                </div>
            </div>
{{--            <div style="float: right">--}}
{{--                {{ $mouvements->links('pagination::bootstrap-4') }}--}}
{{--            </div>--}}

        </div>
        <!-- Contextual classes table ends -->
    </div>

@endsection

@section('js')
@endsection

@section('css')
@endsection
