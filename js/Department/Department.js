/**
 * Department JS
 */
var Department = (function($) {
	
	return {

		/**
		 * Get Department Head
		 */
		getDepartmentHead : function(params) {
			$.ajax({
				url: $('#getDepartmentHeadLink').val(),
				method: 'GET',
				data: params.data,
				beforeSend: function() {
					params.beforeSend();
				},
				success: function(res) {
					params.success(res);
				}
			});
		}
	};

})(jQuery);