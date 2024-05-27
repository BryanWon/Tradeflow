document.addEventListener("DOMContentLoaded", function() {
    // Get the star rating inputs and "Write a Review" link/button
    var reviewButton = document.querySelector('.review-btn');

    reviewButton.addEventListener('click', toggleReviewForm);

    // Function to toggle the review form visibility
    function toggleReviewForm() {
        var reviewForm = document.getElementById('reviewForm');
        reviewForm.style.display = reviewForm.style.display === 'none' ? 'block' : 'none';
    }

    // Get all star labels
    var starLabels = document.querySelectorAll('.star-rating label');

    // Variable to store the rating value
    var ratingValue = 0;

    // Add click event listener to each star label
    starLabels.forEach(function(starLabel, index) {
        starLabel.addEventListener('click', function() {
            // Update rating value
            ratingValue = index + 1;

            // Reset color for all stars
            starLabels.forEach(function(label, idx) {
                if (idx <= index) {
                    label.style.color = '#FFCD3C'; // Change color for clicked star and previous stars
                } else {
                    label.style.color = '#ccc'; // Reset color for subsequent stars
                }
            });

        });
    });
});

/* Product Detail Page */
function openTab(event, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove('active');
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove('active');
    }
    document.getElementById(tabName).classList.add('active');
    event.currentTarget.classList.add('active');
}