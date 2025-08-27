(function($) {
    let $uploadButton, $imageTableHead, $imageTable;
    let width, options = [], mobile;

    const pageInit = function() {
        $uploadButton = $('#imageUpload');
        $imageTableHead = $('#imageTableHead');
        $imageTable = $('#imageTable');

        getImages();
        $uploadButton.on('click', openMediaUuploader);
    }

    const getImages = function() {
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
        mobile = window.mobileCheck();

        if (mobile !== true) {
            $imageTableHead.append('<tr>' +
                '<th>Thumbnail</th>' +
                '<th>Details</th>' +
                '<th>Actions</th>' +
                '</tr>');

            $.each(data, function(key, image){
                $imageTable.append('<tr>' +
                    '<td><image src="' + image.path + '" style="max-height: ' + ((width < 500) ? 100 : 200) + 'px;"></image></td>' +
                    '<td><input class="imageDescription" style="' + ((width < 500) ? 'max-width: 150px;' : 'min-width: 100%;') + '" type="text" id="description-' + image.id + '" value="' + image.description + '"></td>' +
                    '<td><a class="btn btn-secondary" href="' + image.path + '" download style="margin-right: 5px;"><i class="fa fa-download"></i></a>' +
                    '<a class="btn btn-danger" id="delete-' + image.id + '" style="margin-right: 5px;"><i class="fa fa-trash"></i></a>' +
                    '<select id="imageOrder-' + image.id + '" class="imageOrder" style="margin-right: 5px;"></select>' +
                    '<input class="imageFeatured" type="checkbox" id="featured-' + image.id + '" style="margin-right: 5px;" ' + ((image.featured === '1') ? 'checked' : '') + '><label for="featured-' + image.id + '">Featured</label></td>' +
                    '</tr>');

                options[key + 1] = '<option id="orderOption-' + image.id + '" value="' + (key + 1) + '">' + (key + 1) + '</option>';
            });
        } else {
            $imageTableHead.append('<tr>' +
                '<th>Thumbnail</th>' +
                '<th>Details</th>' +
                '</tr>');

            $.each(data, function(key, image){
                $imageTable.append('<tr>' +
                    '<td><image src="' + image.path + '" style="max-height: ' + ((width < 500) ? 100 : 200) + 'px;"></image></td>' +
                    '<td><input class="imageDescription" type="text" id="description-' + image.id + '" value="' + image.description + '"></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><input class="imageFeatured" type="checkbox" id="featured-' + image.id + '" style="margin-right: 15px;" ' + ((image.featured === '1') ? 'checked' : '') + '><label for="featured-' + image.id + '">Featured</label></td>' +
                    '<td><a class="btn btn-secondary" href="' + image.path + '" download style="margin-right: 15px;"><i class="fa fa-download"></i></a>' +
                    '<a class="btn btn-danger" id="delete-' + image.id + '" style="margin-right: 15px;"><i class="fa fa-trash"></i></a>' +
                    '<select id="imageOrder-' + image.id + '" class="imageOrder" style="margin-right: 15px;"></select></td>' +
                    '</tr>');


                options[key + 1] = '<option id="orderOption-' + image.id + '" value="' + (key + 1) + '">' + (key + 1) + '</option>';
            });
        }

        $('.imageOrder').append(options);

        $.each(data, function(key, image){
           $('#imageOrder-' + image.id).val(image.orderNumber);
        });

        setActions();
    }

    const setActions = function () {
        $('.imageOrder').on('change', function(e){
            $.post(PG_AJAX_URL, {
                action: 'pg_image',
                data: {
                    postId: e.currentTarget.id.split('-')[1],
                    orderNumber: e.currentTarget.value
                }
            }, function(response){
                if (response.status === 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            })
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
        });

        $('.imageFeatured').on('click', function(e) {
            console.log(((e.currentTarget.checked === true) ? 1 : 0));
            $.post(PG_AJAX_URL, {
                action: 'pg_image',
                data: {
                    'postId': e.currentTarget.id.split('-')[1],
                    'featured': ((e.currentTarget.checked === true) ? 1 : 0),
                }
            }, function(response){
                if (response.status === 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            })
        });
    }

    const openMediaUuploader = function () {
        'use strict';
        console.log(options.length);

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
                        orderNumber: options.length,
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

    window.mobileCheck = function() {
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    $(document).ready( function() {
        pageInit();
    });
})(jQuery);