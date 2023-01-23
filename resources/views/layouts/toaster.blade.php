<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css')}}">
<script src="{{ asset('admin/plugins/toastr/toastr.min.js')}}"></script>
<script>

    function showToaster(status='error', message='') {
        if(status=='success'){
            toastr.success(message);
        }else{
            toastr.error(message);
        }
    }

    <?php if(session()->get("success")){ ?>
        showToaster('success', '<?php echo session()->get("success") ?>');
        // toastr.success('<?php echo session()->get("success") ?>')
    <?php }else if(session()->get("error")){ ?>
        showToaster('error', '<?php echo session()->get("error") ?>');
        // toastr.error('<?php echo session()->get("error") ?>')
    <?php } ?>
</script>