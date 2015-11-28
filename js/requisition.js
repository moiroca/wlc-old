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
		 * Approve Requisition
		 */
		approve: function(requistion_id, type, callback) {
			$.ajax({
				method: 'POST',
				url : $('#approval_item_requisition_link').val(),
				data: {
					requistion_id : requistion_id,
					type : type
				},
				datatype: 'application/json',
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		}
	};
}(jQuery);
