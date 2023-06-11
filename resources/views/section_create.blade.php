<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
</head>
<body style="background: #1a2b3c">
<form action="{{ route('section.create') }}" method="post" class="row justify-content-center align-items-center"
      style="height: 100vh">
    @csrf
    @method('POST')
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Create section</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name"
                           class="form-control" value="{{ old('name') }}">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</form>
</body>
</html>
