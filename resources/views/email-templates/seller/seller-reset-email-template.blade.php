<p>Dear @if(!empty($seller->name)) {{ $seller->name }} @else {{ $seller->username }} @endif </p>
<br>
<p>
    Your password on {{env('APP_NAME')}} system was changed successfully.
    Here is your new login credentials:
    <br>
    <b>Login ID: </b>{{ $seller->username }} or {{ $seller->email }}
    <br>
    <b>Password: </b>{{ $new_password }}
</p>
<br>
Please, keep your credentials confidential.
Your username and password are your own credentials,
and you should never share them with anybody else.
<p>
    {{env('APP_NAME')}} will not be liable for any misuse of your username or password.
</p>
<br>
----------------------------------------------
<p>
    This email was automatically sent by {{env('APP_NAME')}} system. Do not reply it.
</p>
