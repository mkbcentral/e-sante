<div>
    <address>
        <div class="h6">
            @foreach($consultationSheet->getFreshConsultation()->diagnostics as $diagnostic)
                <span class="">{{$diagnostic->name}}  <i class="fas fa-times text-danger "
                                                        wire:click="showDeleteDialog({{$diagnostic->pivot->id}})"
                                                        style="cursor: pointer"></i></span>
            @endforeach
        </div>
    </address>
    @push('js')
        <script type="module">
            //Confirmation dialog for delete role
            window.addEventListener('delete-diagnostic-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "retirer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteIDiagnosticListener');
                    }
                })
            });
            window.addEventListener('diagnostic-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
