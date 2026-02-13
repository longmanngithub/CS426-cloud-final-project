<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2>New Contact Message Received</h2>
    
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    
    <h3>Message:</h3>
    <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; border-left: 4px solid #3b82f6;">
        {!! nl2br(e($data['message'])) !!}
    </div>
    
    <br>
    <p style="font-size: 12px; color: #777;">This email was sent from the Local Event Discovery Platform contact form.</p>
</body>
</html>
