
<div class="type-variations-col">
    <label for="{{$final_attr['slug']}}">{{$final_attr['name']}}</label>

    <select name="{{$final_attr['slug']}}" id="{{$final_attr['slug']}}" class="form-control">
        @foreach($final_attr['attri_'.$final_attr['slug']] as $key=>$attr)
            <?php
                if($type == 1){
                    if($attr == ' 9ct White Gold '){
                        $attriSelected = 'selected';
                    }else{
                        $attriSelected = '';
                    }
                }if($type == 0){
                    if($key==0){
                        $attriSelected = $key;
                    }
                }
            ?>
            <option value="{{$attr}}" {{$attriSelected}}>{{$attr}}</option>
        @endforeach

    </select>
</div>
