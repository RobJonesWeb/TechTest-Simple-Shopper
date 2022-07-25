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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

        .select2-selection__arrow b {
            top: 70%!important;
            left: 30%!important;
        }

        .select2-selection--single {
            border: none!important;
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

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
<div class="container py-5">
    <header class="row text-center">
        <h1>Simple Shopper</h1>
    </header>
    <article class="row text-md-start text-center scenario bg-white text-dark border border-dark rounded p-2">
        <p class="col-12 m-0">
            <span class="fw-bold">Scenario: </span> Create a Laravel application that allows you to show, create and delete items from a
shopping list. The project should include a MySql database to store data. There should be a
single html page which shows all items currently on the list, with features to add new items
and remove items. The project should include both front-end and back-end elements.
We should be able to store a quantity for each item on the list.
Once complete, upload to a public GitHub repository and provide the link.
        </p>
    </article>
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
    <main class="row justify-content-center">
        <article class="col-md-12">
            <form method="post" action="{{ route('addItem') }}" class="pb-4" id="shopping-list">
                @csrf
                <fieldset>
                    <legend class="text-center text-md-start">Add New Item:</legend>
                    <div class="row py-1">
                        <div class="col-md-4">
                            <input type="text" class="form-control col-md-6" id="item" name="name"
                                   placeholder="Bread/Milk/Eggs" required/>
                        </div>
                        <div class="col-md-2">
                        <input type="number" class="form-control col-md-6" id="qty" name="qty"
                                   placeholder="0" required/>
                        </div>
                        <div class="col-md-3">
                        <select class="form-control col-md-6 select2" name="shop" id="shop" required>
                                <option value="option_select" disabled selected>Choose a shop...</option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                        <select class="form-control col-md-6 select2" name="department" id="department" required>
                                <option value="0" disabled selected>Choose a department...</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="offset-md-4 col-md-4">
                        <input type="submit" class="form-control mt-2 bg-primary text-white" value="submit">
                    </div>
                </fieldset>
            </form>
        </article>
        <article class="col-md-12">
            <h4 class="py-4 pt-md-2 text-center">Current Shopping List:</h4>
            <div class="row mb-2">
                <div class="col-3 col-md-2">Store</div>
                <div class="col-3 col-md-2">Aisle</div>
                <div class="col-3 col-md-6">Item/Qty</div>
                <div class="col-3 col-md-2">Action</div>
            </div>
            @foreach($shops as $shop)
                @foreach($departments as $department)
                    @if($departmentName = $department->id == -1 ? 'Miscellaneous' : $department->name)
                    @endif
                    @foreach($items as $item)
                        @if($shop->id === $item->shops_id && $department->id === $item->departments_id)
                            <div class="row bg-white py-2 align-items-center border border-bottom">
                                <div class="col-3 col-md-2">{{$shop->name}}</div>
                                <div class="col-3 col-md-2">{{$departmentName}}</div>
                                <div class="col-3 col-md-6">{{$item->name}} x {{$item->qty}}</div>
                                <form class="col-3 col-md-2" action="{{ url('/delete', ['id' => $item->id]) }}" method="post">
                                    <img src="/bin.svg" class="btn btn-danger" alt="Delete Icon">
                                    <input type="hidden" name="_method" value="delete"/>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </article>
    </main>
    @include('includes.footer')
</div>
</body>
</html>
