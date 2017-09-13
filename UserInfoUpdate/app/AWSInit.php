<?php
require ('vendor/autoload.php');

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;

$sdk = new Aws\Sdk([
    'region'   => 'us-west-2',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();

$params = [
    'TableName' => 'Users',
    'KeySchema' => [
        [
            'AttributeName' => 'name',
            'KeyType' => 'HASH'  //Partition key
        ]
    ],
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'name',
            'AttributeType' => 'S'
        ]
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 10,
        'WriteCapacityUnits' => 10
    ]
];

try {
    $result = $dynamodb->createTable($params);
    echo 'Created table.  Status: ' . 
        $result['TableDescription']['TableStatus'] ."\n";

} catch (DynamoDbException $e) {
    echo "Unable to create table:\n";
    echo $e->getMessage() . "\n";
}


