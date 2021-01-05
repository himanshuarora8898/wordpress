jQuery(document).ready(function () {
    jQuery('#submit').on('click', function () {
        var selected = []; // initialize array
        jQuery('.post').each(function () {
            if (jQuery(this).is(":checked")) {
                selected.push(jQuery(this).val());
            }
        });
        alert(selected.length);

        jQuery.ajax({
            url: js_custom_object.ajax_url,
            type: 'post',
            data: {
                action: 'custom_action_ajax',
                send_data: selected
            },
            success: function (response) {
                // jQuery('.rml_contents').html(response);
            }
        });

    });
});