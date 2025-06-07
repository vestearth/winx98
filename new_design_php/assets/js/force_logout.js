$(document).ready(function () {
  var minutes = 10;

  // Function to update the countdown timer
  function updateTimer() {
    var expirationTime = new Date();
    expirationTime.setMinutes(expirationTime.getMinutes() + minutes);

    var countdownInterval = setInterval(function () {
      var now = new Date().getTime();
      var remainingTime = expirationTime - now;

      var minutesRemaining = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
      var secondsRemaining = Math.floor((remainingTime % (1000 * 60)) / 1000);

      // Update the countdown display
      $('#countdown').text(minutesRemaining + "m " + secondsRemaining + "s");

      // Check if the countdown has reached 0
      if (remainingTime <= 0) {
        clearInterval(countdownInterval);
        logout();
      }
    }, 1000);
  }

  // Function to perform the logout action
  function logout() {
    // Redirect the user to the login page or any desired page
    window.location.href = "logout.php";
  }

  // Call the function to start the countdown
  updateTimer();
});