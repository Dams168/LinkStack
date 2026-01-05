@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
$usrhandl = Auth::user()->littlelink_name;
@endphp
<!doctype html>
@include('layouts.lang')
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{env('APP_NAME')}}</title>

  <script src="{{asset('assets/js/detect-dark-mode.js')}}"></script>

  {{--
  <base href="{{url()->current()}}" /> --}}

  {{-- @include('layouts.analytics') --}}
  @stack('sidebar-stylesheets')
  {{-- @include('layouts.notifications') --}}

  @php
  // Update the 'updated_at' timestamp for the currently authenticated user
  if (auth()->check()) {
  $user = auth()->user();
  $user->touch();
  }
  @endphp

  <!-- Favicon -->
  {{-- @if(file_exists(base_path("assets/linkstack/images/").findFile('favicon')))
  <link rel="icon" type="image/png" href="{{ asset('assets/linkstack/images/'.findFile('favicon')) }}">
  @else
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/linkstack/images/logo.svg') }}">
  @endif --}}

  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-p79.png') }}">

  <!-- Library / Plugin Css Build -->
  <link rel="stylesheet" href="{{asset('assets/css/core/libs.min.css')}}" />

  <!-- Aos Animation Css -->
  <link rel="stylesheet" href="{{asset('assets/vendor/aos/dist/aos.css')}}" />

  @include('layouts.fonts')

  <!-- Hope Ui Design System Css -->
  {{--
  <link rel="stylesheet" href="{{asset('assets/css/hope-ui.min.css?v=2.0.0')}}" /> --}}

  <!-- Custom Css -->
  <link rel="stylesheet" href="{{asset('assets/css/custom.min.css?v=2.0.0')}}" />

  <!-- Dark Css -->
  {{--
  <link rel="stylesheet" href="{{asset('assets/css/dark.min.css')}}" /> --}}

  <link rel="stylesheet" href="{{asset('assets/css/override.css')}}">

  <!-- Customizer Css -->
  {{-- @if(file_exists(base_path("assets/dashboard-themes/dashboard.css")))
  <link rel="stylesheet" href="{{asset('assets/dashboard-themes/dashboard.css')}}" />
  @else
  <link rel="stylesheet" href="{{asset('assets/css/customizer.min.css')}}" />
  @endif --}}

  <!-- RTL Css -->
  {{--
  <link rel="stylesheet" href="{{asset('assets/css/rtl.min.css')}}" /> --}}

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('assets/linkstack/css/hover-min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/linkstack/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/external-dependencies/bootstrap-icons.css') }}">
  <script defer src="https://unpkg.com/alpinejs@3.13.5/dist/cdn.min.js"></script>

</head>

<body x-data="{sidebar: false}" :data-sidebar="sidebar">
  <nav class="app-nav">
    <div class="nav-logo">
      <div class="logo">
        <img class="logo-image" src="{{ asset('assets/img/logo-p79.png') }}" alt="Logo">
      </div>
      <button @click="sidebar = !sidebar" class="sidebar-button">
        <i class="bi bi-list"></i>
      </button>
    </div>
    <div class="nav-action">
      <div class="nav-profile-dropdown" x-data="{ open: false }" @click.away="open = false">

        <button @click="open = !open" class="nav-profile">
          <img class="nav-profile-avatar"
            src="@if(file_exists(base_path(findAvatar(Auth::user()->id)))){{ url(findAvatar(Auth::user()->id)) }}@elseif(file_exists(base_path('assets/linkstack/images/').findFile('avatar'))){{ url('assets/linkstack/images/').'/'.findFile('avatar') }}@else{{ asset('assets/linkstack/images/logo.svg') }}@endif"
            alt="avatar">
          <div class="nav-profile-info">
            <p class="nav-profile-name">{{Auth::user()->name}}</p>
            <p class="nav-profile-status">
              Online
              {{-- @if(Auth::user()->role == "admin")
              {{__('messages.Administrator')}}
              @elseif(Auth::user()->role == "vip")
              {{__('messages.Verified user')}}
              @else
              {{__('messages.User')}}
              @endif --}}
            </p>
          </div>
          <i class="bi bi-chevron-down" :data-open="open"></i>
        </button>

        <ul class="nav-profile-dropdown-list" x-show="open" x-cloak x-transition>
          <li>
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo">
        <img class="logo-image" src="{{ asset('assets/img/logo-p79.png') }}" alt="Logo">
        <p class="logo-text">LinkStack</p>
      </div>
      <button @click="sidebar = !sidebar" class="sidebar-button">
        <i class="bi bi-list"></i>
      </button>
    </div>

    <div class="sidebar-section">
      <button class="sidebar-head">
        <i class="bi bi-house-door-fill"></i>
        <span>Home</span>
        <i class="bi bi-chevron-down"></i></button>
      <ul class="sidebar-list">
        <li class="sidebar-link" data-active="{{ Request::segment(1) == 'dashboard' ? 'true' : 'false' }}">
          <a href="{{ url('/dashboard') }}">Dashboard</a>
        </li>
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'add-link' ? 'true' : 'false' }}">
          <a href="{{ url('/studio/add-link') }}">Add Link</a>
        </li>
      </ul>
    </div>

    @if(auth()->user()->role == 'admin')
    <div class="sidebar-section">
      <button class="sidebar-head">
        <i class="bi bi-gear-fill"></i>
        <span>Administration</span>
        <i class="bi bi-chevron-down"></i></button>
      <ul class="sidebar-list">
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'config' ? 'true' : 'false'}}">
          <a href="{{ url('admin/config') }}">Config</a>
        </li>
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'users' ? 'true' : 'false'}}">
          <a href="{{ url('admin/users/all')}}"">Manage Users</a>
        </li>
        <li class=" sidebar-link" data-active="{{ Request::segment(2) == 'pages' ? 'true' : 'false'}}">
            <a href="{{ url('admin/pages') }}">Footer Pages</a>
        </li>
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'site' ? 'true' : 'false'}}">
          <a href="{{ url('admin/site') }}">Site Customization</a>
        </li>
      </ul>
    </div>
    @endif

    <div class="sidebar-section">
      <button class="sidebar-head">
        <i class="bi bi-person-fill"></i>
        <span>Personalization</span>
        <i class="bi bi-chevron-down"></i>
      </button>
      <ul class="sidebar-list">
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'links' ? 'true' : 'false' }}">
          <a href="{{ url('/studio/links') }}">Links</a>
        </li>
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'page' ? 'true' : 'false' }}">
          <a href="{{ url('/studio/page') }}">Appearance</a>
        </li>
        <li class="sidebar-link" data-active="{{ Request::segment(2) == 'theme' ? 'true' : 'false' }}">
          <a href="{{ url('/studio/theme') }}">Themes</a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="app-main">
    @yield('content')
  </main>
  <footer class="app-footer">
    <div class="footer-copyright">
      <div class="logo logo-sm">
        <img class="logo-image" src="{{ asset('assets/img/logo-p79.png') }}" alt="Logo">
        <p class="logo-text">LinkStack</p>
      </div>
      &#169;2026 All rights reserved.
    </div>

    <div class="footer-cto">
      <a href="">How it works</a>
      <a href="">Help Center</a>
      <a href="">Contact Us</a>
    </div>
  </footer>
  {{--
  <script>
    document.addEventListener("DOMContentLoaded", function() {
            var downloadButton = document.getElementById("downloadButton");
            var generatedImage = document.getElementById("generatedImage");
        
            downloadButton.addEventListener("click", function() {
                var format = generatedImage.getAttribute("data-format") || "png";
                var downloadLink = document.createElement("a");
                downloadLink.href = generatedImage.src;
                downloadLink.download = "generated_image." + format;
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            });
        });
  </script> --}}

  <!-- Library Bundle Script -->
  <script src="{{asset('assets/js/core/libs.min.js')}}"></script>

  <!-- External Library Bundle Script -->
  <script src="{{asset('assets/js/core/external.min.js')}}"></script>

  <!-- Widgetchart Script -->
  <script src="{{asset('assets/js/charts/widgetcharts.js')}}"></script>

  <!-- mapchart Script -->
  <script src="{{asset('assets/js/charts/vectore-chart.js')}}"></script>
  <script src="{{asset('assets/js/charts/dashboard.js')}}"></script>

  <!-- fslightbox Script -->
  <script src="{{asset('assets/js/plugins/fslightbox.js')}}"></script>

  <!-- Settings Script -->
  <script src="{{asset('assets/js/plugins/setting.js')}}"></script>

  <!-- Slider-tab Script -->
  <script src="{{asset('assets/js/plugins/slider-tabs.js')}}"></script>

  <!-- Form Wizard Script -->
  <script src="{{asset('assets/js/plugins/form-wizard.js')}}"></script>

  <!-- AOS Animation Plugin-->
  <script src="{{asset('assets/vendor/aos/dist/aos.js')}}"></script>

  <!-- App Script -->
  {{-- <script src="{{asset('assets/js/hope-ui.js')}}" defer></script> --}}

  <!-- Flatpickr Script -->
  <script src="{{asset('assets/vendor/flatpickr/dist/flatpickr.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/flatpickr.js')}}" defer></script>

  <script src="{{asset('assets/js/plugins/prism.mini.js')}}"></script>
  {{--
  <!-- Share Button -->
  <script>
    // Get a reference to all buttons with the class "share-button"
      const shareButtons = document.querySelectorAll('.share-button');
      
      // Add a click event listener to each button
      shareButtons.forEach(button => {
        button.addEventListener('click', () => {
          // Get the value to share/copy from the "data-share" attribute
          const valueToShare = button.dataset.share;
      
          // Check if the Web Share API is supported
          if (navigator.share) {
            // Call the Web Share API to open the native share dialog
            navigator.share({
              title: '{{__("messages.Share your profile")}}',
              text: valueToShare,
              url: valueToShare,
            })
            .catch(err => console.error('{{__("messages.Error sharing:")}}', err));
          } else {
            // If the Web Share API is not supported, copy the value to the clipboard
            navigator.clipboard.writeText(valueToShare)
            .then(() => {
              // If copying was successful, alert the user
              alert('{{__("messages.Text copied to clipboard!")}}');
            })
            .catch(err => {
              // If copying failed, alert the user
              alert('{{__("messages.Error copying text:")}}', err);
            });
          }
        });
      });
  </script> --}}

  <script src="{{ asset('assets/js/popper.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/Sortable.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-block-ui.js') }}"></script>
  <script src="{{ asset('assets/js/main-dashboard.js') }}"></script>

  @stack('sidebar-scripts')

</body>

</html>