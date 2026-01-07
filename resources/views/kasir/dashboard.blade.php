@extends('layouts.kasir')

@section('content')
<h1 class="text-2xl font-bold">Dashboard Kasir</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>
@endsection