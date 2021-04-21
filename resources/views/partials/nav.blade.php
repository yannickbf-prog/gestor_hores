


<nav class="nav flex-column nav-pills col-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link {{ setActive('*home.*') }}" href="{{ route($lang.'_home.index') }}">{{ __('Home') }}</a>
  <a class="nav-link {{ setActive('*company_info.*') }}" href="{{ route($lang.'_company_info.index') }}">{{ __('Company info') }}</a>
  <a class="nav-link {{ setActive('*type-bag-hours.*') }}" href="{{ route('type-bag-hours.index') }}">@lang('Bag hours types')</a>
  <a class="nav-link {{ setActive('*customers.*') }}" href="{{ route($lang.'_customers.index') }}">{{ __('message.customers') }}</a>
</nav>