<div>
    <x-modal.build-modal-fixed idModal='user-link-modal' bg='bg-indigo' size='xl' headerLabel="PRISE SIGNES VITAUX ET AUTRES"
        headerLabelIcon='fas fa-link'>
        @if ($user != null)

        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open close user link modal
            window.addEventListener('close-user-link-modal', e => {
                $('#user-link-modal').modal('hide')
            });

        </script>
    @endpush
</div>
