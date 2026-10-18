@extends('errors.fancy')

@section('title', '403 Server Error')
@section('code', '403')
@section('message')
    {{ $message ?? 'Access denied.' }}
@endsection

@section('error_ref')
    @if(isset($error_ref))
        <p class="mt-4 text-sm text-gray-600">
            Error Reference:
            <span class="font-mono text-red-600">{{ $error_ref }}</span>
        </p>
    @endif
@endsection
