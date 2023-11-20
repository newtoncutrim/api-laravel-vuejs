<!-- Em resources/views/teste.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Seus meta tags e cabeçalho aqui -->
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

    <form action="{{ route('teste.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo">
        <button type="submit">Upload file</button>
    </form>


</body>
</html>
