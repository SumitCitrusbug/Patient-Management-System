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
    <p>Doctor name = {{ $user->doctor->name }}</p>
    <p>Appointment time = {{ $user->timeSlots->time_start }} - {{ $user->timeSlots->time_end }}</p>
    <p>Appointment date = {{ $user->timeSlots->date }}</p>
    <h2>Paid Amount = $ {{ $user->doctor->amount }}</h2>
</body>

</html>
