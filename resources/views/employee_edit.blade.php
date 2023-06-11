<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee</title>
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
<main class="container">
    <br/>
    <h2 class="text-light">Edit employee: <em>{{ $employee->name }}</em></h2>
    <form action="{{ route('employee.edit', [$employee->id]) }}" method="post">
        @csrf
        @method('POST')
        <!-- name -->
        <div class="mb-3">
            <label for="name" class="form-label text-light">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}">
        </div>
        <!-- email -->
        <div class="mb-3">
            <label for="email" class="form-label text-light">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $employee->email }}">
        </div>
        <!-- salary -->
        <div class="mb-3">
            <label for="salary" class="form-label text-light">Salary</label>
            <input type="text" class="form-control" id="salary" name="salary" value="{{ $employee->salary }}">
        </div>
        <!-- section -->
        <div class="mb-3">
            <label for="section" class="form-label text-light">Section</label>
            <select class="form-select" id="section" name="section">
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @if($section->id == $employee->section_id) selected @endif>{{ $section->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</main>
</body>
</html>
