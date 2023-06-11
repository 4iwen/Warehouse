<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
</head>
<body style="background: #1a2b3c">
<main class="container">
    <form action="{{ route('change-password') }}" method="post" class="row justify-content-center align-items-center"
          style="height: 100vh">
        @csrf
        @method('POST')
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Change password</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Old password</label>
                        <input type="password" name="old_password" id="old_password"
                               class="form-control @error('old_password') is-invalid @enderror">
                        @error('old_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New password</label>
                        <input type="password" name="new_password" id="new_password"
                               class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">New password confirmation</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                               class="form-control @error('new_password_confirmation') is-invalid @enderror">
                        @error('new_password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Change password</button>
                </div>
            </div>
        </div>
    </form>
</main>
</body>
</html>
