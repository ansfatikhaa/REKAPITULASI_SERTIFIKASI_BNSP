<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Halaman Login</title>
    <link rel="shortcut icon" href="favicon.png" />
    <link href="assets/Plugins/MDB-Pro_4.14.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/Plugins/MDB-Pro_4.14.1/css/mdb.min.css" rel="stylesheet" />
    <link href="assets/Plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
    <link href="assets/Plugins/fontawesome-free-5.11.2-web/css/fontawesome.min.css" rel="stylesheet" />
    <link href="assets/Plugins/fontawesome-free-5.11.2-web/css/solid.min.css" rel="stylesheet" />
    <link href="assets/Styles/Style.css" rel="stylesheet" />
    <script src="assets/Plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="assets/Plugins/fontawesome-free-5.11.2-web/js/fontawesome.min.js"></script>
</head>

<body class="body-background" style="font-family: 'Noto Sans', sans-serif;">
    <form action="{{ route('login.masuk') }}" method="post" id="formLogin">
        @csrf
        @method('POST')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8 col-sm-12 rounded mb-0 border border-light" style="top: 110px; padding: 30px; margin: 30px; background-color: white;">
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <img src="assets/Images/IMG_Logo.png" style="width: 100%; margin-bottom: 10px; margin-top: 10px;" />
                            </div>
                            <br />
                            @if(\Session::has('alert'))
                            <div class="alert alert-danger">
                                <div>{{ Session::get('alert') }}</div>
                            </div>
                            @endif
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <div>{{ $errors->first() }}</div>
                            </div>
                            @endif
                            <input type="text" name="username" class="form-control mb-3" placeholder="Nama Akun" />
                            <input type="password" name="password" class="form-control mb-3" placeholder="Kata Sandi" />
                            <button type="submit" class="btn btn-info btn-block my-4">Masuk</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="panelfooter">Copyright &copy; <?php echo date("Y"); ?> - MIS Politeknik Astra</div>
</body>

</html>