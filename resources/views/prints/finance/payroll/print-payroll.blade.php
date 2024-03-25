<x-print-layout>
    @php
        $total = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <div class=" text-right mt-1">
        <span class="" sty>Fait àLubumbashi, Le {{ (new DateTime($payroll->created_at))->format('d/m/Y') }}</span>
    </div>
    <div class=" text-right mt-1">
        <h4>N°P.C: {{ $payroll->number }}/{{ $payroll->currency->name }}</h4>
    </div>
    <h2 class="text-center text-b   old mt-2">ETAT DE PAIE</h2>
    <table class="table table-striped  table-sm">
        <thead class="table-dark">
            <tr class="">
                <th>N°</th>
                <th class="">NOM COMPLET</th>
                <th class="">FONCTION</th>
                <th class="text-right">MONTANT</th>
                <th class="text-center">SIGNATURE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payroll->payRollItems as $index => $payRollItem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payRollItem->name }}</td>
                    <td>{{ $payRollItem->agentService->name }}</td>
                    <td class="text-right">{{ app_format_number($payRollItem->amount, 0) }}
                        {{ $payroll->currency->name }}</td>
                    <td></td>
                </tr>
                @php
                    $total += $payRollItem->amount;
                @endphp
            @endforeach
            <tr>
                <td colspan="3" class="text-right bg-dark text-white text-bold">TOTAL</td>
                <td class="text-right text-bold">{{ app_format_number($total, 0) }} {{ $payroll->currency->name }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="text-left mt-4">
        <span class="text-bold"><b>Nous disons:</b> {{ ucfirst(app_format_number_letter($total)) }}
            {{ $payroll->currency->name == 'USD' ? 'Dollars Américains' : 'Francs congolais' }}</span>
    </div>
    <div class="text-left">
        <span class="text-bold"><b>JUSTIFICATION: </b> {{ $payroll->description }}</span>
    </div>
    <div class="invoice-box mt-2">
        <table>
            <tr>
                <td colspan="3" style="border: none">
                    <table style="border: none">
                        <tr style="border: none">
                            <td style="border: none" class="text-bold text-left">
                                <b> COMPTABLE</b>
                            </td>
                            <td style="border: none" class="text-right ">
                                A.G
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
