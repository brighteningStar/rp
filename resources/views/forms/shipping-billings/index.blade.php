@extends('layouts.master')
@section('title')
    <title>Shipping Billings</title>
@endsection

@section('page_heading')
    Shipping Billings
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Billings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Shipping Billings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <shipping-billing-component></shipping-billing-component>




@endsection
