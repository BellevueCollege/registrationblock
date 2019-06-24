<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en-US" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en-US" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-US" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-US" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-US" class="no-js">
<!--<![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--- Open Graph Tags -->
	<meta property="og:type" content="website" />
	<meta property="og:image" content="https://www.bellevuecollege.edu/bc-og-default.jpg" />
	
	<meta property="og:url" content="{{ config('app.url') }}" />
	<meta property="og:site_name" content="Bellevue College" />

	<title>Registration Blocks @ Bellevue College</title>

	<link rel='stylesheet' id='globals-css'  href='{{ config('globals.uri') }}/c/g.css?ver={{ config('globals.version') }}' type='text/css' media='screen' />
	<link rel='stylesheet' id='globals-print-css'  href='{{ config('globals.uri') }}/c/p.css?ver={{ config('globals.version') }}' type='text/css' media='print' />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type='text/javascript' src='{{ config('globals.uri') }}/j/ghead-full.min.js?ver={{ config('globals.version') }}'></script>

	<?php include(config('globals.path') . '/h/gabranded.html') ?>

</head>

<body class="nav-services">

	<?php include(config('globals.path') . '/h/bhead.html') ?>

	<div id="main-wrap" class="globals-branded">
		<div id="main" class="container no-padding">
			<div class="content-padding">
				<div id="site-header">
					@yield('title')
				</div><!-- container header -->
			</div><!-- content-padding -->
			<div class="row">
				<div class="col-md-12">
					<div id="content"  class="box-shadow">
						<div class="row row-padding">
							<div class="col-md-12">
								<main role="main">
									<div class="content-padding" data-swiftype-name="body" data-swiftype-type="text" style="margin-top: 1em;">
										<div class="pull-right">You are logged in as {{ $username }}. <a href="{{ $logout }}" class="btn btn-default">Log Out</a></div>
										@yield('content')
									</div><!--.content-padding-->
								</main>
							</div>
						</div>
					</div><!-- #content-->
				</div><!-- row -->
			</div><!-- col-md-12 -->
		</div><!-- #main .container -->
	</div><!-- #main-wrap -->

	<?php include(config('globals.path') . '/h/bfoot.html') ?>

	<?php include(config('globals.path') . '/h/legal.html') ?>


	<script type='text/javascript' src='{{ config('globals.uri') }}/j/gfoot-full.min.js?ver={{ config('globals.version') }}'></script>


</body>
</html>
