@component('mail::message')

    Здравствуйте {{$data['friend_name']}}, {{$data['your_name']}}({{$data['your_email']}})
    порекомендовал вам эту работу.

    @component('mail::button', ['url' => $data['jobUrl']])
        Посмотреть вакансию
    @endcomponent

    Спасибо,<br>
    {{ config('app.name') }}
@endcomponent
