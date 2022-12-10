## Base URL :

    https://jumia-samir-hussein.vercel.app/apis

## Company Admin Account

    email: alfred29@example.org
    password: 12345678

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

#### (only admin account can create new account)

<b>POST :</b>

    /company/register

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {company_token}"

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

### Company Account Forgot Password

<b>POST :</b>

    /company/forgot-password

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    email (required)

### Company Account Reset Password

<b>POST :</b>

    /company/reset-password

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

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

<b>Parameters :</b>

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

<b>Parameters :</b>

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

### Customer Account Forgot Password

<b>POST :</b>

    /customer/forgot-password

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    email (required)

### Customer Account Reset Password

<b>POST :</b>

    /customer/reset-password

<b>Headers :</b>

    Accept : Application/json

<b>Parameters :</b>

    token (required)
    email (required)
    password (required | min:8)
    password_confirmation (required)
