@component('mail::message')
# New Notice

The text of the notice right here.

@component('mail::button', ['url' => 'app.computerclinicmw.com'])
Go to {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
