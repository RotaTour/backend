@extends('layouts.default')

@section('content')
@include('place.submenu')
<h3>Categorias</h3>
<div class="row">
    @foreach($categories as $category)
    <div class="col-md-4">
        <a href="#">{{$category->display_name}}</a>
    </div>
    @endforeach
</div>
@endsection