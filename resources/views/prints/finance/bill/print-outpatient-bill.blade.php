<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> {{ config('app.name') }} </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
        }

        body h1 {
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            padding: 0px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        @if ($outpatientBill)
            <table>
                <tr class="top">
                    <td colspan="3">
                        <table>
                            <tr>
                                <td class="">
                                    <b>POLYCLINIQUE SHUKRANI (SARL)<br /></b>
                                    N° 12,Av. CHRISTIAN KUNDA<br />
                                    Q. GOLF TSHAMALALE/LUBUMBASHI<br />
                                    RCCM:CD/LUBUMBASHI/RCCM/19-B-00658 <br>
                                    N° IMPOT A2029032E
                                </td>
                                <td></td>
                                <td>
                                    <b>Invoice</b> #: {{ $outpatientBill->bill_number }}<br />
                                    <b>Client</b>: {{ $outpatientBill->client_name }} <br>
                                    <b>Cash-ID</b>:{{ Auth::user()->name }} <br>
                                    <b>At:</b> {{ $outpatientBill->created_at->format('d-m-Y H:i:s') }}<br />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered table-sm">
                @if ($outpatientBill->consultation->price_private > 0)
                    <tr>
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
                        <tr class="">
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
                    <td colspan="3">
                        <table>
                            <tr>
                                <td class="text-bold text-left">
                                    Client
                                </td>
                                <td></td>
                                <td class="text-right ">
                                    CashId
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        @endif
    </div>

</body>

</html>
