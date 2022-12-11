## Base URL :

    https://jumia-samir-hussein.vercel.app/apis

## Company Admin Account

    email: alfred29@example.org
    password: 12345678

## Contents

-   [Company Account APIs](#Company-Account-APIs)
-   [Customer Account APIs](#Customer-Account-APIs)
-   [Seller Account APIs](#Seller-Account-APIs)
-   [Category APIs](#Category-APIs)
-   [Sub Category APIs](#Sub-Category-APIs)
-   [Brand APIs](#Brand-APIs)

### Get active user information using token

<b>GET :</b>

    /active-user

<b>Headers :</b>

    Accept : Application/json
    Authorization : "Bearer {token}"

## **Company Account APIs**

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

## Customer Account APIs

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

## Seller Account APIs

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

## Category APIs

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

## Sub Category APIs

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

## Brand APIs

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
