<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img class="" src="{{ asset('logo.png') }}" alt="Logo" width="80px">
        </div>
        <div class="card-body">
            <form wire:submit='loginUser'>
                <div>
                    <x-form.label value="{{ __('Adresse email') }}" />
                    <x-form.input type='text' wire:model.blur='email' :error="'email'" />
                    <x-errors.validation-error value='email' />
                </div>
                <div>
                    <x-form.label value="{{ __('Mot de passe') }}" />
                    <x-form.input type='text' wire:model.blur='password' :error="'password'" />
                    <x-errors.validation-error value='password' />
                </div>

                <div class="mt-4">
                    <x-form.button class="btn-primary w-100" type='submit'> Se
                        connecter</x-form.button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
