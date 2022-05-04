
<div class="type-variations-col">
    <label for="{{$final_attr['slug']}}">{{$final_attr['name']}}</label>

    <select name="{{$final_attr['slug']}}" id="{{$final_attr['slug']}}" class="form-control">
        @foreach($final_attr['attri_'.$final_attr['slug']] as $key=>$attr)
            <option value="{{$attr}}" @if($key==0) selected @endif>{{$attr}}</option>
        @endforeach

    </select>
</div>
