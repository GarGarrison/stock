import requests

test_base = {
    "secret": "ceiFa2aequaezairaiPhiewae4ahgeem7ra9eegha5Ee5yah6ohchah9yaeth7ji"
}

test_goods = {
    "action": "insertgoods",
    "num": 5,
    "address": 5,
    "goodsname": "5XSFDsdf",
    "mark": 5,
    "producer": 5,
    "case": 5,
    "price_retail_usd": 5,
    "price_retail_rub": 5,
    "price_minitrade_usd": 5,
    "price_minitrade_rub": 5,
    "price_trade_rub": 5,
    "price_trade_usd": 5,
    "packcount": 5,
    "price_pack_usd": 5,
    "price_pack_rub": 5,
    "onlinecount": 5,
    "offlinecount": 5,
    "cell": 5
}

def test_create_delete_goods():
    # test create goods
    print("CREATE GOODS")
    DELETE_ID = 0
    test_goods.update(test_base)
    req = requests.post("http://localhost:8000/backoffice", data = test_goods)
    try:
        assert req.status_code == 200, "status is'not 200"
        assert req.text.isdigit, "response is not int"
        DELETE_ID = int(req.text)
        print("Successfully create goods with id={}".format(DELETE_ID))
    except Exception as e:
        print(str(e))
        print("status: ", req.status_code)
        print("text: ", req.text)

    # test delete goods
    print("DELETE GOODS")
    if DELETE_ID != 0:
        data = {"action": "deletegoods", "id": DELETE_ID}
        data.update(test_base)
        req = requests.post("http://localhost:8000/backoffice", data = data)
        try:
            assert req.status_code == 200, "status is not 200"
            assert req.text == "ok", "response is not ok"
            print("Successfully delete goods with id={}".format(DELETE_ID))
        except Exception as e:
            print(str(e))
            print("status: ", req.status_code)
            print("text: ", req.text)

# def test_update_user():
#     #test update user
#     uid = "04197004-f692-4093-959f-c8a16dbf7d67"
#     data = {"action": "update_user", "id": uid, "address":"Королев Богомолова"}
#     data.update(test_base)
#     req = requests.post("http://localhost:8000/backoffice", data = data)
#     try:
#         assert req.status_code == 200, "status is not 200"
#         assert req.text == "ok", "response is not ok"
#         print("Successfully update user with id={}".format(uid))
#     except Exception as e:
#         print(str(e))
#         print("status: ", req.status_code)
#         print("text: ", req.text)

# def test_get_user_uuid():
#     email = "q@q.ru"
#     data = {"action": "get_user_uid_by_email", "email": email}
#     data.update(test_base)
#     req = requests.post("http://localhost:8000/backoffice", data = data)
#     try:
#         assert req.status_code == 200, "status is not 200"
#         print("Successfully get user uid={} for email={}".format(req.text, email))
#     except Exception as e:
#         print(str(e))
#         print("status: ", req.status_code)
#         print("text: ", req.text)

test_create_delete_goods()