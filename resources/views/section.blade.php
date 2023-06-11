<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Section</title>
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

    <a class="link-light" href="{{ url('/employees') }}">Employees</a><br/>
    <a class="link-light" href="{{ url('/sections') }}">Sections</a><br/>
    <a class="link-light" href="{{ url('/products') }}">Products</a><br/>
</header>
<main class="container">
    <br/>
    <h2 class="text-light">Section: <em>{{ $section->name }}</em></h2>
    <dl class="dl-horizontal">
        <dt class="text-light">Employees</dt>
        @if (count($section->employees) === 0)
            <dd class="text-light">
                No employees
            </dd>
        @else
            @foreach($section->employees as $employee)
                <dd class="text-light">
                    <a href="{{ url('/employee/' . $employee->id) }}">{{ $employee->name }}</a>
                </dd>
            @endforeach
        @endif
        <dt class="text-light">Products</dt>
        @if (count($section->products) === 0)
            <dd class="text-light">
                No products
            </dd>
        @else
            @foreach($section->products as $product)
                <dd class="text-light">
                    <a href="{{ url('/product/' . $product->id) }}">{{ $product->name }}</a>
                </dd>
            @endforeach
        @endif
    </dl>
    <form style="display: inline-block" action="{{ route('section.edit', [$section->id]) }}">
        @csrf
        @method('GET')
        <button type="submit" class="btn btn-warning">Edit</button>
    </form>
    <form style="display: inline-block" action="{{ route('section.delete', [$section->id]) }}"
          method="post">
        @csrf
        @method('POST')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</main>
</body>
</html>
