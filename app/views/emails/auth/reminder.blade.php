<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>Dear user,</p>

    <p>You recently requested to reset your password.<br/>
        To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.<br/>
        This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.</p>
</div>
</body>
</html>
