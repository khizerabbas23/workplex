jQuery(document).ready(function() {
    if (jQuery('.worplex-datepicker').length > 0) {
        var todayDate = new Date().getDate();
        jQuery('.worplex-datepicker').datetimepicker({
            maxDate: new Date(new Date().setDate(todayDate)),
            timepicker: false,
            format: 'd-m-Y',
            scrollMonth: false,
            scrollInput: false
        });
    }
    if (jQuery('.worplex-datepicker-min').length > 0) {
        jQuery('.worplex-datepicker-min').datetimepicker({
            minDate: new Date(new Date().setDate(todayDate)),
            timepicker: false,
            format: 'd-m-Y',
            scrollMonth: false,
            scrollInput: false
        });
    }
	if (jQuery('.worplex-dashb-multilist').length > 0) {
		jQuery(".worplex-dashb-multilist").sortable({
			items: '.worplex-dashb-multilitm',
			placeholder: "ui-state-highlight",
			handle: ".multili-sorter",
			start : function(e, ui) {
				var this_item = ui.item;
				var items_holder = this_item.parents('.worplex-dashb-multilist');
				items_holder.find('.worplex-dashb-multilitm .inner-fields-formcon').hide();
			},
			update : function(e, ui) {
				//
			}
		}).disableSelection();
	}
});

jQuery('.choos-acctype-maincon .acctype-box-itm').on('click', function() {
    var this_itm = jQuery(this);
    if (this_itm.hasClass('employer-box-item')) {
        var acc_type = 'employer';
    } else {
        var acc_type = 'candidate';
    }
    this_itm.find('i').attr('class', 'worplex-fa worplex-faicon-circle-notch worplex-faicon-spin');
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: worplex_dashb_vars.ajax_url,
        data: {
            acc_type: acc_type,
            action: 'worplex_user_account_type_selection_call'
        },
        success: function(data) {
            window.location.replace(data.url);
        }
    });
});

jQuery('.candidate-addexperience-form').on('click', '.candash-form-chkbutncon input[name="still_working"]', function() {
	var this_chk = jQuery(this);
	var par_con = this_chk.parents('.candash-form-centrow');
	var endate_holdr = par_con.find('input[name="enddate"]').parents('.col-4');
	if (this_chk.is(":checked")) {
		endate_holdr.hide();
	} else {
		endate_holdr.removeAttr('style');
	}
});

jQuery('.worplex-dashb-multilist').on('click', '.multili-act-remove', function() {
	var this_btn = jQuery(this);
	var itm_con = this_btn.parents('.worplex-dashb-multilitm');
	var itm_id = itm_con.attr('data-id');
	var this_par = this_btn.parents('.worplex-dashb-multilist');
	if (this_par.hasClass('worplex-dashbcand-experiencelist')) {
		var action_str = 'worplex_dashcand_experienceitm_remove_call';
	} else {
		var action_str = 'worplex_dashcand_eduitm_remove_call';
	}
	this_par.append('<div class="worplex-loder-con"><div class="worplex-loder-iner"><div class="worplex-loader"></div></div></div>');

	jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: worplex_dashb_vars.ajax_url,
        data: {
            id: itm_id,
            action: action_str
        },
        success: function(data) {
            if (data.error == '0') {
				worplex_submit_msg_alert(data.msg, 'worplex-alert-success');
				itm_con.remove();
			} else {
				worplex_submit_msg_alert(data.msg, 'worplex-alert-danger');
			}
			this_par.find('.worplex-loder-con').remove();
        },
		error: function() {
			this_par.find('.worplex-loder-con').remove();
		}
    });
});

function worplex_dashform_after_succ_call(this_form, data) {
	if (this_form.hasClass('candidate-addedu-form')) {
		var items_holder = jQuery('.worplex-dashbcand-edulist');
		items_holder.append(data.html);
		var last_itm = items_holder.find('.worplex-dashb-multilitm:last-child');
		last_itm.find('.multilitm-hder').css({'background-color': '#fffff0'});
		setTimeout(function() {
			last_itm.find('.multilitm-hder').removeAttr('style');
		}, 4000);
		jQuery('html, body').animate({scrollTop: last_itm.offset().top - 100}, 1000);
		this_form.find('input[type="text"]').val('').attr('value', '');
	}
	if (this_form.hasClass('candidate-addexperience-form')) {
		var items_holder = jQuery('.worplex-dashbcand-experiencelist');
		items_holder.append(data.html);
		var last_itm = items_holder.find('.worplex-dashb-multilitm:last-child');
		last_itm.find('.multilitm-hder').css({'background-color': '#fffff0'});
		setTimeout(function() {
			last_itm.find('.multilitm-hder').removeAttr('style');
		}, 4000);
		jQuery('html, body').animate({scrollTop: last_itm.offset().top - 100}, 1000);
		this_form.find('input[type="text"]').val('').attr('value', '');
	}
}

jQuery(document).on('submit', '.worplex-dashb-form', function (ev) {

	ev.preventDefault();
	
	var this_form = jQuery(this);
	var from_element = this_form[0];
	var form_data = new FormData(from_element);
	
	if (!this_form.hasClass('ajax-processing')) {
		this_form.append('<div class="worplex-loder-con"><div class="worplex-loder-iner"><div class="worplex-loader"></div></div></div>');
		var elem_to_got = this_form.find('.worplex-loder-con .worplex-loader');
		jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);

		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: worplex_cscript_vars.ajax_url,
			processData: false,
			contentType: false,
			data: form_data,
			success: function(data) {
				if (data.error == '0') {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-success');
				} else if (data.error == '2') {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-info');
				} else {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-danger');
				}
				worplex_dashform_after_succ_call(this_form, data);
				if (typeof data.redirect !== undefined && data.redirect != undefined && data.redirect != '') {
					if (data.redirect == 'same') {
						window.location.reload();
					} else {
						window.location.replace(data.redirect);
					}
					return false;
				}
				jQuery('body').find('.worplex-loder-con').remove();
				this_form.removeClass('ajax-processing');
			},
			error: function() {
				jQuery('body').find('.worplex-loder-con').remove();
				this_form.removeClass('ajax-processing');
			}
		});
	}
	
	this_form.addClass('ajax-processing');
});

function worplex_dashb_image_file_change(e) {
    var img_test = '';
    var allow_file_types = ['image/jpg', 'image/jpeg', 'image/png'];
    var allow_file_size = 10400;
    if (e.target.files.length > 0) {
        var dropd_file = e.target.files[0];
        var file_type = dropd_file.type;
        var file_size = dropd_file.size;
        file_size = parseFloat(file_size / 1024).toFixed(2);
        if (!(allow_file_types.indexOf(file_type) >= 0)) {
            worplex_submit_msg_alert('Error: Only image with .png or .jpg extension is allowed to upload.', 'worplex-alert-danger');
            img_test = 'fail';
        }
        if (file_size > allow_file_size && img_test != 'fail') {
            worplex_submit_msg_alert('Error: Image size is too big to upload. Please use optimized image only.', 'worplex-alert-danger');
            img_test = 'fail';
        }
    } else {
        img_test = 'fail';
    }

    if (img_test != 'fail') {
        if (e.target.files.length > 0) {
            
            var logo_img_con = jQuery('#logofile-name-container').find('.logo-img-con');
            //
            var img_reader = new FileReader();
            img_reader.addEventListener("load", function() {
				var img_src = img_reader.result;
				logo_img_con.find('img').attr('src', img_src);
				logo_img_con.find('i').hide();
				logo_img_con.find('img').removeAttr('style');
			}, false);
            img_reader.readAsDataURL(dropd_file);
        }
    }
}

jQuery(document).on('click', '.worplex-mangjob-delbtn', function (ev) {

	ev.preventDefault();
	
	var this_btn = jQuery(this);
    var id = this_btn.attr('data-id');
	var this_par = this_btn.parents('.worplex-mangjobs-con');
	
	if (!this_btn.hasClass('ajax-processing')) {
		this_par.append('<div class="worplex-loder-con"><div class="worplex-loder-iner"><div class="worplex-loader"></div></div></div>');
		var elem_to_got = this_par.find('.worplex-loder-con .worplex-loader');
		jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);

		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: worplex_cscript_vars.ajax_url,
			data: {
                id: id,
                action: 'worplex_dash_empjob_remove_call'
            },
			success: function(data) {
				if (data.error == '0') {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-success');
				} else if (data.error == '2') {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-info');
				} else {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-danger');
				}
				
				this_par.find('.worplex-loder-con').remove();
				this_btn.removeClass('ajax-processing');
			},
			error: function() {
				this_par.find('.worplex-loder-con').remove();
				this_btn.removeClass('ajax-processing');
			}
		});
	}
	
	this_btn.addClass('ajax-processing');
});