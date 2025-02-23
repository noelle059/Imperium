<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Phone</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <style>
        body {
            margin-top: 20px;
            background-color: #F6FCF5;
            position: relative;
            min-height: 100vh;
            background-image: url("../../images/CLASSROOM_BACKGROUND.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: 'Poppins', sans-serif !important;
        }

        .card {
            background-image: linear-gradient(to bottom, #a7d1ab, #c5ebac, #80a184);
            border-radius: 10px !important;
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.08);
            max-width: 400px;
            width: 100%;
            height: auto;
            text-align: center;
            padding: 20px;
        }

        .h2 {
            font-size: 24px !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 2px !important;
            color: #555 !important;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .form-control {
            width: 90% !important;
            padding: 8px !important;
            background: #f5f5f5 !important;
            color: #333 !important;
            border-radius: 7px !important;
            font-size: 14px !important;
            text-align: center;
        }

        .btn-primary {
            width: 90% !important;
            background: #9ABA2F !important;
            color: #fff !important;
            cursor: pointer !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            letter-spacing: 1px !important;
            transition: 0.5s !important;
            border-radius: 15px !important;
            border: none !important;
            padding: 10px 15px !important;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #f5f5f5 !important;
            color: #809927 !important;
        }

        @media screen and (max-width: 768px) {
            .card {
                width: 90%;
            }
            .h2 { font-size: 22px !important; }
            .form-control { font-size: 14px !important; }
            .btn-primary { font-size: 13px !important; padding: 8px 12px !important; }
        }

        @media screen and (max-width: 480px) {
            .card { width: 100%; padding: 15px; }
            .h2 { font-size: 20px !important; }
            .form-control { font-size: 13px !important; padding: 6px !important; }
            .btn-primary { font-size: 12px !important; padding: 6px 10px !important; }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="h2">Verify Phone</h2>
        <form method="POST" action="{{ route('google.phone.store') }}">
            @csrf
            <input type="hidden" name="user" value="{{ $user->id }}">
            <div class="form-group">
                <label for="contact_number" class="form-label">Phone Number</label>
                <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Enter your phone" required>
                @error('contact_number')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
