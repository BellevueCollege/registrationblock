@extends('layout.app')

@section('content')
<div class="alert alert-warning">
    <h1>Error: Unable to retrieve student account</h1>
    <p>Registration block information is only available for Bellevue College students. You may have logged in with a non-student account, or an error has occurred. <a href="{{ $logout }}" class="btn btn-default">Log out</a></p>
</div>
@endsection

