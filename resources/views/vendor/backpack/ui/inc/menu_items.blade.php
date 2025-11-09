{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="字彙表" icon="la la-question" :link="backpack_url('proper-noun')" />
<x-backpack::menu-item title="未上市遊戲" icon="la la-question" :link="backpack_url('unpublish-game')" />
<x-backpack::menu-item title="排程撈取功能" icon="la la-question" :link="backpack_url('news-request')" />
<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />