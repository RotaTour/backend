<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'categories';
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $categories = [
            //['google_name'=>'','display_name'=>'','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'accounting','display_name'=>'Contabilidade','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'airport','display_name'=>'Aeroporto','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'amusement_park','display_name'=>'Parque de diversões','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'aquarium','display_name'=>'Aquário','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'art_gallery','display_name'=>'Galeria de Arte','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'atm','display_name'=>'Caixa eletrônico','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'bakery','display_name'=>'Padaria','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'bank','display_name'=>'Banco','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'bar','display_name'=>'Bar','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'beauty_salon','display_name'=>'Salão de Beleza','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'bicycle_store','display_name'=>'Loja de Bicicleta','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'book_store','display_name'=>'Livraria','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'bowling_alley','display_name'=>'Pista de boliche','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'bus_station','display_name'=>'Estação de ônibus','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'cafe','display_name'=>'Café','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'campground','display_name'=>'Área de camping','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'car_dealer','display_name'=>'Vendedor de carros','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'car_rental','display_name'=>'Aluguel de carros','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'car_repair','display_name'=>'Oficina (Carro)','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'car_wash','display_name'=>'Lava-jato','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'casino','display_name'=>'Casino','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'cemetery','display_name'=>'Cemitério','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'church','display_name'=>'Igreja','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'city_hall','display_name'=>'Prefeitura','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'clothing_store','display_name'=>'Loja de Roupas','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'convenience_store','display_name'=>'Loja de conveniência','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'courthouse','display_name'=>'Palácio de justiça','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'dentist','display_name'=>'Dentista','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'department_store','display_name'=>'Loja de departamento','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'doctor','display_name'=>'Médico','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'electrician','display_name'=>'Eletricista','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'electronics_store','display_name'=>'Loja de eletrônicos','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'embassy','display_name'=>'Embaixada','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'fire_station','display_name'=>'Bombeiros','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'florist','display_name'=>'Florista','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'funeral_home','display_name'=>'Casa funenária','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'furniture_store','display_name'=>'Loja de móveis','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'gas_station','display_name'=>'Estação de gás','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'gym','display_name'=>'Acadêmia','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'hair_care','display_name'=>'Cuidado com cabelos','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'hardware_store','display_name'=>'Loja de ferramentas','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'hindu_temple','display_name'=>'Templo Hindu','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'home_goods_store','display_name'=>'Loja de bens domésticos','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'hospital','display_name'=>'Hospital','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'insurance_agency','display_name'=>'Agência de seguros','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'jewelry_store','display_name'=>'Loja de Joias','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'laundry','display_name'=>'Lavanderia','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'lawyer','display_name'=>'Advogado','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'library','display_name'=>'Biblioteca','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'liquor_store','display_name'=>'Loja de bebidas','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'local_government_office','display_name'=>'Escritório do governo local','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'locksmith','display_name'=>'chaveiro','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'lodging','display_name'=>'Alojamento','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'meal_delivery','display_name'=>'Entrega de refeições','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'meal_takeaway','display_name'=>'Refeição para viagem','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'mosque','display_name'=>'Mesquita','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'movie_rental','display_name'=>'Locadora de Filmes','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'movie_theater','display_name'=>'Cinema','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'moving_company','display_name'=>'Companhia de mudança','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'museum','display_name'=>'Museu','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'night_club','display_name'=>'Clube Nortuno','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'painter','display_name'=>'Pintor','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'park','display_name'=>'Parque','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'parking','display_name'=>'Estacionamento','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'pet_store','display_name'=>'Loja de animais','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'pharmacy','display_name'=>'Farmácia','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'physiotherapist','display_name'=>'Fisioterapeuta','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'plumber','display_name'=>'Encanador','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'police','display_name'=>'Polícia','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'post_office','display_name'=>'Agência dos Correios','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'real_estate_agency','display_name'=>'Agência imobiliária','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'restaurant','display_name'=>'Restaurante','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'roofing_contractor','display_name'=>'Contratante de cobertura','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'rv_park','display_name'=>'Parque de veículos recreativos','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'school','display_name'=>'Escola','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'shoe_store','display_name'=>'Loja de Sapatos','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'shopping_mall','display_name'=>'Shopping Center','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'spa','display_name'=>'Spa','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'stadium','display_name'=>'Estádio','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'storage','display_name'=>'Armazem','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'store','display_name'=>'Loja','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'subway_station','display_name'=>'Estação de Metrô','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'synagogue','display_name'=>'Sinagoga','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'taxi_stand','display_name'=>'Ponto de Taxi','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'train_station','display_name'=>'Estação de Trem','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'transit_station','display_name'=>'transit_station','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'travel_agency','display_name'=>'Agência de turismo','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'university','display_name'=>'Universidade','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'veterinary_care','display_name'=>'Veterinário','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'zoo','display_name'=>'Zoológico','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'administrative_area_level_1','display_name'=>'administrative_area_level_1','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'administrative_area_level_2','display_name'=>'administrative_area_level_2','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'administrative_area_level_3','display_name'=>'administrative_area_level_3','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'administrative_area_level_4','display_name'=>'administrative_area_level_4','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'administrative_area_level_5','display_name'=>'administrative_area_level_5','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'colloquial_area','display_name'=>'Área coloquial','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'country','display_name'=>'País','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'establishment','display_name'=>'Estabelecimento','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'finance','display_name'=>'Finança','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'floor','display_name'=>'Piso','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'food','display_name'=>'Comida','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'general_contractor','display_name'=>'Empreiteiro geral','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'geocode','display_name'=>'geocode','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'health','display_name'=>'Saúde','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'intersection','display_name'=>'interseção','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'locality','display_name'=>'localidade','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'natural_feature','display_name'=>'Característica natural','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'neighborhood','display_name'=>'Bairro','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'place_of_worship','display_name'=>'Local de culto','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'political','display_name'=>'Político','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'point_of_interest','display_name'=>'Ponto de interesse','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'post_box','display_name'=>'Caixa postal','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'postal_code','display_name'=>'Código postal','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'postal_code_prefix','display_name'=>'prefixo do código postal','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'postal_code_suffix','display_name'=>'sufixo de código postal','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'postal_town','display_name'=>'Cidade postal','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'premise','display_name'=>'premissa (prédio)','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'room','display_name'=>'sala','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'route','display_name'=>'rota','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'street_address','display_name'=>'Endereço de rua','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'street_number','display_name'=>'Número de rua','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'sublocality','display_name'=>'Sublocalidade','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'sublocality_level_4','display_name'=>'sublocality_level_4','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'sublocality_level_5','display_name'=>'sublocality_level_5','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'sublocality_level_3','display_name'=>'sublocality_level_3','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'sublocality_level_2','display_name'=>'sublocality_level_2','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'sublocality_level_1','display_name'=>'sublocality_level_1','created_at'=> $now,'updated_at' => $now],
            ['google_name'=>'subpremise','display_name'=>'subpremise','created_at'=> $now,'updated_at' => $now],
        ];
        DB::table($table)->insert($categories);
    }
}
