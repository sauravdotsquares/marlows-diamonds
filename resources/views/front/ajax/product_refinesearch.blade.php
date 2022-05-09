
@foreach($getActualData as $key => $refineData)
    @if($key < 3)
        <tr>
            <td>{{isset($refineData['Shape'])?$refineData['Shape']:''}}</td>
            <td>{{isset($refineData['Carat'])?$refineData['Carat']:''}}</td>
            <td>{{isset($refineData['Color'])?$refineData['Color']:''}}</td>
            <td>{{isset($refineData['Clarity'])?$refineData['Clarity']:''}}</td>
            @if(isset($refineData['Shape']) && $refineData['Shape'] == "ROUND")
                <td>{{isset($refineData['PolishTitle'])?$refineData['PolishTitle']:''}}</td>
            @endif
            <td>
                <a href="#" target="_blank" class="certificate-link">{{isset($refineData['Lab'])?$refineData['Lab']:''}}</a>
            </td>
            <td>{{MY_CURRENCY_SYMBOL}}<span class="custom_pricediamond">{{isset($refineData['Amount'])?number_format($refineData['Amount'],2):''}}<span></td>
            <td>
                <a href="{{isset($refineData['CertificateLink'])?$refineData['CertificateLink']:''}}" target="_blank" class="table-btn certificate-link">View</a>
            </td>
            <td>
                <a href="{{isset($refineData['CertificateLink'])?$refineData['CertificateLink']:''}}" target="_blank" class="table-btn image-link">View
                    Diamond</a>
            </td>
            <td>
                @if($key == 0)
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{isset($refineData['Amount'])?number_format($refineData['Amount'],2):''}}" data-certurl="{{isset($refineData['CertificateLink'])?$refineData['CertificateLink']:''}}" data-certno="{{isset($refineData['CERT_NO'])?$refineData['CERT_NO']:''}}" data-shape="{{isset($refineData['Shape'])?$refineData['Shape']:''}}" name="selectrefinedata" checked>
                @else
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{isset($refineData['Amount'])?number_format($refineData['Amount'],2):''}}" data-certurl="{{isset($refineData['CertificateLink'])?$refineData['CertificateLink']:''}}" data-certno="{{isset($refineData['CERT_NO'])?$refineData['CERT_NO']:''}}" data-shape="{{isset($refineData['Shape'])?$refineData['Shape']:''}}" name="selectrefinedata">
                @endif
            </td>
        </tr>
    @endif
@endforeach
