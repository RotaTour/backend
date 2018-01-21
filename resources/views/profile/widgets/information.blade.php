<div class="profile-information">
    @if( isset($my_profile) )
        <div class="edit-button">
            <div class="button-frame">
                <a href="javascript:;" data-toggle="modal" data-target="#profileInformation">
                    <i class="fa fa-pencil"></i>
                    Edit
                </a>
            </div>
        </div>
    @endif
    <ul class="list-group">
        @if( $user->location != null )
        <li class="list-group-item">
            <i class="fa fa-map-marker"></i>
            {{ $user->location }}
        </li>
        @endif
        
    </ul>
</div>