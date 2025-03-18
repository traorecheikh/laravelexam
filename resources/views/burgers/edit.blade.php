@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le Burger</h1>
        <form action="{{ route('burgers.update', $burger) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('burgers._form', ['burger' => $burger])
            <button type="submit" class="btn btn-success mt-3">Mettre à jour</button>
        </form>
    </div>
@endsection
