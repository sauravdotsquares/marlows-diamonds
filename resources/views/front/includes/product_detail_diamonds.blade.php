<tr>
            <td>{{isset($apiRecords['Shape'])?$apiRecords['Shape']:''}}</td>
            <td>{{isset($apiRecords['Carat'])?$apiRecords['Carat']:''}}</td>
            <td>{{isset($apiRecords['Color'])?$apiRecords['Color']:''}}</td>
            <td>{{isset($apiRecords['Clarity'])?$apiRecords['Clarity']:''}}</td>
            <td>{{isset($apiRecords['Cut'])?$apiRecords['Cut']:''}}</td>
            <td>{{isset($apiRecords['Lab'])?$apiRecords['Lab']:''}}</td>
            <td>{{isset($apiRecords['Amount'])?number_format($apiRecords['Amount']*$VAT,2):''}}</td>
            <td><a href="{{isset($apiRecords['CertificateLink'])?$apiRecords['CertificateLink']:''}}" target="_blank" class="table-btn certificate-link">View</a></td>
            <td>
                <a href="{{isset($apiRecords['ImageLink'])?$apiRecords['ImageLink']:''}}" target="_blank" class="table-btn image-link">View
                    Diamond</a>
            </td>
            <td>
               
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{isset($apiRecords['Amount'])?number_format($apiRecords['Amount']*$VAT,2):''}}" data-certurl="{{isset($apiRecords['CertificateLink'])?$apiRecords['CertificateLink']:''}}" data-certno="{{isset($apiRecords['Stock_NO'])?$apiRecords['Stock_NO']:''}}" data-shape="{{isset($apiRecords['Shape'])?$apiRecords['Shape']:''}}" name="selectrefinedata" @if($key==0) checked @endif>
              
            </td>

</tr>