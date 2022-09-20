@section('title')
    {{title( 'Modification Utilisateur' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Profils[] $profils ;
 * @var \App\Models\Users[] $user ;
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
                            <h4>Modification Nouveau Utilisateur</h4>
                            <span>Donne la possibility de Modifier un utilisateur   </span>
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
                        <form method="POST" action="/users/{{$user->id}}" onsubmit="document.getElementById('submit_users').setAttribute('disabled', 'disabled')">
                             @method('put')
                             @csrf
                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="f_name" class="col-sm-3 col-form-label">Prénom</label>
                                <div class="col-sm-3">
                                    <input required  value="{{$user->f_name}}" name="f_name" id="f_name" type="text"
                                           class="form-control form-control-normal" placeholder="Prénom">
                                    @error('f_name')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- #######################################################FILED ############################### --}}

                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="l_name" class="col-sm-3 col-form-label">Nom</label>
                                <div class="col-sm-3">
                                    <input required  value="{{$user->l_name}}" name="l_name" id="l_name" type="text"
                                           class="form-control form-control-normal" placeholder="Nom">
                                    @error('l_name')
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
                                    <input required  value="{{$user->phone}}" name="phone" id="phone" type="tel"
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
                                    <input required  value="{{$user->email}}" name="email" id="email" type="email"
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
                                <label for="address" class="col-sm-3 col-form-label">Adresse</label>
                                <div class="col-sm-3">
                                    <textarea    name="address" id="address"
                                        class="form-control form-control-normal" placeholder="Adresse">{{$user->address}}</textarea>
                                    @error('address')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- #######################################################FILED ############################### --}}

                            {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="profils_id" class="col-sm-3 col-form-label">Profil</label>
                                <div class="col-sm-3">
                                    <select required   name="profils_id" id="address"
                                            class="form-control form-control-normal" >
                                        <option value="">------Sélectionner-----</option>
                                        @foreach($profils as $profil)
                                            <option @if($user->profils_id == $profil->id) selected @endif value="{{$profil->id}}">{{$profil->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('profils_id')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- #######################################################FILED ############################### --}}



                            <div class="form-group row" style="margin-top: 100px">
                                <div class="col-sm-3">
                                    <button id="submit_users"  type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Enregistrer
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/users'" type="button"
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
