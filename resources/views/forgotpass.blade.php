<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/forgotpass.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('scripts/forgotpass.js') }}" defer></script>
</head>
<body>
        <div class="container h-100">
    		<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="card">
                            <div class="text-center mt-4">
                                <h1 class="h2">Reset password</h1>
                                <p class="lead">
                                    Enter your email to reset your password.
                                </p>
                            </div>

							<div class="card-body">
								<div class="m-sm-4">
                                    <form id="emailForm">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input id="email" class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="index.html" class="btn btn-lg btn-primary">Reset password</a>
                                            <a href="{{ route('login') }}" class="login-button d-lg-block">back to Login</a>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
        
</body>


</html>