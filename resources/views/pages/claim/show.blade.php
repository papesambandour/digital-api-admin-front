@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Claim $claim ;
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
                            <h4> Réclamation</h4>
                            <span class="currency">Ticket numéro : {{$claim->claim_ref}}   </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if($claim->statut == STATUS_CLAIM['OPENED'])
                    <button onclick="$('#modalTicket').modal('show')" type="button"
                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                        <i title="Ajouter un clef" class="ti-close "></i>
                        <span style=""> Fermer la réclamation</span>
                    </button>
                    @endif
                    @if($claim->statut == STATUS_CLAIM['CREATED'])

                            <a class="primary-api-digital btn btn-primary btn-outline-primary btn-block " href="/claim/{{$claim->id}}/edit">
                                <i title="Ajouter un clef" class="ti-hand-open "></i>
                                <span style=""> Ouvrir le ticket</span>
                            </a>
                    @endif

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
                                    <th class="col-md-4"># Ticket</th>
                                    <th class="text-center col-md-8">{{$claim->claim_ref}}</th>
                                </tr>
                                <tr>
                                    <th> Motif</th>
                                    <td class="text-center">{{$claim->subject}}</td>
                                </tr>
                                <tr>
                                    <th> Message</th>
                                    <th class="text-center">{{$claim->message}}</th>
                                </tr>
                                <tr>
                                    <th> Statut</th>
                                    <td class="text-center">{!!claimStatut($claim->statut)!!} </td>
                                </tr>
                                <tr>
                                    <th> Montent transaction</th>
                                    <th class="text-center">{{$claim->transaction->amount}}</th>
                                </tr>



                                <tr>
                                    <th> Ouvert par</th>
                                    <td class="text-center">{{@$claim->userOpened->fullName}} </td>
                                </tr>
                                <tr>
                                    <th> Fermer par</th>
                                    <th class="text-center">{{@$claim->userClosed->fullName}}</th>
                                </tr>


                                <tr>
                                    <th> Numéro client</th>
                                    <td class="text-center">{{$claim->transaction->phone}}</td>
                                </tr>
                                <tr>
                                    <th> ID transaction</th>
                                    <th class="text-center">{{$claim->transaction->id}}</th>
                                </tr>
                                <tr>
                                    <th> Ref transaction</th>
                                    <td class="text-center">{{$claim->transaction->transaction_id}}</td>
                                </tr>
                                <tr>
                                    <th> Service</th>
                                    <th class="text-center">{{$claim->transaction->service_name}}</th>
                                </tr>
                                <tr>
                                    <th>Sous Service</th>
                                    <td class="text-center">{{$claim->transaction->sous_service_name}}</td>
                                </tr>
                                <tr>
                                    <th>Statut Transaction</th>
                                    <th class="text-center">{{$claim->transaction->statut}}</th>
                                </tr>
                                <tr>
                                    <th>Type Opération Transaction</th>
                                    <td class="text-center"><span class="currency">{{$claim->transaction->type_operation}}</span> </td>
                                </tr>
                                <tr>
                                    <th>Commentaire</th>
                                    <th class="text-center"><span class="">{{@$claim->comment ?: "n\a"}}</span> </th>
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

    {{--  MODAL FRAIX START  --}}

    <div class="modal fade" id="modalTicket" tabindex="-1" role="dialog"
         aria-labelledby="modalTicketLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTicketLabel">
                       Ajouter un commentaire au ticket
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/claim/{{$claim->id}}" method="POST"  class="modal-body">
                    @csrf
                    @method('put')
                    <div >
                        <div class="form-group row">
                            <label for="comment" class="col-sm-12 col-form-label">Taux commission</label>
                            <div class="col-sm-12">
                                <textarea rows="10" name="comment" id="comment"
                                       class="form-control form-control-normal" placeholder="Commentaire"></textarea>
                            </div>

                        </div>
                        <div class="text-center">
                            <button  class="primary-api-digital btn btn-primary btn-outline-primary "
                                    type="submit" >
                                <i class="ti-plus"></i> Fermer le ticker
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  MODAL FRAIX END  --}}

@endsection

@section('js')

@endsection

@section('css')
@endsection
