document.addEventListener("DOMContentLoaded", function () {
  // Function to show the preloader
  function showPreloader() {
    var preloader = document.querySelector(".preloader");
    preloader.style.display = "flex"; // Show the preloader
  }

  // Function to hide the preloader
  function hidePreloader() {
    var preloader = document.querySelector(".preloader");
    preloader.style.display = "none"; // Hide the preloader
  }

  // Function to handle link clicks
  function redirectHref(link) {
    // Show preloader on link click
    // showPreloader();

    // Check if the link has a data-link attribute
    if (link.getAttribute("data-link")) {
      // Simulate link navigation after a short delay (you can adjust the delay)
      // setTimeout(function () {
      window.location.href = link.getAttribute("data-link");
      // }, 1000); // 1000 milliseconds = 1 second (adjust as needed)
    } else {
      // If no data-link attribute, proceed with the default link behavior
      // setTimeout(function () {
      window.location.href = link.href;
      // }, 1000); // 1000 milliseconds = 1 second (adjust as needed)
    }
  }

  // Attach click event to links with class 'preloader-link'
  var preloaderLinks = document.querySelectorAll(".preloader-link");
  preloaderLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      // Prevent default link behavior to allow time for preloader
      event.preventDefault();

      // Call redirectHref with the clicked link
      redirectHref(link);
    });
  });

  // Hide the preloader when the page is fully loaded
  window.addEventListener("load", function () {
    // hidePreloader();
  });
});