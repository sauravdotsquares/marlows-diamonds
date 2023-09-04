
<div class="type-variations-col">
    <label for="{{$final_attr['slug']}}">{{$final_attr['name']}}  
        @if($final_attr['slug'] == 'finger-size')
        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#myModal">Guide
            </a>
        @endif
    </label>

    <select name="{{$final_attr['slug']}}" id="{{$final_attr['slug']}}" class="form-control">
        @foreach($final_attr['attri_'.$final_attr['slug']] as $key=>$attr)
            <?php
                $attriSelected = '';
                if(isset($selected) && $selected == trim($attr)){
                    $attriSelected = 'selected';
                }

                if(!isset($selected) && empty($selected)){
                    if( $attriSelected == '' && $attr == ' 9ct White Gold '){
                        $attriSelected = 'selected';
                    }
                }
            ?>
            <option value="{{$attr}}" {{$attriSelected}}>{{$attr}}</option>
        @endforeach

    </select>
</div>
