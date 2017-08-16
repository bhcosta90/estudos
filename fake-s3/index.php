<?php
include "vendor/autoload.php";

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;

$s3 = S3Client::factory(array(
    'version' => 'latest',
    'region'  => '',
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

$s3->putObject(array(
    'Bucket'       => "s3",
    'Key'          => $imagem = time() . ".jpg",
    'SourceFile'   => __DIR__ . "/img/84179_index_gg.jpg",
    'ContentType'  => $size['mime'],
    'ACL'          => 'public-read',
    'StorageClass' => 'REDUCED_REDUNDANCY'
));

print "<img src='http://s3.fakes3:4569/$imagem' />";
// exit;

try {
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => ''
    ));

    echo "Keys retrieved!\n";
    print "<pre>";
    foreach ($objects as $object) {
        echo "<br>";
        print_r($object);
    }
    print "</pre>";
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

?>
