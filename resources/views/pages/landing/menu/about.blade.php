@extends('pages.landing.main')
@section('content')

    <!-- Start Banner Hero -->
    <section class="bg-light w-100">
        <div class="container">
            <div class="row d-flex align-items-center py-5">
                <div class="col-lg-6 text-start">
                    <h1 class="h2 py-5 text-primary typo-space-line">Tentang Kami</h1>
                    <p class="light-300">
                        Berikut merupakan halaman tentang kami pengurus BEM FASILKOM UNEJ. Yuk yang penasaran bisa dikepoin ya :)
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="{{asset("template-assets/img/banner-img-02.svg")}}">
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Hero -->


    <!-- Start Team Member -->
{{--    <section class="container py-5">--}}
{{--        <div class="pt-5 pb-3 d-lg-flex align-items-center gx-5">--}}

{{--            <div class="col-lg-3">--}}
{{--                <h2 class="h2 py-5 typo-space-line">Our Team</h2>--}}
{{--                <p class="text-muted light-300">--}}
{{--                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,--}}
{{--                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.--}}
{{--                </p>--}}
{{--            </div>--}}

{{--            <div class="col-lg-9 row">--}}
{{--                <div class="team-member col-md-4">--}}
{{--                    <img class="team-member-img img-fluid rounded-circle p-4" src="{{asset("template-assets/img/team-01.jpg")}}" alt="Card image">--}}
{{--                    <ul class="team-member-caption list-unstyled text-center pt-4 text-muted light-300">--}}
{{--                        <li>John Doe</li>--}}
{{--                        <li>Business Development</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="team-member col-md-4">--}}
{{--                    <img class="team-member-img img-fluid rounded-circle p-4" src="{{asset("template-assets/img/team-02.jpg")}}" alt="Card image">--}}
{{--                    <ul class="team-member-caption list-unstyled text-center pt-4 text-muted light-300">--}}
{{--                        <li>Jane Doe</li>--}}
{{--                        <li>Media Development</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="team-member col-md-4">--}}
{{--                    <img class="team-member-img img-fluid rounded-circle p-4" src="{{asset("template-assets/img/team-03.jpg")}}" alt="Card image">--}}
{{--                    <ul class="team-member-caption list-unstyled text-center pt-4 text-muted light-300">--}}
{{--                        <li>Sam</li>--}}
{{--                        <li>Developer</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </section>--}}
    <!-- End Team Member -->

    <section class="service-wrapper py-3">
        <div class="service-tag py-5 bg-secondary">
            <div class="col-md-12">
                <ul class="nav d-flex justify-content-center">
                    <li class="nav-item mx-lg-4" >
                        <a class="filter-btn nav-link btn-outline-primary active shadow rounded-pill text-light px-4 light-300" href="#" data-filter=".BPH" selected>BPH</a>
                    </li>
                    <li class="nav-item mx-lg-4">
                        <a class="filter-btn nav-link btn-outline-primary rounded-pill text-light px-4 light-300" href="#" data-filter=".KOMINFO">KOMINFO</a>
                    </li>
                    <li class="filter-btn nav-item mx-lg-4">
                        <a class="filter-btn nav-link btn-outline-primary rounded-pill text-light px-4 light-300" href="#" data-filter=".LuarDalam">Luar Dalam</a>
                    </li>
                    <li class="nav-item mx-lg-4">
                        <a class="filter-btn nav-link btn-outline-primary rounded-pill text-light px-4 light-300" href="#" data-filter=".ADKESMA">ADKESMA</a>
                    </li>
                    <li class="nav-item mx-lg-4">
                        <a class="filter-btn nav-link btn-outline-primary rounded-pill text-light px-4 light-300" href="#" data-filter=".PSDM">PSDM</a>
                    </li>
                    <li class="nav-item mx-lg-4">
                        <a class="filter-btn nav-link btn-outline-primary rounded-pill text-light px-4 light-300" href="#" data-filter=".Perekonomian">Perekonomian</a>
                    </li>
                    <li class="nav-item mx-lg-4">
                        <a class="filter-btn nav-link btn-outline-primary rounded-pill text-light px-4 light-300" href="#" data-filter=".NATKAT">NATKAT</a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="container overflow-hidden py-5">
        <div class="row gx-5 gx-sm-3 gx-lg-5 gy-lg-5 gy-3 pb-3 projects">
            @foreach($member as $m)
                    <div class="col-xl-3 col-md-4 col-sm-6 project ui {{ $m->division }}">
                        <div class="service-work overflow-hidden card mx-5 mx-sm-0">
                            <img class="service card-img" src={{ asset('storage/img/member/'.$m->thumbnail) }} alt="...">
                            <div class="card-body">
                                <h5 class="card-title light-300 text-dark"><b>{{ $m->name }}</b></h5>
                                <p class="card-text light-300 text-dark">
                                    {{ $m->position }}
                                </p>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    </section>

    <section class="bg-secondary">
        <div class="container py-5">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-7 col-12 text-light pt-2">
                    <h3 class="h4 light-300"><b>"Successful people don't fear failure but understand that it's necessary to learn and grow from"</b></h3>
                    <p class="light-300">Robert Kiyosaki</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End View Work -->

    <!-- Start Choice -->
    <section class="why-us banner-bg bg-light">
        <div class="container my-4">
            <div class="row">
                <div class="banner-img col-lg-5">
                    <img src="{{asset("template-assets/img/work.svg")}}" class="rounded img-fluid" alt="">
                </div>
                <div class="banner-content col-lg-7 align-self-end">
                    <h2 class="h2 pb-3">Yuk Kepoin Media Sosial Kami</h2>
                    <p class="text-muted pb-5 light-300">
                        Biar tidak ketinggalan informasi terkait perkuliahan maupun informasi lainnya yuk segera follow media sosial BEM FASILKOM UNEJ ya
                </div>
            </div>
        </div>
    </section>
    <!-- End Choice -->

@endsection
