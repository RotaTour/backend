@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-9">

                <div class="content-page-title">
                    <i class="fa fa-map"></i> Encontre locais próximos
                </div>

                <div class="actions">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#categorias">Categorias</a>
                        <!-- <li><a data-toggle="tab" href="#texto">Texto</a> -->
                        <li><a data-toggle="tab" href="#localizacao">Localização</a>
                        <!-- <li><a data-toggle="tab" href="#palavra-chave">Palavra Chave</a> -->
                        <li><a data-toggle="tab" href="#demonstracao">demonstração</a>
                    </ul>

                    <div class="tab-content">
                        
                        <div id="categorias" class="tab-pane fade in active">
                            <div class="button">
                                <label for="gmap_type">Tipo:</label>
                                <select id="gmap_type" class="select2 selectCat">
                                    <!-- https://developers.google.com/places/web-service/supported_types -->
                                    @foreach($categories as $category)
                                    @if($category->google_name == "point_of_interest")
                                    <option value="{{$category->google_name}}" selected >{{$category->display_name}}</option>
                                    @else
                                    <option value="{{$category->google_name}}">{{$category->display_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="button">
                        
                            <label for="gmap_radius">Raio (em km):</label>
                            <select id="gmap_radius" class="select2 selectRad">
                                <option value="500">0.5</option>
                                <option value="1000">1.0</option>
                                <option value="1500">1.5</option>
                                <option value="5000">5.0</option>
                                <option value="10000">10.0</option>
                                <option value="20000">20.0</option>
                                <option value="30000">30.0</option>
                                <option value="40000">40.0</option>
                                <option value="50000">50.0</option>
                            </select>
                            </div>
                            
                            <div id="button1" class="btn btn-primary pull-right" onclick="findPlaces(); return false;">Pesquisar por categoria</div>
                        </div>

                        <div id="texto" class="tab-pane fade">
                            <div class="button">
                                <label for="gmap_text">Texto:</label>
                                <input id="gmap_text" type="text" name="gmap_text" /></div>
                                <div id="button1" class="btn btn-primary pull-right" onclick="findPlaces(); return false;">Pesquisar por texto</div>
                        </div>

                        <div id="localizacao" class="tab-pane fade">
                            <div class="button">
                                <label for="gmap_where">Mudar localização para:</label>
                                <input id="gmap_where" type="text" name="gmap_where" /></div>
                            <div id="button2" class="btn btn-primary pull-right" onclick="findAddress(); return false;">Mudar localização</div>
                        </div>

                        <div id="palavra-chave" class="tab-pane fade">
                            <div class="button">
                            <label for="gmap_keyword">Palavras chave:</label>
                            <input id="gmap_keyword" type="text" name="gmap_keyword" /></div>
                            <div id="button1" class="btn btn-primary pull-right" onclick="findPlaces(); return false;">Pesquisar palavra chave</div>
                        </div>

                        <div id="demonstracao" class="tab-pane fade">
                            <div class="button">
                                <div id="button2" class="btn btn-default" onclick="resetCeagri(); return false;">Ceagri II</div>
                                <div id="button2" class="btn btn-default" onclick="getCurrentGeo(); return false;">resetar</div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" id="lat" name="lat" />
                    <input type="hidden" id="lng" name="lng" />
                    
                </div>

                <div id="map-render" style="width: 100%; height: 500px"></div>

                <div class="content-page-blue-title">
                    <span id="markCount">0</span> locais dentro do raio de <span id="radValue">500</span> m!
                </div>
                
                <div class="alert-message alert-message-danger" id="div-message-danger">
                    
                </div>

                <div id="markersResult" class="row">

                </div>

            </div>

            <div class="modal fade " id="placeDetails" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title">Detalhes do local</h5>
                        </div>

                        <div class="modal-body">
                        
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@include('place.scripts')
@endsection