$(document).ready(function () {
  let notificationCount = 3;

  // Toggle notification dropdown
  $('#notificationBtn').on('click', function (e) {
    e.stopPropagation();
    const dropdown = $('#notificationDropdown');
    const profileDropdown = $('#profileDropdown');

    // Close profile dropdown if open
    profileDropdown.removeClass('show');
    $('#profileBtn').removeClass('active');

    // Toggle notification dropdown
    dropdown.toggleClass('show');
    $(this).toggleClass('active');
  });

  // Toggle profile dropdown
  $('#profileBtn').on('click', function (e) {
    e.stopPropagation();
    const dropdown = $('#profileDropdown');
    const notificationDropdown = $('#notificationDropdown');

    // Close notification dropdown if open
    notificationDropdown.removeClass('show');
    $('#notificationBtn').removeClass('active');

    // Toggle profile dropdown
    dropdown.toggleClass('show');
    $(this).toggleClass('active');
  });

  // Close dropdowns when clicking outside
  $(document).on('click', function (e) {
    if (!$(e.target).closest('.icon-wrapper, .dropdown-menu').length) {
      $('.dropdown-menu').removeClass('show');
      $('.icon-btn').removeClass('active');
    }
  });

  // Handle notification item clicks
  $('.notification-item').on('click', function () {
    if ($(this).hasClass('unread')) {
      $(this).removeClass('unread');
      updateNotificationCount(-1);
    }
  });

  // Clear all notifications
  $('.clear-all-btn').on('click', function (e) {
    e.stopPropagation();
    $('.notification-item.unread').removeClass('unread');
    updateNotificationCount(0, true);
  });

  // Update notification count
  function updateNotificationCount(change, reset = false) {
    if (reset) {
      notificationCount = 0;
    } else {
      notificationCount += change;
    }

    const badge = $('#notificationBadge');
    if (notificationCount <= 0) {
      badge.addClass('hidden');
      notificationCount = 0;
    } else {
      badge.removeClass('hidden').text(notificationCount);
    }
  }

  // Simulate new notification (for demo)
  function addNewNotification() {
    const newNotification = $(`
            <div class="notification-item unread">
                <div class="notification-content">
                    <span class="notification-text">New notification received</span>
                    <span class="notification-time">Just now</span>
                </div>
            </div>
        `);

    $('.notification-list').prepend(newNotification);
    updateNotificationCount(1);

    // Add click handler to new notification
    newNotification.on('click', function () {
      if ($(this).hasClass('unread')) {
        $(this).removeClass('unread');
        updateNotificationCount(-1);
      }
    });
  }

  // Demo: Add new notification every 30 seconds
  setInterval(addNewNotification, 30000);

  // Handle profile dropdown links
  $('.dropdown-link').on('click', function (e) {
    if ($(this).hasClass('logout')) {
      e.preventDefault();
      if (confirm('Are you sure you want to sign out?')) {
        // Handle logout logic here
        console.log('User logged out');
      }
    }
  });

  // Keyboard accessibility
  $('.icon-btn').on('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      $(this).click();
    }
  });

  // Escape key to close dropdowns
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      $('.dropdown-menu').removeClass('show');
      $('.icon-btn').removeClass('active');
    }
  });
});