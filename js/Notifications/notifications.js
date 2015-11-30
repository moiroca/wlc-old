/**
 * Notifications JS
 * 
 * @since November 2015
 */
var Notifications = (function($) {
	return {
		viewNotifBtn : $('#view_notif'),

		notificationsList : $('#view_notif').find('li'),

		updateNotificationUrl : $('#view_notif').find('input[type="hidden"]').val(),

		activeBtn : false,

		init : function() {
			Notifications.addEventListener();
		},

		addEventListener : function() {
			Notifications.viewNotifBtn.on('click', function() {
				
				if (!Notifications.activeBtn) {
					var notificationIds = [];

					$.each(Notifications.getAllNotifications(), function(index, notifs) {
						notificationIds.push(parseInt($(notifs).attr('data-id')));
					});

					Notifications.changeNotificationStatusToView(notificationIds, {
						beforeSend: function() {
							console.log('Updating...');
						},
						success: function(data) {
							Notifications.viewNotifBtn.find('label.badge').remove();
							Notifications.viewNotifBtn.attr('id','');
						}
					});

					Notifications.activeBtn = true;
				} else { Notifications.activeBtn = false; }
			});
		},

		getAllNotifications : function() {
			return Notifications.notificationsList;
		},

		changeNotificationStatusToView: function(notificationIds, callback) {
			$.ajax({
				method: 'POST',
				url: Notifications.updateNotificationUrl,
				data: {
					notificationIds : notificationIds
				},
				beforeSend: function() {
					callback.beforeSend();
				},
				success: function(data) {
					callback.success(data);
				}
			});
		}
	}
})(jQuery);