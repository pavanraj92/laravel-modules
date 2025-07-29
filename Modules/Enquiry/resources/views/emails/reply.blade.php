<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reply to Your Enquiry</title>
</head>

<body>
    <p>Dear {{ $enquiry->full_name ?? 'User' }},</p>

    <p>Thank you for reaching out to us with your enquiry.</p>

    <p><strong>Your Original Message:</strong></p>
    <blockquote style="background: #f9f9f9; padding: 10px; border-left: 3px solid #ccc;">
        {!! $enquiry->message !!}
    </blockquote>

    <p><strong>Admin's Reply:</strong></p>
    <blockquote style="background: #f9f9f9; padding: 10px; border-left: 3px solid #ccc;">
        {!! $enquiry->admin_reply !!}
    </blockquote>

    <p>If you have any further questions or concerns, feel free to reply to this email.</p>

    <p>Best regards,</p>
    <p>{{ $enquiry->repliedBy->full_name ?? 'Support Team' }}<br>
        {{ config('app.name') }}

    </p>
</body>

</html>