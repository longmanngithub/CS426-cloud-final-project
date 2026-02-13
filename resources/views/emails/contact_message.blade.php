<!DOCTYPE html>
<html>
<head>
    <title>Contact Message</title>
</head>
<body>
    <h2>New Contact Us Message</h2>
    <p><strong>From:</strong> {{ $data['name'] }} ({{ $data['email'] }})</p>
    <p><strong>Subject:</strong> {{ $data['subject'] ?? 'Inquiry' }}</p>
    <hr>
    <p>{{ $data['message'] }}</p>
</body>
</html>
