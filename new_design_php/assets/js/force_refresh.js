function refreshAllImages() {
  // Get all <img> elements on the page
  const images = document.querySelectorAll('img');

  // Loop through each image
  images.forEach(img => {
    // Get the current source URL
    const currentSrc = img.src;
    // Add a unique query string to the URL
    img.src = currentSrc + '?version=' + new Date().getTime();

  });

  // $('img').each(function () {
  //   var fullImagePath = $(this).attr('src');
  //   var relativeImagePath = fullImagePath.replace('http://localhost:8100/nmg_neon_website_blue/', '');
  //   console.log(fullImagePath);
  //   console.log(relativeImagePath);
  //   $(this).attr('src', relativeImagePath + '?version=' + new Date().getTime());
  // });
}
// refreshAllImages();
window.addEventListener('load', refreshAllImages);