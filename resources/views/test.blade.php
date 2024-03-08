<!DOCTYPE html>
<html>
<head>
    <title>Scratch Blade</title>
</head>
<body>
    <h1>QR Code Image</h1>
    <div class="visible-print text-center">
        {!! QrCode::size(100)->generate('sam bayot'); !!}
        <p>Scan me to return to the original page.</p>

        <a href="{{ route('qrcode.download') }}">Download</a>

    </div>
</body>
</html>
