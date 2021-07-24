<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registration</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">

</head>
<body class="login-page-wrapper">

<section>
    <nav class="navbar navbar-expand-lg navbar-dark t10">
        <div class="container">
            <a class="navbar-brand" href="#">RP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav align-items-lg-center d-none d-lg-flex ml-lg-auto fs-nav">
                    <li class="nav-item">
                        <span class="white f14">Already have an account?</span>
                    </li>
                    <li class="nav-item">
                        <a href="/login" class="f14 btn btn-lg btn-white btn-icon ml-3 nav-btn header-signup-btn">Sign in</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>

<section style="margin-top: 20%;" class="registration-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <img src="images/bottom-image-1.png" class="img-responsive all-servers">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="card dt-pull-up">
                    <div class="card-body">
                        <h5 class="card-title dati-account-title text-center">Sign up to RP</h5>
                        <p class="card-title text-center f14" style="width: 70%;margin: 0 auto;">and spending more time on your projects and lets <strong>RP</strong> managing your infrastructure</p>
                        <form action="" method="POST" class="text-center mt-30 login-form">
                            <div class="alert alert-success dt-success-msg d-none f12"></div>
                            <div class="alert alert-danger dt-error-msg d-none f12"></div>
                            <div class="row form-field">
                                <div class="col-md-12">
                                    <label for="email" class="login-email">Full name &#42;</label>
                                    <input type="text" class="form-control f14" placeholder="" name="name"/>
                                    <input type="text" class="form-control mt-2 f14" placeholder="Email address &#42;" name="email"/>
                                    <input type="password" class="form-control mt-2 f14" placeholder="Password" name="password"/>
                                    <input type="password" class="form-control mt-2 f14" placeholder="Confirm password" name="password"/>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-md-12 text-left">
                                    <button class="btn btn-primary login-btn ">Sign up with Email @include('auth/loader')</button>
                                </div>
                            </div>
                        </form>

                        <div class="row login-form mt-30">
                            <div class="col-md-12 p-md-0 text-center">
                                <span class="forgot-pass-text">By signing up you agree to</span><br><a href="#" class="forgot-pass-text dt-underline">Terms of services</a> <span class="forgot-pass-text"> and </span> <a href="#" class="forgot-pass-text dt-underline">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-20 login-signup-text">
                    <div class="col-md-12 text-center">
                        <span class="login-signup-text">Already have an account? <a href="/login">Sign in</a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <img src="images/bottom-image-2.png" class="img-responsive all-server-2">
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

</html>