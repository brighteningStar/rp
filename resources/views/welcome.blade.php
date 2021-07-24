@extends('layouts.auth.master')
@section('title')
    <title>RP</title>
@endsection
<section class="msg-bar-color">
    <div class="msg-bar-text text-center justify-content-center" style="top: 20px;color: #fff;position: relative;font-size: 14px;">
        <span style="font-weight: 500;">Test our free demo</span> <span>Our intuitive control panel, simple pricing packages and adaptable tools means our services grow along with you.</span>
    </div>
</section>

<section class="main-bg mb-60">
    <div class="contact-btn">
        <button class="btn btn-lg white"><i class="far fa-circle fa-icon"></i><i class="fas fa-circle fa-inner-icon"></i>Talk to us</button>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark t10">
        <div class="container">
            <a class="navbar-brand" href="#">RP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav mt-2 ml-lg-auto fs-nav">
                    <li class="nav-item active">
                        <a class="nav-link white" href="#">Products <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link white" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link white" href="#">Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link white" href="#">Company</a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-lg-center d-none d-lg-flex ml-lg-auto fs-nav">
                    <li class="nav-item">

                        @if( Auth::user() == null )
                            <a class="nav-link white" href="/login">Login</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a href="/register" class="btn btn-lg btn-white btn-icon ml-3 nav-btn">Sign up</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
    <div class="banner-main-text">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="white txt-cloud">Cloud and managed services</span>
                    <span class="blue-shade txt-cloud">&nbsp;that put the right information at your fingertips.</span>
                    <p class="white pitch-txt">Our intuitive control panel, simple pricing packages and adaptable tools mean our services grow along with you, so you can focus on scaling your business.</p>
                    <form class="sign-up-form">
                        <div class="form-row">
                            <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Your Email" required>
                            <button class="btn">Get Started</button>
                        </div>
                    </form>
                    <div class="check-list f14 row">
                        <span class="white col-md-4"><i class="fas fa-check blue-shade"></i> Free 14-days Demo</span>
                        <span class="white col-md-3"><i class="fas fa-check blue-shade ml-lg-auto"></i> No setup</span>
                        <span class="white col-md-5"><i class="fas fa-check blue-shade"></i> No credit card needed</span>
                    </div>
                    <div class="slider-lines row">
                        <div class="col-md-4">
                            <hr class="active-line first" onclick="plusDivs(+1)">
                        </div>
                        <div class="col-md-4">
                            <hr class="non-active-line second">
                        </div>
                        <div class="col-md-4">
                            <!-- <hr class="non-active-line"> -->
                        </div>
                        <!-- <img src="images/slider-line.png" /> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="server-img">
                        <img src="images/server.png" class="my-slides" data-hr="first"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<section class="banner-below mb-60">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <h1 class="">Rapid access with Daticloud</h1>
            <div class="col-md-7">
                <p class="f14">Daticloud’s simple, effective system always puts you and your team first. You get more time to focus on your business while we take care of your infrastructure and platforms.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card light-blue-shade">
                    <div class="card-body">
                        <img src="images/cup.png" />
                        <h3 class="card-subtitle mb-2 text-muted">Intuitive Interface</h3>
                        <p class="card-text">Access your data with effortless controls. Our robust API lets you focus on.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card light-blue-shade">
                    <div class="card-body">
                        <img src="images/shield.png" />
                        <h3 class="card-subtitle mb-2 text-muted">Superior Integration</h3>
                        <p class="card-text">Access your data with effortless controls. Our robust API lets you focus on.</p>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dark-blue-shade special-card">
                    <div class="card-body">
                        <img src="images/server-icon.png" />
                        <h3 class="card-subtitle mb-2 text-muted white">Excellent Support</h3>
                        <p class="card-text white">Access your data with effortless controls. Our robust API lets you focus on.</p>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card light-blue-shade">
                    <div class="card-body">
                        <img src="images/shield-icon.png" />
                        <h3 class="card-subtitle mb-2 text-muted">Total <br> Security</h3>
                        <p class="card-text">Access your data with effortless controls. Our robust API lets you focus on.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="last-bg mb-60">
    <div class="container-fluid last-banner">
        <div class="row justify-content-center text-center">
            <div class="col-md-3">
                <img src="images/bottom-image-1.png" class="img-responsive all-servers"/>
            </div>
            <div class="col-md-6">
                <h1 class="white inter-family">Grow your Business</h1>
                <h2 class="blue-shade inter-family mb-60">with our platform.</h2>
                <p class="white mb-0">Daticloud includes all the latest features you need to stay ahead of the pack.</p>
                <p class="white mb-60">Discover the difference our rapid, streamlined and intuitive systems can make.</p>
                <button class="btn btn-primary"><a href="/register">Create your account</a></button>
            </div>
            <div class="col-md-3">
                <img src="images/bottom-image-2.png" class="img-responsive all-server-2"/>
            </div>
        </div>
    </div>

</section>

<footer>
    <div class="container">
        <div class="row mb-60">
            <div class="col-md-4">
                <p class="dark-blue-shade-font mb-5">Cloud and managed services that put the right information at your fingertips</p>
                <span>Follow us around</span>
                <br>
                <img src="images/facebook.png" class="media-logo"/>
                <img src="images/linkedin.png" class="media-logo"/>
                <img src="images/instagram.png" class="media-logo"/>
            </div>
            <div class="col-md-2">
                <h6>Products</h6>
                <ul>
                    <li>Cloud Compute</li>
                    <li>HF Computer</li>
                    <li>Bare Metal</li>
                    <li>Object Storage</li>
                    <li>Block Storage</li>
                    <li>Dedicated Instences</li>
                    <li>DDoS Protections</li>
                    <li>Direct Connect</li>
                    <li>Load Balancers</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Features</h6>
                <ul>
                    <li>Data Center Locations</li>
                    <li>Advanced Network</li>
                    <li>Control Panel</li>
                    <li>Operating Systems</li>
                    <li>Upload ISO</li>
                    <li>Onw-Click Apps</li>
                    <li>Bring you IP space</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Resources</h6>
                <ul>
                    <li>FAQ</li>
                    <li>Developers / API's</li>
                    <li>Vultr Docs</li>
                    <li>Benchmarks</li>
                    <li>Server Status</li>
                    <li>Bug Bonty</li>
                    <li>Coupons</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Company</h6>
                <ul>
                    <li>Our Team</li>
                    <li>News</li>
                    <li>Brand Assets</li>
                    <li>Referral Program</li>
                    <li>Careers</li>
                    <li>SLA</li>
                    <li>Legal</li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
        <hr class="dark-blue-shade">
        <div class="row mb-5">
            <div class="col-md-6">
                <span>Daticloud 2020 - Daticloud is a registered trademark of DatiHoldings Coperation.</span>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <span class="mis-links">Terms of services</span>
                <span class="mis-links">AUP / DMCA</span>
                <span class="mis-links">Privacy Policy</span>
                <span class="mis-links">Cookie Policy</span>
            </div>
        </div>
    </div>
</footer>