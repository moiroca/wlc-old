/* Add Requisition */
Requisition.init();

$(document).ready(function() {
	
	/**
	 * Remove Item From Item List
	 */
	var removeItemFromItemList = function() {
		var item = $(this).closest('tr');
		$(this).closest('tr').remove();
	}

	/**
	 * Add Item To List
	 */
	var appendResultToItemList = function(event) {
		var item = $(this).closest('tr');

		item.removeClass();
		item.find('td:last-child button').removeClass('btn-primary').addClass('btn-warning');
		item.find('td:last-child button').removeClass('add_item').addClass('remove_item');
		item.find('td:last-child button').html('<i class="fa fa-minus"> Remove</i>');

		$('#item_list').prepend(
			$('<tr/>', { 'data-id': item.attr('data-id'), 'data-control_number' : item.attr('data-control_number') })
				.append(item.children())
				.append($('<input />', { 'type' : 'hidden', 'name' : 'items[]'}).val(item.attr('data-id')))
		);
		
		item.attr('data-id', 0);
		item.attr('data-control_number', 0);
		$('.remove_item').bind('click', removeItemFromItemList);
		$(this).unbind('click', appendResultToItemList);
	}

	$('#requisition_type').on('change', function() {
		var requisitionType = $(this);

		if (requisitionType.val() == 'Job') {
			Requisition.$attachedItemGroup.show();
		} else {	
			Requisition.$attachedItemGroup.hide();
		}
	});

	$('#item_control_number').on('keyup', function(e) {

		if (86 == e.keyCode || 13 == e.keyCode) {

		}
	});

	$('#search_control_number').on('click', function() {

		var itemControlNumber = $('#item_control_number'),
			itemsList = $('#item_list').find('tr'),
			isExistInItemsList = false;

		$.each(itemsList, function(index, itemInList) {
			if (itemControlNumber.val() == $(itemInList).attr('data-control_number')) {
				isExistInItemsList = true;
				return false;
			}
		})

		if (isExistInItemsList) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').text('Item Control Number Already Exist.');
			return false;
		}

		if (0 === itemControlNumber.val().length) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').addClass('warning').text('Please Enter Item Control Number.');
			return false;
		} else {
			$('#attached_item_group').find('p.help-block').text('Item Control Numbe Required').hide();
		}

		$('#item_table').show();

		Requisition.search(
			itemControlNumber.val(), 
			{	
				beforeSend: function() {
					$('#loader').show();					
					$('#empty').hide();
					$('#result').empty();
				},
				success: function(data) {

					$('#loader').hide();

					if ('object' == typeof data && null != data) {
						
						var td = $('<td />');
						var tr = $('#result');

						tr.attr('data-id', data.stock_id);
						tr.attr('data-control_number', data.stock_control_number);

						tr.prepend('<td><button type="button" class="add_item btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add </button></td>');
						tr.prepend('<td>'+data.stock_type+'</td>');
						tr.prepend('<td>'+data.stock_status+'</td>');
						tr.prepend('<td>'+data.area_name+'</td>');
						tr.prepend('<td>'+data.stock_name+'</td>');
						tr.prepend('<td>'+data.stock_control_number+'</td>');

						$('#result').prepend(tr);

						$('.add_item').bind('click', appendResultToItemList);

					} else {  
						$('#empty').show().fadeOut(1600);
					}

					itemControlNumber.val('');
				}
			});
	});
	
	/**
	 * Approve Item Requisition
	 */
	$('.approve_item_requisition').on('click', function(e) {
		var item = $(this).closest('tr');

		Requisition.approve(item.attr('data-id'), item.attr('data-type'), {
			beforeSend: function() {
				console.log(3);
			},
			success: function(data) {
				console.log(data);
			}
		});

		e.preventDefault();
	});
});