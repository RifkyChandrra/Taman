document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector(".slider");
  const lightbox = document.querySelector(".lightbox");
  const lightboxImg = document.getElementById("expandedImg");

  slider.addEventListener("click", function (event) {
    if (event.target.tagName === "IMG") {
      lightbox.style.display = "block";
      lightboxImg.src = event.target.src;
    }
  });

  lightbox.addEventListener("click", function () {
    lightbox.style.display = "none";
  });

  const closeBtn = document.querySelector(".close");
  closeBtn.addEventListener("click", function () {
    lightbox.style.display = "none";
  });
});
