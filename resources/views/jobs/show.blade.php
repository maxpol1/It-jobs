@extends('layouts.main')
@section('content')
    <div class="album text-muted">
        <div class="container">
            @if(Session::has('message'))

                <div class="alert alert-success">{{Session::get('message')}}</div>
            @endif
            @if(Session::has('err_message'))

                <div class="alert alert-danger">{{Session::get('err_message')}}</div>
            @endif
            @if(isset($errors)&&count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>

            @endif
                <div class="row">
                    <div class="title" style="margin-top: 20px;">
                        <h2>{{$job->title}}</h2>

                    </div>

                    <img src="{{asset('vacancy.jpg')}}" style="width: 100px;">
                </div>

            <div class="row" id="app">



                <div class="col-lg-8">


                    <div class="p-4 mb-8 bg-white">
                        <!-- icon-book mr-3-->
                        <h3 class="h5 text-black mb-3"><i class="fa fa-book" style="color: blue;">&nbsp;</i>Описание
                            <a href="#" data-toggle="modal" data-target="#exampleModal1"><i
                                    class="fa fa-envelope-square" style="font-size: 34px;float:right;color:green;"></i></a>
                        </h3>
                        <p> {{$job->description}}.</p>

                    </div>
                    <div class="p-4 mb-8 bg-white">
                        <!--icon-align-left mr-3-->
                        <h3 class="h5 text-black mb-3"><i class="fa fa-user" style="color: blue;">&nbsp;</i>Роли и
                            Обязанности</h3>

                        <p>{{$job->roles}} .</p>

                    </div>
                    <div class="p-4 mb-8 bg-white">
                        <h3 class="h5 text-black mb-3">
                            <i class="fa fa-users" style="color: blue;">&nbsp;</i>
                            Количество вакансий</h3>
                        <p>{{$job->number_of_vacancy }} .</p>

                    </div>
                    <div class="p-4 mb-8 bg-white">
                        <h3 class="h5 text-black mb-3"><i class="fa fa-clock-o" style="color: blue;">&nbsp;</i>Стаж

                        </h3>
                        <p>{{$job->experience}}&nbsp;лет</p>

                    </div>
                    <div class="p-4 mb-8 bg-white">
                        <h3 class="h5 text-black mb-3"><i class="fa fa-venus-mars" style="color: blue;">&nbsp;</i>Gender
                        </h3>
                        <p>{{$job->gender}} </p>

                    </div>
                    <div class="p-4 mb-8 bg-white">
                        <h3 class="h5 text-black mb-3"><i class="fa fa-dollar" style="color: blue;">&nbsp;</i>Зарплата
                        </h3>
                        <p>{{$job->salary}}</p>
                    </div>

                </div>


                <div class="col-md-4 p-4 site-section bg-light">
                    <h3 class="h5 text-black mb-3 text-center">Краткая информация</h3>
                    <p>Имя компании:<a
                            href="{{ route('company.index',[$job->company->id, $job->company->slug]) }}"></a>{{$job->company->cname}}
                    </p>
                    <p>Адрес:{{$job->address}}</p>
                    <p>Вид занятости:{{$job->type}}</p>
                    <p>Позиция:{{$job->position}}</p>
                    <p>Время публикации:{{$job->created_at->diffForHumans()}}</p>
                    <p>Последняя дата подачи заявки :{{ date('F d, Y', strtotime($job->last_date)) }}</p>


                    <p><a href="{{route('company.index',[$job->company->id,$job->company->slug])}}"
                          class="btn btn-warning" style="width: 100%;">Посетить страницу компании</a></p>
                    <p>
                        @if(Auth::check()&&Auth::user()->user_type=='seeker')


                            @if(!$job->checkApplication())

                                <apply-component :jobid={{$job->id}}></apply-component>
                    @else
                        <center><span style="color: #000;">Заявка отправлена</span></center>
                    @endif
                    <br>
                    <favorite-component
                        :jobid={{$job->id}} :favorited={{$job->checkSaved()?'true':'false'}} ></favorite-component>
                    @else
                        Пожалуйста войдите, чтобы подать заявку

                        @endif

                        </p>

                </div>
                @foreach($jobRecommendations as $jobRecommendation)
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <p class="badge badge-success">{{$jobRecommendation->type}}</p>
                            <h5 class="card-title">{{$jobRecommendation->position}}</h5>
                            <p class="card-text">{{\Illuminate\Support\Str::limit($jobRecommendation->description,90)}}
                            <center><a href="{{route('jobs.show',[$jobRecommendation->id,$jobRecommendation->slug])}}"
                                       class="btn btn-success">Смотреть</a></center>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Modal -->
                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Порекомендовать</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('mail')}}" method="POST">
                                @csrf

                                <div class="modal-body">
                                    <input type="hidden" name="job_id" value="{{$job->id}}">
                                    <input type="hidden" name="job_slug" value="{{$job->slug}}">

                                    <div class="form-group">
                                        <label>Ваше имя * </label>
                                        <input type="text" name="your_name" class="form-control" required="">
                                    </div>
                                    <div class="form-goup">
                                        <label>Ваш email*</label>
                                        <input type="email" name="your_email" class="form-control" required="">
                                    </div>
                                    <div class="form-goup">
                                        <label>Имя человека *</label>
                                        <input type="text" name="friend_name" class="form-control" required="">
                                    </div>
                                    <div class="form-goup">
                                        <label>Его почта *</label>
                                        <input type="email" name="friend_email" class="form-control" required="">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <br>
            <br>
            <br>

        </div>
    </div>
@endsection
