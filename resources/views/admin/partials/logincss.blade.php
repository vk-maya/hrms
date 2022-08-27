<!DOCTYPE html>
<html lang="en" oncontextmenu="return false">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="robots" content="noindex, nofollow">

    @yield('title')

	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">

	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">

	<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">

	<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">

	<style>
		.login-scrum{
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.account-page .main-wrapper.login-scrum .account-content .account-logo{
			margin-bottom: 5px!important;
		}

		</style>
</head>
<body class="account-page">
