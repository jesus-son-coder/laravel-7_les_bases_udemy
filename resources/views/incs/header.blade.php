<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="nav-menu">
            <!-- On vérifie si l'utilisateur est connecté,
                en fonction, on affiche une Navbar diférente : -->
            @if (Auth::check())
                @include('incs.auth.header')
            @else
                @include('incs.ano.header')
            @endif
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
<!-- Header End -->
