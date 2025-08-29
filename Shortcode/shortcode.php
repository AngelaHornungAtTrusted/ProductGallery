<?php

?>
<script>
    PG_AJAX_URL = '<?php echo esc_url(admin_url('admin-ajax.php', 'relative')); ?>';
    FEATURED = '<?php echo $featured; ?>';
</script>
<style>
    .image {
        opacity: 1;
        display: block;
        width: 200px;   !important;
        height: 200px;  !important;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        transform: translate(0%, -50%);
        -ms-transform: translate(-50%, -50%);
        align-self: center;
        text-align: center;
    }

    .imageContainer:hover .image {
        opacity: 0.3;
    }

    .imageContainer:hover .middle {
        opacity: 1;
    }

    .text {
        background-color: #1E1F22;
        color: white;
        font-size: 12px;
        padding: 16px 32px;
        border-radius: 5px;
    }
</style>
<div class="row" id="featuredImageTable" style="align-content: center;">

</div>
<div class="row" id="imageTable" style="align-content: center;">

</div>
