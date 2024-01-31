<?php
require 'vendor/autoload.php';

use Google\Cloud\Scheduler\V1\HttpTarget;
use Google\Cloud\Scheduler\V1\CloudSchedulerClient;
use Google\Cloud\Scheduler\V1\Job;
use Google\Cloud\Scheduler\V1\Job\State;

$client = new CloudSchedulerClient();
$projectId = 'livelearn-359911';
$location = 'livelearn.nl';
$parent = CloudSchedulerClient::locationName($projectId, $location);
$job = new Job([
    'name' => CloudSchedulerClient::jobName(
        $projectId,
        $location,
        uniqid()
    ),
    'http_target' => new HttpTarget([
        "uri" => "livelearn.nl/wp-json/custom/v1/databank"
    ]),
    'schedule' => '* * * * *'
]);
$client->createJob($parent, $job);
?>