@section('title')
    {{title( 'CONNEXION' )}}
@endsection

@extends('layouts.main-auth')

@section('page')

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
        </div>
        <div class="col-sm-12">
            <!-- Authentication card start -->
            <div class="login-card card-block auth-body mr-auto ml-auto">
                <form action="/auth/login" method="POST" class="md-float-material">
                    @csrf
                    <div class="text-center">
{{--                        <img width="300" height="150" alt src="/assets/images/INTECH.png" alt="INTECH API"  style="object-fit: contain">--}}
                    </div>
                    <div class="auth-box">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center txt-primary">CONNEXION</h3>
                            </div>
                        </div>
                        <hr/>
                        <div class="input-group">
                            <input required type="email" name="email" class="form-control" placeholder="Adresse Email">
                            <span class="md-line"></span>
                        </div>
                        <div class="input-group">
                            <input required type="password" name="password"  class="form-control" placeholder="Mot de passe">
                            <span class="md-line"></span>
                        </div>
                        <div class="row m-t-25 text-left">

                            <div class="col-sm-5 col-xs-12 forgot-phone text-right">
                                <a href="#" class="text-right f-w-600 text-inverse"> Mot de passe oublié</a>
                            </div>
                        </div>
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <button style="color: #fff;background: #036067" type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Se Connecter</button>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                               <span style="font-size: 20px;color: #aaa;font-weight: bold;letter-spacing: 2px;text-shadow: 1px 1px 1px #353434">ADMIN API DIGITAL INTECH</span>
                            </div>
                        </div>

                    </div>
                </form>
                <!-- end of form -->
            </div>
            <!-- Authentication card end -->
        </div>
        <!-- end of col-sm-12 -->
    </div>

@endsection

@section('js')
@endsection

@section('css')
@endsection
