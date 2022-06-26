@component('mail::message')
Hello {{$name}}  

Your password is reset by admin, now you can login with this credentials :-  

Email Address :- {{$email}}  
Password :- <span style="fornt-weight:bold; color:green; font-size:20px;">{{$password}}</span>  


Sincerely,  
blntlee team
@endcomponent