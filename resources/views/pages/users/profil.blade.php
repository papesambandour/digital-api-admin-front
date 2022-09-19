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
        <div class="page-body row">
            <!-- Contextual classes table starts -->
           <div class="col-6">

               <div class="card">
                   <div class="card-header">
                       <div class="card-block">
                           <form method="POST" action="/account" onsubmit="document.getElementById('submit_users').setAttribute('disabled', 'disabled')">
                               <div class="form-group row">
                                   <h3>Modification information personnel</h3>
                               </div>
                               @csrf
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="f_name" class="col-sm-6 col-form-label">Prénom</label>
                                   <div class="col-sm-6">
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
                                   <label for="l_name" class="col-sm-6 col-form-label">Nom</label>
                                   <div class="col-sm-6">
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
                                   <label for="phone" class="col-sm-6 col-form-label">Telephone</label>
                                   <div class="col-sm-6">
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
                             {{--  <div class="form-group row">
                                   <label for="address" class="col-sm-6 col-form-label">Adresse</label>
                                   <div class="col-sm-6">
                                    <textarea    name="address" id="address"
                                                 class="form-control form-control-normal" placeholder="Adresse">{{$user->address}}</textarea>
                                       @error('address')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>--}}
                               {{-- #######################################################FILED ############################### --}}




                               <div class="form-group row" style="margin-top: 100px">
                                   <div class="col-sm-6">
                                       <button id="submit_users"  type="submit"
                                               class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                               class="icofont icofont-search"></i>Enregistrer
                                       </button>
                                   </div>
                                   <div class="col-sm-6">
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
           <div class="col-6">
               <div class="card">
                   <div class="card-header">
                       <div class="card-block">
                           <form method="POST" action="/password" onsubmit="document.getElementById('password_submit').setAttribute('disabled', 'disabled')">
                               <div class="form-group row">
                                   <h3>Modification mot de passe</h3>
                               </div>
                               @csrf
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="password_old" class="col-sm-6 col-form-label">Mot de passe actuel</label>
                                   <div class="col-sm-6">
                                       <input required   name="password_old" id="password_old" type="password"
                                              class="form-control form-control-normal" placeholder="Mot de passe actuel">
                                       @error('password_old')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="password" class="col-sm-6 col-form-label">Nouveau Mot de passe</label>
                                   <div class="col-sm-6">
                                       <input required   name="password" id="password" type="password"
                                              class="form-control form-control-normal" placeholder="Nouveau Mot de passe">
                                       @error('password')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #############################################FILED ############################## --}}
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="confirm_password" class="col-sm-6 col-form-label">Confirmation Mot de passe</label>
                                   <div class="col-sm-6">
                                       <input required   name="confirm_password" id="confirm_password" type="password"
                                              class="form-control form-control-normal" placeholder="Confirmation Mot de passe">
                                       @error('confirm_password')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #############################################FILED ############################## --}}

                               <div class="form-group row" style="margin-top: 100px">
                                   <div class="col-sm-6">
                                       <button id="password_submit"  type="submit"
                                               class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                               class="icofont icofont-save"></i>Modifier le mot de passe
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
        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')

@endsection

@section('css')
@endsection
