<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Simple Shopper | Rob Jones</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            color: #3A3B3C;
            background: #DBE9F4;
            font-family: 'Nunito', Arial, sans-serif;
        }

        a:link,
        a:visited,
        a:active {
            color: #a3a3a3;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Scripts -->

    <!-- Bootstap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

    <!-- Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"
            integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</head>
<body>
<div class="container py-5">
    <header class="row mb-5 text-center">
        <h1>Simple Shopper</h1>
    </header>
    @if(isset($message))
        <div class="alert alert-primary">{{$message}}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <main class="row">
        <article class="offset-md-1 col-md-4">
            <form method="post" action="{{ route('addItem') }}" id="shopping-list">
                @csrf
                <fieldset>
                    <legend>Add New Item:</legend>
                    <label class="pe-3" for="item">Item</label>
                    <input type="text" class="form-control" id="item" name="name"/>
                    <label class="pe-3" for="qty">Quantity</label>
                    <input type="number" class="form-control" id="qty" name="qty"/>
                    <input type="submit" class="form-control  mt-2 bg-primary text-white" value="submit">
                </fieldset>
            </form>
        </article>
        <article class="offset-md-1 col-md-4">
            <h4 class="py-4 pt-md-2 text-center">Current Shopping List:</h4>
            <div class="row mb-2">
                <div class="col-6">Item</div>
                <div class="col-3">Qty</div>
                <div class="col-3">Action</div>
            </div>
            @foreach($items as $item)
                <div class="row mb-2 bg-white p-2 align-items-center">
                    <div class="col-6">{{$item->name}}</div>
                    <div class="col-3">{{$item->qty}}</div>
                    <form class="col-3" action="{{ url('/delete', ['id' => $item->id]) }}" method="post">
                        <input class="btn btn-danger" type="submit" value="Delete"/>
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            @endforeach
        </article>
    </main>
    @include('includes.footer')
</div>
</body>
</html>
