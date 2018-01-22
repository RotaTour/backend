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
                                @include('friends.widgets.friendship')
                            </div>
                        </div>
                        @endunless
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>