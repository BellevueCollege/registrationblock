@extends('layout.app')

@section('title')
<h1 class="site-title">Registration Block</h1>
@endsection

@section('content')
<h2>You have the following blocks on your account</h2>
<ol>
@foreach ($userData['blocks'] as $block)
<li>{{ $block->reason }}</li>
@endforeach
</ol>
@endsection

