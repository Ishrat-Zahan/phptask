<?php

$apiDocumentation = [
    'Method' => 'Post',
    'Data' => [
        "user_id" => 1,
        "product_id" => 1,
        "review_text" =>  "Good Product"
    ]
];


$prettyJson = json_encode($apiDocumentation, JSON_PRETTY_PRINT);

$prettyJson = nl2br($prettyJson);
echo $prettyJson;
