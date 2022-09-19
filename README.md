## Base URL :

    https://jumia-samir-hussein.vercel.app/apis

## Contents

-   [Company Account APIs](#Company-Account-APIs)
-   [Customer Account APIs](#Customer-Account-APIs)

## **Company Account APIs**

### Company Account login

<b>POST :</b>

    /company/login

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    email (required)
    password (required)

### Company Account register

<b>POST :</b>

    /company/register

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    name (required)
    email (required)
    role (required | [admin , customer service , seller service])

### Company Account verify

<b>POST :</b>

    /company/verify

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

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

## Customer Account APIs

### Customer Account login

<b>POST :</b>

    /customer/login

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    email (required)
    password (required)

### Customer Account register

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

### Customer Account logout

<b>GET :</b>

    /customer/logout

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {customer_token}"
