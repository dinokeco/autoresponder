<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/api/clients/CDNClient.class.php';
/*
use Aws\S3\S3Client;

$client = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'fra1',
    'endpoint' => 'https://fra1.digitaloceanspaces.com',
    'credentials' => [
        'key'    => "VYJLMBH2TCW42KZ4ABZA",
        'secret' => "A2Aw9R3nV/Iyu6xvsJcEdbMlxIHlFaY8xC20OZrOlIs",
    ],
]);

/*
$response = $client->createBucket([
    'Bucket' => 'web-ibu-123456',
]);
print_r($response);

$spaces = $client->listBuckets();
foreach ($spaces['Buckets'] as $space){
    echo $space['Name']."\n";
}
$response = $client->putObject([
    'Bucket' => 'cdn.biznet.ba',
    'Key'    => 'teslabinary4.jpg',
    'Body'   => $image_content,
    'ACL'    => 'public-read'
]);

*/
$image_content = file_get_contents('C:\Users\Dino Keco\Desktop\Tesla.jpg');
//print_r(base64_encode($image_content));


$client = new CDNClient();
$url = $client->upload("teslabinary5.jpg", base64_encode($image_content));
print_r($url);

?>
