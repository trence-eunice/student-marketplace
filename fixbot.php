<?php
$file = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    'if (m.includes("hi") || m.includes("hello") || m.includes("hey"))
        return "Hi there! 👋 I am the StudentMarket assistant. Ask me anything about orders, payment, or selling!";',
    'if (m === "hi" || m === "hello" || m === "hey" || m.startsWith("hi ") || m.startsWith("hello ") || m.startsWith("hey "))
        return "Hi there! 👋 I am the StudentMarket assistant. Ask me anything about orders, payment, or selling!";',
    $content
);

file_put_contents($file, $content);
echo "Done!\n";
