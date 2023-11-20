<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h1><a href={{route('teste.up')}}>add foto</a></h1>
    @if ($photos && count($photos) > 0)
    <h1>Total de Fotos: {{ count($photos) }}</h1>
    @endif
        <!-- Exibição das fotos -->
        @foreach ($photos as $photo)

        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Photo">
        @endforeach
</body>
</html>
