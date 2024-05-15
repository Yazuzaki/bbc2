<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verification</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <form id="adminVerificationForm">
        <div class="form-group">
            <label for="proof_of_payment">Upload Proof of Payment (Screenshot):</label>
            <input type="file" id="proofOfPayment" name="proofOfPayment" class="form-control" accept="image/*" multiple required>
        </div>
        <button type="button" onclick="scanAndVerify()">Verify Payment</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Add jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js"></script>
    <script>
        function scanAndVerify() {
            var fileInput = document.getElementById('proofOfPayment');
            var files = fileInput.files;

            if (files.length > 0) {
                // Loop through each selected file and perform OCR and verification process
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    performOCR(file);
                }
            } else {
                alert('Please select at least one image before verifying.');
            }
        }

        function performOCR(file) {
            // Use Tesseract.js or another OCR library to extract text from the image
            // Example code for Tesseract.js
            Tesseract.recognize(
                file,
                'eng',
                { logger: info => console.log(info) }
            ).then(({ data: { text } }) => {
                // Assuming text contains the extracted reference number
                var referenceNumber = extractReferenceNumber(text);
                if (referenceNumber) {
                    // Send the reference number to backend for verification and update
                    verifyAndUpdate(referenceNumber);
                } else {
                    alert('Reference number not found in the scanned text.');
                }
            });
        }

        function extractReferenceNumber(text) {
            // Implement your logic to extract the reference number from the scanned text
            // This can involve regular expressions or specific text parsing based on your OCR output
            // Return the extracted reference number or null if not found
            // Example:
            var referenceNumberRegex = /\b(?:Ref(?:\.|:)?\s*No(?:\.|:)?|Reference\s*Number)\s*([\d\s]+)\b/g;
            var matches = referenceNumberRegex.exec(text);
            if (matches && matches[1]) {
                return matches[1].trim();
            } else {
                return null;
            }
        }

        function verifyAndUpdate(referenceNumber) {
            // Send an AJAX request to verify the reference number and update reservation status
            $.ajax({
                url: '<?php echo base_url('page/verifyAndUpdate'); ?>', // Update the URL to match your controller method
                type: 'POST',
                data: { referenceNumber: referenceNumber },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Verification successful. Reference number saved.');
                        // Optionally, perform any UI updates or refresh data after successful verification
                    } else {
                        alert('Verification failed. ' + response.message);
                    }
                },
                error: function () {
                    alert('Error verifying reference number.');
                }
            });
        }

    </script>
</body>

</html>
