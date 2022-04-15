@foreach($getActualData as $key => $refineData)
    @if($key < 5)
        <tr>
            <td>{{isset($refineData->ShapeTitle)?$refineData->ShapeTitle:''}}</td>
            <td>{{isset($refineData->Weight)?$refineData->Weight:''}}</td>
            <td>{{isset($refineData->ColorTitle)?$refineData->ColorTitle:''}}</td>
            <td>{{isset($refineData->ClarityTitle)?$refineData->ClarityTitle:''}}</td>
            <td>{{isset($refineData->PolishTitle)?$refineData->PolishTitle:''}}</td>
            <td>
                <a href="#" target="_blank" class="certificate-link">{{isset($refineData->LabTitle)?$refineData->LabTitle:''}}</a>
            </td>
            <td>{{isset($refineData->CurrencySymbol)?$refineData->CurrencySymbol:''}}<span class="custom_pricediamond">{{isset($refineData->FinalPrice)?number_format($refineData->FinalPrice,2):''}}<span></td>
            <td>
                <a href="#" target="_blank" class="table-btn certificate-link">View</a>
            </td>
            <td>
                <a href="#" target="_blank" class="table-btn image-link">View
                    Diamond</a>
            </td>
            <td>
                @if($key == 0)
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{number_format($refineData->FinalPrice,2)}}" name="selectrefinedata" checked>
                @else
                    <input type="radio" id="selectrefinedata{{$key}}" class="refinedata" data-price="{{number_format($refineData->FinalPrice,2)}}" name="selectrefinedata">
                @endif
            </td>
        </tr>
    @endif
@endforeach