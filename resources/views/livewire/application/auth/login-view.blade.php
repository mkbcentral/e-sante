<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img class="" src="{{ asset('logo-afia.png') }}" alt="Logo" width="300px">
        </div>
        <div class="card-body">
            <h4 class="text-olive text-uppercase text-center text-bold align-items-center">
                <i class="fas fa-user"></i> se connecter
            </h4>
            <form wire:submit='loginUser'>
                <div>
                    <x-form.label value="{{ __('Adresse email') }}" />
                    <x-form.input type='text' wire:model='email' :error="'email'" style="height: 45px" />
                    <x-errors.validation-error value='email' />
                </div>
                <div class="mt-2">
                    <x-form.label value="{{ __('Mot de passe') }}" />
                    <x-form.input type='password' wire:model='password' :error="'password'" style="height: 45px"/>
                    <x-errors.validation-error value='password' />
                </div>
                <div class="mt-4">
                    <x-form.button class="btn-success w-100" type='submit'>
                         <x-widget.loading-circular-md wire:loading wire:target='loginUser'/> <span wire:loading.class='d-none'>Se connecter</span>
                    </x-form.button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
