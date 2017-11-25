@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('status.store') }}" method="post" role="form">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('status') ? 'has-error': '' }}">
                <textarea name="status" rows="2" class="form-control" placeholder="Quer compartilhar algo {{Auth::user()->getFirstNameOrUsername()}}?"></textarea>
                @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">Publicar status</button>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-5">
        <!--Timeline statuses and replies -->
        @if(!$statuses->count())
        <p>Não há o que mostrar na sua linha do tempo, ainda.</p>
        @else
            @foreach($statuses as $status)
                @include('timeline.status')
            @endforeach

            {!! $statuses->render() !!}
        @endif
    </div>
</div>
@endsection