<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }} Attachment</title>
</head>
<style>
    .text {
        color: black !important;
    }
</style>

<body style="font-family: Arial, sans-serif;">

    <p class="text">Hello,</p>

    <p class="text">Please find attached the {{ $subject }} for your reference.</p>

    {{-- <p class="text">
        <a href="{{ app()->isLocal() ? $data->getRiggerPayduty->base_url . $data->getRiggerPayduty->file_url : $data->getRiggerPayduty->base_url . 'storage/' . $data->getRiggerPayduty->file_url }}"
            style="padding: 10px 20px; background-color: #EE3A43; color: #ffffff; text-decoration: none; border-radius: 5px;">View
            Rigger Ticket</a>
    </p> --}}

    <p class="text">Thanks,<br>{{ config('app.name') }}</p>

</body>

</html>
