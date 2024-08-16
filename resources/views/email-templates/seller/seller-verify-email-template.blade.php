<p>Dear {{ $seller->username }}</p>
<p>
    We are received this email to verify Laravel Seller account associated with {{ $seller->email }} <br>
    You can verify your account by clicking on below link: <br>
    <a href="{{ $actionLink }}">Verify Account</a>
</p>
