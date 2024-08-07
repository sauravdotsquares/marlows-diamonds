
<div class="type-variations-col">
    <label for="{{$final_attr['slug']}}">{{$final_attr['name']}}</label>
    <select name="{{$final_attr['slug']}}" id="{{$final_attr['slug']}}" class="form-control">
        @foreach($final_attr['attri_'.$final_attr['slug']] as $key=>$attr)
            <?php
                $attriSelected = '';
                $attriConditionContent = '';
                if(isset($selected) && $selected == trim($attr)){
                    $attriSelected = 'selected';
                }

                if($attr == ' 9ct White Gold ' || $attr == ' 9ct Yellow Gold ' || $attr == ' 9ct Rose Gold '){
                    $attriConditionContent = '- Online-Only';
                }else if(trim($attr) == 'Silver'){
                    $attriConditionContent = '(925)- Online-Only';
                }

                if(!isset($selected) && empty($selected)){
                    if( $attriSelected == '' && $attr == ' 9ct White Gold '){
                        $attriSelected = 'selected';
                    }
                }
            ?>
            @if(trim($attr) == 'Silver' && $diamondType == 'mined_diamond')
                <!-- <option value="{{$attr}}" {{$attriSelected}}>{{$attr.$attriConditionContent}}</option> -->
            @else
                <option value="{{$attr}}" {{$attriSelected}}>{{$attr.$attriConditionContent}}</option>
            @endif
        @endforeach

    </select>
</div>
