@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-9">

                <div class="content-page-title">
                    <i class="fa fa-map"></i> Categorias ( {{$categories->count()}} )
                </div>

                <div class="row">
                    @foreach($categories as $category)
                    <div class="col-md-4">
                        <a href="">{{$category->display_name}}</a>
                    </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
@endsection