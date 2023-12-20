<div>
    <x-modal.build-modal-fixed idModal='list-outpatient-bill-by-date-modal' size='md' headerLabel="CREATION NOUVELLE FACTURE"
        headerLabelIcon='fa fa-file'>
      
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-list-outpatient-bill-by-date-modal', e => {
                $('#list-outpatient-bill-by-date-modal').modal('hide')
            });
            
        </script>
    @endpush
</div>
