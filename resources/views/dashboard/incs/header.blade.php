<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />

  <title>CP | @yield('title_of_page')</title>
  
  <!-- App.css -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" />
  
   <!-- Theme style -->
  @if(app()->getlocale() == 'en')
    <link rel="stylesheet" href="{{asset('css/dashboard_ltr.css')}}" />
  @else
    <link rel="stylesheet" href="{{asset('css/bootstrap-rtl.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/dashboard_rtl.css')}}" />
  @endif
  <!-- Custom Style -->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
  <!-- Color Style -->
  <link rel="stylesheet" href="{{asset('css/skins/skin-blue.css')}}" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">