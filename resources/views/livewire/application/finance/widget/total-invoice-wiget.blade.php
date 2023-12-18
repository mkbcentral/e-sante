<span>
    {{$consultationRequest
    !=null?app_format_number($currencyName=='USD'?$consultationRequest->getTotalInvoiceUSD():
    $consultationRequest->getTotalInvoiceCDF(),1):0}}
    {{ $currencyName }}
</span>