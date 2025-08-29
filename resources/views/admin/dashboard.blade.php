<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ReadSphere • Admin Dashboard</title>
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
        <div class="nav-title">Admin Menu</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
            <a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.index') ? 'active' : '' }}">📚 Manage Books</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">📦 Manage Orders</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">👥 Manage Users</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">🏷️ Manage Categories</a>
           
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
        </nav>
        <div class="footer">ReadSphere Admin © {{ date('Y') }}</div>
    </aside>


    <!-- Header -->
    <header class="header">
        <div class="brand">ReadSphere Admin</div>
        <form class="search" method="GET" action="{{ route('admin.dashboard') }}">
            <input type="text" name="q" placeholder="Search books, authors…" value="{{ $q ?? '' }}">
            <button type="submit">Search</button>
        </form>
    </header>


    <!-- Main -->
    <main class="main">
        <h1>Admin Dashboard</h1>
       
        <!-- Admin Stats -->
        <div class="grid">
            <div class="card">
                <h3>Total Books</h3>
                <p>{{ $totalBooks }}</p>
            </div>
            <div class="card">
                <h3>Total Earnings</h3>
                <p>${{ number_format($totalEarnings, 2) }}</p>
            </div>
            <div class="card">
                <h3>Total Transactions</h3>
                <p>{{ $totalTransactions }}</p>
            </div>
            <div class="card">
                <h3>Categories</h3>
                <p>{{ $totalCategories }}</p>
            </div>
            <div class="card">
                <h3>Total Stocks</h3>
                <p>{{ $totalStocks }}</p>
            </div>
        </div>


        <!-- Recent Books -->
        <h2 style="margin-top: 30px;">Recent Books</h2>
        <section class="grid">
            @forelse($books as $book)
                <article class="card">
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
                </article>
            @empty
                <p>No books found.</p>
            @endforelse
        </section>
       
        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ $books->previousPageUrl() }}" style="font-size: 12px; padding: 5px 10px; cursor: pointer;">« Previous</a>
            <a href="{{ $books->nextPageUrl() }}" style="font-size: 12px; padding: 5px 10px; cursor: pointer;">Next »</a>
        </div>
    </main>
</div>


</body>
</html>


