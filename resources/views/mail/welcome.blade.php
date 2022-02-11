@extends('mail.layout')

@section('content')

    <h1>Hi {{ $name  }}</h1>

    <p>

        Welcome to the learning management application!

    </p>

    <p>

        Address: <a href="{{ $link }}" target="_blank">{{ $link }}</a>

    </p>

    <p>

        Password: {{ $password }}

    </p>

    <span>Please, make sure to change your password on your profile page.</span>

@endsection
