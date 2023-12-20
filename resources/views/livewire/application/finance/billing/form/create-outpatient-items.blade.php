<div>
    <div class="card">
        <div class="card-body bg-dark">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class=""><span class="text-bold">Client name: </span> {{$outpatientBill->client_name}}</h4>
                    <p class=""><span class="text-bold">Date: </span> {{$outpatientBill->created_at}}</p>
                </div>
                <div>
                   
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
            </ul>
        </div>
        <div class="card-body card-pink">
            @livewire('application.finance.billing.form.widget.tarif-items-with-outpatient-bill', [
                'outpatientBill' => $outpatientBill,
                'selectedIndex' => $selectedIndex,
            ])
        </div>
    </div>

</div>
