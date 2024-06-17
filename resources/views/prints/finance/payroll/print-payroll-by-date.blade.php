<x-print-layout>
    @php
        $total = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>

    <h2 class="text-center text-b   old mt-2">RAPPORT DEPENSES JOURNALIERES</h2>
    <div class="text-left mt-1">
        <div><b><span>Date:</span></b> <span
                class="text-bold">{{ $date }}</span>
        </div>
        <div><b><span>Devise:</span></b> <span
                class="text-bold">{{ $currencyData == null ? 'USD&CDF' : $currencyData->name }}</span>
        </div>
        @if ($categoryData != null)
            <div><b><span>Categorie:</span></b> <span class=""> {{ $categoryData->name }}</span></div>
        @endif
        @if ($sourceData != null)
        <div><b><span>Source(Compte):</span></b><span class="text-bold"> {{ $sourceData->name }}</span></div>
        @endif
    </div>
    <table class="table table-striped  table-sm mt-2">
        <thead class="table-dark">
            <tr class="">
                <th class="text-center">N°</th>
                <th>DATE</th>
                <th>NUMERO PC</th>
                <th>DESCRIPTION</th>
                <th class="text-right">M.T USD</th>
                <th class="text-right">M.T CDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payrolls as $index => $payroll)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $payroll->created_at->format('d/m/Y') }}</td>
                    <td>{{ $payroll->number }}</td>
                    <td>{{ $payroll->description }}</td>
                   <td class="text-right">
                        @if ($payroll->currency->name == 'USD')
                            {{ app_format_number($payroll->getPayrollTotalAmount(), 1) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($payroll->currency->name == 'CDF')
                            {{ app_format_number($payroll->getPayrollTotalAmount(), 1) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
           <tr>
                <td colspan="4" class="text-right bg-dark text-white text-bold">TOTAL</td>
                <td class="text-right text-bold h5">{{ app_format_number($total_usd, 1) }} $</td>
                <td class="text-right text-bold h5">{{ app_format_number($total_cdf, 1) }} Fc</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-box mt-2">
        <table>
            <tr>
                <td colspan="3" style="border: none">
                    <table style="border: none">
                        <tr style="border: none">
                            <td style="border: none" class="text-bold text-left">
                                <b> COMPTABLE</b>
                            </td>
                            <td style="border: none" class="text-right text-bold">
                                <b>A.G</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none">
                    <table style="border: none">
                        <tr style="border: none">
                            <td style="border: none" class="text-bolds">
                                Patrick MAGHOMA BIN MUYUMBA
                            </td>
                            <td style="border: none; margin-right: ;" class="text-right mr-4">
                                Dady KALMERY
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</x-print-layout>
