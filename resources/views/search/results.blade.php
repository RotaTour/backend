@extends('layouts.app')
@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#users">Users ({{ $users->count() }})</a></li>
                </ul>

                <div class="tab-content">

                    <div id="users" class="tab-pane fade">

                        @if($users->count() == 0)

                            <div class="alert-message alert-message-default">
                                <h4>Nada encontrado!</h4>
                            </div>

                        @else
                            <div class="m-t-20"></div>
                            <div class="row">
                                    @foreach($users as $user_p)

                                        <div class="col-sm-6 col-md-4">
                                            <div class="card-container">
                                                <div class="card">
                                                    <div class="front">
                                                        <div class="cover"></div>
                                                        <div class="content" style="padding-bottom: 20px">
                                                            <div class="main">
                                                                <a href="{{ route('profile.show', ['username'=>$user_p->getUsernameOrEmail()]) }}">
                                                                    <h3 class="name">{{ $user_p->name }}</h3>
                                                                    <p class="profession">
                                                                        {{ '@'.$user_p->username }}
                                                                        <small>{{ $user_p->location }}</small>
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                            </div>
                        @endif


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection