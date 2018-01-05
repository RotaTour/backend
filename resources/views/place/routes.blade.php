<div class="pull-right form-group">
    <div id="addToRouteForm">
        <select name="addToRouteSelect" id="addToRouteSelect">
            @foreach($routes as $route)
            <option value="{{$route->id}}">{{$route->name}}</option>
            @endforeach
        </select>
        <button id="addToRouteButton" class="btn btn-success btn-sm" onclick="addToRoute(); return false;">Adicionar na Rota</button>
    </div>
    <div id="resultForm"></div>
</div>
