@component('mail::message')
Hello {{ $name }}  

Your password has been changed, Now these are your login credentials.

Email : {{ $email }}  
Password : {{ $password }}  

Sincerely,  
CarsBN
@endcomponent