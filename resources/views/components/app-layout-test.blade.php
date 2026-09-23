@extends('layouts.app')

@section('content')
    <div style="background: yellow; padding: 20px; font-weight: bold;">
        TES BERHASIL - app-layout.blade.php TERPAKAI
    </div>
    {{ $slot }}
@endsection
