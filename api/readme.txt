Метод products (GET)		##########

http://ДОМЕН/api/products/[type]/[second]/[third]/

type: [category, collection, new, search]

second: [id(для type=category и type=collection), page(для new)]

third: [page(для type=category и type=collection)]

Для type=search нужно передавать параметры s и page, например, так:
http://ДОМЕН/api/products/search/?s=lorem ipsum&page=1

ПРИМЕР: 
http://ДОМЕН/api/products/category/1/1/


Метод product (GET)			##########

http://ДОМЕН/api/product/[id]/


Метод info (GET)			##########

http://ДОМЕН/api/info/[infoName]

infoName: [main, about, contacts, privacy, services, lookbook, header, articles, article, social, slider]

Для infoName=article нужно передавать еще и id, например, так:
http://ДОМЕН/api/info/article/1/


Метод delivery (GET)		##########

http://ДОМЕН/api/delivery/


Метод call (POST)			##########

http://ДОМЕН/api/call/ + параметры (name, phone)


Метод message (POST)		##########

http://ДОМЕН/api/message/ + параметры (name, phone, email, msg)


Метод checkout (POST)			##########

http://ДОМЕН/api/checkout/

Создает пустой заказ в БД и возвращает номер заказа


Метод order (POST)			##########

http://ДОМЕН/api/order/ + параметры (id, name, phone, email, address, msg, payment_type, delivery_type, products[])


Ожидаются данные в таком формате:
{
	"id": 1,
    "name": "Jhon Snow",
	"phone": "+7 (999) 543-34-34",
	"email": "mail@mail.mail",
    "address": "Winterfell",
	"msg": "Winter is coming",
	"payment_type": "online",
	"delivery_type": 1,	
    "products": [
        {
            "id": 2,
			"attributes": [
				{
					"attr_id": 2,
					"value_id": 5
				},
				{
					"attr_id": 3,
					"value_id": 2
				}
			]
        },
        {
            "id": 1,
			"attributes": [
				{
					"attr_id": 2,
					"value_id": 5
				},
				{
					"attr_id": 3,
					"value_id": 2
				}
			]
        }
    ]
}