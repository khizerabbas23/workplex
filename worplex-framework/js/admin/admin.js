jQuery(document).on("click", ".worplex-upload-media", function () {
    var id = jQuery(this).attr("data-id");
    var custom_uploader = wp.media({
        title: 'Select Image',
        button: {
            text: 'Add Image'
        },
        library: {
            type: [ 'image' ]
        },
        multiple: false
    })
        .on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('#' + id).val(attachment.url);
            jQuery('#' + id + '-img').attr('src', attachment.url);
            jQuery('#' + id + '-box').show();
        }).open();
});
jQuery(document).on("click", ".worplex-rem-media-b", function () {
    var id = jQuery(this).data('id');
    jQuery('#' + id).val('');
    jQuery('#' + id + '-img').attr('src', '');
    jQuery('#' + id + '-box').hide();
});