<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ env('APP_NAME') }}</title>
  {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/favicon.ico') }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/fontawesome.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
</head>


<body>
   <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h1>{{ __('500') }}</h1>
            <h2>{{ __('Error') }}</h2>

            <div class="page-description">
             {{ __('SERVER ERROR') }}
            </div>
            <div class="page-search">
              {{-- <form action="{{ url(env('APP_URL').'/register') }}">
                <div class="form-group floating-addon floating-addon-not-append">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-search"></i>
                      </div>
                    </div>
                    <input type="email" name="email" required="" class="form-control" placeholder="Enter your email">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-lg">
                        {{ __('Register') }}
                      </button>
                    </div>
                  </div>
                </div>
              </form> --}}
                <a href="{{ url(env('APP_URL')) }}">
                    <button class="btn btn-primary btn-lg">
                        {{ __('Back to Home') }}
                    </button>
                </a>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
            {{ 'Made With' }} <i class="fas fa-heart fas-lg text-danger"></i> {{ 'By' }} <a href="https://sala.sd" class="font-weight-bold" target="_blank" rel="noopener noreferrer">{{ 'Sala Platform' }}</a>&copy; <div class="bullet"></div>{{ '2019' }} - {{ date('Y') }}
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('admin/assets/js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
</body>
</html>
