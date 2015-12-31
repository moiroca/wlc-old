/**
 * User Js
 */
$(document).ready(function() {
	
	/**
	 * On Change Department Get Department Head
	 */	
	$('#department_id').on('change', function() {
		var departmentId = $(this).val(),
			alert = $('#departmentHead').find('div.alert'),
			departmentHeadName = $('#departmentHead').find('p');

		if (departmentId) { 

			Department.getDepartmentHead({
				data : {
					departmentId : departmentId
				},
				beforeSend: function() {
					console.log('Fetching Department Head...');
				},
				success: function(response) {

					$('#departmentHead').show();
					if (response.error) {
						departmentHeadName.hide();
						alert.show();
						alert.text(response.error);
					} else {
						alert.hide();
						departmentHeadName.show();
						departmentHeadName.find('b').text(response.departmentHead);
					}
				}
			});
		} else {
			alert.hide();
			departmentHeadName.hide();
		}
	});
});