<div class="card card-primary">
    <div class="card-header">EXAMENS</div>
    <div class="card-body p-0">
        @if($tarifs->isEmpty())
           <span class=" text-danger">
               <h6 class="text-center"> Aucun examen</h6>
           </span>
        @else
            <ul>
                @foreach($tarifs as $tarif)
                    <li class=" text-uppercase">
                        {{$tarif->abbreviation==null? $tarif->name:$tarif->abbreviation}} <span>({{$tarif->qty}})</span>
                        <i class="fas fa-times text-danger " wire:click="showDeleteDialog({{$tarif->id}})" style="cursor: pointer"></i>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    @push('js')
        <script type="module">
            //Confirmation dialog for delete role
            window.addEventListener('delete-item-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "retirer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText:'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteItemListener');
                    }
                })
            });
            window.addEventListener('item-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
