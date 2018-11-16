Hola {{$user->name}}
Ha cambiado el correo , verifique la nueva dirección sigguiendo el siguiente enlace:
{{route('verify',$user->verification_token)}}