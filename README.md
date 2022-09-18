## Base URL :

    https://jumia-samir-hussein.vercel.app/apis

## Seller APIs

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

    Authorization : "Bearer seller_token"

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

    Authorization : "Bearer customer_token"

## Category APIs

### Add new category

<b>POST :</b>

    /category

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer seller_token"

<b>Parameters :</b>

    name (required)

## Brand APIs

### Add new brand

<b>POST :</b>

    /brand

<b>Headers :</b>

    Accept : Application/json

    Authorization : "Bearer seller_token"

<b>Parameters :</b>

    name (required)
