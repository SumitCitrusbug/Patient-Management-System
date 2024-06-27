{{-- <!DOCTYPE html>
<html>

<head>
    <title>appointment accepted</title>

    <script src="https://js.stripe.com/v3/"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>
    <h1> DEAR , {{ $user->users->name }}</h1>
    <h1> Your appointment is accepted</h1>
    <p>Doctor name = {{ $user->docter->name }}</p>
    <p>Appointment time = {{ $user->appointment_time }}</p>
    <p>Appointment date = {{ $user->appointment_date }}</p>
    <h2>Amount = $ {{ $user->docter->amount }}</h2>

    <h3>To payment click on link below
    </h3>
    <p></p>
    <br>
    <a href="{{ $invoice }}"> MAKE PAYMENT INVOICE</a>



</body>

</html> --}}
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <h2 class="text-center m-4">Your appointmnet is accepted</h2>
    <h4 class="text-center m-4">Appointment Deatils</h4>
    <div class="container">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Doctor</th>
                    <th scope="col">Appointment time</th>
                    <th scope="col">Apoointment date</th>
                    <th scope="col">ammount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $user->docter->name }}</td>
                    <td>{{ $user->appointment_time }}</td>
                    <td>{{ $user->appointment_date }}</td>
                    <td>$ {{ $user->docter->amount }}</td>
                </tr>
                <tr>

            </tbody>
        </table>

        <div class="text-center mt-4">

            <a href="{{ $invoice }}" class="btn btn-primary">Make Payment</a>

        </div>


</body>

</html>
