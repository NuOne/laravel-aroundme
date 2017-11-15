<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getPlaceDetails(Request $request){
        $placeId = $request->get('placeId');
        $URL = 'https://maps.googleapis.com/maps/api/place/details/json?placeid='.$placeId.'&key='.env('GOOGLE_PLACE_API_KEY');
        $json = file_get_contents($URL);
        $data = json_decode($json);
        $html = ''; $status = false;
        if($data->status == 'OK') {
            $response = $data->result;
            $types = '';
            $phone = '';
            $status = true;
            foreach ($response->types as $type) {
                $types .= ' <span class="badge badge-success">'.$type.'</span>';
            }

            if(isset($response->formatted_phone_number))
                $phone = $response->formatted_phone_number;

            $html = '</div><hr class="featurette-divider"><div class="row featurette">' .
                '<div class="col-md-7">' .
                '<h2 class="featurette-heading">' .$response->name. '</h2>' . $types.
                '<h3></h3>' . $phone .
                '<p class="lead">'.$response->adr_address.'</p>' .
                '</div>' ;
                if(isset($response->photos) and is_array($response->photos)) {
                    $photos = $response->photos;
                    $html .= '<div class="col-md-5">' .
                    '<img class="featurette-image img-fluid mx-auto" src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='.$photos[0]->photo_reference.'&key='.env('GOOGLE_PLACE_API_KEY').'" alt="Generic placeholder image">' .
                    '</div>' ;
                }
                $html.= '</div><hr class="featurette-divider">';
        }

        return $this->printJson($status,$html);
    }
}
