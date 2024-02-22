<div class="container pt-4">
    <div class="d-flex justify-content-center">
        <div wire:loading wire:target='makeLoadingState' class="spinner-border text-white" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div>
        <img class="" src="{{ asset('log-white.png') }}" alt="Logo">
    </div>
    <div class="row mt-0">
        @if (Auth::user()->mainMenus->isEmpty())
            @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                <a wire:click='makeLoadingState' href="{{ route('users') }}" wire:navigate>
                    <div class="info-box zoom">
                        <span class="info-box-icon bg-dark  elevation-1">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-number">
                                Administration
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>Auth::user()->roles->pluck('name')->contains('Caisse')
            @endif
        @else
            @foreach (Auth::user()->mainMenus()->orderBy('name')->get() as $mainMenu)
                <div class="col-12 col-sm-6 col-md-3 ">
                    <a wire:click='makeLoadingState' href="{{ route($mainMenu->link) }}" wire:navigate>
                        <div class="info-box zoom">
                            <span class="info-box-icon {{ $mainMenu->bg }} elevation-1">
                                <i class="fas {{ $mainMenu->icon }}"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-number">
                                    {{ $mainMenu->name }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
            @endforeach
        @endif


    </div>
</div>
