<nav class="main-header navbar navbar-expand {{theme_setting('is_dark_mode')?'navbar-dark':'navbar-white'}} navbar-light">
    @auth
    <ul class="navbar-nav">
        @livewire('application.setting.change-collapse-state')
    </ul>
    @endauth

    <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-4">
           <h3 class="text-bold text-indigo">Taux 1$=  @livewire('application.finance.widget.rate-info-widget')</h3>
        </li>
        <li class="nav-item mr-4">
            <div class="form-group d-flex align-items-center">
                <label class="mr-2">Devise</label>
                @livewire('application.finance.widget.currency-widget')''
            </div>
        </li>
        @auth
        <li class="nav-item mr-4">
            @livewire('application.setting.switch-theme-widget')
         </li>
        @endauth
        <li class="nav-item dropdown user-menu text-white">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('defautl-user.jpg') }}"
                class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline ">User name</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                <img src="{{ asset('defautl-user.jpg') }}"
                class="img-circle elevation-2" alt="User Image">
                <p>
                  <small>mkcentral@gmail.com</small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        this.closest('form').submit();" class="btn btn-default btn-flat float-right">Déconnexion</a>
                </form>

              </li>
            </ul>
          </li>
    </ul>
</nav>
