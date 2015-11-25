/* Requisitions JS */
var Requisition = function($){

	return {

		$attachedItemGroup: $('#attached_item_group'),

		init: function() {
			console.log('Requisition Instance');
		},

		/**
		 * Search Item Control Number
		 */
		search: function(itemControlNumber, callback) {
			$.ajax({
				method: 'GET',
				url: $('#searchRequisitionLink').val(),
				datatype: 'application/json',
				data: {
					itemControlNumber : itemControlNumber,
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		},

		/**
		 * Save Requisition
		 */
		save: function() {

		},
	};
}(jQuery);
