<h1>Email Verification</h1>
<p>A verification link has been sent to your email. Please check your inbox.</p>
<form method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit">Resend Verification Email</button>
</form>
