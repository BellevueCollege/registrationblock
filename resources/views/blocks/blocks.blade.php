@extends('layout.app')

@section('content')
<h1>You have the following blocks on your account</h1>
<ol>
@foreach ($userData['blocks'] as $block)
<li>{{ $block->reason }}</li>
@endforeach
</ol>
<p>If instructions on how to a remove block are not listed, please <a href="https://www2.bellevuecollege.edu/sc-requests/submit-ticket/">contact Enrollment &amp; Registrar Services</a>.</p>
@endsection

