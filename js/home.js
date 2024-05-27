 window.addEventListener('resize', function() {
      location.reload();
  });
      // Check if the screen width is greater than or equal to 992 pixels (large devices)
      if (window.innerWidth >= 992) {
          ScrollReveal().reveal('#bodytext', {
              duration: 1000, // Duration of the animation (in milliseconds)
              distance: '50px', // Distance the element moves
              origin: 'bottom', // Origin of the animation (e.g., 'bottom', 'left', 'top', 'right')
              opacity: 0, // Starting opacity
              reset: true, // Whether the animation should reset when the element is out of view
              viewFactor: 0.6 // Adjust this value to control when the element appears
          });
      }
