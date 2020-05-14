<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 19.01.19
 * Time: 19:45
 */

namespace App;

class Nanoparams
{
    // Тип налогообложения
    const NALOG_TYPE_OSN    = 0; // Общая система налогообложения
    const NALOG_TYPE_USN_D  = 1; // Упрощенная доход
    const NALOG_TYPE_USN_DR = 2; // Упрощенная доход минус расход
    const NALOG_TYPE_ENVD   = 3; // Единый налог на вмененный доход
    const NALOG_TYPE_ESN    = 4; // Единый сельскохозяйственный налог
    const NALOG_TYPE_PSN    = 5; // Патентная система налогообложения

    // Ставка НДС
    const STAVKA_NDS_18  = 1; // Ставка НДС 18
    const STAVKA_NDS_10  = 2; // Ставка НДС 10
    const STAVKA_NDS_118 = 3; // Ставка НДС 18/118
    const STAVKA_NDS_110 = 4; // Ставка НДС 10/110
    const STAVKA_NDS_0   = 5; // Ставка НДС 0
    const STAVKA_NDS_BEZ = 6; // Без НДС

    // Признак расчета
    const OPERATION_PRIHOD          = 1; // Приход
    const OPERATION_VOZVRAT_PRIHODA = 2; // Возврат прихода
    const OPERATION_RASHOD          = 3; // Расход
    const OPERATION_VOZVRAT_RASHODA = 4; // Возврат расхода

    // Чек возврата
    const VOZVRAT_SAM   = 0; // Самостоятельно
    const VOZVRAT_NESAM = 1; // По предписанию

    // Признак способа расчета
    const OPLATA_POLN_DO       = 1; // Полная предварительная оплата до момента передачи предмета расчета
    const OPLATA_CHAST_DO      = 2; // Частичная предварительная оплата до момента передачи предмета расчета
    const OPLATA_AVANS         = 3; // Аванс
    const OPLATA_POLN_MOMENT   = 4; // Полная оплата, в том числе с учетом аванса (предварительной оплаты) в момент передачи предмета расчета
    const OPLATA_CHAST_MOMENT  = 5; // Частичная оплата предмета расчета в момент его передачи с последующей оплатой в кредит
    const OPLATA_KREDIT_MOMENT = 6; // Передача предмета расчета без его оплаты в момент его передачи с последующей оплатой в кредит
    const OPLATA_KREDIT_POSLE  = 7; // Оплата предмета расчета после его передачи с оплатой в кредит (оплата кредита)

    // Признак предмета расчета
    const PREDMET_TOVAR_MAIN              = 1; // Реализуемый товар, за исключением подакцизного товара (1)
    const PREDMET_TOVAR_PODAKCIZ          = 2; // Реализуемый подакцизный товар (2)
    const PREDMET_TOVAR_VYPOLN_RABOTA     = 3; // Выполняемая работа (3)
    const PREDMET_TOVAR_OKAZ_USLUGA       = 4; // Оказываемая услуга (4)
    const PREDMET_TOVAR_AZART_STAVKI      = 5; // Прием ставок при осуществлении деятельности по проведению азартных игр (5)
    const PREDMET_TOVAR_AZART_VYIGRYSH    = 6; // Выплата денежных средств в виде выигрыша при осуществлении деятельности по проведению азартных игр (6)
    const PREDMET_TOVAR_LOTEREYA_VYIGRYSH = 8; // Выплата денежных средств в виде выигрыша при осуществлении деятельности по проведению лотерей (8)
    const PREDMET_TOVAR_PRAVA_IS          = 9; // Предоставление прав на использование результатов интеллектуальной деятельности или средств индивидуализации (9)
    const PREDMET_TOVAR_AVANS_ITD         = 10; // Аванс, задаток, предоплата, кредит, взнос в счет оплаты, пеня, штраф, вознаграждение, бонус и иной аналогичный предмет расчета (10)
    const PREDMET_TOVAR_PA                = 11; // Вознаграждение пользователя, являющимся платежным агентом (11)
    const PREDMET_TOVAR_ALL               = 12; // Предмет расчета, состоящем из предметов, каждому из которых может быть присвоено значение от «1» до «11» (12)
    const PREDMET_TOVAR_OTHER             = 13; // Предмет расчета, не относящемуся к предметам расчета, которым может быть присвоено значение от «1» до «12» (13)

    // Признак агента
    const NO_AGENT    = 40; // Пользователь ККТ не является платежным агентом по всем предметам расчета
    const AGENT_BPA   = 0; // Оказание услуг покупателю (клиенту) пользователем, являющимся банковским платежным агентом
    const AGENT_BPSA  = 1; // Оказание услуг покупателю (клиенту) пользователем, являющимся банковским платежным субагентом
    const AGENT_PA    = 2; // Оказание услуг покупателю (клиенту) пользователем, являющимся платежным агентом
    const AGENT_PSA   = 3; // Оказание услуг покупателю (клиенту) пользователем, являющимся платежным субагентом
    const AGENT_POVER = 4; // Осуществление расчета с покупателем (клиентом) пользователем, являющимся поверенным
    const AGENT_KOMIS = 5; // Осуществление расчета с покупателем (клиентом) пользователем, являющимся комиссионером
    const AGENT_A     = 6; // Осуществление расчета с покупателем (клиентом) пользователем, являющимся агентом и не являющимся банковским платежным агентом

    // Other
    const TEXT_AGENT_FIO   = "Системный администратор";
    const TEXT_AGENT_INN   = "12345678901";
    const TEXT_DOCUM_OSNOV = "Коррекция";
    const TEXT_DOCUM_NUM   = "1";

    // AES + RSA
    const RSA_PUB_FIRST = "-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAwFXHnzc5YKj8e3tlNzST
CkA8Tq4gjTH0VMuhJhg5QWpFjFKwtnK3u4EOaQGmjqDtzyffVHmKuGikg9jE20sG
nJN4hTtySihOiUWRd4zhJVMevBQmsEQS33bg26UzzKCeO12mbM/Q4ip7YXEfWM/F
Tq2l94psQgmIDh/LtHVf3OBlz8I6u5VaP3AS0Hv9RBUin0RBkRUC+5tgURm382XT
nJ2GzZ8cEGJm3C+s0+W1N2igjV0X3MihylHGDyl+8FpbFIlXsaJOYQ0//JIgnaBz
MV2JyNTHBzPJrcIMHIbKBVAmDLfgeDNKug7wIadEcqoJaCz74yG9l9nJWISWQkI6
Ed8nDVsoaIkMQBuWWxfHjQEU8R8OVjRzhOGHPG2ka6y1/jcOS5JWPzS5YVXRPbrh
QYcoNebsOBaFxJYZ2E7VhVdrGWlBqhANFba7umZXVOvmDXIsH974Yv4awAaP70VP
SLFIdjiNy/SB8w0O8PJOUPznpMhvi1clBgp3PvtYmhUqmdHWPwjcjy0JmY9KrWz0
0Im1yDTTybtV3uYnwR677TmsLmR9c6T7EHlT3gG6Y0bM3w9tyrGqVKy1jIkyUZPV
f0dmXTfbh+hcC5kYal+M7lcn7wSSLHTUk+C/YWE1e5TvTBK6teU2VNmz80Yt2IS2
mcXlfKlZXilMmPJCdUI7nNMCAwEAAQ==
-----END PUBLIC KEY-----";

    const RSA_PUB_SECOND = "-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA+fu+NGlnWAXqIVgEL37v
eatlyooYi+iHLiBmCDowNZUBAiQ+pvbnzkowUKdr86lGrzQLCAvVyXWG0U4kdixA
X0GTkIR/3g3h2/8hRx0x3K0umT+tcZC3iJytKzP+EM/B6sDdw6/URbykwvrAlbQs
G9d6eCqq0F/6muOM3gQazy8CuHyx4iFQpml4E1/IQgp3tZJOX5I9xieHTUwct2Ok
URCKYnHJZrRIN9rwXQkNG1q+M8HDqI1Mwq88wieVC+SUuoPc8F0MlIWs2zwDhLcX
84OQTRFqlW3NFR/6kUn3TIC1JZD1Ft/8fWukZzAFsAmdXmFzhBUuBPvjIzzLafY3
f8IszADMnloJ0BW3iGVRGj6hygX7Jpr/86LPHu6PBJzHzCp9bnfOiSjRENzzy55f
DdVbYpVgWDt4+UEkl9qNRNuiSMDpKeVNy6jxbihZneYCR8alnH8Olh6lL7bmGdww
qI9LSyq/qFfIMDV8onit/dLxzypFJofRfjZ1Dc8ZEqh2sab8qEMNPGQwTM/FVFWM
bq0hmjjY+BFWGY/h0z1NZMX75Uzyd9OdXaRoTlHPfOxxAIfclP2XY2K8f5PQ37g/
fX2R8bw/fXQd2ndi/+uPCGK92Xw4/3/osJKpm3QSYhSda53T9Ddned7BtWDQJqdV
Y/SUskwLLyjtSb0LqsSKBHkCAwEAAQ==
-----END PUBLIC KEY-----";

    const HMAC_FIRST               = "BBuXaXBdHg+wLPjRJpf3N/NmLq5kuvzGQx3II15/j8o=";
    const HMAC_SECOND              = "aFZP3PbvrMZNNxxqJxaCnCLama5L8H1/YGO3UYsoCVQ=";
    const URL_TO_SEND_TO_NANOKASSA = "http://q.nanokassa.ru/srv/igd.php";

}