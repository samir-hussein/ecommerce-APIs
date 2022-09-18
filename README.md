## Base URL : https://jumia-samir-hussein.vercel.app/apis

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

    Authorization : "Bearer token"
