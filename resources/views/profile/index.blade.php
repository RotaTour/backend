@extends('layouts.default')

@section('content')
<div class="col-lg-5">
    <!-- User information and statuses -->
    @if( isset($user) )
    @include('users.partials.userblock')
    @else
    User nao definido
    @endif
    <hr>
</div>

<div class="col-lg-4 col-lg-offset-3">
    <!-- Friends, friends requests -->
</div>
@endsection

