@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Claim[] $claims ;
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
                            <span>Donne la liste de tous les reclamations   </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                        {{--<button onclick="window.location.href='/partner/claim/create'" type="button"
                                class="primary-api-digital btn btn-primary btn-outline-primary btn-block ">
                            <i title="Ajouter un clef" class="ti-plus "></i>
                            <span style=""> Ajouter une réclamation</span>
                        </button>--}}

                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
            <!-- Contextual classes table starts -->
            <div class="card">
                <div class="card-header">
                    <h5>Filtres</h5>
                    <div class="card-block">
                        <form>
                            <div class="form-group row">
                                {{--                 DATE START                --}}
                                <label class="col-sm-3 col-form-label">Date de début</label>
                                <div class="col-sm-3">
                                    <input value="{{$date_start}}" name="date_start" id="date_start" type="date"
                                           class="form-control form-control-normal" placeholder="Date de début">
                                </div>
                                {{--                 DATE START                --}}

                                {{--                 DATE START                --}}
                                <label class="col-md-3 col-form-label">Date de fin</label>
                                <div class="col-sm-3">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>
                            </div>

                            <div class="form-group row">
                                {{--                 DATE START                --}}
                                <label class="col-sm-3 col-form-label">Reference Ticket</label>
                                <div class="col-sm-3">
                                    <input value="{{$ref}}" name="ref" id="ref" type="text"
                                           class="form-control form-control-normal" placeholder="Reference Ticket">
                                </div>
                                {{--                 DATE START                --}}

                                {{--                 DATE START                --}}
                                <label class="col-md-3 col-form-label">Transaction Id</label>
                                <div class="col-sm-3">
                                    <input value="{{$transactionId}}" name="transactionId" id="transactionId" type="text"
                                           class="form-control form-control-normal" placeholder="Transaction Id">
                                </div>
                            </div>
                            <div class="form-group row">

                                    <label for="statut" class="col-sm-3 col-form-label">Statut</label>
                                    <div class="col-sm-3">
                                        <select    name="statut" id="statut"
                                                 class="form-control form-control-normal" >
                                            <option value="" >---</option>
                                            @foreach(array_values(STATUS_CLAIM) as $statutClaim)
                                                <option @if($statut == $statutClaim) selected @endif value="{{$statutClaim}}">{{claimStatutText($statutClaim)}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                <div class="col-sm-3">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/claim'" type="button"
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
                <div class="card-block table-border-style">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                            <tr>
                                <th># Ref Ticket</th>
                                <th>Motif</th>
                                <th>Message</th>
                                <th>Transaction ID</th>
                                <th>Telephone</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($claims as $claim)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$claim->claim_ref}}
                                        </span>
                                    </th>
                                    <td class="text-center"><span class="currency"> {{ $claim->subject }} </span> </td>
                                    <td class="text-center">{{substr($claim->message,0,100)}}... </td>
                                    <td class="text-center">
                                        <span class="currency"> #{{ $claim->transaction_id }} </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="currency"> {{ $claim->transaction->phone }} </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="currency"> {{ $claim->transaction->amount }} XOF</span>
                                    </td>

                                    <td>
                                        <span class="currency"> {!!  claimStatut($claim->statut) !!} </span>
                                    </td>
                                    <td>
                                        {{ $claim->created_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown-split-success">

                                            <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="/claim/{{$claim->id}}">Details</a>
                                                @if($claim->statut == STATUS_CLAIM['CREATED'])
                                                <a class="dropdown-item waves-light waves-effect" href="/claim/{{$claim->id}}/edit">Ouvrir le ticket</a>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="float: right">
                {{ $claims->links('pagination::bootstrap-4') }}
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
