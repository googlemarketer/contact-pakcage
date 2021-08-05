@component('mail::message')
# Introduction

The body of your message is
 {{$message}} and sent by
 {{$name}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
