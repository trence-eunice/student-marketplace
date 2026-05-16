<?php
$file = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    'function getBotReply(msg) {
    var m = msg.toLowerCase().trim();
        return "Hi there! 👋 I am the StudentMarket assistant. How can I help you today?";',
    'function getBotReply(msg) {
    var m = msg.toLowerCase().trim();
    if (m === "hi" || m === "hello" || m === "hey" || m === "hi!" || m === "hello!" || m === "hey!")
        return "Hi there! 👋 I am the StudentMarket assistant. How can I help you today?";',
    $content
);

file_put_contents($file, $content);
echo "Done!\n";
