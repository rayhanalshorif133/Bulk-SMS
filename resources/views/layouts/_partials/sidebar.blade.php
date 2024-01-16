@php
$currentRoute = Route::currentRouteName();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{route('user.dashboard')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        {{-- <img src="{{asset('assets/logo/1.png')}}" height="70" weight="100%"/> --}}
        <i class="fa-regular fa-envelope" style="font-size:3rem"></i>
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">
        BULK SMS
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item @if( $currentRoute == 'user.dashboard') active  @endif">
      <a href="{{route('user.dashboard')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    <li class="menu-item @if( $currentRoute == 'send-sms.index') active  @endif">
      <a href="{{route('send-sms.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-send"></i>
        <div data-i18n="Analytics">Send SMS</div>
      </a>
    </li>
    <li class="menu-item @if( $currentRoute == 'send-sms.log') active  @endif">
      <a href="{{route('send-sms.log')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-line-chart"></i>
        <div data-i18n="Analytics">SMS Logs</div>
      </a>
    </li>
    <!-- Transactions -->
    <li class="menu-item @if( $currentRoute == 'credit.index') active  @endif">
      <a href="{{route('credit.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-bank"></i>
        <div data-i18n="Analytics">Transactions</div>
      </a>
    </li>
    @role('admin')
     <!-- Balance -->
     <li class="menu-item @if( $currentRoute == 'balance.index') active  @endif">
      <a href="{{route('balance.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Analytics">Balance</div>
      </a>
    </li>
    @endrole

    <!-- Users -->
    <!-- Balance -->

    <!-- sender info -->
    <li class="menu-item @if( $currentRoute == 'sender-info.index') active  @endif">
      <a href="{{route('sender-info.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-info-circle"></i>
        <div data-i18n="Analytics">Sender Infos</div>
      </a>
    </li>





    @role('admin')
    <li class="menu-item @if( $currentRoute == 'user.index') active  @endif">
      <a href="{{route('user.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-user"></i>
        <div data-i18n="Analytics">Users</div>
      </a>
    </li>
    @endrole
    <li class="menu-item @if( $currentRoute == 'developer-settings.index') active  @endif">
      <a href="{{route('developer-settings.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-customize"></i>
        <div data-i18n="Analytics">Developer Settings</div>
      </a>
    </li>

    @role('admin')
    <!-- Found -->
    <li class="menu-item @if( $currentRoute == 'fund.index') active  @endif">
      <a href="{{route('fund.index')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-credit-card-front"></i>
        <div data-i18n="Analytics">Fund</div>
      </a>
    </li>
    @endrole

  </ul>
</aside>
