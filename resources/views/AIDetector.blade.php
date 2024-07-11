<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachable Machine Image Model</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9a1a1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(235, 6, 6, 0.942);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #ff0000;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        input[type="file"] {
            display: none;
            width: 100%;
            padding: 2rem;
            border-radius: 45px;
        }
        #webcam-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        #label-container {
            margin-top: 10px;
            text-align: left;
        }
        .prediction {
            text-align: center;
            margin-bottom: 5px;
            margin-top: 15px; 
        }
        .id webcam-container {
          width: 100%;
          padding: 2rem;
          border-radius: 45px;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <h1>Teachable Machine Image Model</h1>
        <button type="button" onclick="handleImageUpload()">Upload Image</button>
        <input type="file" id="image-upload" accept="image/*">
        <div id="webcam-container"></div>
        <div id="label-container"></div>
    </div>

    <!-- TensorFlow.js and Teachable Machine libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script type="text/javascript">
        const URL = "https://teachablemachine.withgoogle.com/models/4Vmrx-678/"; // Replace with your model URL

        let model, maxPredictions;
        let labelContainer = document.getElementById("label-container");
        let imageContainer = document.getElementById("webcam-container");

        async function init() {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";

            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();
        }

        function handleImageUpload() {
            document.getElementById("image-upload").click();
        }

        async function predictImage(event) {
            const file = event.target.files[0];
            const imageElement = document.createElement("img");
            const reader = new FileReader();

            reader.onload = async function() {
                imageElement.src = reader.result;
                imageElement.width = 400; // Adjust width as needed
                imageElement.height = 260; // Adjust height as needed
                imageElement.onload = async function() {
                    const prediction = await model.predict(imageElement);
                    displayImageAndPredictions(imageElement, prediction);
                };
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function displayImageAndPredictions(imageElement, predictions) {
            labelContainer.innerHTML = ""; // Clear previous content
            imageContainer.innerHTML = ""; // Clear previous content

            // Display uploaded image
            imageContainer.appendChild(imageElement);

            // Display predictions
            for (let i = 0; i < maxPredictions; i++) {
                const probability = predictions[i].probability;
                if (probability >= 0.50) { // Adjust threshold as needed
                    const classPrediction = predictions[i].className + ": " + (probability * 100).toFixed(2) + "%";
                    const predictionDiv = document.createElement("div");
                    predictionDiv.textContent = classPrediction;
                    predictionDiv.classList.add("prediction");
                    labelContainer.appendChild(predictionDiv);
                }
            }
        }

        init();
        document.getElementById("image-upload").addEventListener("change", predictImage);
    </script>
</body>
</html>
