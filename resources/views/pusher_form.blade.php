<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
</head>
<body>
    <form action="{{route('form')}}" method="post">
        @csrf
        <label for="name">Post Name</label>
        <input type="text" name="name" ><br><br>
        
        <label for="description">Post Description</label>
        <input type="text" name="description" ><br><br>

        <input type="submit" value="submit">
        
    </form>
</body>
</html>