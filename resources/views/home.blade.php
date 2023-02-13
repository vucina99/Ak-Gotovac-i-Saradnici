@extends('content')

@section('content')
    <div class="setHeight d-flex align-items-center choose">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 pb-3 col-sm-12">
                            <a href="/case">
                                <div class="w-100 options-first options">
                                    <h1 class=" text-center">PREDMETI</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 pb-3 col-sm-12">
                            <a href="/trial">
                                <div class="w-100 options-secound options">
                                    <h1 class="text-center"> ROČIŠTA </h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
