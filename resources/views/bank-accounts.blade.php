@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{ route('bank-accounts') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <x-card-element></x-card-element>
                </div>
                <div class="row col-md-8">
                    <a href="{{ route('add-account') }}" class="btn btn-outline-dark">Add Account</a>
                    @foreach ($external_accounts as $external_account)
                        <div class="col-sm-4 mt-4">
                            <div class="card">
                                <div class="card-body btn btn-outline-gray">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="account"
                                            value="{{ $external_account->id }}" required
                                            @if ($external_account->default_for_currency) {{ 'checked' }} @endif>
                                    </div>
                                    @if ($external_account->account_holder_name)
                                        <p class="btn btn-dark">{{ $external_account->account_holder_name }}</p>
                                    @endif
                                    <h5 class="card-title btn btn-danger">R: {{ $external_account->routing_number }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-dark">Set as Default</button>
                </div>
            </div>
        </form>
    </div>
@endsection
