@if( isset($routes))
    @include('place.routes')
@endif
<div class="media">
    <span class="pull-left" >
        <img src="{{ $place->google_json->result->icon }}" 
        alt="{{ $place->google_json->result->name }}" 
        class="media-object">
    </span>
    <div class="media-body">
        <h4 class="media-heading">
            {{ $place->google_json->result->name }}
        </h4>
        <p>
            Endereço: {{ $place->google_json->result->formatted_address }} <br>
            
            @if(isset($place->google_json->result->formatted_phone_number))
            Telefone: {{ $place->google_json->result->formatted_phone_number }} <br>
            @endif
            
            Origem dos dados: {{ $place->google_json->result->scope }} <br>
            
            @if(isset($place->google_json->result->website))
            Website: <a href="{{ $place->google_json->result->website }}" target="_blank">
            {{ $place->google_json->result->website }}
            </a><br>
            @endif
            
            @if( !isset($place_id))
            Mais detalhes: <a href="{{ route('place.show') }}?place_id={{ $place->google_place_id}}">
                {{ $place->google_json->result->name }}
            </a>
            @endif
        </p>
    </div>
</div>
