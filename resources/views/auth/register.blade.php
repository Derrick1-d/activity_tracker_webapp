<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row register-container w-100" style="max-width: 900px;">
            <!-- Image Section -->
            <div class="col-md-6 register-image">
                <img src="/img/login.jpeg" alt="Registration Illustration" class="img-fluid" style="max-width: 80%;">
            </div>

            <!-- Form Section -->
            <div class="col-md-6 register-form">
                <h2>Create an Account</h2>
                <p class="mb-4">Sign up now and unlock exclusive access!</p>

                <!-- General Error Display -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="First Last" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="you@email.com" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <!-- Password Confirmation -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        @error('password_confirmation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                    </div>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="already-account">Sign in</a>
                </div>

                <div class="text-center mt-3">
                    <a href="mailto:derricktabiri046@gmail.com" class="help-link">derricktabiri046@gmail.com</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
