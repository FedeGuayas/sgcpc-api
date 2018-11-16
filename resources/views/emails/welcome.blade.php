Hola {{$user->name}}
Verifica la cuenta dando clik en el siguiente link:
{{route('verify',$user->verification_token)}}