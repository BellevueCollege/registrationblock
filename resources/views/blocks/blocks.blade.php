@extends('layout.app')

@section('title')
<h1 class="site-title">Registration Block</h1>
@endsection

@section('content')
<ul>
    <li>First Name: {{ $userData['firstName'] }}</li>
    <li>Last Name: {{ $userData['lastName'] }}</li>
</ul>
@endsection

