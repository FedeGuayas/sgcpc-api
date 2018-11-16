@component('mail::message')
# Hola {{$user->name}}

Ha cambiado su dirección de correo electrónico. Por favor verifique la nueva dirección usando el siguiente botón:

@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirmar mi cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
