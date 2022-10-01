<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Main</div>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('member.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Member
                </a>
                <div class="sb-sidenav-menu-heading">Bill</div>
                <a class="nav-link" href="{{ route('utility.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                    Utility Bill
                </a>
                <a class="nav-link" href="{{ route('cooker.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Cooker Bill
                </a>
                <a class="nav-link" href="{{ route('bill.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-handshake"></i></div>
                    Pay Cooker Bill
                </a>
                <div class="sb-sidenav-menu-heading">Setting</div>
                <a class="nav-link" href="{{ route('setting') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-gear"></i></div>
                    Setting
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @auth
            {{ Auth::user()->name }}
            @endauth
        </div>
    </nav>
</div>