<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

use App\Models\Product;
use App\Models\Category;

echo "=== Categories ===\n";
echo "Total: " . Category::count() . "\n";
foreach (Category::all() as $c) {
    echo "- {$c->name} (slug: {$c->slug})\n";
}

echo "\n=== Products ===\n";
echo "Total: " . Product::count() . "\n";
foreach (Product::all() as $p) {
    echo "- {$p->name} (price: {$p->price}, category_id: {$p->category_id})\n";
}
