## Base URL :

    https://jumia-samir-hussein.vercel.app/apis

## Contents

-   [Seller APIs](#Seller-APIs)
-   [Customer APIs](#Customer-APIs)
-   [Category APIs](#Category-APIs)
-   [Brand APIs](#Brand-APIs)
-   [Product APIs](#Product-APIs)

## **Seller APIs**

### Seller login

<b>POST :</b>

    /seller/login

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    email (required)

    password (required)

### Seller register

<b>POST :</b>

    /seller/register

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    name (required)

    email (required)

    phone (required)

    password (required | min:8)

    password_confirmation (required)

### Seller logout

<b>GET :</b>

    /seller/logout

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer {seller_token}"

## Customer APIs

### Customer login

<b>POST :</b>

    /customer/login

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    email (required)

    password (required)

### Customer register

<b>POST :</b>

    /customer/register

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    name (required)

    email (required)

    phone (required)

    password (required | min:8)

    password_confirmation (required)

### Customer logout

<b>GET :</b>

    /customer/logout

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer {customer_token}"

## Category APIs

### Get all categories

<b>GET :</b>

    /category

<b>Headers :</b>

    Accept : Application/json

### Add new category

<b>POST :</b>

    /category

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer {seller_token}"

<b>Parameters :</b>

    name (required)

## Brand APIs

### Get all brands

<b>GET :</b>

    /brand

<b>Headers :</b>

    Accept : Application/json

### Add new brand

<b>POST :</b>

    /brand

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer {seller_token}"

<b>Parameters :</b>

    name (required)

## Product APIs

### Add a new product

<b>POST :</b>

    /product

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer {seller_token}"

<b>Parameters :</b>

    name (required)

    primary_img (required | [jpeg,jpg,png,webp] | max:10MB)

    price (required)

    category_id (required)

    brand_id (required)

    description (optional)

    discount (optional)

    stock (optional)

    images (optional | array of images | [jpeg,jpg,png,webp] | max:10MB)

    specifications (optional | array)

<b>Body request example :</b>

    {
        name: "product name",

        primary_img: "image file",

        price: 35,

        category_id: 2,

        brand_id: 1,

        description: "this is text",

        discount: 30,

        stock: 60,

        images: ["image file 1", "image file 2" , "image file 3"],

        specifications: [
            "Weight" => "194 grams",
            "ROM" => "4GB",
            "Display" => "6.1-inch Liquid Retina HD display"
        ]
    }

### Update a product

<b>PUT :</b>

    /product/{product_id}

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer {seller_token}"

<b>Parameters :</b>

    name (optional)

    primary_img (optional | [jpeg,jpg,png,webp] | max:10MB)

    price (optional)

    category_id (optional)

    brand_id (optional)

    description (optional)

    discount (optional)

    stock (optional)

    images (optional | array of images | [jpeg,jpg,png,webp] | max:10MB)

    specifications (optional | array)

<b>Body request example :</b>

    {
        name: "product name",

        primary_img: "image file",

        price: 35,

        category_id: 2,

        brand_id: 1,

        description: "this is text",

        discount: 30,

        stock: 60,

        images: ["image file 1", "image file 2" , "image file 3"],

        specifications: [
            "Weight" => "194 grams",
            "ROM" => "4GB",
            "Display" => "6.1-inch Liquid Retina HD display"
        ]
    }
