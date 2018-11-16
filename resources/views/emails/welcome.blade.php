@component('mail::message')
# Hola {{$user->name}}

Por favor verifique su dirección de correo electrónico usando el siguiente botón:

@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirmar mi cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent