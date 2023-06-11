<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
</head>
<body style="background: #1a2b3c">
<header class="container">
    <div style="display: flex; justify-content: space-between">
        <a class="link-primary" href="{{ route('home') }}"><h1>Warehouse</h1></a>
        <div>
            <!-- change password and logout button-->
            <form style="display: inline-block" action="{{ route('change-password') }}">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-primary">Change password</button>
            </form>
            <form style="display: inline-block" action="{{ route('logout') }}" method="post">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <a class="link-light" href="{{ route('employees') }}">Employees</a><br/>
    <a class="link-light" href="{{ route('sections') }}">Sections</a><br/>
    <a class="link-light" href="{{ route('products') }}">Products</a><br/>
</header>
<br/>
<div class="container">
    <form action="{{ route('product.create') }}">
        @csrf
        @method('GET')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
<main class="container">
    <br/>
    <table class="table table-dark table-striped-columns">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Section</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody class="table-light">
        @if (count($products) === 0)
            <tr>
                <td colspan="6">No products found</td>
            </tr>
        @else
            @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>
                        <a href="{{ route('product', [$product->id]) }}">{{ $product->name }}</a>
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <a href="{{ route('section', [$product->section_id]) }}">{{ $product->section_name }}</a>
                    </td>
                    <td>
                        <form style="display: inline-block" action="{{ route('product.edit', [$product->id]) }}">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>

                        <form style="display: inline-block" action="{{ route('product.delete', [$product->id]) }}"
                              method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</main>
</body>
</html>
