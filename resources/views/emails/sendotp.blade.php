<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: red;
        }

        .otp-container {
            background-color: red;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .otp-container p {
            color: #ffffff;
        }

        .footer {
            text-align: center;
            color: #95a5a6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verification</h1>
        </div>

        <div class="otp-container">
            <p>Your One-Time Password (OTP) is:</p>
            <strong>{{ $Otp }}</strong>
        </div>

        <div class="footer">
            <p>This email was sent to you as part of the OTP verification process. If you did not request this, please
                ignore this email.</p>
        </div>
    </div>
</body>

</html>
