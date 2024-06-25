<!DOCTYPE html>
<html>
<head>
    <title>My First Web Globe Page</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%; 
            width: 100%; 
            background-color: black; 
        }
        #globeCanvas {
            width: 100%;
            height: 100%;
            position: absolute; 
            top: 0; 
            left: 0; 
            z-index: 1; 
        }
        #actionButton {
            position: fixed;  /* Fixed position */
            top: 20px;        /* Distance from the top */
            right: 20px;      /* Distance from the right */
            z-index: 1000;    /* Ensure it's on top of other content */
            padding: 10px;    /* Some padding */
            background-color: lime; /* Background color */
            color: black;     /* Text color */
            border-style: solid;
            border-color: lime;    
            border-radius: 5px; /* Rounded corners */
            cursor: pointer;  /* Pointer cursor on hover */
            width: 150px;
        
        }
        #actionButton:hover{
            background-color: limegreen;
            border-color: limegreen;
        }
        #resetButton {
            position: fixed; 
            top: 20px; 
            right: 200px; /* Adjust position as needed */
            padding: 10px; 
            background-color: red;
            color: black;
            border-style: solid;
            border-color: red;    
            border-radius: 5px; /* Rounded corners */
            cursor: pointer;
            z-index: 1000; 
            width: 150px;
        }
        #resetButton:hover{
            background-color: #d40a0a;
            border-color: #d40a0a;
        }
        #zoomSlider {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            z-index: 10;
        }
    </style>
</head>
<body>
    <canvas id="globeCanvas"></canvas>
    <button id="actionButton">Start</button>
    <button id="resetButton">Reset</button> <!-- New reset button -->
    <input type="range" id="zoomSlider" min="1" max="100" value="50"> <!-- New zoom slider -->
    <script type="module">
        import { init, startAnimation, stopAnimation, resetGlobe, updateZoom } from './globe.js'; // Ensure correct imports

        const canvas = document.getElementById('globeCanvas');
        init(canvas);

        const actionButton = document.getElementById('actionButton');
        actionButton.addEventListener('click', () => {
            if (actionButton.textContent === 'Start') {
                startAnimation();
                actionButton.textContent = 'Stop';
            } else {
                stopAnimation();
                actionButton.textContent = 'Start';
            }
        });

        const resetButton = document.getElementById('resetButton');
        resetButton.addEventListener('click', () => {
            resetGlobe();
            // Optionally reset the action button text if needed
            actionButton.textContent = 'Start';
        });

        // Get the zoom slider element
        const zoomSlider = document.getElementById("zoomSlider");

        // Add an event listener to detect changes in the slider value
        zoomSlider.addEventListener("input", () => {
            // Get the current value of the slider (between 1 and 100)
            const sliderValue = parseFloat(zoomSlider.value);

            // Calculate the zoom level based on the slider value (adjust as needed)
            const invertedSliderValue = 100 - sliderValue;
            const invertedZoomLevel = invertedSliderValue / 50;

            // Update the zoom level (adjust as needed)
            updateZoom(invertedZoomLevel);
        });
    </script>
</body>
</html>
