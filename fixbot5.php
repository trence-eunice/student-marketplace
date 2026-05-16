<?php
$file = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    'if ((m.includes("order") || m.includes("buy") || m.includes("purchase")) && (m.includes("how") || m.includes("place") || m.includes("make")))
        return "To place an order: Browse products → click a product → set quantity → Add to Cart → Proceed to Checkout → enter address → choose payment → confirm. Done! 🎉";',
    'if ((m.includes("place") && m.includes("order")) || (m.includes("how") && (m.includes("buy") || m.includes("purchase") || m.includes("order a product"))) || m.includes("add to cart"))
        return "To place an order: Browse products → click a product → set quantity → Add to Cart → Proceed to Checkout → enter address → choose payment → confirm. Done! 🎉";',
    $content
);

file_put_contents($file, $content);
echo "Done!\n";
