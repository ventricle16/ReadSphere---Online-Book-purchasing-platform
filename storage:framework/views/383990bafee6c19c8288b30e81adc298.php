<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ReadSphere • My Wishlist</title>
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
        --danger: #ef4444;
        --success: #10b981;
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
        transition: all 0.3s ease;
    }
    .card:hover{
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0,0,0,.15);
    }
    .card img{
        width:100%; aspect-ratio: 3/4; object-fit: cover; display:block;
    }
    .card .meta{
        padding:12px 14px 14px;
    }
    .title{ font-weight:700; font-size:14px; line-height:1.25; margin-bottom:4px; }
    .author{ font-size:12px; color: var(--muted); margin-bottom:6px; }
    .price{ font-weight: 700; color: #22c55e; margin: 8px 0; font-size: 14px; }
    .rating{ font-size: 12px; color: #f59e0b; margin-bottom: 8px; }
   
    .card-actions{
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }
   
    .action-row{
        display: flex;
        gap: 8px;
        justify-content: space-between;
    }
   
    .remove-action{
        margin-top: 8px;
    }
   
    .btn{
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
   
    .btn-primary{
        background: linear-gradient(135deg, #007AFF 0%, #0056CC 100%);
        color: white;
        flex: 1;
    }
   
.btn-danger{
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 600;
}
   
    .btn:hover{
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
   
    .empty-state{
        text-align: center;
        padding: 60px 20px;
        color: var(--muted);
    }
   
    .empty-state h3{
        font-size: 18px;
        margin-bottom: 8px;
        color: var(--text);
    }
   
    .empty-state p{
        font-size: 14px;
        margin-bottom: 20px;
    }
   
    .wishlist-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
   
    .wishlist-title{
        font-size: 24px;
        font-weight: 700;
        color: var(--text);
    }
   
    .wishlist-count{
        background: var(--pill);
        color: var(--brand);
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
    }
</style>
</head>
<body>


<div class="canvas">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="nav-title">Menu</div>
        <nav class="nav">
            <a href="<?php echo e(route('books.index')); ?>" class="<?php echo e(request()->routeIs('books.index') ? 'active' : ''); ?>">📚 Books</a>
            <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">🏠 Dashboard</a>
            <a href="<?php echo e(route('profile')); ?>" class="<?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">👤 View Profile</a>
            <a href="<?php echo e(route('wishlist')); ?>" class="<?php echo e(request()->routeIs('wishlist') ? 'active' : ''); ?>">❤️ My Wishlist</a>
            <a href="<?php echo e(route('admin.books.create')); ?>" class="<?php echo e(request()->routeIs('admin.books.create') ? 'active' : ''); ?>">🗂️ My Uploads</a>
            <a href="<?php echo e(route('cart')); ?>" class="<?php echo e(request()->routeIs('cart') ? 'active' : ''); ?>">🛒 Shopping Cart</a>


            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
            </form>
        </nav>
        <div class="footer">ReadSphere © <?php echo e(date('Y')); ?></div>
    </aside>


    <!-- Header -->
    <header class="header">
        <div class="brand">ReadSphere</div>
        <form class="search" method="GET" action="<?php echo e(route('wishlist')); ?>">
            <input type="text" name="q" placeholder="Search your wishlist…" value="<?php echo e($q ?? ''); ?>">
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
        <div class="wishlist-header">
            <h1 class="wishlist-title">My Wishlist</h1>
            <span class="wishlist-count"><?php echo e($books->count()); ?> items</span>
        </div>


        <?php if(session('success')): ?>
            <div style="
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                padding: 12px 16px;
                border-radius: 12px;
                margin-bottom: 20px;
                font-weight: 600;
            ">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>


        <?php if(session('error')): ?>
            <div style="
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                color: white;
                padding: 12px 16px;
                border-radius: 12px;
                margin-bottom: 20px;
                font-weight: 600;
            ">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>


        <?php if(($q ?? '') !== ''): ?>
            <p style="margin-bottom:20px; color: var(--muted);">
                Showing results for: <strong><?php echo e($q); ?></strong>
            </p>
        <?php endif; ?>


        <?php if($books->count() > 0): ?>
            <section class="grid">
                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card">
                        <img src="<?php echo e($book->cover_image ?? 'https://placehold.co/300x400?text=No+Cover'); ?>" alt="<?php echo e($book->title); ?>">
                        <div class="meta">
                            <div class="title" title="<?php echo e($book->title); ?>"><?php echo e(\Illuminate\Support\Str::limit($book->title, 28)); ?></div>
                            <div class="author"><?php echo e($book->author); ?></div>
                           
                            <?php if($book->category): ?>
                                <div class="author" style="color: var(--brand); font-size: 11px;"><?php echo e($book->category->name); ?></div>
                            <?php endif; ?>
                           
                            <?php if($book->rating): ?>
                                <div class="rating">⭐ <?php echo e($book->rating); ?></div>
                            <?php endif; ?>
                           
                            <?php if($book->price): ?>
                                <div class="price">$<?php echo e(number_format($book->price, 2)); ?></div>
                            <?php endif; ?>


                            <div class="card-actions">
                                <div class="action-row">
                                    <a href="<?php echo e(route('books.show', $book->id)); ?>" class="btn btn-primary">
                                        View Details
                                    </a>
                                   
                                    <?php if($book->price): ?>
                                        <!-- Add to Cart Form -->
                                        <form method="POST" action="<?php echo e(route('cart.add', $book->id)); ?>" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn" style="
                                                background: linear-gradient(135deg, #007AFF 0%, #0056CC 100%);
                                                color: white;
                                                border: none;
                                                padding: 8px 12px;
                                                border-radius: 8px;
                                                font-weight: 600;
                                                font-size: 12px;
                                                cursor: pointer;
                                                transition: all 0.2s ease;
                                            " onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(0, 122, 255, 0.4)';"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                                🛒 Add to Cart
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn" style="
                                            background: #6b7280;
                                            color: white;
                                            border: none;
                                            padding: 8px 12px;
                                            border-radius: 8px;
                                            font-weight: 600;
                                            font-size: 12px;
                                            cursor: not-allowed;
                                            opacity: 0.6;
                                        " title="Price not available">
                                            ❌ No Price
                                        </button>
                                    <?php endif; ?>
                                </div>
                               
                                <!-- Remove from wishlist - Now on separate line -->
                                <div class="remove-action">
                                    <form action="<?php echo e(route('wishlist.remove', $book->id)); ?>" method="POST" style="display:block; margin-top: 8px;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this from your wishlist?')" style="width: 100%;">
                                          Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </section>
        <?php else: ?>
            <div class="empty-state">
                <h3>Your wishlist is empty</h3>
                <p>Start adding books you love to your wishlist!</p>
                <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary" style="padding: 12px 24px;">
                    Browse Books
                </a>
            </div>
        <?php endif; ?>
    </main>
</div>


<script>
// Simple confirmation for remove actions
function confirmRemove() {
    return confirm('Are you sure you want to remove this from your wishlist?');
}
</script>


</body>
</html>



<?php /**PATH C:\xampp\htdocs\readsphere\resources\views/wishlist.blade.php ENDPATH**/ ?>