<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Your Password</title>
  <style>
    body {
      background: #f4f4f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #27272a;
      margin: 0;
      padding: 1rem;
    }
    .email-container {
      max-width: 600px;
      margin: 2rem auto;
    }
    .container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 10px 15px -3px rgba(39, 39, 42, 0.1);
      position: relative;
    }
    .container::before {
      content: '';
      position: absolute;
      top: -15px; left: -15px; right: -15px; bottom: -15px;
      border-radius: 1rem;
      background: linear-gradient(90deg, #71717a, #a1a1aa, #71717a);
      opacity: 0.15;
      filter: blur(15px);
      z-index: -1;
    }
    h1 {
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    p {
      font-size: 1rem;
      line-height: 1.5;
      margin-bottom: 1rem;
    }
    a.button {
      display: inline-block;
      background-color: #000000;
      color: #ffffff;
      padding: 0.75rem 1.5rem;
      border-radius: 0.75rem;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    a.button:hover {
      background-color: #222222;
    }
    .copy-url a {
      word-break: break-all;
      color: #52525b;
      text-decoration: underline;
    }
    .footer p {
      margin: 0.25rem 0;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="container">
      <h1>Hi {{ $user->email }},</h1>
      <p>You requested to reset your password. To complete this action, click the button below:</p>
      <p><a href="{{ $url }}" class="button">Reset Password</a></p>
      <p>This password reset link will expire in 60 minutes.</p>
      <p>If you did not request a password reset, no further action is required.</p>
      <div class="copy-url">
        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
        <p><a href="{{ $url }}">{{ $url }}</a></p>
      </div>
      <div class="footer">
        <p>Best regards,</p>
        <p>{{ config('app.name') }} Team</p>
      </div>
    </div>
  </div>
</body>
</html>
