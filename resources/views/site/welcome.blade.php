<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Meu Porquinho</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Styles -->

    <link href="{{ asset('css/site.css') }}" rel="stylesheet">

    {{-- icon --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
</head>

<body class="bg-light">
    <div class="">

        <div class="text-center">
            <img src="{{ asset('img/logo-sem-fundo.png') }}" style="max-width: 300px" alt="Meu Porquinho">

            <hr>


            @if (Auth::check())
                <h2 class="mb-0">Bem-vindo,</h2>
                <h4> {{ Auth::user()->name }}!</h4>
                <a href="{{ route('dashboard') }}" class="btn btn-success">Acessar</a>
            @else
                <h2 class="mb-0">Bem-vindo, </h2>
                <h4>visitante!</h4>
                <p><a href="{{ route('login') }}" class="btn btn-success">Login</a></p>
                <p><a href="{{ route('register') }}" class="btn btn-success">Cadastro</a></p>
            @endif
        </div>

    </div>

    <footer class="footer mt-auto py-2 bg-footer text-center">
        <div class="container">
            <span class="text-light text-outline">Desenvolvido por <a href="https://www.instagram.com/joaovictor.doratioto/" target="_blank"
                    class="desenvolvido">NogueiraDoratioto</a></span>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
