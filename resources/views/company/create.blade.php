@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">

                @if(empty(Auth::user()->company->logo))

                    <img src="{{asset('avatar/man.jpg')}}" style="width: 100%;">

                @else
                    <img src="{{asset('uploads/logo')}}/{{Auth::user()->company->logo}}" style="width: 100%;">
                @endif
                <br><br>
                <form action="{{route('company.logo')}}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card">
                        <div class="card-header">Обновить логотип</div>
                        <div class="card-body">
                            <input type="file" class="form-control" name="company_logo"><br>
                            <button class="btn btn-dark float-right" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Обновите информацию о компании</div>

                    <form action="{{route('company.store')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Адрес</label>
                                <input type="text" class="form-control" name="address"
                                       value="{{Auth::user()->company->address}}">
                            </div>
                            <div class="form-group">
                                <label for="">Телефон</label>
                                <input type="text" class="form-control" name="phone"
                                       value="{{Auth::user()->company->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="">Сайт</label>
                                <input type="text" class="form-control" name="website"
                                       value="{{Auth::user()->company->website}}">
                            </div>
                            <div class="form-group">
                                <label for="">Слоган</label>
                                <input type="text" class="form-control" name="slogan"
                                       value="{{Auth::user()->company->slogan}}">
                            </div>
                            <div class="form-group">
                                <label for="">Описание</label>
                                <textarea name="description"
                                          class="form-control"> {{Auth::user()->company->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-dark" type="submit">Обновить</button>
                            </div>

                        </div>
                        @if(Session::has('message'))
                            <div class="alert alert-success">
                                {{Session::get('message')}}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">О компании</div>
                    <div class="card-body">

                        <p> название:{{Auth::user()->company->cname}}</p>

                        <p> адрес:{{Auth::user()->company->address}}</p>

                        <p> телефон:{{Auth::user()->company->phone}}</p>

                        <p> сайт:<a href="{{Auth::user()->company->website}}"> {{Auth::user()->company->website}}</a>
                        </p>

                        <p>Слоган компании:{{Auth::user()->company->website}}</p>
                        <p>Страница компании:<a href="company/{{Auth::user()->company->slug}}">View</a></p>
                    </div>
                </div>
                <br>
                <form action="{{route('cover.photo')}}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card">
                        <div class="card-header">Обновить сопроводительное письмо</div>
                        <div class="card-body">
                            <input type="file" class="form-control" name="cover_photo"><br>
                            <button class="btn btn-dark float-right" type="submit">Обновить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

