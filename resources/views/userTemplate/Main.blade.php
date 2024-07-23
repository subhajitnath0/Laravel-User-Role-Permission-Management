@include('userTemplate.Header') <!-- Include header -->

@include('userTemplate.Headerbar') <!-- Include headerbar -->

@include('userTemplate.Sidebar') <!-- Include sidebar -->


<main id="main" class="main">
    <div class="container">
        @if (session('status') && session('message'))
            <!-- Display session status message -->
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @yield('content') <!-- Yield main content -->

    </div>
</main>

@include('userTemplate.Footer') <!-- Include footer -->
