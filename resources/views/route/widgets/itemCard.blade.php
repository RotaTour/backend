<div class="media" id="item-card-{{$item->id}}">
    <div class="media-left">
        <img src="{{ $item->place->json()->result->icon }}" class="media-object" style="width:60px">
    </div>
    <div class="media-body">
        <a href="{{route('place.show', ['place_id'=>$item->place->google_place_id])}}">
            <h4 class="media-heading">{{ $item->place->json()->result->name }}</h4>
        </a>
        <p>{{ $item->place->json()->result->formatted_address }}</p>
        <p>Adicionado em: {{ $item->created_at->diffForHumans() }}</p>
        <p class="pull-right">
            <a href="#" id="item-check-{{$item->id}}">
                @if($item->done)
                <i class="fa fa-check-square-o"></i>
                @else
                <i class="fa fa-square-o"></i>
                @endif
            </a>
            &nbsp;&nbsp;
            <a href="{{route('place.show', ['place_id'=>$item->place->google_place_id])}}">
                <i class="fa fa-eye"></i>
            </a>
            @if($item->route->user_id == Auth::user()->id)
            &nbsp;&nbsp;
            <a href="{{ route('item.delete', ['id'=>$item->id]) }}">
                <i class="fa fa-trash"></i>
            </a>
            @endif
        </p>
    </div>
</div>
<hr>