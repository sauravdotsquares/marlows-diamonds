
@php
    $valid_video_extensions = ['mp4'];
@endphp

@if (!empty($image) && $image)

    <?php 
    $style = '';
    $style .= !empty($height) ? 'height:'.$height.';' : '100px';
    $style .= !empty($width) ? 'width:'.$width.';' : '100px';
    ?>
    
    @if (in_array($image['extension'], $valid_video_extensions))
        {{-- If file is video --}}
        <video style="<?php echo $style ?>" autoplay muted>
            <source src="{{ asset( 'uploads/'.  $image['image']) }}">
        </video>
    @else
        {{-- If file is image --}}
        <img alt="{{$image['image']}}" style="<?php echo $style ?>" src="{{ asset( 'uploads/'.  $image['image']) }}"> 
    @endif

@endif