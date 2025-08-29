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
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.index') ? 'active' : '' }}">📚 Books</a>
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">👤 View Profile</a>
            <a href="{{ route('admin.books.create') }}" class="{{ request()->routeIs('admin.books.create') ? 'active' : '' }}">🗂️ My Uploads</a>
            <a href="{{ route('wishlist') }}" class="{{ request()->routeIs('wishlist') ? 'active' : '' }}">❤️ My Wishlist</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">📦 Manage Order</a>  

            <!-- ⭐ Ratings Filter -->
            <div class="ratings-filter" style="margin-top: 16px; padding: 12px; background:#fff; border-radius:12px; border:1px solid #e5e7eb;">
                <div class="ratings-header" 
                     style="font-weight: 600; margin-bottom: 10px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;"
                     onclick="toggleRatingsFilter()">
                    Ratings <span id="ratings-arrow" style="font-size:14px;">▾</span>
                </div>
                <div id="ratings-options" style="display:flex; flex-direction:column; gap:6px;">
                    @for($i=5; $i>=1; $i--)
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                            <input type="checkbox" 
                                   onclick="window.location='{{ route('dashboard', ['ratings' => $i] + request()->except('ratings')) }}'" 
                                   {{ request('ratings') == $i ? 'checked' : '' }}>
                            <span style="color: #f59e0b; font-size: 16px;">
                                @for($j=1; $j<=$i; $j++) ⭐ @endfor
                            </span>
                        </label>
                    @endfor
                </div>
            </div>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
        </nav>
        <div class="footer">Contact Us {{ 'admin@readsphere.com'}}</div>
        <div class="footer">ReadSphere © {{ date('Y') }}</div>
    </aside>

    <!-- Header -->
    <header class="header">
        <div class="brand">ReadSphere</div>
        <form class="search" method="GET" action="{{ route('dashboard') }}">
            <input type="text" name="q" placeholder="Search books, authors…" value="{{ $q ?? '' }}">
            <button type="submit">Search</button>
        </form>
        
        <!-- Cart Button -->
        <a href="{{ route('cart') }}" class="cart-btn" style="
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
            @auth
                @php
                    $cart = Auth::user()->cart;
                    $itemCount = $cart ? $cart->item_count : 0;
                @endphp
                @if($itemCount > 0)
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
                    ">{{ $itemCount }}</span>
                @endif
            @endauth
        </a>

    </header>

    <!-- Main -->
<main class="main">
    

        <!-- Category Filter -->
        <div style="margin-bottom: 18px;">
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <span style="font-weight: 600; color: var(--text);">Filter by Category:</span>
                <a href="{{ route('dashboard') }}" 
                   class="pill {{ !request('category') ? 'active' : '' }}" 
                   style="text-decoration: none; cursor: pointer;">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('dashboard', ['category' => $category->id] + request()->except('category')) }}" 
                       class="pill {{ request('category') == $category->id ? 'active' : '' }}" 
                       style="text-decoration: none; cursor: pointer;">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if(($q ?? '') !== '')
            <p class="muted" style="margin-bottom:12px;">Showing results for: <strong>{{ $q }}</strong></p>
        @endif

        @if(request('category'))
            <p class="muted" style="margin-bottom:12px;">Filtered by category: <strong>{{ $categories->firstWhere('id', request('category'))->name ?? '' }}</strong></p>
        @endif

        @if(request('ratings'))
            <p class="muted" style="margin-bottom:12px;">Filtered by ratings: <strong>{{ request('ratings') }} stars</strong></p>
        @endif


        <section class="grid">
            @forelse($books as $book)
                <article class="card">
                    <!-- Clickable book details area -->
                    <a href="{{ route('books.show', $book->id) }}" style="text-decoration: none; color: inherit; display: block;">
<img src="{{ $book->cover_url ?? 'https://placehold.co/300x400?text=No+Cover' }}" alt="{{ $book->title }}">

                        <div class="meta">
                            <div class="title" title="{{ $book->title }}">{{ \Illuminate\Support\Str::limit($book->title, 28) }}</div>
                            <div class="author">{{ $book->author }}</div>
                            @if($book->category)
                                <div class="author" style="color: var(--brand); font-size: 11px;">{{ $book->category->name }}</div>
                            @endif
                            <div class="author" style="font-size: 12px; color: #f59e0b;">⭐ {{ $book->rating ?? 'N/A' }}</div>
                            <div class="price" style="font-weight: 700; color: #22c55e; margin: 8px 0; font-size: 14px;">
                               ${{ number_format($book->price, 2) }}
                           </div>
                        </div>
                    </a>
                    
                    <!-- Add to Cart Form (outside the link to remain functional) -->
                    <form method="POST" action="{{ route('cart.add', $book->id) }}" style="margin: 10px 12px 12px;">
                        @csrf
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
            @empty
                <p>No books found.</p>
            @endforelse
        </section>
        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ $books->previousPageUrl() }}" style="font-size: 12px; padding: 5px 10px; cursor: pointer;">« Previous</a>
            <a href="{{ $books->nextPageUrl() }}" style="font-size: 12px; padding: 5px 10px; cursor: pointer;">Next »</a>
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
