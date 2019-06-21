@extends('layout.app')

@section('title')
<h1 class="site-title">Registration Block</h1>
@endsection

@section('content')
<ul>
    <li>First Name: {{ $firstName }}</li>
    <li>Last Name: {{ $lastName }}</li>
    <li>Email: {{ $email }}</li>
    <li>SID: {{ $SID }}</li>
</ul>
@endsection

