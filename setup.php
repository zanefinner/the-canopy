<?php 
$init = array(
    "createUser", 
    "seedUser",
    "createRudimentaryStrainTable",
    "seedStrains",
    "createPosts",
    "seedPosts"
);
foreach ($init as $fileName) {
    include 'mysql/'.$fileName.'.php'; // or require $fileName;
};