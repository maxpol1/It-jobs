@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Applicants</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                @foreach($applicants as $applicant)

                    <div class="card">
                        <div class="card-header"><a
                                href="{{route('jobs.show',[$applicant->slug])}}"> {{$applicant->title}}</a>
                        </div>

                        <div class="card-body">
{{--                            @dd($applicant->users)--}}
                            @foreach($applicant->users as $user)

                                <table class="table" style="width: 100%;">
                                    <thead class="thead-dark">
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            @if($user->profile->avatar)
                                                <img src="{{asset('uploads/avatar')}}/{{$user->profile->avatar}}"
                                                     width="80">
                                            @else
                                                <img src="{{asset('uploads/avatar/man.jpg')}}" width="80">
                                            @endif

                                            <br>Дата публикации:{{ date('F d, Y', strtotime($applicant->created_at)) }}
                                        </td>
                                        <td>Имя:{{$user->name}}</td>
                                        <td>Email{{$user->email}}</td>
                                        <td>Адрес:{{$user->profile->address}}</td>
                                        <td>Пол{{$user->profile->gender}}</td>
                                        <td>Опыт:{{$user->profile->experience}}</td>
                                        <td>О себе:{{$user->profile->bio}}</td>
                                        <td>Телефон:{{$user->profile->phone_number}}</td>

                                        <td><a href="{{Storage::url($user->profile->resume)}}">Резюме</a></td>

                                        <td><a href="{{Storage::url($user->profile->cover_letter)}}">Сопроводительное письмо</a>
                                        </td>
                                        <td></td>

                                    </tr>

                                    </tbody>
                                </table>

                        </div>
                        <br><br>
                        @endforeach
                    </div>
                    <br>
                @endforeach


            </div>

        </div>
    </div>
    </div>
@endsection
