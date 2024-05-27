const slidePage = document.querySelector(".slide-page");
const nextBtnFirst = document.querySelector(".firstNext");
const prevBtnSec = document.querySelector(".prev-1");
const nextBtnSec = document.querySelector(".next-1");
const prevBtnThird = document.querySelector(".prev-2");
const nextBtnThird = document.querySelector(".next-2");
const prevBtnFourth = document.querySelector(".prev-3");
const submitBtn = document.querySelector(".submit");
const progressText = document.querySelectorAll(".step p");
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let current = 1;

// Function to move to the next slide
function moveToNextSlide(marginLeftValue) {
  slidePage.style.marginLeft = marginLeftValue;
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
}

nextBtnFirst.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form from submitting prematurely
  moveToNextSlide("-25%"); // Move to the second page
});

nextBtnSec.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form from submitting prematurely
  moveToNextSlide("-50%"); // Move to the third page
});

nextBtnThird.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form from submitting prematurely
  moveToNextSlide("-75%"); // Move to the fourth (final) page
});

// Submit button simply allows the form to proceed to server-side validation
submitBtn.addEventListener("click", function (event) {
  document.getElementById('registrationForm').submit();
  // Optionally, you might want to add any client-side actions before submitting
});

prevBtnSec.addEventListener("click", function (event) {
  event.preventDefault();
  slidePage.style.marginLeft = "0%";
  adjustProgress(-1);
});

prevBtnThird.addEventListener("click", function (event) {
  event.preventDefault();
  slidePage.style.marginLeft = "-25%";
  adjustProgress(-1);
});

prevBtnFourth.addEventListener("click", function (event) {
  event.preventDefault();
  slidePage.style.marginLeft = "-50%";
  adjustProgress(-1);
});

// Utility function to adjust the progress indicators
function adjustProgress(change) {
  current += change;
  bullet.forEach((item, index) => item.classList.toggle("active", index < current));
  progressCheck.forEach((item, index) => item.classList.toggle("active", index < current));
  progressText.forEach((item, index) => item.classList.toggle("active", index < current));
}
