<div class="media" id="route-card-{{$route->id}}">
    <div class="media-left">
        <img src="{{ asset('images/route-64.png') }}" class="media-object" style="width:60px"></img>
    </div>
    <div class="media-body">
        <a href="{{route('route.show', ['id'=>$route->id])}}">
            <h4 class="media-heading">{{ $route->name }}</h4>
        </a>
        <p>{{ $route->body }}</p>
        <p>Criada em: {{ $route->created_at->diffForHumans() }}</p>
        <p>Possui {{ $route->itens()->count() }} Itens</p>
        @unless( isset($hiddenOptions) )
        <p class="pull-right">
            <a href="{{ route('route.show', ['id'=>$route->id]) }}">
                <i class="fa fa-eye"></i>
            </a>
            &nbsp;&nbsp;
            @if($route->user_id == Auth::user()->id)
            <a href="{{ route('route.delete', ['id'=>$route->id]) }}">
                <i class="fa fa-trash"></i>
            </a>
            @endif
        </p>
        @endunless
    </div>
</div>
<hr>