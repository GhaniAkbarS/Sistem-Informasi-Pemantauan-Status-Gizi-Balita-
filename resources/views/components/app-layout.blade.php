<!DOCTYPE html>
<html lang="id">
<head>
    @include('includes.meta')
    @stack('before-style')
    @include('includes.style')
    @stack('after-style')
</head>
<body>
    <x-nav-layout></x-nav-layout>
    {{ $slot }}

    @stack('before-script')
    @include('includes.script')
    @stack('after-script')
</body>
</html>
