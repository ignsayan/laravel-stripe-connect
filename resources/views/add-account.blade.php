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
                        {{ __('New Account') }}
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('add-account') }}" id="payment-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="holder_name" class="form-control" placeholder="Account Holder"
                                    required>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" name="account_no" class="form-control" placeholder="Account Number"
                                    value="000123456789" required>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" name="routing_no" class="form-control" placeholder="Routing Number"
                                    value="110000000" required>
                            </div>
                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-dark">Add Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
