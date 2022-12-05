@extends('layouts.app')

@push('styles')
    <link href="{{ asset('styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" role="alert">
                        {{ __('Amount to be Transfered ($)') }}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('post.transfer') }}" method="post">
                            @csrf
                            <input type="hidden" name="uuid" value="{{ $uuid }}">
                            <input type="number" class="form-control" name="amount">
                            <p></p>
                            <div class="form-group text-center">
                                <button class="btn btn-dark">Transfer Amount</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
