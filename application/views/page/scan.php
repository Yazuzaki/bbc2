<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Scanning with Tesseract.js</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        #resultContainer {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Image Scanning</h1>

        <form id="imageForm" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="imageInput">Select Image:</label>
                <input type="file" id="imageInput" name="imageInput" accept="image/*" required
                    class="form-control-file">
            </div>

            <button type="button" onclick="scanImage()" class="btn btn-primary">Scan Image</button>
        </form>

        <div id="resultContainer" class="mt-4" style="display: none;">
            <h3>Scanned Text:</h3>
            <pre id="scannedText" class="border p-3"></pre>
            <h3 class="mt-3">Extracted Reference Number:</h3>
            <div id="extractedReferenceNumber" class="border p-3"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Add jQuery library -->

    <script>
        function scanImage() {
            var fileInput = document.getElementById('imageInput');
            var resultContainer = document.getElementById('resultContainer');
            var scannedTextElement = document.getElementById('scannedText');
            var extractedReferenceNumberElement = document.getElementById('extractedReferenceNumber');

            var file = fileInput.files[0];

            if (file) {
                Tesseract.recognize(
                    file,
                    'eng',
                    { logger: info => console.log(info) }
                ).then(({ data: { text } }) => {
                    resultContainer.style.display = 'block';
                    scannedTextElement.textContent = text;

                    // Define a regular expression for matching reference numbers
                    var referenceNumberRegex = /\b(?:Ref\. No\.|Reference\s*Number)\s*([\d\s]+)\b/g;

                    // Extract reference numbers from the scanned text
                    var matches = referenceNumberRegex.exec(text);

                    if (matches && matches[1]) {
                        var referenceNumber = matches[1];
                        extractedReferenceNumberElement.innerHTML = referenceNumber;

                        // Send the extracted reference number to the backend for insertion
                        sendReferenceNumberToBackend(referenceNumber.toString());

                    } else {
                        extractedReferenceNumberElement.innerHTML = 'No reference numbers found.';
                    }
                });
            } else {
                alert('Please select an image before scanning.');
            }

            function sendReferenceNumberToBackend(referenceNumber) {
                // Use jQuery AJAX to send data to the backend
                $.ajax({
                    url: '<?php echo site_url("Page/process_scan"); ?>',
                    method: 'POST',
                    data: { referenceNumber: referenceNumber },
                    dataType: 'json', // specify the expected data type
                    success: function (response) {
                        console.log('Reference number sent to the backend successfully');
                        // You can handle the response from the backend here
                    },
                    error: function (error) {
                        console.error('Error sending reference number to the backend', error);
                    }
                });
            }
        }




    </script>
</body>

</html>