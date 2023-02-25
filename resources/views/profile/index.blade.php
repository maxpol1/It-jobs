@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @if(empty($profile->avatar))
                    <img src="{{asset('avatar/man.jpg')}}" width="100" style="width: 100%;">
                @else
                    <img src="{{asset('uploads/avatar')}}/{{$profile->avatar}}" width="100"
                         style="width: 100%;">

                @endif
                <br><br>

                <form action="{{route('avatar')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">Загрузить фото</div>
                        <div class="card-body">
                            <input type="file" class="form-control" name="avatar">
                            <br>
                            <button class="btn btn-success float-right" type="submit">Добавить</button>
                            @if($errors->has('avatar'))
                                <div class="error" style="color: red;">{{$errors->first('avatar')}}</div>
                            @endif

                        </div>
                    </div>
                </form>


            </div>

            <div class="col-md-5">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{Session::get('message')}}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Обновите профиль</div>

                    <form action="{{route('profile.create')}}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Адрес</label>
                                <input type="text" class="form-control" name="address"
                                       value="{{$profile->address}}">
                                @if($errors->has('address'))
                                    <div class="error" style="color: red;">{{$errors->first('address')}}</div>
                                @endif

                            </div>


                            <div class="form-group">
                                <label for="">Телефон</label>
                                <input type="text" class="form-control" name="phone_number"
                                       value="{{$profile->phone_number}}">
                                @if($errors->has('phone_number'))
                                    <div class="error" style="color: red;">{{$errors->first('phone_number')}}</div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="">Опыт</label>
                                <textarea name="experience"
                                          class="form-control">{{$profile->experience}}</textarea>
                                @if($errors->has('experience'))
                                    <div class="error" style="color: red;">{{$errors->first('experience')}}</div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="">О себе</label>
                                <textarea name="bio" class="form-control">{{$profile->bio}}</textarea>
                                @if($errors->has('bio'))
                                    <div class="error" style="color: red;">{{$errors->first('bio')}}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Применить</button>
                            </div>

                        </div>
                </div>


            </div>


            </form>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">О себе</div>
                    <div class="card-body">
                        <p>Имя:{{Auth::user()->name}}</p>
                        <p>Email:{{Auth::user()->email}}</p>
                        <p>Адрес:{{$profile->address}}</p>

                        <p>Телефон:{{$profile->phone_number}}</p>
                        <p>Пол:{{$profile->gender}}</p>
                        <p>Стаж:{{$profile->experience}}</p>
                        <p>О себе:{{$profile->bio}}</p>
                        <p>Дата регистрации:{{date('F d Y',strtotime(Auth::user()->created_at))}}</p>

                        @if(!empty($profile->cover_letter))
                            <p><a href="{{Storage::url($profile->cover_letter)}}">Сопроводительное
                                    письмо</a></p>
                        @else
                            <p>Загрузить сопроводительное письмо</p>
                        @endif


                        @if(!empty($profile->resume))
                            <p><a href="{{Storage::url($profile->resume)}}">Рузюме</a></p>
                        @else
                            <p>Загрузить резюме</p>
                        @endif


                    </div>
                </div>
                <br>
                <form action="{{route('cover.letter')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">Обновить сопроводительное письмо</div>
                        <div class="card-body">
                            <input type="file" class="form-control" name="cover_letter"><br>
                            <button class="btn btn-success float-right" type="submit">Update</button>
                            @if($errors->has('cover_letter'))
                                <div class="error" style="color: red;">{{$errors->first('cover_letter')}}</div>
                            @endif
                        </div>
                    </div>
                </form>

                <br>
                <form action="{{route('resume')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">Обновить резюме</div>
                        <div class="card-body">
                            <input type="file" class="form-control" name="resume">
                            <br>
                            <button class="btn btn-success float-right" type="submit">Применить</button>
                            @if($errors->has('resume'))
                                <div class="error" style="color: red;">{{$errors->first('resume')}}</div>
                            @endif
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection

