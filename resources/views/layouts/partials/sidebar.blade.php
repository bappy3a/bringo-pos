<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <ul>
                        <li class="{{ areActiveRoutes(['home']) }}">
                            <a href="{{ route('home') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="submenu">
                            <a class="{{ areActiveRoutesRequest(['products*','categories*']) }}" href="javascript:void(0);"><i data-feather="package"></i><span>Products</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('home') }}">List Products</a></li>
                                <li><a href="{{ route('home') }}">Add Products</a></li>
                                <li><a href="{{ route('home') }}">Print Labels</a></li>
                                <li><a href="{{ route('home') }}">Import Products</a></li>
                                <li><a href="{{ route('home') }}">Units</a></li>
                                <li><a class="{{ areActiveRoutesRequest(['categories*']) }}" href="{{ route('categories.index') }}">Category</a></li>
                                <li><a href="{{ route('home') }}">Brands</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                
            </ul>
        </div>
    </div>
</div>
