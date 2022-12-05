@extends('layouts.app')

@push('styles')
    <link href="{{ asset('styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-card-element></x-card-element>
                <div class="card">
                    <div class="card-header" role="alert">
                        {{ __('Payment Methods') }}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @elseif (session('cardstatus'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('cardstatus') }}
                            </div>
                        @endif
                        @foreach ($data as $card)
                            <div class="form-row">
                                <label for="card-element"></label>
                                <div style="display: flex;">
                                    @if ($default->id != $card->id)
                                        <a class="btn btn-success" style="margin-right:2%"
                                            href="{{ route('set-default', ['id' => $card->id]) }}">
                                            Default
                                        </a>
                                    @endif
                                    <div class="form-control btn btn-outline-dark">
                                        {{ $card->billing_details->name }}
                                        &nbsp;| &nbsp; **** **** **** {{ $card->card->last4 }}
                                        &nbsp;| &nbsp; Expiry:
                                        {{ $card->card->exp_month < 10 ? '0' . $card->card->exp_month : $card->card->exp_month }}
                                        -{{ $card->card->exp_year }}
                                    </div>
                                    @if ($default->id != $card->id)
                                        <a class="btn btn-danger" style="margin-left:2%"
                                            onclick="return confirm('Are you sure want to remove this card ?')"
                                            href="{{ route('remove-card', ['id' => $card->id]) }}">
                                            Remove
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
