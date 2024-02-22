<div>
    @livewire('application.finance.billing.form.create-detail-outpatient-bill')
    @livewire('application.finance.billing.form.create-other-detail-outpatient-bill')
    <div class="card">
        <div class="card-body bg-indigo">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="">
                        <span class="text-bold">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        {{ $outpatientBill->client_name }}
                    </h5>
                    <h5><i class="fas fa-funnel-dollar"></i>
                        <span>
                            {{ $outpatientBill->currency == null ? 'USD & CDF' : $outpatientBill->currency->name }}</span>
                        @if ($outpatientBill->currency == null)
                            <x-form.icon-button :icon="'fa fa-pen'" class="btn-info" wire:click="openAddDetailFormModal" />
                        @endif
                    </h5>
                    <p class="">
                        <span class="text-bold"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        {{ $outpatientBill->created_at }}
                    </p>
                </div>
                <div>
                    <h4>N° Fact: <span>{{ $outpatientBill->bill_number }}</span></h4>
                    <span class="text-bold">
                        <i class="fa fa-user-check" aria-hidden="true"></i>
                        User: </span>
                    {{ Auth::user()?->name }}
                </div>
            </div>
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
                     <button class="btn btn-secondary" wire:click='OpenOtherDetailOutpatientBill' type="button">Autres détails</button>
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

             //Open outpatient bill other details
            window.addEventListener('open-form-new-other-detail-outpatient-bill', e => {
                $('#form-new-other-detail-outpatient-bill').modal('show')
            });
        </script>
    @endpush
</div>
