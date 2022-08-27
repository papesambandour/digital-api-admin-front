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
    <div class="col-md-12">
        @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif
    </div>
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Modification  Services Provider  <span style="color:green;font-weight: bold">#{{$phones->id  . '<=>' . $phones->number}} | {{$phones->sousServicesPhones[0]->sousService->name}} | {{$phones->service->name}}</span></h4>
                            <span>Donne la possibility d'ajouter un Services Provider  </span>
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
                        <form method="POST" action="/phones/{{$phones->id}}" onsubmit="document.getElementById('submit_phones').setAttribute('disabled', 'disabled')">
                        @method('put')
                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="number" class="col-sm-3 col-form-label">Numéro ou Identifiant</label>
                                <div class="col-sm-3">
                                    <input required  value="{{$phones->number}}" name="number" id="number" type="text"
                                           class="form-control form-control-normal" placeholder="Numéro ou Identifiant">
                                    @error('number')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- #######################################################FILED ############################### --}}


                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="codeSecret" class="col-sm-3 col-form-label">Code secrete</label>
                                <div class="col-sm-3">
                                    <input min="4" max="4" required  value="{{$phones->codeSecret}}" name="codeSecret" id="codeSecret" pattern="^([0-9]{4})$" type="text"
                                           class="form-control form-control-normal" placeholder="Code secrete">
                                    @error('codeSecret')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- #######################################################FILED ############################### --}}
                            <div class="form-group row">
                                <x-sous-service col_id="{{$phones->sousServicesPhones[0]->sousService->id}}" col_name="-" col_require="true" col_l="3" col_s="3"/>
                            </div>
                            {{-- #######################################################FILED ############################### --}}



                            <div class="form-group row" style="margin-top: 100px">
                                <div class="col-sm-3">
                                    <button id="submit_phones"  type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Enregistrer
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/phones'" type="button"
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
    <script>
        $("#services_id").select2()
    </script>
@endsection

@section('css')
@endsection
