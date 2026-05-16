<?php
$file = 'resources/views/layouts/app.blade.php';
$lines = file($file);

foreach ($lines as $i => $line) {
    if (trim($line) === 'return "Hi there! 👋 I am the StudentMarket assistant. How can I help you today?";') {
        $lines[$i] = '    if (m === "hi" || m === "hello" || m === "hey" || m === "hi!" || m === "hello!")' . "\n" .
                     '        return "Hi there! 👋 I am the StudentMarket assistant. How can I help you today?";' . "\n";
        break;
    }
}

file_put_contents($file, implode('', $lines));
echo "Done!\n";
