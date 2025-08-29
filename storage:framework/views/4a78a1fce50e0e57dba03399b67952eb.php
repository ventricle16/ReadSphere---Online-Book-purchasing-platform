<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ReadSphere • Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    :root{
        --sky: #87CEEB;
        --panel: #ffffff;
        --text: #1f2937;
        --muted: #6b7280;
        --brand: #1f3a93;
        --pill: #e8f0ff;
        --shadow: 0 10px 30px rgba(0,0,0,.10);
        --radius: 16px;
    }
    html,body{
        margin:0; padding:0; height:100%;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
        background: var(--sky);
        color: var(--text);
    }
    .canvas{
        width:1280px; height:720px;
        margin:24px auto;
        background: var(--panel);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow:hidden;
        display:grid;
        grid-template-columns: 250px 1fr;
        grid-template-rows: 64px 1fr;
        grid-template-areas:
            "sidebar header"
            "sidebar main";
    }
    .header{
        grid-area: header;
        display:flex; align-items:center; gap:20px;
        padding: 0 24px;
        background: linear-gradient(180deg, #f7fbff 0%, #ffffff 100%);
        border-bottom: 1px solid #eef2f7;
    }
    .brand{
        font-weight: 800;
        font-size: 26px;
        color: var(--brand);
        letter-spacing: .2px;
    }
    .search{
        flex:1;
        display:flex;
        align-items:center;
        gap:10px;
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius: 999px;
        padding: 10px 16px;
    }
    .search input{
        border:none; outline:none; width:100%;
        font-size: 14px; color: var(--text);
        background: transparent;
    }
    .search button{
        border:none; background: var(--brand); color:#fff;
        padding:8px 14px; border-radius: 999px; cursor:pointer;
        font-weight:600;
    }
    .sidebar{
        grid-area: sidebar;
        background: #f2f9ff;
        border-right: 1px solid #e6eef7;
        padding: 18px;
        display:flex; flex-direction:column; gap:8px;
    }
    .nav-title{
        font-weight:700; color:#111827; margin:8px 8px 14px;
        display:flex; align-items:center; gap:8px;
    }
    .nav a{
        display:flex; align-items:center; gap:10px;
        text-decoration:none;
        color:#111827;
        padding:12px 14px;
        border-radius:12px;
        font-weight:600;
    }
    .nav a:hover{ background:#e9f2ff; }
    .nav a.active{ background: var(--pill); color: var(--brand); }
    .main{
        grid-area: main;
        padding: 20px 24px 24px;
        overflow:auto;
    }
    .tabs{
        display:flex; gap:10px; margin-bottom:18px;
    }
    .pill{ background:#eef3ff; color:#243b79; padding:8px 14px; border-radius:999px; font-weight:700; font-size:13px; }
    .pill.active{ background: var(--brand); color:#fff; }
    .grid{
        display:grid;
        grid-template-columns: repeat(6, 1fr);
        gap:16px;
    }
    .card{
        background:#fff; border:1px solid #eef2f7;
        border-radius:14px; overflow:hidden; box-shadow: var(--shadow);
        display:flex; flex-direction:column;
    }
    .card img{
        width:100%; aspect-ratio: 3/4; object-fit: cover; display:block;
    }
    .card .meta{
        padding:10px 12px 12px;
    }
    .title{ font-weight:700; font-size:14px; line-height:1.25; margin-bottom:4px; }
    .author{ font-size:12px; color: var(--muted); }
</style>
</head>
<body>

<div class="canvas">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="nav-title">Menu</div>
        <nav class="nav">
            <a href="<?php echo e(route('books.index')); ?>" class="<?php echo e(request()->routeIs('books.index') ? 'active' : ''); ?>">📚 Books</a>
            <a href="<?php echo e(route('profile')); ?>" class="<?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">👤 View Profile</a>
            <a href="<?php echo e(route('admin.books.create')); ?>" class="<?php echo e(request()->routeIs('admin.books.create') ? 'active' : ''); ?>">🗂️ My Uploads</a>
            <a href="<?php echo e(route('wishlist')); ?>" class="<?php echo e(request()->routeIs('wishlist') ? 'active' : ''); ?>">❤️ My Wishlist</a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders.index') ? 'active' : ''); ?>">📦 Manage Order</a>  

            <!-- ⭐ Ratings Filter -->
            <div class="ratings-filter" style="margin-top: 16px; padding: 12px; background:#fff; border-radius:12px; border:1px solid #e5e7eb;">
                <div class="ratings-header" 
                     style="font-weight: 600; margin-bottom: 10px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;"
                     onclick="toggleRatingsFilter()">
                    Ratings <span id="ratings-arrow" style="font-size:14px;">▾</span>
                </div>
                <div id="ratings-options" style="display:flex; flex-direction:column; gap:6px;">
                    <?php for($i=5; $i>=1; $i--): ?>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                            <input type="checkbox" 
                                   onclick="window.location='<?php echo e(route('dashboard', ['ratings' => $i] + request()->except('ratings'))); ?>'" 
                                   <?php echo e(request('ratings') == $i ? 'checked' : ''); ?>>
                            <span style="color: #f59e0b; font-size: 16px;">
                                <?php for($j=1; $j<=$i; $j++): ?> ⭐ <?php endfor; ?>
                            </span>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
            </form>
        </nav>
        <div class="footer">Contact Us <?php echo e('admin@readsphere.com'); ?></div>
        <div class="footer">ReadSphere © <?php echo e(date('Y')); ?></div>
    </aside>

    <!-- Header -->
    <header class="header">
        <div class="brand">ReadSphere</div>
        <form class="search" method="GET" action="<?php echo e(route('dashboard')); ?>">
            <input type="text" name="q" placeholder="Search books, authors…" value="<?php echo e($q ?? ''); ?>">
            <button type="submit">Search</button>
        </form>
        
        <!-- Cart Button -->
        <a href="<?php echo e(route('cart')); ?>" class="cart-btn" style="
            background: linear-gradient(135deg, #007AFF 0%, #0056CC 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
            position: relative;
        ">
            🛒 Cart
            <?php if(auth()->guard()->check()): ?>
                <?php
                    $cart = Auth::user()->cart;
                    $itemCount = $cart ? $cart->item_count : 0;
                ?>
                <?php if($itemCount > 0): ?>
                    <span class="cart-badge" style="
                        background: #FF3B30;
                        color: white;
                        border-radius: 50%;
                        width: 20px;
                        height: 20px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 12px;
                        font-weight: 700;
                        position: absolute;
                        top: -5px;
                        right: -5px;
                    "><?php echo e($itemCount); ?></span>
                <?php endif; ?>
            <?php endif; ?>
        </a>

    </header>

    <!-- Main -->
<main class="main">
    

        <!-- Category Filter -->
        <div style="margin-bottom: 18px;">
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <span style="font-weight: 600; color: var(--text);">Filter by Category:</span>
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="pill <?php echo e(!request('category') ? 'active' : ''); ?>" 
                   style="text-decoration: none; cursor: pointer;">
                    All
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('dashboard', ['category' => $category->id] + request()->except('category'))); ?>" 
                       class="pill <?php echo e(request('category') == $category->id ? 'active' : ''); ?>" 
                       style="text-decoration: none; cursor: pointer;">
                        <?php echo e($category->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <?php if(($q ?? '') !== ''): ?>
            <p class="muted" style="margin-bottom:12px;">Showing results for: <strong><?php echo e($q); ?></strong></p>
        <?php endif; ?>

        <?php if(request('category')): ?>
            <p class="muted" style="margin-bottom:12px;">Filtered by category: <strong><?php echo e($categories->firstWhere('id', request('category'))->name ?? ''); ?></strong></p>
        <?php endif; ?>

        <?php if(request('ratings')): ?>
            <p class="muted" style="margin-bottom:12px;">Filtered by ratings: <strong><?php echo e(request('ratings')); ?> stars</strong></p>
        <?php endif; ?>


        <section class="grid">
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="card">
                    <!-- Clickable book details area -->
                    <a href="<?php echo e(route('books.show', $book->id)); ?>" style="text-decoration: none; color: inherit; display: block;">
<img src="<?php echo e($book->cover_url ?? 'https://placehold.co/300x400?text=No+Cover'); ?>" alt="<?php echo e($book->title); ?>">

                        <div class="meta">
                            <div class="title" title="<?php echo e($book->title); ?>"><?php echo e(\Illuminate\Support\Str::limit($book->title, 28)); ?></div>
                            <div class="author"><?php echo e($book->author); ?></div>
                            <?php if($book->category): ?>
                                <div class="author" style="color: var(--brand); font-size: 11px;"><?php echo e($book->category->name); ?></div>
                            <?php endif; ?>
                            <div class="author" style="font-size: 12px; color: #f59e0b;">⭐ <?php echo e($book->rating ?? 'N/A'); ?></div>
                            <div class="price" style="font-weight: 700; color: #22c55e; margin: 8px 0; font-size: 14px;">
                               $<?php echo e(number_format($book->price, 2)); ?>

                           </div>
                        </div>
                    </a>
                    
                    <!-- Add to Cart Form (outside the link to remain functional) -->
                    <form method="POST" action="<?php echo e(route('cart.add', $book->id)); ?>" style="margin: 10px 12px 12px;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn" style="
                            background: linear-gradient(135deg, #007AFF 0%, #0056CC 100%);
                            color: white;
                            border: none;
                            padding: 10px 16px;
                            border-radius: 8px;
                            width: 100%;
                            font-weight: 600;
                            font-size: 13px;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            box-shadow: 0 2px 8px rgba(0, 122, 255, 0.3);
                        " onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(0, 122, 255, 0.4)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0, 122, 255, 0.3)';">
                            🛒 Add to Cart
                        </button>
                    </form>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No books found.</p>
            <?php endif; ?>
        </section>
        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo e($books->previousPageUrl()); ?>" style="font-size: 12px; padding: 5px 10px; cursor: pointer;">« Previous</a>
            <a href="<?php echo e($books->nextPageUrl()); ?>" style="font-size: 12px; padding: 5px 10px; cursor: pointer;">Next »</a>
        </div>



        <!-- Pagination -->
        <div style="margin-top: 20px;">
        </div>
    </main>
</div>

<!-- Script for collapsible ratings -->
<script>
function toggleRatingsFilter() {
    const options = document.getElementById('ratings-options');
    const arrow = document.getElementById('ratings-arrow');
    if (options.style.display === 'none') {
        options.style.display = 'flex';
        arrow.textContent = '▾';
    } else {
        options.style.display = 'none';
        arrow.textContent = '▸';
    }
}
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\readsphere\resources\views/dashboard.blade.php ENDPATH**/ ?>