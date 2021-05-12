<nav class="nav flex-column nav-pills col-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link {{ setActive('*home.*') }}" href="{{ route($lang.'_home.index') }}">{{ __('message.home') }}</a>
  <a class="nav-link {{ setActive('*company_info.*') }}" href="{{ route($lang.'_company_info.index') }}">{{ __('message.company_info') }}</a>
  <a class="nav-link {{ setActive('*users.*') }}" href="{{ route($lang.'_users.index') }}">{{ __('message.users') }}</a>
  <a class="nav-link {{ setActive('*customers.*') }}" href="{{ route($lang.'_customers.index') }}">{{ __('message.customers') }}</a>
  <a class="nav-link {{ setActive('*projects.*') }}" href="{{ route($lang.'_projects.index') }}">{{ __('message.projects') }}</a>
  <a class="nav-link {{ setActive('*bag_hours.*') }}" href="{{ route($lang.'_bag_hours.index') }}">{{ __('message.bag_of_hours') }}</a>
  <a class="nav-link {{ setActive('*bag_hours_types.*') }}" href="{{ route($lang.'_bag_hours_types.index') }}">{{ __('message.bag_hours_types') }}</a>
</nav>