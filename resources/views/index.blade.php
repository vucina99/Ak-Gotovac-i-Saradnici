@extends("content")

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center ">
                <div class="responsive-div-width setHeight d-flex align-items-center">
                    <div class="text-center">
                      <img src="{{asset("img/started-page-image.jpg")}}" class="img-fluid" alt="started-image"> <br><br><br>
                        <a href="/login"><button class="btn w-100 btn-outline-primary">PRONADJI TRAŽENI PREDMET   <i class="fa fa-angle-double-right ml-2" aria-hidden="true"></i>
                            </button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
