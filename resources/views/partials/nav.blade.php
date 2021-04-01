
<nav class="col-2 bg-primary bg-info border border-primary navbar navbar-light">
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