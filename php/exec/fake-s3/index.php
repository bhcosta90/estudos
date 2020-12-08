<?php
include "vendor/autoload.php";

use Aws\S3\S3Client;
// use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;

$s3 = new S3Client(array(
    'version' => 'latest',
    'region'  => 'us-east-1',
    'endpoint' => 'http://fakes3:4569',
    'credentials' => [
        'key' => '',
        'secret' => ''
    ]
));

// $bucket = $s3->createBucket(array(
// 	'Bucket' => 'images'
// ));

$size = getimagesize(__DIR__ . "/img/84179_index_gg.jpg");

$key = 123456;

// $s3->putObject(array(
//     'Bucket'       => "s3",
//     'Key'          => $key . ".jpg",
//     'SourceFile'   => __DIR__ . "/img/84179_index_gg.jpg",
//     'ContentType'  => $size['mime'],
//     'ACL'          => 'public-read',
//     'StorageClass' => 'REDUCED_REDUNDANCY'
// ));

print "<img src='http://localhost:4569/fakes3/s3/$key.jpg' />";//*/

try {
    $results = $s3->getPaginator('ListObjects', [
        'Bucket' => 's3'
    ]);

    foreach ($results as $result) {
        foreach ($result['Contents'] as $object) {
            echo $object['Key'] . PHP_EOL;
        }
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

/*$s3->deleteObject(array(
    'Bucket' => "s3",
    'Key'    => $key . ".jpg"
));//*/

?>
