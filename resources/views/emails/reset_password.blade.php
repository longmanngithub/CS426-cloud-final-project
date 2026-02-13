<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        <a href="{{ $link }}" style="display:inline-block;padding:10px 20px;background-color:#007bff;color:#fff;text-decoration:none;border-radius:5px;">
            Reset Password
        </a>
    </p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>This password reset link will expire in 24 hours.</p>
    <hr>
    <p style="font-size:12px;color:#888;">If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: {{ $link }}</p>
</body>
</html>
