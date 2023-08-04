<?php
// Retrieve the JSON data from the AJAX request
$jsonData = json_decode(file_get_contents("php://input"), true);

// Process the data, call the GPT-3.5 API, and generate the email content
$apiKey = "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";
$url = "https://api.openai.com/v1/engines/text-davinci-003/completions";

$headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey
);

$data = array(
    "prompt" => "Dear Dr. " . $jsonData['doctorName'] . ",\n\nThank you for your interest in our services. We have reviewed your dental practice, " . $jsonData['practiceName'] . ", in " . $jsonData['location'] . ". Based on our analysis, we identified the following weaknesses:\n\n" . $jsonData['weaknesses'] . "\n\nWe propose the following solutions to prevent these weaknesses:\n\n" . $jsonData['solutions'] . "\n\nOur comprehensive package price is $" . $jsonData['packagePrice'] . " per month, and it includes website redesign, SEO optimization, social media management, and more.\n\nPlease feel free to reach out to us if you have any questions or would like to discuss further.\n\nSincerely,\n[Your Web Development Agency]",
    "max_tokens" => 500, // Set the number of tokens for the response
    "temperature" => 0.7 // Adjust the temperature for the response randomness (0.2 to 1.0)
);

$options = array(
    "http" => array(
        "header" => implode("\r\n", $headers),
        "method" => "POST",
        "content" => json_encode($data)
    )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    // Handle error
    $emailContent = "Error generating email.";
} else {
    $response = json_decode($result, true);
    $emailContent = $response['choices'][0]['text'];
}

// Return the generated email content as JSON response
$response = array("email" => $emailContent);
echo json_encode($response);
?>
