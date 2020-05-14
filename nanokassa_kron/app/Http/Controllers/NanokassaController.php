<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 19.01.19
 * Time: 19:39
 */

namespace App\Http\Controllers;

use App\Nanofunctions as nanoF;
use App\Nanoparams as nanoP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NanokassaController extends Controller
{
    /**
     * @param Request $req
     */
    public function send(Request $req)
    {
        Log::notice('Пришел запрос ' . print_r($req->all(), true));

        $data = $req->all();

        $kassaid    = '122383';
        $kassatoken = '5365daec9e2aded58a7c7a989a3ba926';

        $requestToNanokassa = [
            "kassaid"         => $kassaid,
            "kassatoken"      => $kassatoken,
            "cms"             => "wordpress",
            "check_send_type" => "email",
            "products_arr"    => [
                "name_tovar"                => $data['products_arr']['name_tovar'],
                "price_piece_bez_skidki"    => $data['products_arr']['price_piece_bez_skidki'],
                "kolvo"                     => $data['products_arr']['kolvo'],
                "price_piece"               => $data['products_arr']['price_piece'],
                "summa"                     => $data['products_arr']['summa'],
                "stavka_nds"                => $data['products_arr']['stavka_nds'],
                "priznak_sposoba_rascheta"  => $data['products_arr']['priznak_sposoba_rascheta'],
                "priznak_predmeta_rascheta" => $data['products_arr']['priznak_predmeta_rascheta'],
                "priznak_agenta"            => $data['products_arr']['priznak_agenta']
            ],
            "oplata_arr"      => [
                "rezhim_nalog"     => $data['oplata_arr']['rezhim_nalog'],
                "money_nal"        => $data['oplata_arr']['money_nal'],
                "money_electro"    => $data['oplata_arr']['money_electro'],
                "money_predoplata" => $data['oplata_arr']['money_predoplata'],
                "money_postoplata" => $data['oplata_arr']['money_postoplata'],
                "money_vstrecha"   => $data['oplata_arr']['money_vstrecha'],
                "client_email"     => $data['oplata_arr']['client_email'],
                "client_phone"     => $data['oplata_arr']['client_phone']
            ],
            "itog_arr"        => [
                "priznak_rascheta" => $data['itog_arr']['priznak_rascheta'],
                "itog_cheka"       => $data['itog_arr']['itog_cheka']
            ],
        ];

        $firstcrypt   = nanoF::crypt_nanokassa_first(json_encode($requestToNanokassa));
        $returnDataAB = $firstcrypt[0];
        $returnDataDE = $firstcrypt[1];
        $request2     = '{
	"ab":"' . $returnDataAB . '",
	"de":"' . $returnDataDE . '",
	"kassaid":"' . $kassaid . '",
	"kassatoken":"' . $kassatoken . '",
	"test":"0"
}';

        $secondcrypt   = nanoF::crypt_nanokassa_second($request2);
        $returnDataAAB = $secondcrypt[0];
        $returnDataDE2 = $secondcrypt[1];
        $request3      = '{
	"aab":"' . $returnDataAAB . '",
	"dde":"' . $returnDataDE2 . '",
	"test":"0"
}';

        $url    = nanoP::URL_TO_SEND_TO_NANOKASSA;
        $answer = nanoF::sndcurl($request3, $url);

        return response()->json(['answer' => $answer], 200, ['Content-Type' => 'application/json']);
    }
}