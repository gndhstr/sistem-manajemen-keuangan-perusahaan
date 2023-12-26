<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <title>Halaman Login</title>
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form action="" method="post">
        @csrf
        <!-- login kanan -->
        <h1>Login </h1>
        <span>
          <!-- Menampilkan pesan kesalahan -->
          @if ($errors->any())
          <div class="alert alert-danger">

            @foreach ($errors->all() as $error)
            <b>{{ $error }}</b>
            @endforeach
            </>
          </div>
          @endif
        </span>
        <!-- input username -->
        <input id="username" type="text" name="username" placeholder="Masukkan username" required autocomplete="username" autofocus />
        <!-- input password -->
        <input id="password" type="password" placeholder="Password" name="password" required autocomplete="current-password">
        <!-- <a href="#">Forgot your password?</a> -->
        <button type="submit">Masuk</button>
      </form>
    </div>

    <!-- Login kiri -->
    <div class="form-container sign-in-container">
      <form action="" method="post">
        @csrf
        <h1>Login </h1>
        <!-- <div class="social-container">
          <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
          <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
        </div> -->
        <span>
          <!-- Menampilkan pesan kesalahan -->
          @if ($errors->any())
          <div class="alert alert-danger">

            @foreach ($errors->all() as $error)
            <b>{{ $error }}</b>
            @endforeach
            </>
          </div>
          @endif
        </span>
        <!-- input username -->
        <input id="username" type="text" name="username" placeholder="Masukkan username" required autocomplete="username" autofocus />
        <!-- input password -->
        <input id="password" type="password" placeholder="Password" name="password" required autocomplete="current-password">
        <a href="{{ route('lupa') }}" style="color: blue">Lupa Password ?</a>
        <button type="submit">Masuk</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <img class="img-fluid" style="width: 200px" src="{{asset('img/app-logo-shadow.png')}}" alt="logo"></img>
          <h1>Peringatan</h1>
          <p>Usahakan Jangan Login Pakai Akun Lain ya..</p>
          <button class="ghost" id="signIn">Kiri</button>
        </div>
        <div class="overlay-panel overlay-right">
          <img class="img-fluid" style="width: 200px" src="{{asset('img/app-logo-shadow.png')}}" alt="logo"></img>
          <h1>Selamat Datang !</h1>
          <p>Silahkan Login dengan Akun Masing - Masing </p>
          <button class="ghost" id="signUp">Kanan</button>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('js/login.js')}}"></script>
</body>

</html>