<?php

session_start();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Method not allowed."
    ]);

    exit;
}


// Load OpenAI API key from the server
$config = require "/etc/healthbridge/openai.php";

$apiKey = $config["api_key"] ?? "";

if ($apiKey === "") {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "OpenAI API configuration is missing."
    ]);

    exit;
}


// Read JSON sent from JavaScript
$input = json_decode(
    file_get_contents("php://input"),
    true
);

$message = trim($input["message"] ?? "");


// Validate message
if ($message === "") {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Please enter a message."
    ]);

    exit;
}


if (strlen($message) > 1000) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Your message is too long."
    ]);

    exit;
}


// HealthBridge chatbot instructions
$instructions = <<<TEXT

You are the HealthBridge Medical Assistant for a mock educational healthcare website.

HealthBridge Medical is not a real healthcare provider.

Your job is to help visitors understand the HealthBridge Medical website.

You may help users with:

- HealthBridge services
- Membership plans
- Office hours
- Scheduling appointments
- Cancelling appointments
- Registration
- Login
- Password reset
- Patient dashboard
- Contact and support information
- Privacy policy
- Terms and conditions
- Accessibility
- General website navigation

Membership plans:

Essential:
$39 per month
$30 primary care visit fee
$25 virtual visit fee

Plus:
$79 per month
$20 primary care visit fee
$10 virtual visit fee

Premier:
$149 per month
$0 routine primary care visit fee
$0 virtual visit fee

Office hours:

Monday through Friday: 8:00 AM to 5:00 PM
Saturday: 9:00 AM to 1:00 PM
Sunday: Closed

Important safety rules:

Do not diagnose medical conditions.

Do not recommend medications, dosages, or medical treatments.

Do not claim to be a doctor or medical professional.

Do not ask users for passwords, payment card information, Social Security numbers, or sensitive medical information.

If someone describes a medical emergency or potentially life-threatening situation, clearly tell them not to rely on this chatbot and to contact emergency services such as 911 in the United States or their local emergency number.

If someone asks for medical advice, explain that you can provide information about the HealthBridge website but cannot provide medical diagnosis or treatment advice.

Keep responses friendly, concise, and easy to understand.

TEXT;


// Build request for OpenAI Responses API
$requestData = [
    "model" => "gpt-5.4",
    "instructions" => $instructions,
    "input" => $message,
    "max_output_tokens" => 300
];


$ch = curl_init(
    "https://api.openai.com/v1/responses"
);

curl_setopt_array($ch, [

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_POST => true,

    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $apiKey,
        "Content-Type: application/json"
    ],

    CURLOPT_POSTFIELDS => json_encode($requestData),

    CURLOPT_TIMEOUT => 30

]);


$response = curl_exec($ch);

$curlError = curl_error($ch);

$statusCode = curl_getinfo(
    $ch,
    CURLINFO_HTTP_CODE
);

curl_close($ch);


// Handle connection failure
if ($response === false) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Unable to connect to the AI service."
    ]);

    exit;
}


$data = json_decode(
    $response,
    true
);


// Handle OpenAI API error
if (
    $statusCode < 200 ||
    $statusCode >= 300
) {

    error_log(
        "OpenAI API error: " .
        $statusCode .
        " " .
        $response
    );

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "The HealthBridge Assistant is temporarily unavailable."
    ]);

    exit;
}


// Extract assistant text
$assistantReply = "";

if (isset($data["output"])) {

    foreach ($data["output"] as $outputItem) {

        if (
            isset($outputItem["content"]) &&
            is_array($outputItem["content"])
        ) {

            foreach ($outputItem["content"] as $contentItem) {

                if (
                    ($contentItem["type"] ?? "") === "output_text" &&
                    isset($contentItem["text"])
                ) {

                    $assistantReply .= $contentItem["text"];

                }
            }
        }
    }
}


if ($assistantReply === "") {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "The assistant did not return a response."
    ]);

    exit;
}


// Send safe response back to JavaScript
echo json_encode([
    "success" => true,
    "reply" => $assistantReply
]);
