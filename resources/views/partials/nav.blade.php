<!-- 
<nav class="col-2">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ setActive('home') }}" href="{{ route('home') }}">
                @lang('Home')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ setActive('company-info') }}" href="{{ route('company-info') }}">
                @lang('Company info')
            </a>
        </li>
        <li>Users</li>
        <li>Customers</li>
        <li>Projects</li>
        <li>Hours bag</li>
        <li>Hours bag types</li>
        <li>Hours entry</li>
    </ul>
</nav>

comment -->


<nav class="nav flex-column nav-pills col-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link {{ setActive('*home') }}" href="{{ route('home') }}">@lang('Home')</a>
  <a class="nav-link {{ setActive('*company_info.*') }}" href="{{ route($lang.'_company_info.index') }}">{{ __('Company info') }}</a>
  <a class="nav-link {{ setActive('*type-bag-hours.*') }}" href="{{ route('type-bag-hours.index') }}">@lang('Bag hours types')</a>
  <a class="nav-link {{ setActive('*customers.*') }}" href="{{ route($lang.'_customers.index') }}">{{ __('message.customers') }}</a>
</nav>