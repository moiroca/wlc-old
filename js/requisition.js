/* Requisitions JS */
var Requisition = function($){

	return {

		$attachedItemGroup: $('#attached_item_group'),

		$itemRequisitionType : $('#itemRequisitionType'),

		$jobRequisition : $('#jobRequisition'),

		$itemRequisition : $('#itemRequisition'),

		$newItemRequisitionForm: $('#newItemRequisitionForm'),
		
		$requisitionStaus: { },

		init: function() {
			console.log('Requisition Instance');
		},

		/**
		 * Search Item Control Number
		 */
		search: function(data, callback) {
			$.ajax({
				method: 'GET',
				url: $('#searchRequisitionLink').val(),
				datatype: 'application/json',
				data: {
					itemIds : data.itemIds,
					itemControlNumber : data.itemControlNumber,
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
		approve: function(data, callback) {
			$.ajax({
				method: 'POST',
				url : $('#approval_item_requisition_link').val(),
				data: {
					requisition_id : data.requisition_id,
					type : data.type
				},
				datatype: 'application/json',
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		},

		/**
		 * Receive Item Requisition
		 */
		receive: function(data, callback) {
			$.ajax({
				method: 'POST',
				url : $('#approval_item_requisition_link').val(),
				data: {
					requisition_id : data.requisition_id,
					itemIds : data.itemIds
				},
				datatype: 'application/json',
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		},

		/**
		 * Attach Item To Requisition
		 */
		attach: function(data, callback) {
			$.ajax({
				method : 'POST',
				url : $('#attach_item_to_requisition_url').val(),
				data: {
					requisition_id : data.requisition_id,
					area_id : data.area_id,
					name : data.name,
					quantity : data.quantity,
					status: data.status,
					type: data.type
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		},

		approveRequisition: function(requisitionId, requesterId, callback) {  
			$.ajax({
				url: $('#approve_item_requisition_url').val(),
				method: 'POST',
				data: {
					type: $('#requisition_type').val(),
					requisitionId: requisitionId,
					requesterId: requesterId
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		},

		declineRequisition: function(requisitionId, callback) {
			$.ajax({
				url: $('#declined_item_requisition_url').val(),
				method: 'POST',
				data: {
					requisitionId: requisitionId
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		},

		approveItemInRequisition: function(data, callback) {
			$.ajax({
				method: 'POST',
				url: $('#approve_item_in_requisition').val(),
				data: {
					items : data.items,
					requisitionId : data.requisitionId	
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(response) {
					callback.success(response);
				}
			});
		},

		saveRequisitionComment: function(data, callback) {
			$.ajax({
				method: 'POST',
				url: $('#add_requisition_comment').val(),
				data: {
					requisition_id : data.requisition_id,
					comment : data.comment	
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(response) {
					callback.success(response);
				}
			});
		}
	};
}(jQuery);
