<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/parsley.css') }}">
</head>
<body>
    
    <div id="app">
        <Navbar></Navbar>
        <add-post></add-post>
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/parsley.min.js') }}"></script>
</body>
</html>