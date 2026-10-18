@extends('errors.hosterror')

@section('title', '400 Bad Request')
@section('code', '400')
@section('message', $exception->getMessage() ?? 'Bad Request')