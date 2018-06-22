@component('mail::message')
# New Feedback

### name
{{ $data['name'] }}

### email
{{ $data['email'] }}


### comments
{{ $data['comments'] }}

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
