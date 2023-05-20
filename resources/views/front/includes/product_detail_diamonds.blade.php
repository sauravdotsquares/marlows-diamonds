<tr>
            <td>{{isset($apiRecords['Shape'])?$apiRecords['Shape']:''}}</td>
            <td>{{isset($apiRecords['Carat'])?number_format($apiRecords['Carat'],2):''}}</td>
            <td>{{isset($apiRecords['Color'])?$apiRecords['Color']:''}}</td>
            <td>{{isset($apiRecords['Clarity'])?$apiRecords['Clarity']:''}}</td>
            @if(isset($apiRecords['Shape']) && strtolower($apiRecords['Shape']) == "round")
                @if(isset($apiRecords['Cut']) && $apiRecords['Cut'] == "EX")
                    <td>Excellent</td>
                @else
                    <td>{{isset($apiRecords['Cut'])?$apiRecords['Cut']:''}}</td>
                @endif
            @endif
            <td>{{isset($apiRecords['Lab'])?$apiRecords['Lab']:''}}</td>
            <td>{{isset($apiRecords['Amount'])?number_format(($apiRecords['Amount']),2):''}}</td>
            <td><a href="{{isset($apiRecords['CertificateLink'])?$apiRecords['CertificateLink']:''}}" target="_blank" class="table-btn certificate-link">View</a></td>
            <td>
                @if(isset($apiRecords['ImageLink']) && !empty($apiRecords['ImageLink']))
                <a href="{{isset($apiRecords['ImageLink'])?$apiRecords['ImageLink']:''}}" target="_blank" class="table-btn image-link">View
                    Diamond</a>
                @endif
            </td>
            <td>
                    <input type="radio" id="selectrefinedata{{$key}}" data-jsonvalue="{{json_encode($apiRecords)}}" class="refinedata" data-price="{{isset($apiRecords['Amount'])?number_format(($apiRecords['Amount']),2):''}}" data-certurl="{{isset($apiRecords['CertificateLink'])?$apiRecords['CertificateLink']:''}}" data-certno="{{isset($apiRecords['Stock_NO'])?$apiRecords['Stock_NO']:''}}" data-shape="{{isset($apiRecords['Shape'])?$apiRecords['Shape']:''}}" name="selectrefinedata" @if($key==0) checked @endif>
            </td>

</tr>
