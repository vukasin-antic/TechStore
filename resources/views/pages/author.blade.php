@extends('layouts.layout')

@section('Title', 'Author')

@section('content')

    @include('fixed.page-header', [
        'title' => 'Author',
        'breadcrumbs' => [
            'Author' => '#'
        ]
    ])

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="mx-auto text-center naslov py-5">
                    <h1>About me</h1>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5 col-md-7 col-10 pb-5">
                        <img src="{{ asset('img/author.jpg') }}" alt="author" class="img-fluid author-img mx-auto"/>
                    </div>
                    <div class="col-lg-5 text-center">
                        <h6 class="fs-4 text-primary text-decoration-underline">Name:</h6>
                        <p class="fs-3">Vukašin Antić</p>
                        <h6 class="fs-4 text-primary text-decoration-underline">Index:</h6>
                        <p class="fs-3">65/23</p>
                        <h6 class="fs-4 text-primary text-decoration-underline">Collage:</h6>
                        <p class="fs-3">ICT | IT</p>
                        <div class="col-12 text-center social-icon author pt-3">
                            <ul class="list-group list-group-horizontal justify-content-center">
                                <li class="list-group-item fs-3"><a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a></li>
                                <li class="list-group-item fs-3"><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li class="list-group-item fs-3"><a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-group-item fs-3"><a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                                <li class="list-group-item fs-3"><a href="{{ 'documentation.pdf' }}" target="_blank"><i class="fas fa-file"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
