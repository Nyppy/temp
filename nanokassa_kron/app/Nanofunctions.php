<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 19.01.19
 * Time: 19:44
 */

namespace App;

use App\Nanoparams as nanoP;

class Nanofunctions
{
    static function dropdown_list($list, $value) {
        if (is_array($value)) {
            foreach($list as $key => $item){
                echo "<option value='$key' ".(in_array($key, $value)?'selected="selected"':'').">$item</option>";
            }
        } else {
            foreach($list as $key => $item){
                echo "<option value='$key' ".($key==$value?'selected="selected"':'').">$item</option>";
            }
        }
    }

    static function nalog_type_list() {
        $list = array(
            0 => 'Общая система налогообложения',
            1 => 'Упрощенная доход',
            2 => 'Упрощенная доход минус расход',
            3 => 'Единый налог на вмененный доход',
            4 => 'Единый сельскохозяйственный налог',
            5 => 'Патентная система налогообложения',
        );
        //return ($list, $value);
        return ($list);
    }

    static function random_bytes_mod($len) {
        if (function_exists('random_bytes')) {
            $rand_by = random_bytes($len);
        } else {
            $rand_by = openssl_random_pseudo_bytes($len);
        }
        return ($rand_by);
    }

    static function dropdown_yesno_list() {
        $list = array(
            0 => 'Нет',
            1 => 'Да',
        );
        return ($list);
    }

    static function dropdown_type_check_list() {
        $list = array(
            1 => 'email',
            2 => 'sms',
        );
        return ($list);
    }

    static function dropdown_type_corr_list() {
        $list = array(
            0 => 'Самостоятельно',
            1 => 'По предписанию',
        );
        return ($list);
    }

    static function nds_list_wordpress_wc() {
        $list = array(
            70 => 'Брать ставку НДС из атрибута товара',
            1 => 'Ставка НДС 18%',
            2 => 'Ставка НДС 10%',
            3 => 'Ставка НДС 18/118',
            4 => 'Ставка НДС 10/110',
            5 => 'Ставка НДС 0',
            6 => 'Без НДС',
        );
        return ($list);
    }

    static function nds_list() {
        $list = array(
            // 70 => 'Брать ставку НДС из атрибута товара',
            1 => 'Ставка НДС 18%',
            2 => 'Ставка НДС 10%',
            3 => 'Ставка НДС 18/118',
            4 => 'Ставка НДС 10/110',
            5 => 'Ставка НДС 0',
            6 => 'Без НДС',
        );
        return ($list);
    }

    static function crypt_nanokassa_first ($cleardata) {
        $IVdata = self::random_bytes_mod(16);
        $pw = self::random_bytes_mod(32);
        $mk = nanoP::HMAC_FIRST;
        $dataAES = openssl_encrypt($cleardata, "aes-256-ctr", $pw, OPENSSL_RAW_DATA, $IVdata);
        $hmac = hash_hmac('sha512', $IVdata.$dataAES, base64_decode($mk), true);
        $returnDataDE = base64_encode($hmac.$IVdata.$dataAES);
        openssl_public_encrypt($pw, $ab_rsa, nanoP::RSA_PUB_FIRST, OPENSSL_PKCS1_OAEP_PADDING);
        $ab = base64_encode ($ab_rsa);
        $ret_arr = array($ab, $returnDataDE);

        return ($ret_arr);
    }

    static function crypt_nanokassa_second ($cleardata) {
        $IVdata2 = self::random_bytes_mod(16);
        $pw2 = self::random_bytes_mod(32);
        $mk2 = nanoP::HMAC_SECOND;
        $dataAES2 = openssl_encrypt($cleardata, "aes-256-ctr", $pw2, OPENSSL_RAW_DATA, $IVdata2);
        $hmac2 = hash_hmac('sha512', $IVdata2.$dataAES2, base64_decode($mk2), true);
        $returnDataDE2 = base64_encode($hmac2.$IVdata2.$dataAES2);
        openssl_public_encrypt($pw2, $aab_rsa, nanoP::RSA_PUB_SECOND, OPENSSL_PKCS1_OAEP_PADDING);
        $aab = base64_encode ($aab_rsa);
        $ret_arr = array($aab, $returnDataDE2);

        return ($ret_arr);
    }

    static function nds_dostavka_list_wordpress_wc() {
        $list = array(
            // 70 =>'Брать ставку НДС из настроек налогов woocommerce',
            1 => 'Ставка НДС 18%',
            2 => 'Ставка НДС 10%',
            3 => 'Ставка НДС 18/118',
            4 => 'Ставка НДС 10/110',
            5 => 'Ставка НДС 0',
            6 => 'Без НДС',
        );
        return ($list);
    }

    static function nds_dostavka_list() {
        $list = array(
            1 => 'Ставка НДС 18%',
            2 => 'Ставка НДС 10%',
            3 => 'Ставка НДС 18/118',
            4 => 'Ставка НДС 10/110',
            5 => 'Ставка НДС 0',
            6 => 'Без НДС',
        );
        return ($list);
    }

    static function priznak_sposoba_rascheta_list() {
        $list = array(
            70 => 'Брать признак способа расчета из атрибута товара',
            1 => 'Полная предварительная оплата до момента передачи предмета расчета',
            2 => 'Частичная предварительная оплата до момента передачи предмета расчета',
            3 => 'Аванс',
            4 => 'Полная оплата, в том числе с учетом аванса (предварительной оплаты) в момент передачи предмета расчета',
            5 => 'Частичная оплата предмета расчета в момент его передачи с последующей оплатой в кредит',
            6 => 'Передача предмета расчета без его оплаты в момент его передачи с последующей оплатой в кредит',
            7 => 'Оплата предмета расчета после его передачи с оплатой в кредит (оплата кредита)',
        );
        return ($list);
    }


    static function priznak_predmeta_rascheta_list() {
        $list = array(
            70 => 'Брать признак предмета расчета из атрибута товара',
            1 => 'Реализуемый товар, за исключением подакцизного товара (1)',
            2 => 'Реализуемый подакцизный товар (2)',
            3 => 'Выполняемая работа (3)',
            4 => 'Оказываемая услуга (4)',
            5 => 'Прием ставок при осуществлении деятельности по проведению азартных игр (5)',
            6 => 'Выплата денежных средств в виде выигрыша при осуществлении деятельности по проведению азартных игр (6)',
            8 => 'Выплата денежных средств в виде выигрыша при осуществлении деятельности по проведению лотерей (8)',
            9 => 'Предоставление прав на использование результатов интеллектуальной деятельности или средств индивидуализации (9)',
            10 => 'Аванс, задаток, предоплата, кредит, взнос в счет оплаты, пеня, штраф, вознаграждение, бонус и иной аналогичный предмет расчета (10)',
            11 => 'Вознаграждение пользователя, являющимся платежным агентом (11)',
            12 => 'Предмет расчета, состоящем из предметов, каждому из которых может быть присвоено значение от «1» до «11» (12)',
            13 => 'Предмет расчета, не относящемуся к предметам расчета, которым может быть присвоено значение от «1» до «12» (13)',
        );
        return ($list);
    }

    static function priznak_agenta_list() {
        $list = array(
            70 => 'Брать признак агента из атрибута товара',
            40 => 'Пользователь ККТ не является платежным агентом по всем предметам расчета',
            0  => 'Оказание услуг покупателю (клиенту) пользователем, являющимся банковским платежным агентом',
            1  => 'Оказание услуг покупателю (клиенту) пользователем, являющимся банковским платежным субагентом',
            2  => 'Оказание услуг покупателю (клиенту) пользователем, являющимся платежным агентом',
            3  => 'Оказание услуг покупателю (клиенту) пользователем, являющимся платежным субагентом',
            4  => 'Осуществление расчета с покупателем (клиентом) пользователем, являющимся поверенным',
            5  => 'Осуществление расчета с покупателем (клиентом) пользователем, являющимся комиссионером',
            6  => 'Осуществление расчета с покупателем (клиентом) пользователем, являющимся агентом и не являющимся банковским платежным агентом',
        );
        return ($list);
    }

    static function sndcurl($request, $url) {
        if (function_exists('curl_init')) {
            $curl = @curl_init();
            @curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
            @curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
            @curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            @curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            @curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            @curl_setopt($curl, CURLOPT_POST, true);
            @curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            $tp = @curl_exec($curl);
        } else {
            $tp = 'error, curl not installed on server';
        }
        return ($tp);
    }

}