<?php

use Configuration;
use Api\SmsApi;
use SmsDestination;
use SmsTextualMessage;
use SmsAdvancedTextualRequest;
use Twilio\Rest\Client;

require __DIR__ . "autoload.php";

$number = $_POST["number"];
$message = $_POST["message"];

if ($_POST["provider"] === "infobip") {

    $base_url = "https://nmrx58.api.infobip.com";
    $api_key = "2771b41286282bbbf5ec459e685316a9-e78bf9c7-7f87-461c-b76c-82c1e3121f12";

    $configuration = new Configuration(host: $base_url, apiKey: $api_key);

    $api = new SmsApi(config: $configuration);

    $destination = new SmsDestination(to: $number);

    $message = new SmsTextualMessage(
        destinations: [$destination],
        text: $message,
        from: "Edakho Tv"
    );

    $request = new SmsAdvancedTextualRequest(messages: [$message]);

    $response = $api->sendSmsMessage($request);

} else {   // Twilio

    $account_id = "your account SID";
    $auth_token = "your auth token";

    $client = new Client($account_id, $auth_token);

    $twilio_number = "+ your outgoing Twilio phone number";

    $client->messages->create(
        $number,
        [
            "from" => $twilio_number,
            "body" => $message
        ]
    );

}

echo "Message sent.";

?>
