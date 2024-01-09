<div>
    <x-modal.build-modal-fixed idModal='form--user-role' bg='bg-indigo' size='md' headerLabel="ROLES"
        headerLabelIcon='fas fa-fingerprint'>
        @if ($user == null)
            <div class="d-flex justify-content-center ">
                <x-widget.loading-default />
            </div>
        @else
            <div class="d-flex justify-content-center ">
                <x-widget.loading-default wire:loading wire:target='assignRoles' />
            </div>
            <div class="row mt-1">
                @if ($roles->isEmpty())
                    <div class="text-center">
                        <x-errors.data-empty />
                    </div>
                @else
                    @foreach ($roles as $role)
                        <div class="col-sm-6">
                            <!-- checkbox -->
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="{{ str_replace(' ', '', $role->name) }}"
                                        wire:model="rolesItems" value="{{ $role->id }}"
                                        {{$user->roles()->pluck('role_id')->contains($role->id)?'checked':''}}>
                                    <label for="{{ str_replace(' ', '', $role->name) }}" class="">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="d-flex justify-content-end mt-2">
                <x-form.button type="button" class="btn-primary w-100" wire:click='assignRoles'>
                   <i class="fa fa-check-circle" aria-hidden="true"></i> Assigner
                </x-form.button>
            </div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form--user-role', e => {
                $('#form--user-role').modal('hide')
            });
        </script>
    @endpush
</div>
