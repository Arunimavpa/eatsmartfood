<script>
// JavaScript for Speech Recognition (Voice Input)
var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
recognition.lang = 'en-US';  // Set language

function startVoiceRecognition() {
    recognition.start();  // Start voice recognition
}

recognition.onresult = function(event) {
    var voiceInput = event.results[0][0].transcript;  // Capture the speech result
    document.getElementById('order-output').innerText = "You said: " + voiceInput;  // Display the recognized speech

    // Send voice input to the server for processing
    sendOrderToServer(voiceInput);
};

// Function to send manual order input
function sendManualOrder() {
    var manualInput = document.getElementById('manual-order-input').value;
    document.getElementById('order-output').innerText = "You typed: " + manualInput;
    
    // Send the manual order to the server for processing
    sendOrderToServer(manualInput);
}

// Function to send order (voice or manual) to the server
function sendOrderToServer(orderInput) {
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'orderInput=' + encodeURIComponent(orderInput)  // Send order input in the body
    })
    .then(response => response.json())
    .then(data => {
        // Display the server's response (e.g., order confirmation)
        document.getElementById('order-output').innerText += "\nResponse: " + data.response;
    })
    .catch(error => {
        document.getElementById('order-output').innerText += "\nError: " + error.message;
    });
}
</script>
