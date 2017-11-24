@extends('layouts.default')

@section('content')
    <h3>Sua pesquisa por "{{ Request::input('query') }}"</h3>

    @if( !$users->count() )
    <p>Sem resultados, desculpe.</p>
    @else
    <div class="rows">
        <div class="col-lg-12">
            @foreach($users as $user)
            @include('users.partials.userblock')
            @endforeach
        </div>
    </div>
    @endif
@endsection