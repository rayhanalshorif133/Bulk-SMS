<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      <span class="app-brand-logo demo">
        {{-- <img src="{{asset('assets/logo/1.png')}}" height="70" weight="100%"/> --}}
        <i class="fa-regular fa-envelope" style="font-size:3rem"></i>
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">
        {{ config('app.name', 'Laravel') }}
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
      <a href="index.html" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <!-- Layouts -->
    
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Layouts">Users</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Add New">Add New</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Add New">User List</div>
          </a>
        </li>
      </ul>
    </li>
    
    </li>
  </ul>
</aside>