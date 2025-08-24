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
                            <a class="{{ areActiveRoutesRequest(['contacts*']) }}" href="javascript:void(0);"><i data-feather="users"></i><span>Contact</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ isActiveUrl('contacts', ['type' => 'supplier']) }}" href="{{ route('contacts.index',['type'=>'supplier']) }}">Suppliers</a></li>
                                <li><a class="{{ isActiveUrl('contacts', ['type' => 'customer']) }}" href="{{ route('contacts.index',['type'=>'customer']) }}">Customers</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a class="{{ areActiveRoutesRequest(['products*','categories*','units*','brands*','print-labels*']) }}" href="javascript:void(0);"><i data-feather="package"></i><span>Products</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ areActiveRoutesForSubMenu(['products.index','products.show','products.edit','products.delete']) }}" href="{{ route('products.index') }}">List Products</a></li>
                                <li><a class="{{ areActiveRoutesForSubMenu('products.create') }}" href="{{ route('products.create') }}">Add Products</a></li>
                                <li><a class="{{ areActiveRoutesRequest(['print-labels*']) }}" href="{{ route('product.print-labels') }}">Print Labels</a></li>
                                <li><a href="{{ route('products.index') }}">Import Products</a></li>
                                <li><a class="{{ areActiveRoutesRequest(['units*']) }}" href="{{ route('units.index') }}">Units</a></li>
                                <li><a class="{{ areActiveRoutesRequest(['categories*']) }}" href="{{ route('categories.index') }}">Category</a></li>
                                <li><a class="{{ areActiveRoutesRequest(['brands*']) }}" href="{{ route('brands.index') }}">Brands</a></li>
                            </ul>
                        </li>


                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
