{{-- This file is used for menu items by any Backpack v6 theme --}}

<meta name="csrf-token" content="{{ csrf_token() }}">
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="字彙表" icon="la la-book" :link="backpack_url('proper-noun')" />
<x-backpack::menu-item title="未上市遊戲" icon="la la-gamepad" :link="backpack_url('unpublish-game')" />
<x-backpack::menu-item title="排程撈取" icon="la la-clock" :link="backpack_url('news-request')" />
<x-backpack::menu-item title="使用者" icon="la la-user" :link="backpack_url('user')" />