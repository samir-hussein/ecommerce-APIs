# <h1 align="center">eCommerce APIs</h1>

## Base URL :

    https://jumia-samir-hussein.vercel.app/apis

## Company Admin Account

    email: alfred29@example.org
    password: 12345678

## Contents

-   [Company Account End Points](#Company-Account-End-Points)
-   [Customer Account End Points](#Customer-Account-End-Points)
-   [Seller Account End Points](#Seller-Account-End-Points)
-   [Category End Points](#Category-End-Points)
-   [Sub Category End Points](#Sub-Category-End-Points)
-   [Brand End Points](#Brand-End-Points)
-   [Products End Points](#Products-End-Points)
-   [Reviews End Points](#Reviews-End-Points)
-   [Cart End Points](#Cart-End-Points)

### Get active user information using token

<b>GET :</b>

    /active-user

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {token}"

## **Company Account End Points**

### Company Account login

<b>POST :</b>

    /company/login

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    email (required)
    password (required)

### Company Account register

#### (only admin account can create new account)

<b>POST :</b>

    /company/register

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    name (required)
    email (required)
    role (required | [admin , customer service , seller service])

### Company Account verify

<b>POST :</b>

    /company/verify

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    token (required)
    email (required)
    password (required | min:8)
    password_confirmation (required)

### Company Account logout

<b>GET :</b>

    /company/logout

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

### Company Account Forgot Password

<b>POST :</b>

    /company/forgot-password

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    email (required)

### Company Account Reset Password

<b>POST :</b>

    /company/reset-password

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    token (required)
    email (required)
    password (required | min:8)
    password_confirmation (required)

### Company Account Update Information

<b>PUT :</b>

    /company/account/{account_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    name (optional)
    img (optional | mimes:jpeg,jpg,png,webp | max:10MB)
    password (optional | min:8)
    password_confirmation (required with password)
    old_password (required with password)

### Company Account Update Role

#### (only admin account can change the role of any account)

<b>PUT :</b>

    /company/account/{account_id}/update-role

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    role (required | [admin , customer service , seller service])

### Get All Company Accounts

#### (only admin account has access)

<b>GET :</b>

    /company/account

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

### Get Specified Company Account Information

#### (only admin account can get specified account information)

<b>GET :</b>

    /company/account/{account_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

### Company Account Delete

#### (only admin account can delete any account)

<b>DELETE :</b>

    /company/account/{account_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

## Customer Account End Points

### Customer Account login

<b>POST :</b>

    /customer/login

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    email (required)
    password (required)

### Customer Account register

<b>POST :</b>

    /customer/register

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    name (required)
    email (required)
    phone (required)
    password (required | min:8)
    password_confirmation (required)

### Customer Account logout

<b>GET :</b>

    /customer/logout

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

### Customer Account Forgot Password

<b>POST :</b>

    /customer/forgot-password

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    email (required)

### Customer Account Reset Password

<b>POST :</b>

    /customer/reset-password

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    token (required)
    email (required)
    password (required | min:8)
    password_confirmation (required)

## Seller Account End Points

### Seller Account login

<b>POST :</b>

    /seller/login

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    email (required)
    password (required)

### Seller Account register

<b>POST :</b>

    /seller/register

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    name (required)
    email (required)
    phone (required)
    password (required | min:8)
    password_confirmation (required)

### Seller Account logout

<b>GET :</b>

    /seller/logout

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

### Seller Account Forgot Password

<b>POST :</b>

    /seller/forgot-password

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    email (required)

### Seller Account Reset Password

<b>POST :</b>

    /seller/reset-password

<b>Headers :</b>

    Accept : Application/json

<b>Body :</b>

    token (required)
    email (required)
    password (required | min:8)
    password_confirmation (required)

## Category End Points

### Store new category

#### (only company account can store new category)

<b>POST :</b>

    /category

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    name (required | unique)

### Delete a category

#### (only company account can delete a category)

<b>DELETE :</b>

    /category/{category_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

### Display all categories

<b>GET :</b>

    /category

<b>Headers :</b>

    Accept : Application/json

### Display the specified category

<b>GET :</b>

    /category/{category_id}

<b>Headers :</b>

    Accept : Application/json

## Sub Category End Points

### Store new sub category

#### (only company account can store new sub category)

<b>POST :</b>

    /sub-category

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    name (required | unique)
    category_id (required)

### Delete a sub category

#### (only company account can delete a sub category)

<b>DELETE :</b>

    /sub-category/{sub_category_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

### Display all sub categories

<b>GET :</b>

    /sub-category

<b>Headers :</b>

    Accept : Application/json

### Display the specified sub category

<b>GET :</b>

    /sub-category/{sub_category_id}

<b>Headers :</b>

    Accept : Application/json

## Brand End Points

### Store new brand

#### (only company account can store new brand)

<b>POST :</b>

    /brand

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    name (required | unique)

### Add new brand to category

#### (only company account can add new brand to category)

<b>POST :</b>

    /brand/category

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    brand_id (required)
    category_id (required)

### Add new brand to sub category

#### (only company account can add new brand to sub category)

<b>POST :</b>

    /brand/sub-category

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

<b>Body :</b>

    brand_id (required)
    category_id (required)
    sub_category_id (required)

### Delete a brand

#### (only company account can delete a brand)

<b>DELETE :</b>

    /brand/{brand_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

### Display all brands

<b>GET :</b>

    /brand

<b>Headers :</b>

    Accept : Application/json

### Display the specified brand

<b>GET :</b>

    /brand/{brand_id}

<b>Headers :</b>

    Accept : Application/json

## Products End Points

### Store new Product

#### (only seller account can add new product)

<b>POST :</b>

    /product

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

<b>Body :</b>

    name (required)
    img (required | mimes:png,jpg,jpeg,webp | max:10000)
    gallery (optional | array | mimes:jpeg,jpg,png,webp | max:10000)
    price (required | numeric)
    description (required)
    discount (optional | numeric | between:0,100) defualt = 0
    stock (optional | numeric) defualt = 0
    category_id (required)
    sub_category_id (optional)
    brand_id (optional)
    seller_id (required)
    attributes (optional | array)

<b>Body Example</b>

    {
        "name": "pro1",
        "img": main image,
        "gallery": {
            image1,
            image2
        },
        "price": "50",
        "description": "this is desc",
        "category_id": "7",
        "brand_id": "21",
        "seller_id": "3",
        "attributes": [
            {
                "attr_name": "attr 1",
                "attr_val": [
                    "val 1",
                    "val 2"
                ]
            },
            {
                "attr_name": "attr 2",
                "attr_val": [
                    "val 1"
                ]
            }
        ]
    }

### Update a Product

#### (only seller account can update a product)

<b>PUT :</b>

    /product/{product_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

<b>Body :</b>

#### (if sub_category_id or brand_id values don't represent in the body request, their values will be replaced by null.)

    name (optional)
    img (optional | mimes:png,jpg,jpeg,webp | max:10000)
    gallery (optional | array | mimes:jpeg,jpg,png,webp | max:10000)
    price (optional | numeric)
    description (optional)
    discount (optional | numeric | between:0,100) defualt = 0
    stock (optional | numeric) defualt = 0
    category_id (optional)
    sub_category_id (optional)
    brand_id (optional)
    attributes (optional | array)

<b>Body Example</b>

    {
        "name": "pro1",
        "img": main image,
        "gallery": {
            image1,
            image2
        },
        "price": "50",
        "description": "this is desc",
        "category_id": "7",
        "brand_id": "21",
        "seller_id": "3",
        "attributes": [
            {
                "attr_name": "attr 1",
                "attr_val": [
                    "val 1",
                    "val 2"
                ]
            },
            {
                "attr_name": "attr 2",
                "attr_val": [
                    "val 1"
                ]
            }
        ]
    }

### Delete a Product

#### (only seller account can delete a product)

<b>DELETE :</b>

    /product/{product_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

### Delete image from a product gallery

#### (only seller account can delete)

<b>DELETE :</b>

    /product/{product_id}/gallery/{gallery_image_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

### Delete attribute from a product

#### (only seller account can delete)

<b>DELETE :</b>

    /product/{product_id}/attribute/{product_attribute_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

### Delete attribute value from a product

#### (only seller account can delete)

<b>DELETE :</b>

    /product/{product_id}/attribute/{product_attribute_id}/value/{product_attribute_value_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {seller_token}"

### Display the specified Product

<b>GET :</b>

    /product/{product_id}

<b>Headers :</b>

    Accept : Application/json

### Display all Products

<b>GET :</b>

    /product

<b>Headers :</b>

    Accept : Application/json

### Approve a Product

#### (only company account [admin or seller service] can approve a product)

<b>GET :</b>

    /product/{product_id}/approve

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

## Reviews End Points

### Add new review

#### (only customer account can add new review)

<b>POST :</b>

    /review

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

<b>Body :</b>

    comment (optional)
    rating (required | between: 0,5)
    product_id (required)

### Update a review

#### (only customer account can update a review)

<b>PUT :</b>

    /review/{review_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

<b>Body :</b>

    comment (optional)
    rating (optional | between: 0,5)

### Delete a review

#### (only customer account can delete a review)

<b>DELETE :</b>

    /review/{review_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

### Display all reviews

<b>GET :</b>

    /review

<b>Headers :</b>

    Accept : Application/json

### Display the specified review

<b>GET :</b>

    /review/{review_id}

<b>Headers :</b>

    Accept : Application/json

## Cart End Points

### Add a product to cart

#### (only customer account can add)

<b>POST :</b>

    /cart

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

<b>Body :</b>

    product_id (required)

### Update a product amount in the cart

#### (only customer account can update)

<b>PUT :</b>

    /cart/{item_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

<b>Body :</b>

    amount (required | numeric | min:1)

### Delete a product from cart

#### (only customer account can delete)

<b>DELETE :</b>

    /cart/{item_id}

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"

### Display a cart list

#### (only customer account)

<b>GET :</b>

    /cart

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"
