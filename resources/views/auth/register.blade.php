@extends('layouts.auth.master')
@section('title')
    <title>RP</title>
@endsection
@section('content')
<div class="login-page-wrapper">
    <section>
        <nav class="navbar navbar-expand-lg navbar-dark t10">
            <div class="container">
                <a class="navbar-brand" href="#"><img class="logo-img" src="/images/logo3.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav align-items-lg-center d-none d-lg-flex ml-lg-auto fs-nav">
                        <li class="nav-item">
                            <span class="white f14">Already have an account?</span>
                        </li>
                        <li class="nav-item">
                            <a href="/" class="f14 btn btn-lg btn-white btn-icon ml-3 nav-btn header-signup-btn">Sign in</a>
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
                <register-component></register-component>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <img src="images/bottom-image-2.png" class="img-responsive all-server-2">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
