@include('User.app.head')

  <body>
    @include('User.app.nav')

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    @yield('content')
   {{-- @include('User.app.body') --}}

@include('User.app.footer')