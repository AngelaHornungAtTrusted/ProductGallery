(function($) {
    let $imageTable;
    const pageInit = function() {
        console.log('pageInit');

        $imageTable = $('#imageTable');

        grabImages();
    }

    const grabImages = function() {
        $.get(PG_AJAX_URL, {
            action: 'nopriv_pg_shortcode_image'
        }, function(response) {
            if (response.status === 'success') {
                buildTable(response.data);
            } else {
                toastr.error(response.message)
            }
        });
    }

    const buildTable = function(data) {
        $.each(data, function(key, image) {
            $imageTable.append('<div class="col-md-3" style="border-right: 1px; border-color: black; border-style: solid;">' +
                '<a class="image-download" id="image-download-' + image.id + '" href="' + image.path + '" download>' +
                '<img class="center" src="' + image.path + '" style="min-width: 100%; max-height: 200px">' +
                '</a></br>' +
                '<div class="container" style="max-width: 100%; text-align: center;">' +
                '<a class="h6 image-download" id="title-download-' + image.id + '" href="' + image.path + '" download>' + image.title + '</a>' +
                '</div>' +
                '</div>')
        });
    }

    $(document).ready(function() {
        pageInit();
    });
})(jQuery);