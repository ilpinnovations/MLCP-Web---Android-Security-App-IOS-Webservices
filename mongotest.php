<?php
$connection = new MongoClient();
$db=$connection->test;
$student_collection=$db->student;
$doc=array(
"name"=>"Omkar Tarale",
"age"=>22
);
$student_collection->insert($doc);
?>