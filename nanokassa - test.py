import json, binascii, hmac, hashlib, os, base64, io
from base64 import b64encode, b64decode
from Cryptodome.PublicKey import RSA
from Cryptodome.Random import get_random_bytes
from Cryptodome.Cipher import AES, PKCS1_OAEP
from Cryptodome.Util import Counter
from urllib import request, parse
from Cryptodome.Util.number import bytes_to_long
from PIL import Image

cheque = {
    "kassaid": "122772",
    "kassatoken": "5373167af64a6e02cae10c2bf5c6a7e4",
    "cms": "wordpress",
    "check_send_type": "email",
    "name_zakaz": "заказ 51",
    "check_vend_address": "Адрес установки",
    "check_vend_mesto": "Место установки ",
    "check_vend_num_avtovat": "Номер автомата ",
    "products_arr": [],
    "oplata_arr": {
        "rezhim_nalog": "2",
        "money_nal": 0,
        "money_electro": 46561,
        "money_predoplata": 0,
        "money_postoplata": 0,
        "money_vstrecha": 0,
        "kassir_inn": "",
        "kassir_fio": "",
        "client_email": "support@nanokassa.ru",
        "client_phone": "123",
        "inn_pokupatel": "12345678912",
        "name_pokupatel": "ООО Ромашка",
        "dop_rekvizit_1192": ""
    },
    "itog_arr": {
        "priznak_rascheta": 1,
        "itog_cheka": 46561
    }
}

tovar = {
    "name_tovar": "Мойка",
    "price_piece": 30000,
    "summa": 30000,
    "kolvo": 1,
    "stavka_nds": 6,
    "priznak_sposoba_rascheta": 4,
    "priznak_predmeta_rascheta": 1,
    "priznak_agenta": "none",
    "phone_oper_perevoda": "",
    "operation_plat_agenta": "",
    "phone_oper_priem_plat": "",
    "name_oper_perevoda": "",
    "address_oper_perevoda": "",
    "inn_oper_perevoda": "",
    "phone_postavshika": "",
    "name_postavshika": "",
    "deliveryposition": "yes"
}


# 1-е шифрование
def Enc_first(cheque):
    key = get_random_bytes(32)
    salt = get_random_bytes(16)

    ctr = Counter.new(128, initial_value=bytes_to_long(salt))

    cipher = AES.new(key, AES.MODE_CTR, counter=ctr)

    cipher_text = cipher.encrypt(bytes(json.dumps(cheque), 'utf-8'))

    HMAC_FIRST = b"BBuXaXBdHg+wLPjRJpf3N/NmLq5kuvzGQx3II15/j8o="
    mk = hmac.new(b64decode(HMAC_FIRST), salt + cipher_text, hashlib.sha512)

    dataDE = b64encode(mk.digest() + salt + cipher_text).decode('utf-8')

    recipient_key = RSA.import_key(open('1RSAcert.pem').read())
    cipher_rsa = PKCS1_OAEP.new(recipient_key)
    dataAB = b64encode(cipher_rsa.encrypt(key)).decode('utf-8')

    # шифрованный запрос
    return {
        "ab": dataAB,
        "de": dataDE,
        "kassaid": "122772",
        "kassatoken": "5373167af64a6e02cae10c2bf5c6a7e4",
        "check_type": "standart",
        "test": "0"
    }


# 2-е шифрование
def Enc_second(enc1_cheque):
    key = get_random_bytes(32)
    salt = get_random_bytes(16)

    ctr = Counter.new(128, initial_value=bytes_to_long(salt))

    cipher = AES.new(key, AES.MODE_CTR, counter=ctr)

    cipher_text = cipher.encrypt(bytes(json.dumps(enc1_cheque), 'utf-8'))

    HMAC_SECOND = b"aFZP3PbvrMZNNxxqJxaCnCLama5L8H1/YGO3UYsoCVQ="
    mk = hmac.new(b64decode(HMAC_SECOND), salt + cipher_text, hashlib.sha512)
    # print(mk.name, len(mk.digest()), mk.digest())

    dataDDE = b64encode(mk.digest() + salt + cipher_text).decode('utf-8')

    recipient_key = RSA.import_key(open('2RSAcert.pem').read())
    cipher_rsa = PKCS1_OAEP.new(recipient_key)
    dataAAB = b64encode(cipher_rsa.encrypt(key)).decode('utf-8')

    return {
        "aab": dataAAB,
        "dde": dataDDE,
        "test": "0"
    }


def main():
    cheque["client_phone"] = "+79999999999"
    cheque["products_arr"].append(tovar)
    cheque["oplata_arr"]["money_nal"] += tovar["summa"]
    cheque["itog_arr"]["itog_cheka"] = cheque["oplata_arr"]["money_nal"]

    enc2 = Enc_second(Enc_first(cheque))
    # print(enc2)

    with open("enc_cheque.json", "w") as write_file:
        json.dump(enc2, write_file)

    req = request.Request("http://q.nanokassa.ru/srv/igd.php",
                          data=json.dumps(enc2, ensure_ascii=False).encode('utf-8'),
                          method="POST")
    req.add_header("Content-type", "application/json")

    # отправка чека на фискализацию
    # запись данных в админку нанокассы ответ
    resp = request.urlopen(req)
    result = json.loads(resp.read())
    nuid = result['nuid']
    qnuid = result['qnuid']

    print(result)
    if result["status"] == "success":
        print(result["success"], nuid, qnuid)
    elif result["status"] == "error":
        print(result["error"])

    uid = {"nuid": nuid, "qnuid": qnuid, "auth": "base"}

    ##таймаут ожидания фискализации

    # фискализированный тестовый запрос
    # uid = {"nuid": "31723823635991540279828", "qnuid": "15402876854450317214589", "auth": "base"}

    # тестовый запрос без фискализации
    # uid = {"nuid": "34361433266991566837694", "qnuid": "15668465734444552820257", "auth": "base"}

    print("Request from", "http://fp.nanokassa.com/getfp?" + parse.urlencode(uid))

    hdr = {
        'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11',
        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'}

    req_qr = request.Request("http://fp.nanokassa.com/getfp?" + parse.urlencode(uid),
                             headers=hdr,
                             method="GET")

    resp_qr = request.urlopen(req_qr)
    result_qr = json.loads(resp_qr.read())
    print(result_qr)

    qr_arr = result_qr.get("check_qr_code_img_b64")[22:]  # отбросить заголовок поля 'data:image/jpg;base64,' 22 символа

    if qr_arr != None:
        with open('qr_image.jpg', 'wb') as qr_img:
            qr_img.write(b64decode(qr_arr))
            print("QR сохранен в файл qr_image.jpg")
        im = Image.open(io.BytesIO(b64decode(qr_arr)))
        im.show()


if __name__ == '__main__':
    main()
