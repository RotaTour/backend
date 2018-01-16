<div class="panel panel-default suggested-people">
    <div class="panel-heading">Amizades sugeridas</div>
    <ul class="list-group">
        
        <!-- laço de repetição com a sugestão de amizades -->
        <li class="list-group-item">
            <div class="col-xs-12 col-sm-3">
                <a href="{{ url('/nome1') }}">
                    <img src="{{ asset('images/profile-picture.png') }}" alt="nome1" class="img-circle" />
                </a>
            </div>
            <div class="col-xs-12 col-sm-9">
                <a href="{{ url('/nome1') }}">
                    <span class="name">Nome1</span><small>@nome1</small><br />
                </a>
                <div id="people-listed-id1">
                    <a  
                        href="javascript:;" 
                        class="btn btn-default request-button btn-sm" 
                        onclick="console.log('Seguir sugestão')">
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
        </li>

        <li class="list-group-item">
            <div class="col-xs-12 col-sm-3">
                <a href="{{ url('/nome2') }}">
                    <img src="{{ asset('images/profile-picture.png') }}" alt="nome2" class="img-circle" />
                </a>
            </div>
            <div class="col-xs-12 col-sm-9">
                <a href="{{ url('/nome2') }}">
                    <span class="name">Nome2</span><small>@nome2</small><br />
                </a>
                <div id="people-listed-id2">
                    <a  
                        href="javascript:;" 
                        class="btn btn-default request-button btn-sm" 
                        onclick="console.log('Seguir sugestão')">
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
        </li>

        <li class="list-group-item">
            <div class="col-xs-12 col-sm-3">
                <a href="{{ url('/nome3') }}">
                    <img src="{{ asset('images/profile-picture.png') }}" alt="nome3" class="img-circle" />
                </a>
            </div>
            <div class="col-xs-12 col-sm-9">
                <a href="{{ url('/nome3') }}">
                    <span class="name">Nome3</span><small>@nome3</small><br />
                </a>
                <div id="people-listed-id3">
                    <a  
                        href="javascript:;" 
                        class="btn btn-default request-button btn-sm" 
                        onclick="console.log('Seguir sugestão')">
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
        </li>
        
    </ul>
</div>