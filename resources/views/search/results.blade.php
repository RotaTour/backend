@extends('layouts.app')
@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#users">Pessoas ({{ $users->count() }})</a></li>
                </ul>

                <div class="tab-content">

                    <div id="users" class="tab-pane fade in active">

                        @if($users->count() == 0)

                            <div class="alert-message alert-message-default">
                                <h4>Nada encontrado!</h4>
                            </div>

                        @else
                            <div class="m-t-20"></div>
                            <div class="row">
                                @foreach($users as $user_p)
                                @include('profile.widgets.box')
                                @endforeach
                            </div>
                        @endif


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection