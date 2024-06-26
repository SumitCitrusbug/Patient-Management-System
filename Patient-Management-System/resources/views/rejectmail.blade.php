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


    <h1> Dear, {{ $data->users->name }}</h1>
    <h1> Appointment is rejected</h1>
    <p>Doctor name = {{ $data->docter->name }}</p>
    <p>Appointment time = {{ $data->appointment_time }}</p>
    <p>Appointment date = {{ $data->appointment_date }}</p>

    {{-- <h5> {{ $content }} </h5> --}}
    {{-- <p>http://127.0.0.1:8000/api/makepayment/{{ $data->id }}</p> --}}

</body>

</html>
