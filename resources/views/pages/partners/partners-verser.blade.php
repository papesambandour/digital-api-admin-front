@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Parteners[] $partners ;
 */
?>
@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Versement pour le partenaire <span style="color:green;font-weight: bold">{{$partners->name}}</span> </h4>
                            <span>Donne la possibility de verser un montant pour le partenaire  <span class="currency">{{$partners->name}}   </span>
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
                    <div class="card-block">
                        <form enctype="multipart/form-data" method="POST" action="/partners/versement/{{$partners->id}}" onsubmit="document.getElementById('submit_partner').setAttribute('disabled', 'disabled')">

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="amount" class="col-sm-3 col-form-label">Montant du versement</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('amount')}}" name="amount" id="amount" type="number"
                                           class="form-control form-control-normal" placeholder="Montant du versement">
                                    @error('amount')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="amount_confirm" class="col-sm-3 col-form-label">Confirmer le Montant du versement</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('amount_confirm')}}" name="amount_confirm" id="amount_confirm" type="number"
                                           class="form-control form-control-normal" placeholder="Confirmer le montant du versement">
                                    @error('amount_confirm')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}
                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="attachment_path" class="col-sm-3 col-form-label">Justificatif (pdf)</label>
                                <div class="col-sm-3">
                                    <input required   name="attachment_path" id="attachment_path" type="file" accept=".doc, .docx, .pdf"
                                           class="form-control form-control-normal" placeholder="Justificatif (pdf)">
                                    @error('attachment_path')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- #######################################################FILED ############################### --}}


                            <div class="form-group row" style="margin-top: 100px">
                                <div class="col-sm-3">
                                    <button id="submit_partner"  type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Enregistrer
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/partners'" type="button"
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
