@extends('errors.fancy')

@section('title', '400 Server Error')
@section('code', '400')
@section('message')
    Oops! Something went wrong.
@endsection

@section('error_ref')
    @if(isset($error_ref))
        <p class="mt-4 text-sm text-gray-600">
            Error Reference:
            <span class="font-mono text-red-600">{{ $error_ref }}</span>
            <br>
            Error code:
            <span class="font-mono text-red-600">{{ $code }}</span>
        </p>
    @endif
@endsection
