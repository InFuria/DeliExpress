@extends('stores.layouts.app')

@section('title', 'Registros')

@section('main')

    <nav class="card rounded shadow-sm border-0 ml-3" style="height: 50px; max-width: 65%">
        @yield('breadcrumb')
    </nav>

    <main class="content container-fluid card shadow-sm border-0 mt-3 ml-3" style="height: 570px; max-width: 65%">
        @include('sweetalert::alert')

        @yield('content')
    </main>
@endsection
