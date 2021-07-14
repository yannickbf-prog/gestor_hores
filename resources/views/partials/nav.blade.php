<nav class="nav flex-column col-2 pl-0 pr-3">
    <div class="text-center">
        <i class="bi bi-arrow-bar-left" onclick="hideMenu()"></i>
    </div>
    <a class="nav-link text-dark border-bottom {{ setActive('*home.*') }}" href="{{ route($lang.'_home.index') }}">{{ __('message.home') }}</a>
    <a class="nav-link text-dark border-bottom {{ setActive('*company_info.*') }}" href="{{ route($lang.'_company_info.index') }}">{{ __('message.company_info') }}</a>
    <a class="nav-link text-dark border-bottom {{ setActive('*users.*') }}" href="{{ route($lang.'_users.index') }}">{{ __('message.users') }}</a>
    <a class="nav-link text-dark border-bottom {{ setActive('*customers.*') }}" href="{{ route($lang.'_customers.index') }}">{{ __('message.customers') }}</a>
    <a class="nav-link text-dark border-bottom {{ setActive('*projects.*') }}" href="{{ route($lang.'_projects.index') }}">{{ __('message.projects') }}</a>
    <a class="nav-link text-dark border-bottom {{ setActive('*bag_hours.*') }}" href="{{ route($lang.'_bag_hours.index') }}">{{ __('message.bags_of_hours') }}</a>
    <a class="nav-link text-dark border-bottom {{ setActive('*bag_hours_types.*') }}" href="{{ route($lang.'_bag_hours_types.index') }}">{{ __('message.bag_hours_types') }}</a>
    <a class="nav-link text-dark {{ setActive('*time_entries.*') }}" href="{{ route($lang.'_time_entries.index') }}">{{ __('message.time_entries') }}</a>
</nav>