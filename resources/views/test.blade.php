<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('product.store') }}" enctype="multipart/form-data" method="post">
        <input type="file" name="images[]" multiple>
        <input type="text" name="specifications">
        <button type="submit">submit</button>
    </form>
</body>

</html>
