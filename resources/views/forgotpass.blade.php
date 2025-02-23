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
                                <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
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
