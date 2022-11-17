
<?php if(count($images)){ foreach ($images as $key => $value) { ?>
    <?php if($value['extension'] == 'mp4'){ ?>
        <video style="height: 100px; width:100px;" autoplay muted>
            <source src="{{ asset( 'uploads/'.  $value['image']) }}">
        </video>
    <?php }else{ ?>
        <img height="100" width="100" src="{{ asset( 'uploads/'.  $value['image']) }}">  
    <?php } ?>
<?php } } ?>