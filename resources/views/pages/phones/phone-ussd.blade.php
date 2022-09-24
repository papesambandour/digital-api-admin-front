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
                            <h4>Execution USSD  Services Provider  <span style="color:green;font-weight: bold">#{{$phones->id  . '<=>' . $phones->number}} | {{$phones->sousServicesPhones[0]->sousService->name}} | {{$phones->service->name}}</span></h4>
                            <span>Donne la possibility d'exécuter une requête USSD  </span>
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
                        <form method="POST" action="/phones/ussd/{{$phones->id}}" onsubmit="document.getElementById('submit_phones').setAttribute('disabled', 'disabled')">
                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="ussd_code" class="col-sm-12 col-form-label">Code Ussd</label>
                                <div class="col-sm-6">
                                    <textarea required  style="background: black;color: white;font-weight: bold;line-height: 26px;"   name="ussd_code" id="ussd_code"
                                           class="form-control form-control-normal" placeholder="Numéro ou Identifiant">{{$ussd_code}}</textarea>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ussd_code" class="col-sm-12 col-form-label">Résultat USSD</label>

                                <div class="col-sm-6">
                                    <textarea rows="10" readonly style="background: black;color: white;font-weight: bold;line-height: 26px;"
                                           class="form-control form-control-normal" >{{$resultUssd}}</textarea>

                                </div>
                            </div>



                            <div class="form-group row" style="margin-top: 15px">
                                <div class="col-sm-3">
                                    <button id="submit_phones"  type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>EXECUTE
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
        $("#services_id").select2();
        $("#sim_provider").select2();
    </script>
@endsection

@section('css')
@endsection
