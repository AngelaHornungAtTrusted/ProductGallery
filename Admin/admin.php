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
        <h6>Basics</h6>
        <ul style="list-style-type: disc;">
            <li>Upload images you want in your portfolio.</li>
            <li>Images checked as featured will only appear in your featured gallery.</li>
            <li>Images with the same order number (unless one is featured and the other isn't) will organize themselves by ID.</li>
            <li>Descriptions are the text users will see when hovering over your images.</li>
        </ul>
        <a class="btn btn-secondary" href="mailto:helpdesk@trustedtechsupport.com?subject=Product Gallery Support"><i class="fa fa-envelope"></i> Email Support</a>
    </div>
</div>
<div class="row">
    <table class="table table-striped" style="padding-right: 15px;">
        <thead id="imageTableHead">

        </thead>
        <tbody id="imageTable">

        </tbody>
    </table>
</div>
