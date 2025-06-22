<?php
function randomDate(string $start_date, string $end_date): string {
    $min = strtotime($start_date);
    $max = strtotime($end_date);
    $val = rand($min, $max);
    return date('Y-m-d H:i:s', $val);
}

$numberOfPosts = 3000;
$posts = [];

for ($i = 1; $i <= $numberOfPosts; $i++) {
    $posts[] = [
        'id' => $i,
        'created_at' => randomDate('2023-01-01', '2025-06-20'),
        'title' => "Заголовок поста #$i",
        'content' => "Это содержимое поста номер $i.",
        'hotness' => rand(1, 1000),
        'views_count' => rand(0, 1000),
    ];
}

$fileContent = "<?php\n\nreturn " . var_export($posts, true) . ";\n";
file_put_contents(__DIR__ . '/posts.php', $fileContent);

echo "Файл posts.php с $numberOfPosts постами успешно создан.\n";
