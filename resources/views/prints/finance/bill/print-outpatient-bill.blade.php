<x-print-layout>
    <div class="invoice-box">
        @if ($outpatientBill)
            <table>
                <tr>
                    <td class="">
                        <b>POLYCLINIQUE SHUKRANI (SARL)<br /></b>
                        N° 12,Av. CHRISTIAN KUNDA<br />
                        Q. GOLF TSHAMALALE/LUBUMBASHI<br />
                        RCCM:CD/LUBUMBASHI/RCCM/19-B-00658 <br>
                        N° IMPOT A2029032E
                    </td>
                    <td>
                        <b>Invoice</b> #: {{ $outpatientBill->bill_number }}<br />
                        <b>Client</b>: {{ $outpatientBill->client_name }} <br>
                        <b>Cash-ID</b>:{{ Auth::user()->name }} <br>
                        <b>At:</b> {{ $outpatientBill->created_at->format('d-m-Y H:i:s') }}<br />
                    </td>
                </tr>
            </table>
            <table>
                <tr style="border: d-none ">
                    <td class="text-center h4" style="border-top: d-none;border-bottom: none ">Details invoice</td>
                </tr>
            </table>
            <table class="">
                @if ($outpatientBill->consultation->price_private > 0)
                    <tr class="">
                        <td colspan="3"><b>{{ $outpatientBill->consultation->name }}</b></td>
                        <td class="text-right">
                            {{ $currency == 'CDF'
                                ? app_format_number($outpatientBill->getConsultationPriceCDF(), 1)
                                : $outpatientBill->getConsultationPriceUSD() }}
                            {{ $currency }}</td>
                    </tr>
                @endif
                @foreach ($categories as $category)
                    @if (!$category->getOutpatientBillTarifItems($outpatientBill, $category)->isEmpty())
                        <tr class="bg-secondary text-white">
                            <td colspan=""><b>{{ $category->name }}</b></td>
                            <th class="text-right" scope="col">Qt</th>
                            <th class="text-right" scope="col">P.U</th>
                            <th class="text-right" scope="col">P.T</th>
                        </tr>
                        <tbody>
                            @foreach ($category->getOutpatientBillTarifItems($outpatientBill, $category) as $item)
                                <tr>
                                    <td class="">
                                        {{ $item->abbreviation == null ? $item->name : $item->abbreviation }}
                                    </td>
                                    <td class="text-right">{{ $item->qty }}</td>
                                    <td class="text-right">
                                        {{ $currency == 'CDF'
                                            ? app_format_number($item->price_private * $outpatientBill->rate->rate, 1)
                                            : app_format_number($item->price_private, 0) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $currency == 'CDF'
                                            ? app_format_number($item->price_private * $item->qty * $outpatientBill->rate->rate, 1)
                                            : app_format_number($item->price_private * $item->qty, 0) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="total">
                                <td colspan="4" class="text-right">
                                    <b>{{ $category->getAmountOutpatientBillByCategory($outpatientBill->id, $category->id) }}
                                        {{ $currency }}</b>
                                </td>
                            </tr>

                        </tbody>
                    @endif
                @endforeach
                <tr class="bg-secondary">
                    <td colspan="4" class="text-right text-white">Payment infos</td>
                </tr>
                <tr class="total " class="w-25">
                    <td colspan="4" class="text-right">
                        Payment infos <br>
                        <b>Total:
                            {{ $currency == 'CDF'
                                ? app_format_number($outpatientBill->getTotalOutpatientBillCDF(), 1) . ' Fc'
                                : app_format_number($outpatientBill->getTotalOutpatientBillUSD(), 0) . ' $' }}</b>
                        <br>

                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td colspan="3" style="border: none">
                        <table style="border: none">
                            <tr style="border: none">
                                <td style="border: none" class="text-bold text-left">
                                    Client
                                </td>

                                <td style="border: none" class="text-right ">
                                    CashId
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        @endif
    </div>
</x-print-layout>