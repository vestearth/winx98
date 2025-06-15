$(document).ready(function () {
  $('.openBtn').on('click', function () {
    $('#rightNav').css('width', '250px');
    $('.main').addClass('blur-content');
  });

  // Close nav when close button is clicked
  $('.closeBtn').on('click', function (e) {
    e.preventDefault();
    $('#rightNav').css('width', '0');
    $('.main').removeClass('blur-content');
  });

  $(document).on('click', function (event) {
    if ($('#rightNav').css('width') === '250px' &&
      !$(event.target).closest('#rightNav').length &&
      !$(event.target).hasClass('openBtn')) {
      $('#rightNav').css('width', '0');
      $('.main').removeClass('blur-content');
    }
  });
});
