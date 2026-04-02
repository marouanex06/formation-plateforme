<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Nouveau message de contact</h2>

    <p><strong>Nom :</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email :</strong> {{ $contactMessage->email }}</p>
    <p><strong>Sujet :</strong> {{ $contactMessage->subject }}</p>
    <p><strong>Message :</strong></p>
    <p>{{ $contactMessage->message }}</p>
</body>
</html>