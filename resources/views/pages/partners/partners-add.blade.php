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
                            <h4>Ajout Nouveau Partenaires</h4>
                            <span>Donne la possibility d'ajouter un partenaire   </span>
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
                        <form method="POST" action="/partners" onsubmit="document.getElementById('submit_partner').setAttribute('disabled', 'disabled')">

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Libellé</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('name')}}" name="name" id="name" type="text"
                                           class="form-control form-control-normal" placeholder="Libellé">
                                    @error('name')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}


                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label">Telephone</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('phone')}}" name="phone" id="phone" type="text"
                                           class="form-control form-control-normal" placeholder="Téléphone">
                                    @error('phone')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('email')}}" name="email" id="email" type="email"
                                           class="form-control form-control-normal" placeholder="Email">
                                    @error('email')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}


                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="adress" class="col-sm-3 col-form-label">Adresse</label>
                                <div class="col-sm-3">
                                    <textarea
                                        required   name="adress" id="adress"
                                           class="form-control form-control-normal" placeholder="Adresse">{{old('adress')}}</textarea>
                                    @error('adress')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}
                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="allow_id" class="col-sm-3 col-form-label">
                                    IP autorisés
                                    <span style="color: red; font-size: 10px">
                                        les IP sont séparés par point virgule ";"
                                    </span>
                                </label>
                                <div class="col-sm-3">
                                    <textarea
                                        name="allow_id" id="allow_id"
                                        class="form-control form-control-normal" placeholder="IP autorisés">{{old('allow_id')}}</textarea>
                                    @error('allow_id')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pays</label>
                            <div class="col-sm-3">
                                <select  required  name="countries_id" id="countries_id" class="">
                                    <option value="" selected> ---Sélectionner un Pays ---</option>
                                    @foreach(countries() as $country)
                                        <option @if(old('countries_id') == $country->id  ) selected @endif value="{{$country->id}}"> {{$country->name}} </option>
                                    @endforeach

                                </select>
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
    <script>
        $("#countries_id").select2()
    </script>
@endsection

@section('css')
@endsection
