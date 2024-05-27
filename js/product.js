document.addEventListener('DOMContentLoaded', function () {
    const gridButton = document.querySelector('.fa-grip');
    const listButton = document.querySelector('.fa-list');

    // Add event listeners to grid and list buttons
    gridButton.addEventListener('click', function () {
        // Add active class to grid button and remove it from list button
        gridButton.parentElement.classList.add('active');
        listButton.parentElement.classList.remove('active');
        switchToGrid();

    });

    listButton.addEventListener('click', function () {
        // Add active class to list button and remove it from grid button
        listButton.parentElement.classList.add('active');
        gridButton.parentElement.classList.remove('active');
        switchToList();
    });

    const stars = document.querySelectorAll('.star');
    const ratingValue = 4; // Replace this with the retrieved rating value

    // Loop through each star
    stars.forEach(function(star, index) {
        // Check if the index is less than the rating value
        if (index < ratingValue) {
            // Add a class to fill the star
            star.style.color = 'orange';
        }
    });

    
});

 // Function to switch to grid layout
 function switchToGrid() {
    document.querySelectorAll('.item-grid').forEach(function(element) {
        element.style.display = 'block';
    });
    document.querySelectorAll('.item-list').forEach(function(element) {
        element.style.display = 'none';
    });
}

// Function to switch to list layout
function switchToList() {
    document.querySelectorAll('.item-grid').forEach(function(element) {
        element.style.display = 'none';
    });
    document.querySelectorAll('.item-list').forEach(function(element) {
        element.style.display = 'block';
    });
}

function showProductOverlay(productId) {
    document.querySelector('.overlay').style.visibility = 'visible';
}

// Add event listener to the magnifying glass icons
document.querySelectorAll('.details-btn').forEach(icon => {
    icon.addEventListener('click', function() {
        // Extract the product ID from the data-product-id attribute of the button
        var productId = this.parentNode.getAttribute('data-product-id');
        
        // Here you need to fetch product details via AJAX or another method
        // For demonstration purposes, let's assume you have a JavaScript object called productsData
        // containing all product details indexed by product ID
        var productDetails = productData[productId];
        if (productDetails) {
            console.log(document.querySelector('.overlay-content h1'));
            // Update the overlay content with product details
            document.querySelector('.overlay-content h1').innerHTML = productDetails.name;
            document.querySelector('.overlay-content img').setAttribute('src', "admin/product_img/" + productDetails.imgname);

            // Display the overlay
            document.getElementById('productOverlay').style.visibility = 'visible';
        }
    });
});

// Function to close the overlay
function closeProductOverlay() {
    document.getElementById('productOverlay').style.visibility = 'hidden';
}

