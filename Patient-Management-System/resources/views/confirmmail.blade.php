<!DOCTYPE html>
<html>

<head>
    <title>Payment confirmation </title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>
    <h1> Payment successfully by user {{ $user->users->name }}</h1>
    <h1> Appoinment details</h1>
    <p>Doctor name = {{ $user->docter->name }}</p>
    <p>Appointment time = {{ $user->appointment_time }}</p>
    <p>Appointment date = {{ $user->appointment_date }}</p>
    <h2>Paid Amount = $ {{ $user->docter->amount }}</h2>
</body>

</html>
