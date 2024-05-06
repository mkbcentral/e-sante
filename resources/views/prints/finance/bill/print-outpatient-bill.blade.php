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
                        <b>Invoice</b> #: {{ $outpatientBill->bill_number }}-PROFORMAT<br />
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
                           </td>
                    </tr>
                @endif
                @foreach ($categories as $category)
                    @if (!$category->getOutpatientBillTarifItems($outpatientBill, $category)->isEmpty())
                        <tr class="bg-secondary text-white">
                            <th colspan=""><b>{{ $category->name }}</b></th>
                            <th class="text-center" scope="col">QTE</th>
                            <th class="text-right" scope="col">P.U CDF</th>
                            <th class="text-right" scope="col">P.T CDF</th>
                        </tr>
                        <tbody>
                            @foreach ($category->getOutpatientBillTarifItems($outpatientBill, $category) as $item)
                                <tr>
                                    <td class="">
                                        {{ $item->abbreviation == null ? $item->name : $item->abbreviation }}
                                    </td>
                                    <td class="text-center ">{{ $item->qty }}</td>
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


                        </tbody>
                    @endif
                @endforeach
                @if ($outpatientBill->otherOutpatientBill != null)
                    <tr class="bg-secondary text-white">
                        <th colspan="">Autres</b></th>
                        <th class="text-center " scope="col">QTE</th>
                        <th class="text-right" scope="col">P.U CDF</th>
                        <th class="text-right" scope="col">P.T CDF</th>
                    </tr>
                    <tr class="">
                        <td><b>{{ $outpatientBill->otherOutpatientBill->name }}</b></td>
                        <td class="text-center"><b>1</b></td>
                        <td class="text-right">
                            {{ $currency == 'CDF'
                                ? app_format_number($outpatientBill->getOtherOutpatientBillPriceCDF(), 1)
                                : $outpatientBill->getOtherOutpatientBillPriceUSD() }}
                            </td>
                        <td class="text-right">
                            {{ $currency == 'CDF'
                                ? app_format_number($outpatientBill->getOtherOutpatientBillPriceCDF(), 1)
                                : $outpatientBill->getOtherOutpatientBillPriceUSD() }}
                            </td>
                    </tr>
                @endif
                <tr class="bg-secondary">
                    <td colspan="4" class="text-right text-white">Payment infos</td>
                </tr>
                <tr class="total " class="w-25">
                    <td colspan="4" class="text-right">
                        <b>Total:
                            {{ app_format_number($outpatientBill->getTotalOutpatientBillCDF(), 1) . ' Fc' }}</b>
                        <br>
                        {{ app_format_number($outpatientBill->getTotalOutpatientBillUSD(), 0) . ' $' }}
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
                                    Cash-Id
                                </td>
                            </tr>
                             <tr style="border: none">
                                <td style="border: none" class="text-bold text-left">
                                    {{ $outpatientBill->client_name }}
                                </td>

                                <td style="border: none" class="text-right ">
                                    {{ Auth::user()->name }}
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        @endif
    </div>
</x-print-layout>
