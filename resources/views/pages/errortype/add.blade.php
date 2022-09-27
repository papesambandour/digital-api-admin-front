@section('title')
    {{title( 'Ajout Utilisateur' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Profils[] $profils ;
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
                            <h4>Ajout Nouveau type d'erreur</h4>
                            <span>Donne la possibilité d'ajouter un type d'erreur   </span>
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
                        <form method="POST" action="/error_type" onsubmit="document.getElementById('error_type_submit').setAttribute('disabled', 'disabled')">

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="code" class="col-sm-3 col-form-label">Code message</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('code')}}" name="code" id="code" type="text"
                                           class="form-control form-control-normal" placeholder="Code message">
                                    @error('code')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="regex" class="col-sm-3 col-form-label">Regex</label>
                                <div class="col-sm-3">
                                    <textarea required rows="5"  name="regex" id="regex" type="text"
                                              class="form-control form-control-normal" placeholder="Regex">{{old('regex')}}</textarea>
                                    @error('regex')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}


                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="index" class="col-sm-3 col-form-label">Index</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('index')}}" name="index" id="index" type="tel"
                                           class="form-control form-control-normal" placeholder="Index">
                                    @error('index')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}


                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="message" class="col-sm-3 col-form-label">Message</label>
                                <div class="col-sm-3">
                                    <textarea rows="5"
                                           name="message" id="message"
                                           class="form-control form-control-normal" placeholder="Message">{{old('message')}}</textarea>
                                    @error('message')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}

                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="sous_services_id" class="col-sm-3 col-form-label">Sous Service</label>
                                <div class="col-sm-3">
                                    <select    name="sous_services_id" id="sous_services_id"
                                           class="form-control form-control-normal" >
                                        <option value="">------Sélectionner-----</option>
                                        @foreach($sousServices as $sousService)
                                        <option @if(old('sous_services_id') == $sousService->id) selected @endif value="{{$sousService->id}}">{{$sousService->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('sous_services_id')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}
                            <div class="form-group row">
                                <label for="is_critic" class="col-sm-3 col-form-label">Message critique</label>
                                <div class="col-sm-3">
                                    <select required    name="is_critic" id="is_critic"
                                           class="form-control form-control-normal" >
                                        <option selected value="">------Sélectionner-----</option>
                                        @foreach(yesNonSelect() as $key => $value)
                                        <option @if(old('is_critic') == $value) selected @endif value="{{$value}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                    @error('is_critic')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}
                            <div class="form-group row">
                                <label for="is_json" class="col-sm-3 col-form-label">Message JSON</label>
                                <div class="col-sm-3">
                                    <select required    name="is_json" id="is_json"
                                           class="form-control form-control-normal" >
                                        <option selected value="">------Sélectionner-----</option>
                                        @foreach(yesNonSelect() as $key => $value)
                                        <option @if(old('is_json') == $value) selected @endif value="{{$value}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                    @error('is_json')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}



                            <div class="form-group row" style="margin-top: 100px">
                                <div class="col-sm-3">
                                    <button id="error_type_submit"  type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Enregistrer
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/error_type'" type="button"
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
        $("#sous_services_id").select2();
        $("#is_critic").select2();
        $("#is_json").select2();
    </script>
@endsection

@section('css')
@endsection
