<?php

$pdo = new \PDO("mysql:host=localhost;dbname=estudy;charset=utf8", 'root', '');
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$topic_id = 1;

$sql = "
SELECT
    vocabulary.english,
    vocabulary.description,
    topic.title
FROM
    (
        (
            topic_vocabulary
        INNER JOIN topic ON topic_vocabulary.topic_id = topic.id
        )
    INNER JOIN vocabulary ON topic_vocabulary.vocabulary_id = vocabulary.id
    )
WHERE
    topic.id = $topic_id
";

$query = $pdo->query($sql);
$query->execute();

$results = $query->fetchAll();

print_r($results);
