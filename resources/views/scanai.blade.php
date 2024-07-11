<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teachable Machine Image Model with p5.js and ml5.js</title>
  <script src="https://cdn.jsdelivr.net/npm/p5@1.4.0/lib/p5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/p5@1.4.0/lib/addons/p5.dom.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/ml5@0.7.0/dist/ml5.min.js"></script>
  
</head>
<body>
  <div>
    <h2>Teachable Machine Image Model - p5.js and ml5.js</h2>
    <p>This example demonstrates live image classification using a Teachable Machine model.</p>
    <input type="file" id="imageUpload" accept="image/*">
    <p id="result">Upload an image to see the classification result.</p>
    <canvas id="canvas" width="320" height="320"></canvas>
  </div>
  <script type="text/javascript">
      // Classifier Variable
  let classifier;
  // Model URL
  let imageModelURL = 'https://teachablemachine.withgoogle.com/models/ZTGOK9EJq/';
  
  // Video
  let video;
  let flippedVideo;
  // To store the classification
  let label = "";
  let img;

  // Load the model first
  function preload() {
    classifier = ml5.imageClassifier(imageModelURL + 'model.json');
  }

  function setup() {
    createCanvas(320, 260);
    // Create the video
    video = createCapture(VIDEO);
    video.size(320, 240);
    video.hide();

    flippedVideo = ml5.flipImage(video);
    // Start classifying
    classifyVideo();
  }

  function draw() {
    background(0);
    // Draw the video
    image(flippedVideo, 0, 0);

    // Draw the label
    fill(255);
    textSize(16);
    textAlign(CENTER);
    text(label, width / 2, height - 4);
  }

  // Get a prediction for the current video frame
  function classifyVideo() {
    flippedVideo = ml5.flipImage(video)
    classifier.classify(flippedVideo, gotResult);
    flippedVideo.remove();

  }

  function setup1() {
      noCanvas();
      // Handle image upload
      const imageUpload = select('#imageUpload');
      imageUpload.changed(handleFileUpload);
      // Result text
      const resultText = select('#result');
    }

    // Handle the file upload
    function handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        img = createImg(URL.createObjectURL(file), '', '', () => {
          img.hide();
          classifyImage();
        });
      }
    }

    // Get a prediction for the uploaded image
    function classifyImage() {
      classifier.classify(img, gotResult);
    }

  // When we get a result
  function gotResult(error, results) {
    // If there is an error
    if (error) {
      console.error(error);
      return;
    }
    // The results are in an array ordered by confidence.
    // console.log(results[0]);
    label = results[0].label;
    // Classifiy again!
    classifyVideo();
  }
</script>
</body>
</html>