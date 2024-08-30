<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <h1>Admin Reset Password</h1>
        @if(Session::has('error'))
            <p class="text-danger">{{Session::get('error')}}</p>
        @endif
        @if(Session::has('success'))
            <p class="text-success">{{Session::get('success')}}</p>
        @endif
        
        <form action="{{route('admin.reset.password.submit')}}" method="POST">
            @csrf
            
            <input type="hidden" value="{{$token}}" name="token">
            <input type="hidden" value="{{$email}}" name="email">

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="confirm_password">
                @error('confirm_password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
           
            <button type="submit" class="btn btn-primary">Reset</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>