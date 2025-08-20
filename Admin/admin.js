(function($) {
    let $uploadButton, $imageTable;
    let width;

    const pageInit = function() {
        $uploadButton = $('#imageUpload');
        $imageTable = $('#imageTable');

        getImages();
        $uploadButton.on('click', openMediaUuploader);
    }

    const getImages = function() {
        console.log('getImages');
        $.get(PG_AJAX_URL, {
            action: 'pg_image',
        }, function(response){
            if (response.status === 'success') {
                width = Math.max(document.documentElement.clientWidth, window.innerWidth);
                imageTableInit(response.data);
            } else {
                toastr.error(response.message);
            }
        })
    }

    const imageTableInit = function(data){
        //determine screen configuration

        $.each(data, function(key, image){
            $imageTable.append('<tr>' +
                '<td><image src="' + image.path + '" style="max-height: ' + ((width < 500) ? 100 : 200) + 'px;"></image></td>' +
                '<td><input class="imageDescription" style="' + ((width < 500) ? 'max-width: 150px;' : 'min-width: 100%;') + '" type="text" id="description-' + image.id + '" value="' + image.description + '"></td>' +
                '<td><a class="btn btn-secondary" href="' + image.path + '" download><i class="fa fa-download"></i></a>' +
                '<a class="btn btn-danger" id="delete-' + image.id + '"><i class="fa fa-trash"></i></a></td>' +
                '</tr>');
        });

        $('.btn-danger').on('click', function(e) {
            $.post(PG_AJAX_URL, {
                action: 'pg_image',
                data: {
                    'postId': e.currentTarget.id.split('-')[1]
                }
            }, function(response){
                if (response.status === 'success') {
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            })
        });

        $('.imageDescription').on('change', function(e) {
            $.post(PG_AJAX_URL, {
                action: 'pg_image',
                data: {
                    'postId': e.currentTarget.id.split('-')[1],
                    'description': e.target.value
                }
            }, function(response){
                if (response.status === 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            })
        })
    }

    const openMediaUuploader = function () {
        'use strict';

        var uploader = wp.media.frames.file_frame = wp.media({
            frame: 'post',
            state: 'insert',
            multiple: true,
        });

        uploader.on('insert', function(){
            var selections = uploader.state().get('selection').toJSON();

            $.each(selections, function(key, selection){
                console.log(selection.description);
                $.post(PG_AJAX_URL, {
                    action: 'pg_image',
                    data: {
                        title: selection.title,
                        alt: selection.alt,
                        path: selection.url,
                        description: selection.description,
                    }
                }, function(response){
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                })
            })
        });

        uploader.on('error', function(){
            toastr.error("Unexpected Error Occurred");
        })

        uploader.open();
    }

    $(document).ready( function() {
        pageInit();
    });
})(jQuery);