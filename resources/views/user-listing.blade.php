@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-card-element></x-card-element>
                <div class="card">
                    <div class="card-header" role="alert">
                        {{ __('Registered Users') }}
                    </div>
                    <div class="card-body text-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a class="btn btn-warning">{{ $user->name }}</a></td>
                                    <td><a href="{{ route('onboard', ['uuid' => $user->uuid]) }}"
                                            class="btn btn-dark">Transfer</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
