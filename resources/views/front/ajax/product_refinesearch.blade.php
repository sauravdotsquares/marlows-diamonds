
@foreach($getActualData as $key => $refineData)
    @if($key < 3)
        <tr>
            <td>{{isset($refineData['Shape'])?$refineData['Shape']:''}}</td>
            <td>{{isset($refineData['Carat'])?$refineData['Carat']:''}}</td>
            <td>{{isset($refineData['Color'])?$refineData['Color']:''}}</td>
            <td>{{isset($refineData['Clarity'])?$refineData['Clarity']:''}}</td>
            <td>{{isset($refineData['PolishTitle'])?$refineData['PolishTitle']:''}}</td>
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
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{isset($refineData['Amount'])?number_format($refineData['Amount'],2):''}}" name="selectrefinedata" checked>
                @else
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{isset($refineData['Amount'])?number_format($refineData['Amount'],2):''}}" name="selectrefinedata">
                @endif
            </td>
        </tr>
    @endif
@endforeach