<div class="container-fluid">
    <div class="row">
        <div class="cover no-cover">
            @if( isset($my_profile) )
                <div class="loading-cover">
                    <img src="{{ asset('images/rolling.gif') }}" alt="">
                </div>
            @endif
            <div class="bar">
                <div class="container">
                    <div class="profile-image">
                        @if( isset($my_profile) )
                            <div class="loading-image">
                                <img src="{{ asset('images/rolling.gif') }}" alt="">
                            </div>
                            <form id="form-upload-profile-photo" enctype="multipart/form-data">
                                <div class="change-image">
                                    <a href="javascript:;" class="upload-button" onclick="uploadProfilePhoto()"><i class="fa fa-upload"></i> Upload Photo</a>
                                    <input type="file" accept="image/*" name="profile-photo" class="profile_photo_input">
                                </div>
                            </form>
                        @endif
                        <a data-fancybox="group" href="{{ $user->getAvatarUrl() }}">
                            <img class="image-profile" src="{{ $user->getAvatarUrl() }}" alt="" />
                        </a>
                    </div>
                    <div class="profile-text">
                        <h2>{{ $user->name }}</h2>
                        <h4>{{ '@'.$user->username }}</h4>
                        
                    </div>
                    
                        @unless( (Auth::user()->id == $user->id) )
                        <div class="profile-follow">
                            <div class="profile-follow-b1 pull-left" style="margin-right: 10px">
                                <!-- Friends, friends requests -->
                                @if(Auth::user()->hasFriendRequestPending($user))
                                    <p>Esperando por {{ $user->getNameOrUsername() }} aceitar a sua solicitação de amizade</p>
                                @elseif(Auth::user()->hasFriendRequestReceived($user))
                                    <a href="{{route('friend.accept', ['email'=>$user->email])}}" class="btn btn-primary">Aceitar a requisição de amizade</a>
                                @elseif (Auth::user()->isFriendsWith($user))
                                    <p>Você e {{ $user->getNameOrUsername() }} são amigos</p>

                                    <form action="{{route('friend.leave', ['email'=>$user->email])}}" method="post">
                                        {{ csrf_field() }}
                                        <input type="submit" value="Deixar a amizade" class="btn btn-primary">
                                    </form>

                                @elseif (Auth::user()->id != $user->id )
                                    <a href="{{route('friend.add', ['email'=>$user->email])}}" class="btn btn-primary">Adicionar como amigo</a>
                                @endif
                                <!--/ Friends, friends requests -->
                            </div>
                        </div>
                        @endunless
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>