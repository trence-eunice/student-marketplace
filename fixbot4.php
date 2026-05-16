<?php
$file = 'resources/views/layouts/app.blade.php';
$lines = file($file);

// Find start and end of getBotReply function
$start = $end = null;
foreach ($lines as $i => $line) {
    if (strpos($line, 'function getBotReply') !== false) $start = $i;
    if ($start !== null && $i > $start && trim($line) === '}') {
        $end = $i;
        break;
    }
}

$newFunction = <<<'JS'
function getBotReply(msg) {
    var m = msg.toLowerCase().trim();

    if (m === "hi" || m === "hello" || m === "hey" || m === "hi!" || m === "hello!")
        return "Hi there! 👋 I am the StudentMarket assistant. How can I help you today?";

    if (m.includes("thank"))
        return "You are welcome! 😊 Let me know if you have other questions.";

    if ((m.includes("contact") || m.includes("message") || m.includes("chat")) && m.includes("seller"))
        return "You can message a seller! Go to My Orders, find the order, and click Message Seller. Check your Messages inbox in the sidebar too. 💬";

    if ((m.includes("order") || m.includes("buy") || m.includes("purchase")) && (m.includes("how") || m.includes("place") || m.includes("make")))
        return "To place an order: Browse products → click a product → set quantity → Add to Cart → Proceed to Checkout → enter address → choose payment → confirm. Done! 🎉";

    if (m.includes("gcash") || m.includes("cod") || m.includes("cash on delivery") || (m.includes("payment") && (m.includes("method") || m.includes("how") || m.includes("what"))) || (m.includes("how") && m.includes("pay")))
        return "We support two payment methods: 💛 GCash - pay and enter your reference number. 💵 Cash on Delivery (COD) - pay cash when your order arrives. Both available at checkout!";

    if ((m.includes("track") || m.includes("where") || m.includes("status")) && (m.includes("order") || m.includes("package")))
        return "To track your order: go to My Orders in the sidebar. Each order shows its status - Pending, Processing, Shipped, or Delivered. The seller updates it as your order progresses.";

    if (m.includes("cancel") && m.includes("order"))
        return "To cancel: go to My Orders and click Cancel Order on a Pending order. You can only cancel Pending orders - once Processing or Shipped, cancellation is no longer available.";

    if (m.includes("cart") || (m.includes("add") && m.includes("item")))
        return "To manage your cart: click the cart icon in the top bar. You can remove items or proceed to checkout. The badge shows how many items you have.";

    if ((m.includes("add") && m.includes("product")) || (m.includes("how") && m.includes("sell")) || m.includes("list a product"))
        return "To add a product: log in as Seller → go to My Listings → click Add Product → fill in title, description, price, stock → upload image → Save. Your product goes live immediately!";

    if (m.includes("register") || m.includes("sign up") || m.includes("create account"))
        return "To register: click Sign Up on the homepage → enter name, email, password → choose Buyer or Seller role → submit. You are in! 🎓";

    if (m.includes("refund") || m.includes("return") || m.includes("money back"))
        return "For refunds: cancel your Pending order from My Orders. For delivered orders, message the seller through Messages or contact your school admin.";

    if (m.includes("stock") || m.includes("out of stock") || (m.includes("available") && m.includes("product")))
        return "Stock is shown on each product page. If Out of Stock you cannot add it to cart. Sellers update stock regularly so check back soon!";

    if (m.includes("message") || m.includes("inbox"))
        return "You can message sellers about your orders! Go to My Orders → click Message Seller. Your full inbox is in the Messages section of the sidebar. 💬";

    if (m.includes("checkout") || m.includes("check out"))
        return "To checkout: go to Cart → Proceed to Checkout → enter shipping address → choose GCash or COD → confirm. You will be redirected to My Orders after!";

    if (m.includes("ship") || m.includes("deliver") || m.includes("address"))
        return "Enter your shipping address at checkout. The seller updates your order to Shipped once dispatched. Track it under My Orders.";

    if (m.includes("hi") || m.includes("hello") || m.includes("hey"))
        return "Hi there! 👋 I am the StudentMarket assistant. Ask me anything about orders, payment, or selling!";

    return "I am not sure about that. Try asking about: placing an order, payment methods, tracking orders, messaging a seller, cancelling an order, or adding a product. 😊";
}

JS;

array_splice($lines, $start, $end - $start + 1, [$newFunction]);
file_put_contents($file, implode('', $lines));
echo "Done! Replaced lines " . ($start+1) . " to " . ($end+1) . "\n";
