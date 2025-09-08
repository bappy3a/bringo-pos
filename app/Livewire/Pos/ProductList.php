<?php

namespace App\Livewire\Pos;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $products = [];
    public $brands = [];
    public $categories = [];
    public $page = 1;
    public $perPage = 12;
    public $hasMore = true;
    public $loading = false;
    public $search = "";
    public $brandId = [];
    public $categoryId = [];
    public $pendingBrandIds = [];
    public $pendingCategoryIds = [];

    public function mount()
    {
        $this->loadPage(); // first batch
        $this->brands = Brand::all();
        $this->categories = Category::all();

        // initialize pending filters
        $this->pendingBrandIds = $this->brandId;
        $this->pendingCategoryIds = $this->categoryId;
    }

    public function updatedSearch()
    {
        // reset state when search changes
        $this->reset(['products', 'page', 'hasMore']);
        $this->page = 1;
        $this->loadPage();
    }

    public function updatedBrandId()
    {
        // reset and reload when brand filter changes
        $this->reset(['products', 'page', 'hasMore']);
        $this->page = 1;
        $this->loadPage();
    }

    public function updatedCategoryId()
    {
        // reset and reload when category filter changes
        $this->reset(['products', 'page', 'hasMore']);
        $this->page = 1;
        $this->loadPage();
    }

    public function applyFilters(): void
    {
        // move pending selections into active filters
        $this->brandId = (array) $this->pendingBrandIds;
        $this->categoryId = (array) $this->pendingCategoryIds;

        // reset and reload products with applied filters
        $this->reset(['products', 'page', 'hasMore']);
        $this->page = 1;
        $this->loadPage();
    }

    public function clearFilters(): void
    {
        // clear both pending and active filters
        $this->pendingBrandIds = [];
        $this->pendingCategoryIds = [];
        $this->brandId = [];
        $this->categoryId = [];

        // reset and reload all products
        $this->reset(['products', 'page', 'hasMore']);
        $this->page = 1;
        $this->loadPage();
    }

    public function loadMore()
    {
        if ($this->loading || !$this->hasMore) return;

        $this->loading = true;
        $this->page++;
        $this->loadPage();
        $this->loading = false;
    }

    protected function loadPage(): void
    {

        $query = Product::latest();

        if (!empty($this->search)) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if (!empty($this->brandId)) {
            $query->whereIn('brand_id', (array) $this->brandId);
        }

        if (!empty($this->categoryId)) {
            $query->whereIn('category_id', (array) $this->categoryId);
        }

        $paginator = $query->paginate(
            $this->perPage, ['*'], 'page', $this->page
        );

        $this->products = array_merge($this->products, $paginator->items());
        $this->hasMore = $paginator->hasMorePages();
    }
    public function render()
    {
        return view('livewire.pos.product-list');
    }
}
