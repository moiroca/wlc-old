/* Add Requisition */
Requisition.init();

$(document).ready(function() {
	
	/**
	 * Remove Item in New Item Requisition
	 */
	var removeItemInNewItemRequisition = function(e) {
		var tr = $(this).closest('tr');
		tr.remove();
	};

	/**
	 * Remove Item From Item List
	 */
	var removeItemFromItemList = function() {
		var item = $(this).closest('tr');
		$(this).closest('tr').remove();
	}
	
	/**
	 * Append Item For Replace
	 */
	var addItemForReplace = function(event) {
		var item = $(this).closest('tr'),
			listItem = $('#tempItemsForApproval'),
			itemAttachedGroup = $('#attached_item_group'),
			itemForReplaceId = itemAttachedGroup.attr('data-item_id');
			
		itemForReplace = listItem.find('tr[data-id='+itemForReplaceId+']');
		itemForReplace.find('span.item-for-replace').attr('data-item_id', $(item).attr('data-id')).text($(item).attr('data-control_number'));
		itemForReplace.find('input.replacement-item-id').val($(item).attr('data-id'));
		itemAttachedGroup.fadeOut();
	}

	/**
	 * Add Item To List
	 */
	var appendResultToItemList = function(event) {
		var item = $(this).closest('tr');

		var select = item.find('select').val();
		item.find('select').closest('td').empty().text(select);

		item.removeClass();
		item.find('td:last-child button').removeClass('btn-primary').addClass('btn-warning');
		item.find('td:last-child button').removeClass('add_item').addClass('remove_item');
		item.find('td:last-child button').html('<i class="fa fa-minus"> Remove</i>');

		$('#item_list').prepend(
			$('<tr/>', { 
					'data-id': item.attr('data-id'), 
					'data-control_number' : item.attr('data-control_number'), 
					'data-status' : select })
				.append(item.children())
				.append($('<input />', { 'type' : 'hidden', 'name' : 'items[]'}).val(item.attr('data-id')))
				.append($('<input />', { 'type' : 'hidden', 'name' : 'statuses[]'}).val(select))
		);
		
		item.attr('data-id', 0);
		item.attr('data-control_number', 0);

		$('.remove_item').bind('click', removeItemFromItemList);
		$(this).unbind('click', appendResultToItemList);
	}

	$('#requisition_type').on('change', function() {
		var requisitionType = $(this);

		// Hide Areas
		$('.areas').hide();

		if ('Item' == requisitionType.val()) {
			Requisition.$itemRequisition.show();						
			Requisition.$jobRequisition.hide();
		} else if ('Job' == requisitionType.val()) {
			Requisition.$jobRequisition.show();
			Requisition.$itemRequisition.hide();		
		} else {
			Requisition.$jobRequisition.hide();
			Requisition.$itemRequisition.hide();		
		}
		
	}).trigger('change');

	// For Replacing Item Requisition
	Requisition.$itemRequisitionType.on('click', '#replaceItemRequisition', function() {

		var helpText = $(this).closest('div.itemRequisitionTypeDiv').find('.help-block');

		Requisition.$attachedItemGroup.show();
		helpText.text('Attach Item to Requisition by searching using Control Number');
		Requisition.$newItemRequisitionForm.hide();
	});

	// New Item Requisition
	Requisition.$itemRequisitionType.on('click', '#newItemRequisition', function() {

		var helpText = $(this).closest('div.itemRequisitionTypeDiv').find('.help-block');

		Requisition.$attachedItemGroup.hide();
		Requisition.$newItemRequisitionForm.show();
		helpText.text('');
	});

	$('#item_control_number').on('keyup', function(e) {

		if (86 == e.keyCode || 13 == e.keyCode) { }
	});
	
	$('#search_control_number').on('click', function() {

		var itemControlNumber = $('#item_control_number'),
			itemsList = $('#item_list').find('tr'),
			isExistInItemsList = false;
			itemIds = '';

		//--. Comment Out For Testing .--//
		if (itemControlNumber.val().length != 10) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').text('Item Control Number Not Valid.');
			return false;
		}


		$.each(itemsList, function(index, itemInList) {
			console.log(index);
			var id = $(itemInList).attr('data-id')

			if (index == 0) {
				itemIds += id;
			} else if (index > 0) {
				itemIds += '&'+ id;
			}
		});
		
		//--. Temporarily Remove For Debugging .--//
		$.each(itemsList, function(index, itemInList) {
			if (itemControlNumber.val() == $(itemInList).attr('data-control_number')) {
				isExistInItemsList = true;
				return false;
			}
		})

		if (isExistInItemsList) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').text('Item Already Exist.');
			return false;
		}

		if (0 === itemControlNumber.val().length) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').addClass('warning').text('Please Enter Item Name.');
			return false;
		} else {
			$('#attached_item_group').find('p.help-block').text('Item Name Required').hide();
		}


		Requisition.search(
			{
				itemIds : itemIds,
				itemControlNumber : itemControlNumber.val()
			}, 
			{	
				beforeSend: function() {
					$('#loader').show();					
					$('#empty').hide();
					$('#result').empty();
				},
				success: function(data) {

					$('#loader').hide();

					if (data.isEmpty) {
						$('#attached_item_group').find('p.help-block').show();
						$('#attached_item_group').find('p.help-block').text('Item Not Found.');
					} else {
						$('#item_table').show();
						
						if ('object' == typeof data && null != data) {
							
							var td = $('<td />'),
								tr = $('#result'),
								status = $('<select/>', { class: 'form-control'});

							if (data.statuses.length != 0) {
								$.each(data.statuses, function(index, value) {
									status.append('<option value="'+value+'">'+value+'</option>');
								});
							}

							tr.attr('data-id', data.stock_id);
							tr.attr('data-control_number', data.stock_control_number);

							tr.prepend('<td><button type="button" class="add_item btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add </button></td>');
							tr.prepend(td.append(status));
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
			btn = $(this),
			td = $(this).parents('td');

		Requisition.approve({
				requisition_id : item.attr('data-id'),
				type : item.attr('data-type')
			}, {
			beforeSend: function() {
				console.log(3);
			},
			success: function(data) {
				
				if (!data.isError) {
					td.prev().empty().append(data.successMSG);
					td.empty().append("<label class='label label-info'> <i class='fa fa-info'></i> No action Found.</label>");	
				}
			}
		});

		e.preventDefault();
	});

	/**
	 * Add More Item To Approve Item Requisition
	 */
	$('#add_more_item').on('click', function(e) {
		
		var item = $('.approve_requisition_item').first();
		
		$('#approve_requisition_items').append($('<div />', { 'class' : 'col-lg-3'}).append(item));
		e.preventDefault();
	});

	/**
	 * Attach Item to Item Requisition
	 */
	$('#attach_item_to_item_requisition_btn').on('click', function(e) {
		var requisition = $('#approve_requisition_items_template');

		var amount = requisition.find('#amount'),
			quantity = requisition.find('#quantity'),
			unit = requisition.find('#unit'),
			name = requisition.find('#name');

		if (!amount.val()) {
			console.log('Amount required');
			return false;
		}

		if (!quantity.val()) {
			console.log('Quantity required');
			return false;
		}

		if (!name.val()) {
			console.log('Name required');
			return false;
		}

		if (!unit.val()) {
			console.log('Unit required');
			return false;
		}
		
		e.preventDefault();
	});

	/**
	 * Approve Item By President
	 */
	$('.approve_item_by_president_btn').on('click', function(e) {
		var item = $(this).closest('tr'),
			btn = $(this);

			td = $(this).closest('td');

		Requisition.approve({
				requisition_id: $(item).attr('data-id'),
				type: $('#requisition_type').val()
			},
			{
				beforeSend : function() {
					td.empty().append('<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					td.siblings('.status').empty().append('<label class="label label-success">Approved By President</label>')

					td.empty().append('<label class="label label-info"> <i class="fa fa-info"></i> There are no actions available.</label>');
				}
			});
		e.preventDefault();
	});

	/**
	 * Declined 
	 */
	$('.decline_requisition').on('click', function(e) {

		var item = $(this).closest('tr'),
			btn = $(this),
			td = $(this).parents('td');

		Requisition.declineRequisition($(item).attr('data-id'), {
			beforeSend: function() {
				console.log('Declining...')
			},
			success: function(data) {
				td.prev().empty().append('<label class="label label-danger">'+data.msg+'</label>')
				td.empty().append("<label class='label label-info'> <i class='fa fa-info'></i> No Action Available</label>");	
			}	
		});

		e.preventDefault();
	});

	/**
	 * Approve Requisition By GSD Officer
	 */
	$('.approve_item_by_gsd_officer').on('click', function(e) {
		var item = $(this).closest('tr'),
			btn = $(this),
			td = $(this).parents('td');

		Requisition.approve({
			requisition_id: $(item).attr('data-id'),
			type: $('#requisition_type').val()
		}, {
			beforeSend: function() {
				td.empty().append("<i class='fa fa-spinner fa-spin fa-2x'></i>");	
			},
			success: function(data) {
				if (!data.error) {
					td.prev().empty().append('<label class="label label-success">Approved</label>')
					td.empty().append("<label class='label label-info'> <i class='fa fa-info'></i> There is no action available</label>");	
				} else {
					console.log('Error');
				}
			}
		});
		e.preventDefault();
	});

	/**
	 * Add New Requisition 
	 */
	$('.add-item-in-new-requisition').on('click', function() {
		var form = $(this).closest('tr'),
			name = form.find('#name'),
			amount = form.find('#amount'),
			quantity = form.find('#quantity'),
			unit = form.find('#unit');
		
		var tr = $('<tr/>');
		var td = $('<td />');

		if (!name.val()) { name.closest('td').addClass('danger'); } else { name.closest('td').removeClass('danger'); }
		if (!amount.val()) { amount.closest('td').addClass('danger'); } else { amount.closest('td').removeClass('danger'); }
		if (!quantity.val()) { quantity.closest('td').addClass('danger'); } else { quantity.closest('td').removeClass('danger'); }
		if (!unit.val()) { unit.closest('td').addClass('danger'); } else { unit.closest('td').removeClass('danger'); }

		if (name.val() &&
			amount.val() &&
			quantity.val() &&
			unit.val()) {


			tr.append(
				$('<td />').text(name.val()).append(
						$('<input />')
							.attr('type', 'hidden')
							.attr('name', 'names[]')
							.val(name.val())
						)	
				);

			tr.append(
				$('<td />').text(amount.val()).append(
						$('<input />')
							.attr('type', 'hidden')
							.attr('name', 'amounts[]')
							.val(amount.val())
						)
				);

			tr.append(
				$('<td />').text(quantity.val()).append(
						$('<input />')
							.attr('type', 'hidden')
							.attr('name', 'quantities[]')
							.val(quantity.val())
						)
				);

			tr.append(
				$('<td />').text(unit.val()).append(
						$('<input />')
							.attr('type', 'hidden')
							.attr('name', 'units[]')
							.val(unit.val())
						)
				);

			tr.append($('<td />').html("<button type='button' class='btn btn-xs btn-warning remove-item-in-new-item-requisition'><i class='fa fa-minus'></i> Remove </button>"));

			form.closest('tbody').append(tr);
			$('.remove-item-in-new-item-requisition').bind('click', removeItemInNewItemRequisition);
			unit.val('');
			name.val('');
			amount.val('');
			quantity.val('');
		}
	});
	
	// Fetch Area By Department Id
	$('.department_id').on('change', function() {
		var department = $(this),
			departmentId = $(this).val();
			areas = $('.areas');

		if (0 != departmentId.length) {

			$.ajax({
				method : 'GET',
				url : $('#getAreaUrl').val(),
				data : {
					departmentId : departmentId
				},
				beforeSend : function() {
					console.log('Fetching Areas in Department');
					department.closest('div.control-group').find('p.help-block').empty();
				},
				success : function(resp) {
					var select = areas.find('select');
					select.empty();

					if (0 == resp.error.length) {
						if (0 != resp.areas.length) {
							areas.show();
							$.each(resp.areas, function(index, item) {
								// 0 index is the area id
								// 1 index is the area name
								select.append("<option value='"+item[0]+"'>"+item[1]+"</option>");
							});
						} else {
							areas.hide();
							department.closest('div.control-group').find('p.help-block').append('<label class="label label-danger">There are no areas in this department.</label>');
						}
					} else {
						console.log(resp.error);
					}
				}
			});
		} else {
			areas.hide();
		}
	}).trigger('change');

	// ----------------------
	// STOCKS IN REQUISITION
	// ----------------------
	$('table#stocks_in_requisition')

		.on('click', '#approve-btn', function() {

			var checkedstocksCheckBoxes = $('input[type="checkbox"]:not(.select-all):checked'),
				stocksCheckBoxes = $('input[type="checkbox"]:not(.select-all)'),
				stockIds = [];

			// Remove Success Class
			$.each(stocksCheckBoxes, function(index, item) {

				stockIds.push({
					id : $(item).closest('tr').attr('data-id'),
					value : $(item).is(':checked')
				});

				$(item).closest('tr').removeClass('success');
			});

			// Add Success To selected class
			$.each(checkedstocksCheckBoxes, function(index, item) {
				$(item).closest('tr').addClass('success');
			});

			if (0 != stockIds.length) {
				Requisition.approveItemInRequisition({
					stockIds : stockIds
				}, {
					beforeSend : function() {
						console.log('Approving Items');
					},
					success: function(response) {
						console.log(response);
					}
				});
			}
		})

		.on('click', '#checkAllItem', function() {
			var selectAll = $('input[type="checkbox"]#checkAllItem'),
				stocksCheckBoxes = $('input[type="checkbox"]:not(.select-all)');

			if (selectAll.is(':checked')) {
				$.each(stocksCheckBoxes, function(index, item) {
					$(item).prop('checked', true);
				});
			} else {
				$.each(stocksCheckBoxes, function(index, item) {
					$(item).prop('checked', false);
				});
			}
		})

		.on('click', 'input[type="checkbox"]:not(.select-all)', function() {
			var checkedstocksCheckBoxes = $('input[type="checkbox"]:not(.select-all):checked'),
				stocksCheckBoxes = $('input[type="checkbox"]:not(.select-all)');

			if (stocksCheckBoxes.length == checkedstocksCheckBoxes.length) {
				$('#checkAllItem').prop('checked', true);
			} else {
				$('#checkAllItem').prop('checked', false);
			}
		})

		.on('click', '#decline-btn', function() {
			console.log('Decline btn');
		})

	$('#requisition_form').on('submit', function(event) {
		var requisitionType = $('#requisition_type').val(),
			itemType 		= $('#type').val(),
			areaId			= $('.area_id'),
			requisitionItems = $('.requisitionItems'),
			error 			= false,
			formValidation  = $('#form-validation');

		
		formValidation.fadeOut();

		if (requisitionType == 'Job') {
			purpose = $('#purpose').val();

			error = (purpose.length == 0);
			if (!error) {
				
				error = ($('.area_id').is(':visible'));

				if (error) {

					error = (requisitionItems.find('tr:not(.itemForm)').length == 0);

					if (error) {
						formValidation.show();
						formValidation.find('b').text(' Job Requisition Item Required.');
					}
				} else {
					formValidation.show();
					formValidation.find('b').text(' Job Requisition Area Required.');
				}

			} else {
				formValidation.show();
				formValidation.find('b').text(' Job Requisition Purpose Required.');
			}

		} else if(requisitionType == 'Item') {
			error = (itemType.length == 0);
			
			if (!error) {
				error = (areaId.length == 0);

				if (!error) {
					error = (areaId.val().length == 0);

					if (!error) {
						error = (requisitionItems.find('tr:not(.itemForm)').length == 0);
					}
				}
			}
		} else {	

		}

		if (error) { event.preventDefault(); }
	});

	$('#comment').on('keyup', function() {
		if ($(this).val().length != 0) {
			$('#save-comment').prop('disabled', false);
		} else {
			$('#save-comment').prop('disabled', 'disabled');
		}
	}).trigger('keyup');

	$('#save-comment').on('click', function() {
		var requisition_id = $('#comments_wrapper').data('requisition_id'),
			comment = $('#comment').val(),
			comments = $('#comments_wrapper').find('div.list-group');	

		Requisition.saveRequisitionComment({
			requisition_id : requisition_id,
			comment : comment
		}, {
			beforeSend : function() {

			},
			success : function(resp) {
				if (!resp.isError) {
					comments.append('<a href="javascript:void(0)" class="list-group-item"><h4 class="list-group-item-heading">'+resp.data.user+' <small>'+resp.data.datetime+'</small></h4><p class="list-group-item-text">'+comment+'</p></a>');
				} else {
					console.log('Check');
				}
				
				$('#comment').val('');
			}
		})
	});

	/**
	 * Add Remove Item in Item Requisition
	 */
	$('.approve-item').on('change', function() {
		var $item = $(this);

		var key = ApproveItemsUtility.getKey(this);

		console.log($item.val());
	});


	/**
	 * Add From Item Requsition
	 */
	$('.plus-item-requisition').on('click', function() {
		var $plusBtn = $(this),
			key 	 = ApproveItemsUtility.getKey(this);

		if (!ApproveItemsUtility.itemCountIsEqualToCountInStock(key)) {
			
			ItemsForApprovalUtility.addItemToApprove(this);
			ApproveItemsUtility.addItemToApprove(key);
			ApproveItemsUtility.addItemFromRequisition(key);

			$minusBtn = ItemsForApprovalUtility.getMinusBtn(key);
			if (ApproveItemsUtility.itemCountIsEqualToCountInStock(key)) { $plusBtn.hide(); };
			
			$minusBtn.show();
		}

		
	});

	/**
	 * Minus From Item Requisition
	 */
	$('.minus-item-requisition').on('click', function() {
		var $minusBtn = $(this);

		var key = ApproveItemsUtility.getKey(this);

		console.log();
		// Subtract item for approval temp
		if (!ApproveItemsUtility.itemCountIsZero(key)) {

			ItemsForApprovalUtility.subtractItemToApprove(this);
			ApproveItemsUtility.subtractItemToApprove(key);
			ApproveItemsUtility.subtractItemFromRequisition(key);

			$plusBtn = ItemsForApprovalUtility.getPlusBtn(key);

			if (ApproveItemsUtility.itemCountIsZero(key)) { $minusBtn.hide(); };
			$plusBtn.show();
		} 
	});

	/**
	 * Plus From Item Stocks
	 */
	$('.plus-item-stocks').on('click', function() {
		var $plusBtn = $(this),
			key 	 = ItemsInStocks.getKey(this);

		if (!ApproveItemsUtility.itemCountIsEqualToCountInStock(key)) {
			
			ItemsInStocks.subtractItemToApprove(this);
			ApproveItemsUtility.addItemToApprove(key);
			ApproveItemsUtility.addItemFromStocks(key);
			// $minusBtn = ItemsInStocks.getMinusBtn(key);
			// if (ApproveItemsUtility.itemCountIsEqualToCountInStock(key, this)) { $plusBtn.hide(); };
			// $minusBtn.show();
		}
	});

	/**
	 * Minus From Item Stocks
	 */
	$('.minus-item-stocks').on('click', function() {
		var $minusBtn = $(this),
			key = ApproveItemsUtility.getKey(this);

		// Check if Item From Stock is Original

		if (ItemsInStocks.getItemCount(this) == ItemsInStocks.getOriginalItemCount(this)) {
			return false;
		}

		if (!ApproveItemsUtility.itemCountIsZero(key)) {

			ItemsInStocks.addItemToApprove(this);
			ApproveItemsUtility.subtractItemToApprove(key);
			ApproveItemsUtility.subtractItemFromStocks(key);
			// $plusBtn = ItemsForApprovalUtility.getPlusBtn(key);

			// if (ApproveItemsUtility.itemCountIsZero(key)) { $minusBtn.hide(); };
			// $plusBtn.show();
		} 
	});

	/**
	 * Receive Item
	 */
	$('#receivedBtn').on('click', function(e) {
		var items = $('.stock'),
			itemIds = [],
			requisition_id = $('#requisition_id').val();

		$.each(items, function(key, item) {
			id = $(item).val();

			itemIds.push(JSON.stringify({ id : id, isChecked : $(item).is(':checked') }));
		});

		Requisition.receive({
			itemIds : itemIds,
			requisition_id : requisition_id
		}, {
			beforeSend : function() {
				console.log('Before Send...');
			},
			success : function(resp) {
				var table = $('#tempItemsForApproval');
				$.each(itemIds, function(key, item) {
					parseItem = JSON.parse(item);
					tr = table.find('tr[data-id='+parseItem.id+']');
					td = tr.find('td.status');

					if (parseItem.isChecked) {
						$(td).empty().html('<label class="label label-success">Received</label>');
					} else {
						$(td).empty().html('<label class="label label-info">Approved</label>');
					}
				});				
			}
		});

		e.preventDefault();
	});
	/**
	 * Approve Requisition Button
	 */
	$('#approveRequisitionButton').on('click', function(e) {

		$(this).empty().html('<p>Approving... <i class="fa fa-spinner fa-spin"></i></p>');

		var items = ApproveItemsUtility.getAllItem(),
			submitItem = { 
				requisitionId : $('#requisition_id').val(), 
				items : []
			};

		for (var i = items.length - 1; i >= 0; i--) {
			item = $(items[i]);

			submitItem.items.push({
				key : item.data('key'),
				countFromRequisition : parseInt(item.find('td.from-item-requisition').text()),
				countFromStocks : parseInt(item.find('td.from-item-stocks').text())
			});
		};

		Requisition.approveItemInRequisition({
			items : submitItem.items,
			requisitionId : submitItem.requisitionId
		}, {
			beforeSend : function() {
				console.log('Saving Items In Requisition');
			},

			success : function(resp) {
				window. location.reload();
			}
		});
		e.preventDefault();
	});

	var ItemsInStocks = {

		/** 
		 * Get Key Of The Current Element
		 * @param Object element
		 * @return Object
		 */
		getKey : function(element) {
			return $(element).closest('tr').data('key');
		},

		/**
		 * Get Item In Stock
		 * @param string key
		 * @return Object
		 */
		getItem : function(key) {
			return $('#ItemInStock').find('tr[data-key="'+key+'"]');
		},

		/**
		 * Get Item Count
		 * @param Object element
		 * @return int 
		 */
		getItemCount : function(element) {
			return parseInt($(element).closest('tr').data('count_stocks'));			
		},

		/**
		 * Get Original Item Count
		 * @param Object element
		 * @return int 
		 */
		getOriginalItemCount : function(element) {
			return parseInt($(element).closest('tr').data('original_stock_count'));			
		},		

		/**
		 * Get Minus Button
		 * @param String Key
		 * @return Object 
		 */
		getMinusBtn : function(key) {
			return ItemsInStocks.getItem(key).find('.minus-item-stocks');
		},

		/**
		 * Get Plus Btn
		 * @param String Key
		 * @return Object 
		 */
		getPlusBtn : function(key) {
			return ItemsInStocks.getItem(key).find('.plus-item-stocks');
		},

		/**
		 * Subtract Item in Item Stocks
		 * @param Object element
		 */
		subtractItemToApprove : function(element) {
			$(element).closest('tr').find('td.count-stocks').text(parseInt($(element).closest('tr').find('td.count-stocks').text()) - 1);
			$(element).closest('tr').data('count_stocks', parseInt($(element).closest('tr').data('count_stocks')) - 1);
		},

		/**
		 * Add Item In Item Stocks
		 * @param Object element
		 */ 
		addItemToApprove: function(element) {
			$(element).closest('tr').find('td.count-stocks').text(parseInt($(element).closest('tr').find('td.count-stocks').text()) + 1);
			$(element).closest('tr').data('count_stocks', parseInt($(element).closest('tr').data('count_stocks')) + 1);
		},
	};

	// Temporary Items in for Approval in list
	var ItemsForApprovalUtility = {

		getItem : function(key) {
			return $('#tempItemsForApproval').find('tr[data-key="'+key+'"]');
		},

		getMinusBtn : function(key) {
			return ItemsForApprovalUtility.getItem(key).find('.minus-item-requisition');
		},

		getPlusBtn : function(key) {
			return ItemsForApprovalUtility.getItem(key).find('.plus-item-requisition');
		},

		getItemCount : function(element) {
			return parseInt($(element).closest('tr').data('count_stocks'));			
		},

		getAllItem : function() {

		},

		addItemToApprove: function(element) {
			$(element).closest('tr').find('td.count-stocks').text(parseInt($(element).closest('tr').find('td.count-stocks').text()) + 1);
			$(element).closest('tr').data('count_stocks', parseInt($(element).closest('tr').data('count_stocks')) + 1);
		},

		subtractItemToApprove: function(element) {
			$(element).closest('tr').find('td.count-stocks').text(parseInt($(element).closest('tr').find('td.count-stocks').text()) - 1);
			$(element).closest('tr').data('count_stocks', parseInt($(element).closest('tr').data('count_stocks')) - 1);
		},

		itemCountIsZero: function() {

		}
	};

	// Temporary Items in for Approval in queue
	var ApproveItemsUtility = {

		/** 
		 * Get Key Of The Current Element
		 * @param Object element
		 * @return Object
		 */
		getKey : function(element) {
			return $(element).closest('tr').data('key');
		},

		getItem : function(key) {
			return $('#itemsForApproval').find('tr[data-key="'+key+'"]')
		},

		getAllItem : function() {
			return $('#itemsForApproval').find('tr');
		},

		getTotalItemCount : function(key) {
			return parseInt(ApproveItemsUtility.getItem(key).find('td.count-stocks').text());
		},

		getItemCount : function(key) {
			return parseInt(ApproveItemsUtility.getItem(key).data('count_stocks'));
		},

		subtractItemFromRequisition : function(key) {
			var item = ApproveItemsUtility.getItem(key);
			item.find('td.from-item-requisition').text(parseInt(item.find('td.from-item-requisition').text()) - 1);
		},

		addItemFromRequisition : function(key) {
			var item = ApproveItemsUtility.getItem(key);
			item.find('td.from-item-requisition').text(parseInt(item.find('td.from-item-requisition').text()) + 1);
		},

		subtractItemFromStocks : function(key) {
			var item = ApproveItemsUtility.getItem(key);
			item.find('td.from-item-stocks').text(parseInt(item.find('td.from-item-stocks').text()) - 1);
		},		

		addItemFromStocks : function(key) {
			var item = ApproveItemsUtility.getItem(key);
			item.find('td.from-item-stocks').text(parseInt(item.find('td.from-item-stocks').text()) + 1);
		},

		addItemToApprove: function(key) {
			var item = ApproveItemsUtility.getItem(key);
			item.find('td.count-stocks').text(parseInt(item.find('td.count-stocks').text()) + 1);
		},

		subtractItemToApprove : function(key) {
			var item = ApproveItemsUtility.getItem(key);
			item.find('td.count-stocks').text(parseInt(item.find('td.count-stocks').text()) - 1);
		},

		itemCountIsZero: function(key) {
			return (ApproveItemsUtility.getTotalItemCount(key) == 0);
		},

		itemCountIsEqualToCountInStock : function(key) {
			return (ApproveItemsUtility.getTotalItemCount(key) == ApproveItemsUtility.getItemCount(key));
		},
	};

	$('#search_control_number_for_replace').on('click', function() {

		var itemControlNumber = $('#item_control_number'),
			itemsList = $('#item_list').find('tr'),
			isExistInItemsList = false;
			itemIds = '';

		//--. Comment Out For Testing .--//
		if (itemControlNumber.val().length != 10) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').text('Item Control Number Not Valid.');
			return false;
		}

		$.each(itemsList, function(index, itemInList) {
			console.log(index);
			var id = $(itemInList).attr('data-id')

			if (index == 0) {
				itemIds += id;
			} else if (index > 0) {
				itemIds += '&'+ id;
			}
		});
		
		//--. Temporarily Remove For Debugging .--//
		$.each(itemsList, function(index, itemInList) {
			if (itemControlNumber.val() == $(itemInList).attr('data-control_number')) {
				isExistInItemsList = true;
				return false;
			}
		})

		if (isExistInItemsList) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').text('Item Already Exist.');
			return false;
		}

		if (0 === itemControlNumber.val().length) {
			$('#attached_item_group').find('p.help-block').show();
			$('#attached_item_group').find('p.help-block').addClass('warning').text('Please Enter Item Name.');
			return false;
		} else {
			$('#attached_item_group').find('p.help-block').text('Item Name Required').hide();
		}


		Requisition.search(
			{
				itemIds : itemIds,
				itemControlNumber : itemControlNumber.val()
			}, 
			{	
				beforeSend: function() {
					$('#loader').show();					
					$('#empty').hide();
					$('#result').empty();
				},
				success: function(data) {

					$('#loader').hide();

					if (data.isEmpty) {
						$('#attached_item_group').find('p.help-block').show();
						$('#attached_item_group').find('p.help-block').text('Item Not Found.');
					} else {
						$('#item_table').show();
						
						if ('object' == typeof data && null != data) {
							
							var td = $('<td />'),
								tr = $('#result');

							tr.attr('data-id', data.stock_id);
							tr.attr('data-control_number', data.stock_control_number);

							tr.prepend('<td><button type="button" data-stock_id="'+data.stock_id+'" class="add_item_for_replace btn btn-sm btn-primary"><i class="fa fa-plus"></i> Use Item For Replace </button></td>');
							tr.prepend('<td>'+data.stock_type+'</td>');
							tr.prepend('<td>'+data.stock_status+'</td>');
							tr.prepend('<td>'+data.area_name+'</td>');
							tr.prepend('<td>'+data.stock_name+'</td>');
							tr.prepend('<td>'+data.stock_control_number+'</td>');

							$('#result').prepend(tr);

							$('.add_item_for_replace').bind('click', addItemForReplace);

						} else {  
							$('#empty').show().fadeOut(1600);
						}
					}

					itemControlNumber.val('');
				}
			});
	});

	// Show Search Form
	$('.replace-item-btn').on('click', function() {
		var item = $(this).closest('tr'),
			searchForm = $('#attached_item_group');

		searchForm.attr('data-item_id', $(item).attr('data-id'));
		searchForm.fadeIn();

		console.log($(item).attr('data-id'));
	});
});