<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        Dashboard - {{ auth()->user()->posyandu->nama_posyandu ?? 'Posyandu' }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
