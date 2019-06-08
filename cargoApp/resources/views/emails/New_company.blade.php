@component('mail::message')
Hi  **{{$name}}**,  {{-- use double space for line break --}}

Your company account is now active, please login using the following credentials:
تم تفعيل حساب الشركة، من فضلك سجل دخولك باستخدام البيانات الأتية.

Email:**{{$email}}**   {{-- use double space for line break --}}
Password:**{{$password}}**

@component('mail::button', ['url' => $link])
Click here to download the app.
@endcomponent
@component('mail::button', ['url' => $link])
إضغط هنا لتحميل التطبيق
@endcomponent


thanks,   {{-- use double space for line break --}}
Cargo Team.
@endcomponent