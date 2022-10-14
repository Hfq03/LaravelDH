<!-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button> -->
@component('mail::message')
# Hello {{$content['name']}},
 
{{$content['body']}}
 
@component('mail::button', ['url' => $content['url']])
Click Here
@endcomponent
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent
<!-- </x-mail::message> -->
