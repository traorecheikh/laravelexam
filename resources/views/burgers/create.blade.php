@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter un Burger</h1>
        <form action="{{ route('burgers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('burgers._form', ['burger' => new App\Models\Burger])
            <button type="submit" class="btn btn-success mt-3">Ajouter</button>
        </form>
    </div>
@endsection
