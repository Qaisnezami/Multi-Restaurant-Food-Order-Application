@component('mail::message')
{!! $body !!}

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}


@endcomponent