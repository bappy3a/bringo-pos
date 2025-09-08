<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $products = [];
    public $page = 1;
    public $perPage = 12;
    public $hasMore = true;
    public $loading = false;
    public $search = "";

    public function mount()
    {
        $this->loadPage(); // first batch
    }

    public function updatedSearch()
    {
        // reset state when search changes
        $this->reset(['items', 'page', 'hasMore']);
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
