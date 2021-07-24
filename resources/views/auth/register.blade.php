@extends('layouts.auth.master')
@section('title')
    <title>RP</title>
@endsection
@section('content')
<div class="login-page-wrapper">
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
</div>
@endsection