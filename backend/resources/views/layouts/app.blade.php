<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #2c3e50;
            color: white;
        }
        .logo-container {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }
        .logo-container img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        .logo-container h3 {
            font-size: 1.2rem;
            margin-left: 15px;
            font-weight: 600;
        }
        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
        }
        .sidebar .nav-link:hover {
            background-color: #34495e;
        }
        .sidebar .nav-link.active {
            background-color: #34495e;
        }
        .main-content {
            padding: 20px;
        }
        .submenu {
            padding-left: 20px;
            display: none;
        }
        .submenu.show {
            display: block;
        }
        .submenu .nav-link {
            padding: 10px 20px;
            font-size: 0.9em;
        }
        .nav-link i {
            float: right;
            transition: transform 0.3s;
        }
        .nav-link.active i {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="logo-container">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="販売レンタル">
                        <h3 class="mb-0">販売レンタル</h3>
                    </div>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">ホーム</a>
                    <a class="nav-link {{ request()->is('sites') ? 'active' : '' }}" href="/sites">現場</a>
                    <a class="nav-link {{ request()->is('car') ? 'active' : '' }}" href="/car">配車</a>
                    <a class="nav-link {{ request()->is('estimates') ? 'active' : '' }}" href="/estimates">見積もり</a>
                    <a class="nav-link {{ request()->is('orders') ? 'active' : '' }}" href="/orders">受注出荷</a>
                    <a class="nav-link {{ request()->is('acceptances') ? 'active' : '' }}" href="/acceptances">返却</a>
                    <a class="nav-link {{ request()->is('stocks') ? 'active' : '' }}" href="/stocks">在庫</a>
                    <a class="nav-link {{ request()->is('master*') ? 'active' : '' }}" href="#" id="masterMenu">
                        マスタ
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="submenu" id="masterSubmenu">
                        <a class="nav-link {{ request()->is('master/customer') ? 'active' : '' }}" href="/master/customer">取引先</a>
                        <a class="nav-link {{ request()->is('master/items') ? 'active' : '' }}" href="/master/items">商品</a>
                        <a class="nav-link {{ request()->is('master/office') ? 'active' : '' }}" href="/master/office">事業所</a>
                        <a class="nav-link {{ request()->is('master/yard') ? 'active' : '' }}" href="/master/yard">ヤード</a>
                        <a class="nav-link {{ request()->is('master/shelf') ? 'active' : '' }}" href="/master/shelf">棚</a>
                        <a class="nav-link {{ request()->is('master/car-type') ? 'active' : '' }}" href="/master/car-type">車種</a>
                    </div>
                </nav>
            </div>
            <div class="col-md-10 main-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('masterMenu').addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = document.getElementById('masterSubmenu');
            const icon = this.querySelector('i');
            submenu.classList.toggle('show');
            icon.style.transform = submenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    </script>
</body>
</html> 