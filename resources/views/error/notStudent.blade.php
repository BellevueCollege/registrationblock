@extends('layout.app')

@section('title')
<p class="site-title">Registration Block</p>
@endsection

@section('content')
<div class="alert alert-warning">
    <h1>This is not a student account</h1>
    <p>Registration block information is only available for Bellevue College students. You have logged in with a non-student account. <a href="" class="btn btn-default">Log out</a></p>
</div>
@endsection

