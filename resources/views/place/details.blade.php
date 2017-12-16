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
            Telefone: {{ $place->google_json->result->formatted_phone_number }} <br>
            Origem dos dados: {{ $place->google_json->result->scope }} <br>
            Website: <a href="{{ $place->google_json->result->website }}" target="_blank">
            {{ $place->google_json->result->website }}
            </a>
        </p>
    </div>
</div>
