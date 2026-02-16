<!DOCTYPE html>
<html lang="id">
<head>
    @include('includes.meta')
    @stack('before-style')
    @include('includes.style')
    @stack('after-style')
</head>
<body>
    <div id="wrapper">
        <x-nav-layout></x-nav-layout>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                {{ $slot }}
            </div>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    @stack('before-script')
    @include('includes.script')
    @stack('after-script')
</body>
</html>
