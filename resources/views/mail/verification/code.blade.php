<x-mail::message>
Your Verification code is 

<x-mail::button :url="'http://127.0.0.1:8000'">
    {{$code}}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
