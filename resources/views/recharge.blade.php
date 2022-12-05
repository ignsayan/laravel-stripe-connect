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
                        {{ __('Add Funds to Account') }}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="payment-card-body d-flex justify-content-center">
                            @for ($amt = 3000; $amt <= 9000; $amt = $amt + 3000)
                                <div class="alert btn-group">
                                    <a class="btn btn btn-outline-dark" href="{{ '/charge/' . $amt }}">
                                        {{ 'Add $' . $amt }}
                                    </a>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
