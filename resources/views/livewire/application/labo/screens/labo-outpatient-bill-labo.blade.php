<div>
    <div class="card card-primary card-outline mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex align-items-center">
                    <div class="mr-2 w-100">
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                    <div class="mr-2">
                        @if ($isByDate == true)
                            <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                        @elseif($isByMonth == true)
                            <x-widget.list-french-month wire:model.live='month_name' :error="'month_name'" />
                        @elseif($isByPeriod == true)
                            <div class="d-flex align-content-center ">
                                <div class="mr-2">
                                    <x-form.input type='date' wire:model.live='start_date' :error="'start_date'" />
                                </div>
                                <div class="mr-2">
                                    <x-form.input type='date' wire:model.live='end_date' :error="'end_date'" />
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            <table class="table table-striped table-sm">
                <thead class="bg-primary">
                    <tr>
                        <th>#</th>
                        <th>DATE</th>
                        <th>NOM PATIENT</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outpatientBills as $index => $outpatientBill)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $outpatientBill->created_at->format('d/m/Y h:i') }}</td>
                            <td>{{ $outpatientBill->client_name }}</td>
                            <td class="text-center">
                                <x-navigation.link-icon href="{{ route('labo.outpatientBill',$outpatientBill) }}"
                                    wire:navigate :icon="'fa fa-microscope'" class="btn btn-sm  btn-primary" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
