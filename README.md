# Bellie
A web service for bellie company to handle seller invoices.

#### Requirements
```bash
php 7.3 or higher
```

#### Installation
install the dependencies.
```bash
composer install
```

rename .env.example to .env and add DB credentials
```bash
DB_USERNAME=
DB_PASSWORD=
```

key generate.
```bash
php artisan key:generate 
```

run migrations
```bash
php artisan migrate
```

run seeders
```bash
php artisan db:seed
```

to create "personal access" and "password grant" clients which will be used to generate access tokens
```bash
php artisan passport:install
```

When deploying Passport to your application's servers for the first time, you will likely need to run the passport:keys command.
```bash
php artisan passport:keys
```

Run server
```bash
php artisan serve
```

#### Testing
Run unit Test before need sqlite3 php extension
```bash
vendor/bin/phpunit
```

## API Doc
for login, use existing user credentials as
```bash
{
    "email":"admin@admin.com",
    "password":"admin123"
}
```
login API method `POST`
```bash
http://127.0.0.1:8000/api/login
```
in response 
```sh
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiY2I1NjhlYmM5MDBlNWMxOWQ2MGNmMGE5ZmY3MjU5NzgzOTgyMzAwNDJiMGE3YWE4Y2RmOTI0MTFiOThiNzRlODEyZGU1NzY0NWU5MDAxYTYiLCJpYXQiOjE2Mjk4MzM3MTAsIm5iZiI6MTYyOTgzMzcxMCwiZXhwIjoxNjYxMzY5NzEwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.JX-jUJ79b9JyMb3X3Zszt6poF_FMPOTA5ol5C2rx13ctFinyt5IEAKeLwKlpWThxMvKZi3FzZ2ufLUGkm2l1GQEPBhgaiU0gYlStqNPD6CXRa6X16pSu4oCjQonTk0QsiPXoqipNlxu79GCp92pk_B6Oa5lfnk6_bw86EKVE2W4QLmajRbfYwHifZzbbU5tqg_TnsEbLBKYrgsGsV7TKAaUcXgrgxUVnP_LB8dCjPjofZhu9mufee7YX-BiLHBij2RcQS3awVK_FXbafjrvRQKrxzrDTlUUslbu2rIXCwDZKlZBMG5-Jo1FA35XAntfOkyhsNzzg8Zbi3DhOog1e_KvCwntCX9P2xQFHZTkt0NGXM8JRtkpKG4M9rDHNT9W0WRFRvYbV-gJPjCEqfaaDAEItwSVIk_H5NOtUdhCc708f1C5GbIzuMpJ7FYyhNTczHT0yLR5yQv3gCFGZtMT8US_WPdnEzcxiPrZuyGggrNdtuBn9DzJ4g9zGm_p5BSQvUJmlOrfPC1Q3yxf6YulZmQxR2JxXiJ8wUBlwfePi3t2ynuaJYlLhvH7UR1UiIWJI0Htan0rLVXzsAOP2niQq7lc8He4c6mtzERTcL-OnJhPYKTnYwi7HnY-x1h1TTDRowEHEBaTzlO3Temr26bzJCv8N3R9CtPZY1EP2VM_na5E"
}
```
need to get the access_token and and send every other API's header as
```bash
key = Authorization
value = Bearer ${access_token}
```

Add company API method `POST`
```bash
http://127.0.0.1:8000/api/companies
```
request body
```bash
{
    "name":"abc",
    "address_street":"street 1",
    "address_zip_code":"123123",
    "address_city":"colombo",
    "address_country":"sri lanka",
    "debtor_limit":100000,
    "status":"active"
}
```
Update company API method `PUT`
```bash
http://127.0.0.1:8000/api/companies/${saved_company_id}
```
request body
```bash
{
    "name":"abc",
    "address_street":"street 2",
    "address_zip_code":"121212",
    "address_city":"colombo7",
    "address_country":"sri lanka",
    "debtor_limit":200000,
    "status":"active"
}
```
Delete company Api method `DELETE`
```bash
http://127.0.0.1:8000/api/companies/${saved_company_id}
```

Add invoices API method `POST`
```bash
http://127.0.0.1:8000/api/invoices
```
request body
```bash
{
    "company_id" : ${saved_company_id},
    "debtor" : {
       "name" : "test debtor",
       "address_street" : "street 1",
       "address_zip_code" : 222222,
       "address_city" : "new york",
       "address_country" : "USA"
    },
    "items" : [
        {
            "item_description" : "test item1",
            "quantity" : 10,
            "amount" : 1000
        },
        {
            "item_description" : "test item2",
            "quantity" : 3,
            "amount" : 3000
        }
    ]
}
```

Update invoice API method `PUT`
```bash
http://127.0.0.1:8000/api/invoices/${saved_invoice_id}
```
request body
```bash
{
    "status" : "paid",
    "remarks" : "this is successfully paid"
}
```

> Note: `status should be 'paid','declined'` is required 
## License
MIT
