@component('mail::message')
Hi  **{{$name}}**,  {{-- use double space for line break --}}
your email is  :  **{{$email}}**,  {{-- use double space for line break --}}

Your Email has been added as a supervisor, click here to reset your password and to access your account.

تم إضافة بريدك كمشرف، إضغط هنا لإنشاء كلمة سر حسابك ولدخول لوحة التحكم.
@component('mail::button', ['url' => $link])
Click here to reset your password
@endcomponent
thanks,   {{-- use double space for line break --}}
Cargo Team.
@endcomponent