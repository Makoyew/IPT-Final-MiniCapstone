<p>
    Welcome! {{$user->name}}
</p>

<p>
    You received this email as a result of your registration our website.
</p>

<p>
    Please click on the verification link to verify your account
</p>

<p>
    <a href="{{ url('/verification/' . $user->id. '/' . $user->remember_token) }}">Click me please yamete kudasai.</a>
</p>
