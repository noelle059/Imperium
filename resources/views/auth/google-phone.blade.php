@extends('layouts.app')

@section('content')

<style>
    .form-control {
        background-color: #343a40;
        color: #ffffff;
        border: 1px solid #495057;
    }

    .form-control:focus {
        background-color: #495057;
        color: #ffffff;
        border-color: #ffffff;
    }

    .btn-light {
        background-color: #ffffff;
        color: #000;
    }

    .btn-light:hover {
        background-color: #e2e2e2;
    }

    .card {
        max-width: 350px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 15px;
    }
</style>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card text-white bg-dark shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Verify Phone</h4>
        </div>
        <div class="card-body p-4 text-center">
            <form method="POST" action="{{ route('google.phone.store') }}">
                @csrf
                <input type="hidden" name="user" value="{{ $user->id }}">
                
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Phone Number</label>
                    <input type="text" id="contact_number" name="contact_number" class="form-control rounded bg-dark text-white border-light text-center" placeholder="Enter your phone" required>
                    @error('contact_number')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary w-100 rounded-pill">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
