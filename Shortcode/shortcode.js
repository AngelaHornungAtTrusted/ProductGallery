(function($) {
    let $imageTable;
    const pageInit = function() {
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
            console.log(image);
            $imageTable.append('<div class="imageContainer col-md-2">' +
                '<img src="' + image.path + '" class="image" alt="' + image.alt + '">' +
                '<div class="middle">' +
                '<div class="text">' + image.description + '</div> ' +
                '</div> ' +
                '</div>');
        });
    }

    $(document).ready(function() {
        pageInit();
    });
})(jQuery);