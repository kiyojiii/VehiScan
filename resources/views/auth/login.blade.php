<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> MVIS | Login </title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

</head>

<body>

    @extends('layouts.login')

    @section('content')


    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xl-9">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">

                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center">

                                                <h4 class="mb-3"><span class="text-primary"></span></h4>

                                                <div dir="ltr">
                                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4"></p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary"></h4>
                                                                    <p class="font-size-14 mb-0"> </p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <style>
                                                            .quote-container {
                                                                background-color: rgba(255, 255, 255, 0.6) !important;
                                                                /* Adjust the alpha value to set the opacity */
                                                                padding: 10px;
                                                                /* Add padding for better appearance */
                                                                border-radius: 5px;
                                                                /* Add border-radius for rounded corners */
                                                            }
                                                        </style>

                                                        <div class="item">
                                                            <div class="py-3">
                                                                <div class="quote-container bg-light p-3 rounded">
                                                                    <p id="quote" class="font-size-16 mb-2"></p>
                                                                    <div>
                                                                        <h4 id="author" class="font-size-16 text-danger mb-0"></h4>
                                                                        <p class="font-size-14 mb-0"></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                fetch('https://type.fit/api/quotes')
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        // Get 5 random quotes
                                                                        const randomQuotes = getRandomElements(data, 5);
                                                                        // Display each quote
                                                                        randomQuotes.forEach(quote => {
                                                                            const {
                                                                                text,
                                                                                author
                                                                            } = quote;
                                                                            const quoteElement = document.getElementById('quote');
                                                                            const authorElement = document.getElementById('author');
                                                                            // Set quote text and author
                                                                            quoteElement.textContent = `"${text}"`;
                                                                            // Remove ', type.fit' from the author if present
                                                                            const cleanAuthor = author.replace(', type.fit', '');
                                                                            authorElement.textContent = `-${cleanAuthor}`;
                                                                        });
                                                                    })
                                                                    .catch(error => console.error('Error fetching quotes:', error));
                                                            });

                                                            // Function to get n random elements from an array
                                                            function getRandomElements(array, n) {
                                                                const shuffled = array.sort(() => 0.5 - Math.random());
                                                                return shuffled.slice(0, n);
                                                            }
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-primary">Welcome To MVIS!</h5>
                                        <p class="text-muted">Sign in to continue.</p>
                                    </div>

                                    <div class="mt-4">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email" required autocomplete="email" autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required autocomplete="current-password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i>Forgot your password?</a>
                                                @endif
                                            </div>

                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary"> Signup now </a> </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i></p>
                                </div> -->
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    @endsection
</body>

</html>