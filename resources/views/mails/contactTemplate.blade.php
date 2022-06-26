@component('mail::message')
Hello {{ $formData['full_name'] }}  

Here are  your login credentials :-  

Email Address :- {{ $formData['email'] }}  


Sincerely,  
blntlee team
@endcomponent