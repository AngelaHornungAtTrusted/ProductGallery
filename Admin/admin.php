<?php

?>
<script>
    PG_AJAX_URL = '<?php echo esc_url(admin_url('admin-ajax.php', 'relative')); ?>';
</script>
<h2>Admin Page</h2>
<div class="row">
    <div class="col-md-3">
        <button id="imageUpload">Upload Images</button>
    </div>
    <div class="col-md-9">
        <p>Upload images you want in your portfoio.</p>
    </div>
</div>
<div class="row">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Image Title</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="imageTable">

        </tbody>
    </table>
</div>
