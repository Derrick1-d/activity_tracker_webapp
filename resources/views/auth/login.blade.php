<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row login-container w-100" style="max-width: 900px;">
            <!-- Image Section -->
            <div class="col-md-6 login-image">
                <img src="/img/login.jpeg" alt="Login Illustration" class="img-fluid" style="max-width: 80%;">
            </div>

            <!-- Form Section -->
            <div class="col-md-6 login-form">
                <h2>Sign In</h2>
                <p class="mb-4">Unlock your world.</p>

                <!-- Display General Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </form>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="create-account">Create an account</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
