<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Login | M Bahalap Hotel</title>

</head>

<body>

<h1>Login CMS</h1>

@if ($errors->any())

    <p style="color:red">

        {{ $errors->first() }}

    </p>

@endif

<form method="POST" action="{{ route('login.authenticate') }}">

    @csrf

    <label>Email</label>

    <br>

    <input
        type="email"
        name="email"
        required
    >

    <br><br>

    <label>Password</label>

    <br>

    <input
        type="password"
        name="password"
        required
    >

    <br><br>

    <button type="submit">

        Login

    </button>

</form>

</body>

</html>