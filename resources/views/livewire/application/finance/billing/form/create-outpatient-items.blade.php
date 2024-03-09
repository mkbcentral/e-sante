<div>
    @livewire('application.finance.billing.form.create-detail-outpatient-bill')
    @livewire('application.finance.billing.form.create-other-detail-outpatient-bill')
    <div class="card">
        <div class="card-body bg-indigo">
           @include('components.widget.outpatientbill.outpatient-bill-info',['outpatientBill',$outpatientBill])
        </div>
    </div>
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                @foreach ($categories as $category)
                    <li class="nav-item">
                        <a wire:click='changeIndex({{ $category }})'
                            class="nav-link {{ $selectedIndex == $category->id ? 'active' : '' }} " href="#inscription"
                            data-toggle="tab">
                            &#x1F4C2; {{ $category->name }}
                        </a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a wire:click='OpenOtherDetailOutpatientBill'
                        data-toggle="modal"
                        data-target="#form-new-other-detail-outpatient-bill"
                        class="nav-link {{ $isOtherDetail==true?'active':'' }} text-uppercase" href="#inscription"
                        data-toggle="tab">
                        &#x1F4C2 No tarifié
                    </a>
                </li>
            </ul>

        </div>
        <div class="card-body card-pink">
            @livewire('application.finance.billing.form.widget.tarif-items-with-outpatient-bill', [
                'outpatientBill' => $outpatientBill,
                'selectedIndex' => $selectedIndex,
            ])
        </div>
    </div>
    @push('js')
        <script type="module">
            //Open open outpatient bill details
            window.addEventListener('close-form-detail-outpatient-bill', e => {
                $('#form-detail-outpatient-bill').modal('hide')
            });
        </script>
    @endpush
</div>
