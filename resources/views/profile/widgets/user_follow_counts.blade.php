<div class="count_widget">
    <div class="row">
        <div class="col-xs-4">
            <a class="blue" href="{{ url('/'.$user->username) }}">
                0
            </a>
            POSTS
        </div>
        <div class="col-xs-4">
            <a class="green" href="{{ url('/'.$user->username.'/following') }}">
                0
            </a>
            FOLLOWING
        </div>
        <div class="col-xs-4">
            <a class="purple" href="{{ url('/'.$user->username.'/followers') }}">
                0
            </a>
            FOLLOWERS
        </div>
    </div>
</div>
