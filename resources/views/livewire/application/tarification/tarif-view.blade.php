<div>
    @livewire('application.tarification.categoty-tarif-view')
    <div>
        <x-navigation.bread-crumb icon='fa fa-folder' label='TARIFICATION'>
            <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
            <x-navigation.bread-crumb-item label='Tarification' />
        </x-navigation.bread-crumb>
        <x-content.main-content-page>
            <div class="card-header p-2" >
                <ul class="nav nav-pills">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a wire:click='changeIndex({{ $category }})'
                               class="nav-link {{ $selectedIndex == $category->id ? 'active' : '' }} "
                               href="#inscription" data-toggle="tab">
                                &#x1F4C2; {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                        <x-form.button class="btn-dark ml-2" wire:click="showCategoryTarifPage"><x-icons.icon-plus-circle/> Nouvelle categorie</x-form.button>
                </ul>
            </div>
            <div CLASS="row">
                <div class="col-md-8">
                    @livewire('application.tarification.list.list-tarif',['selectedIndex'=>$selectedIndex])
                </div>
                <div class="col-md-4">
                    @livewire('application.tarification.form.tarif-form-view',
                    ['selectedIndex'=>$selectedIndex])
                </div>
            </div>
        </x-content.main-content-page>
    </div>
    @push('js')
        <script type="module">
            //Open create category tarif page
            window.addEventListener('open-category-tarif-page',e=>{
                $('#category-tarif-page').modal('show')
            });
        </script>
    @endpush
</div>
