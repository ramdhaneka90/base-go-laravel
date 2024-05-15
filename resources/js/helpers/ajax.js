(function ($) {
	$.fn.myAjax = function (ajax_options) {
		var object = $(this);

		var defaults = {
			waitMe: 'body',
			type: typeof object.attr('method') !== 'undefined' ? object.attr('method') : 'POST',
			url: typeof object.attr('action') !== 'undefined' ? object.attr('action') : null,
			data: {
				_token: $('meta[name="csrf-token"]').attr('content')
			},
			before: function (event) {},
			success: function (event, data) {},
			error: function (event, data) {},
			xhrFieldsProgress: function (event, data) {},
		};

		var default_messages = {
			confirm: {
				title: __('helpers.ajax.confirm.title'),
				text: __('helpers.ajax.confirm.text'),
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: __('Ya'),
				cancelButtonText:__('Tidak')
			},
			validation: {
				title: true,
				titlePosition: 'after',
				listPosition: 'inline'
			},
			success: {
				title: __('helpers.ajax.success.title'),
				text: __('helpers.ajax.success.text'),
				icon: 'success',
			},
            prevent_close: 'Are you sure? Your process will be canceled.'
		};

		var default_options = $.extend(true, defaults, ajax_options);

		var errorMessage = function (data, messages) {
			var errors = data.responseJSON;

			if (data.status == '404') {
				command: toastr["error"](__('errors.404'));
				return false;
			}

			if (data.status == '422') {
				Swal.fire(
					'Isian Belum Lengkap',
					'Silahkan lengkapi isian terlebih dahulu.',
					'warning',
				);
			}

			command: toastr["error"](errors.message);

			// cleansing errors message
			$('.form-group.has-error', object).removeClass('has-error');
			$('.help-block.error', object).remove();

			if (typeof errors.data !== 'undefined') {

				$.each(errors.data, function (key, value) {
					field = $('[name = "' + key + '"]', object);
					_div = $('.error_' + key, object);
					_group = field.closest('.form-group').find('div.input-group');
					_selectize = field.closest('.form-group').find('div.selectize-control');
					_select2 = field.closest('.form-group').find('.select2-container');

					field.closest('.form-group').addClass('has-error');

					if (messages.validation.title) {
						var manual_target = $('#error_' + key, object);

						if (manual_target.length) {
							manual_target.find('span.help-block.error').remove();
							manual_target.html('<span class="help-block error text-danger"> ' + value + ' </span>');
							manual_target.closest('.form-group').addClass('has-error');
						} else {

							field.closest('.form-group').addClass('has-error').find('span.help-block.error').remove();

							if (messages.validation.titlePosition == 'top' || messages.validation.titlePosition == 'before') {
								if (_group.length) {
									_group.before('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else if (_selectize.length) {
									_selectize.before('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else if (_select2.length) {
									_select2.before('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else if (_div.length) {
									_div.before('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else {
									field.before('<span class="help-block error text-danger"> ' + value + ' </span>');
								}
							} else {
								if (_group.length) {
									_group.after('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else if (_selectize.length) {
									_selectize.after('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else if (_select2.length) {
									_select2.after('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else if (_div.length) {
									_div.after('<span class="help-block error text-danger"> ' + value + ' </span>');
								} else {
									field.after('<span class="help-block error text-danger"> ' + value + ' </span>');
								}
							}
						}
					}
				});
			}
		};

        var prevent_close = function(msg){
            window.onbeforeunload = function (e) {
                e = e || window.event;

                // For IE and Firefox prior to version 4
                if (e) {
                  e.returnValue = msg;
                }

                // For Safari
                return msg;
            };
        };

        var disable_prevent_close = function (){
            window.onbeforeunload = function (e) {
            }
        }

		var ajaxSubmit = function (options, messages) {
			object.ajaxSubmit({
				type: options.type,
				url: options.url,
				data: options.data,
				beforeSubmit: function (arr, form, settings) {
                    prevent_close(messages.prevent_close);
					$(options.waitMe).waitMe();
					options.before.call(this);
				},
				success: function (data) {
                    disable_prevent_close();
					$(options.waitMe).waitMe("hide");
					Swal.fire(
						messages.success.title,
						messages.success.text,
						messages.success.icon
					).then((result) => {
						if (result.value) {
							options.success.call(this, data);
						}
					});
				},
				error: function (data) {
                    disable_prevent_close();
					$(options.waitMe).waitMe("hide");
					errorMessage(data, messages);
					options.error.call(this, data);
				},
                xhrFields: {
                    // Getting on progress streaming response
                    onprogress: function(e)
                    {
                		options.xhrFieldsProgress.call(this, e);
                    }
                }
			});
		};

		return {
			submit: function (messages) {
				var messages = $.extend(true, default_messages, messages);
				Swal.fire(messages.confirm).then((result) => {
					if (result.value) {
						ajaxSubmit(default_options, messages);
					}
				});
			},
			reset: function () {
				object.clearForm();
			},
			delete: function (messages) {
				// refactor option
				var default_data = default_options.data;
				default_options.method = 'POST';
				default_options.url = object.attr('href');

                default_options.data = $.extend(true, default_data, {
                    _method: 'DELETE'
                });

				// refactor messages
				default_messages.confirm.text = __('helpers.ajax.delete.text');
				default_messages.success.title = __('helpers.ajax.delete.success.title');
				default_messages.success.text = __('helpers.ajax.delete.success.text');

				var messages = $.extend(true, default_messages, messages);

				Swal.fire(messages.confirm).then((result) => {
					if (result.value) {
						ajaxSubmit(default_options, messages);
					}
				});
			},
			load: function(messages){
				var messages = $.extend(true, default_messages, messages);
				ajaxSubmit(default_options, messages);
			}
		};
	};
}(jQuery));
