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
    <p>This example demonstrates image classification using a Teachable Machine model.</p>
    <input type="file" id="imageUpload" accept="image/*">
  </div>
  <script type="text/javascript">
      // Classifier Variable
  let classifier;
  // Model URL
  let imageModelURL = 'https://teachablemachine.withgoogle.com/models/ZTGOK9EJq/';
  
  // To store the classification
  let label = "";
  let img;

  // Load the model first
  function preload() {
    classifier = ml5.imageClassifier(imageModelURL + 'model.json');
  }

  function setup() {
    createCanvas(320, 320);
    // Handle image upload
    const imageUpload = select('#imageUpload');
    imageUpload.changed(handleFileUpload);
  }

  function draw() {
    background(255);
    if (img) {
      image(img, 0, 0, width, height);
    }

    // Draw the label
    fill(0);
    textSize(16);
    textAlign(CENTER);
    text(label, width / 2, height - 10);
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
    label = results[0].label;
  }
</script>
</body>
</html>
