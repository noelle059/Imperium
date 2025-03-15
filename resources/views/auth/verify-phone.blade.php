<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Verification</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap">
    <style>
        body {
            margin-top: 20px;
            background-color: #f2f3f8;
            position: relative;
            min-height: 100vh;
            background-image: url("../../images/CLASSROOM_BACKGROUND.svg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Poppins, sans-serif;
        }
        .card {
            background-image: linear-gradient(to bottom, #a7d1ab, #c5ebac, #80a184);
            border-radius: 10px;
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.08);
            max-width: 500px;
            width: 100%;
            padding: 20px;
            text-align: center;
        }
        .h2 {
            font-size: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #555;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            background: #f5f5f5;
            color: #333;
            border-radius: 7px;
            font-size: 15px;
        }
        .btn-primary {
            width: 100%;
            background: #9ABA2F;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            border-radius: 15px;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: 0.5s;
        }
        .btn-primary:hover {
            background: #f5f5f5;
            color: #809927;
        }
    </style>
</head>
<body>
<div class="card">
    <h2 class="h2">Phone Verification</h2>
    <p>We have sent an OTP to your registered contact number:</p>

    <h3 style="color: #555;">
        {{ Auth::user()->contact_number ?? 'No contact number found' }}
    </h3>

    @if (session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif
    
    @if (session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif

    <!-- Send OTP -->
    <form method="POST" action="{{ route('auth.verify-phone.sendOtp') }}">
        @csrf
        <button class="btn-primary" type="submit">Resend OTP</button>
    </form>

    <br>
    <br>
    <br>

    <!-- Verify OTP -->
    <form method="POST" action="{{ route('auth.verify-phone.verifyOtp') }}">
        @csrf
        <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
        <button class="btn-primary" type="submit">Verify OTP</button>
    </form>


</div>
</body>
</html>
