<x-print-layout>

    <div class="invoice-box">
        @foreach ($consultationRequests as $consultationRequest)
            @if ($consultationRequest)
                <table>
                    <tr>
                        <td class="">
                            <b>POLYCLINIQUE SHUKRANI (SARL)<br /></b>
                            N° 12,Av. CHRISTIAN KUNDA<br />
                            Q. GOLF TSHAMALALE/LUBUMBASHI<br />
                            RCCM:CD/LUBUMBASHI/RCCM/19-B-00658 <br>
                            N° IMPOT A2029032E <br>
                            Contact: (+243 971330007)
                        </td>
                        @if ($consultationRequest->consultationSheet->subscription->is_subscriber)
                            <td class="text-left">
                                <span style="font-size: 22px"><b>Invoice</b> #:
                                    {{ $consultationRequest->getRequestNumberFormatted() }}</span><br />
                                <b>Nom</b>: {{ $consultationRequest->consultationSheet->name }} <br>
                                <b>At:</b> {{ $consultationRequest->created_at->format('d-m-Y H:i:s') }}<br />
                                <b>Source:</b> {{ $consultationRequest->consultationSheet->source->name }}<br />

                            </td>
                        @else
                            <td class="text-left">
                                <span style="font-size: 22px"><b>Invoice</b> #:
                                    {{ $consultationRequest->getRequestNumberFormatted() }}</span><br />
                                <b>Nom</b>: {{ $consultationRequest->consultationSheet->name }} <br>
                                <b>Cash-ID</b>:{{ Auth::user()->name }} <br>
                                <b>At:</b> {{ $consultationRequest->created_at->format('d-m-Y H:i:s') }}<br />
                                <b>Source:</b> {{ $consultationRequest->consultationSheet->source->name }}<br />
                            </td>
                        @endif

                    </tr>
                </table>
                <table>
                    <tr style="border: d-none ">
                        <td class="text-center h4" style="border-top: d-none;border-bottom: none ">Details invoice</td>
                    </tr>
                </table>
                <table class=" ">
                    <tr>
                        <td colspan="3"><b>{{ $consultationRequest->consultation->name }}</b></td>
                        <td class="text-right">
                            {{ app_format_number($consultationRequest->getConsultationPriceUSD(), 1) }}
                        </td>
                    </tr>
                    @foreach ($categories as $category)
                        @if (!$category->getConsultationTarifItems($consultationRequest, $category)->isEmpty())
                            <tr class="bg-secondary text-white">
                                <td colspan=""><b>{{ $category->name }}</b></td>
                                <th class="text-center" scope="col">NBRE</th>
                                <th class="text-right" scope="col">P.U {{ $currency }}</th>
                                <th class="text-right" scope="col">P.T {{ $currency }}</th>
                            </tr>
                            <tbody>
                                @foreach ($category->getConsultationTarifItems($consultationRequest, $category) as $item)
                                    as $item)
                                    <tr>
                                        <td class="">
                                            {{ $item->abbreviation == null ? $item->name : $item->abbreviation }}
                                        </td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-right">
                                            {{ $currency == 'CDF'
                                                ? app_format_number($item->price_private * $consultationRequest->rate->rate, 1)
                                                : app_format_number($item->price_private, 0) }}
                                        </td>
                                        <td class="text-right">
                                            {{ $currency == 'CDF'
                                                ? app_format_number($item->price_private * $item->qty * $consultationRequest->rate->rate, 1)
                                                : app_format_number($item->price_private * $item->qty, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="total">
                                    <td colspan="4" class="text-right">
                                        <b> Total:
                                            {{ app_format_number(
                                                $currency == 'USD'
                                                    ? $category->getTotalTarifInvoiceByCategoryUSD($consultationRequest, $category)
                                                    : $category->getTotalTarifInvoiceByCategoryCDF($consultationRequest, $category),
                                                1,
                                            ) }}
                                        </b>
                                    </td>
                                </tr>

                            </tbody>
                        @endif
                    @endforeach
                    @if (!$consultationRequest->products->isEmpty())
                        <tr class="bg-secondary text-white">
                            <th>MEDICATION</th>
                            <th class="text-center">NBRE</th>
                            <th class="text-right">PU {{ $currency }}</th>
                            <th class="text-right">PT {{ $currency }}</th>
                        </tr>
                        @foreach ($consultationRequest->products as $index => $product)
                            <tr>
                                <td class="text-uppercase">- {{ $product->name }}</td>
                                <td class="text-center">
                                    {{ $product->pivot->qty }}
                                </td>
                                <td class="text-right">
                                    {{ app_format_number($product->price, 1) }}
                                </td>
                                <td class="text-right">
                                    {{ app_format_number($product->price * $product->pivot->qty, 1) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total">
                            <td colspan="4" class="text-right">
                                <b>Total:
                                    {{ app_format_number(
                                        $currency == 'USD' ? $consultationRequest->getTotalProductUSD() : $consultationRequest->getTotalProductCDF(),
                                        1,
                                    ) }}
                                </b>
                            </td>
                        </tr>
                    @endif
                    @if (!$consultationRequest->consultationRequestNursings->isEmpty())
                        <tr class="bg-secondary text-white">
                            <th>NURSING & AUTRES</th>
                            <th class="text-center">NBRE</th>
                            <th class="text-right">PU {{ $currency }}</th>
                            <th class="text-right">PT {{ $currency }}</th>
                        </tr>
                        @foreach ($consultationRequest->consultationRequestNursings as $consultationRequestNursing)
                            <tr>
                                <td>{{ $consultationRequestNursing->name }}</td>
                                <td class="text-center">{{ $consultationRequestNursing->number }}</td>
                                <td class="text-right">
                                    {{ app_format_number(
                                        $currency == 'USD' ? $consultationRequestNursing->getAmountUSD() : $consultationRequestNursing->getAmountCDF(),
                                        1,
                                    ) }}
                                </td>
                                <td class="text-right">
                                    {{ app_format_number(
                                        $currency == 'USD'
                                            ? $consultationRequestNursing->getAmountUSD() * $consultationRequestNursing->number
                                            : $consultationRequestNursing->getAmountCDF() * $consultationRequestNursing->number,
                                        1,
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total">
                            <td colspan="4" class="text-right">
                                <b>Total:
                                    {{ app_format_number(
                                        $currency == 'USD' ? $consultationRequest->getNursingAmountUSD() : $consultationRequest->getNursingAmountCDF(),
                                        1,
                                    ) }}
                                </b>
                            </td>
                        </tr>
                    @endif

                    @if (!$consultationRequest->consultationRequestHospitalizations->isEmpty())
                        <tr class="bg-secondary text-white">
                            <th>SEJOUR</th>
                            <th class="text dt-center">NBRE</th>
                            <th>PU {{ $currency }}</th>
                            <th>PT {{ $currency }}</th>

                        </tr>
                        @foreach ($consultationRequest->consultationRequestHospitalizations as $consultationRequestHospitalization)
                            <tr>
                                <td class="text-uppercase">-
                                    {{ $consultationRequestHospitalization->hospitalizationRoom->hospitalization->name }}
                                </td>
                                <td class="text-center">{{ $consultationRequestHospitalization->number_of_day }}</td>
                                <td class="text-right">
                                    {{ app_format_number(
                                        $currency == 'USD'
                                            ? $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateUSD()
                                            : $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateCDF(),
                                        1,
                                    ) }}
                                </td>
                                <td class="text-right">
                                    {{ app_format_number(
                                        $currency == 'USD'
                                            ? $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateUSD() *
                                                $consultationRequestHospitalization->number_of_day
                                            : $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateCDF() *
                                                $consultationRequestHospitalization->number_of_day,
                                        1,
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total">
                            <td colspan="4" class="text-right">
                                <b>Total:
                                    {{ app_format_number(
                                        $currency == 'USD'
                                            ? $consultationRequest->getHospitalizationAmountUSD()
                                            : $consultationRequest->getHospitalizationAmountCDF(),
                                        1,
                                    ) }}
                                </b>
                            </td>
                        </tr>
                    @endif

                    <tr class="bg-secondary">
                        <td colspan="4" class="text-right text-white">Payment infos</td>
                    </tr>
                    <tr class="total " class="w-25">
                        <td colspan="4" class="text-right">
                            <table>
                                <tr>
                                    <td colspan="4"colspan="4" class="text-right">
                                        {{ app_format_number($consultationRequest->getTotalInvoiceCDF(), 1) . ' Fc' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-right">
                                        {{ app_format_number($consultationRequest->getTotalInvoiceUSD(), 0) . ' $' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="page-break">

                    @if ($consultationRequest->consultationSheet->subscription->is_private)
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
                    @endif

                </table>
            @endif
        @endforeach
    </div>

</x-print-layout>
