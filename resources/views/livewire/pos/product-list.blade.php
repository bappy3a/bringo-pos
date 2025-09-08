<div class="col-md-12 col-lg-7">
    <div class="pos-categories tabs_wrapper">
        <div class="row mb-3">
            <div class="col-md-12 col-lg-2">
                <h5 class="mt-2">Products</h5>
            </div>
            <div class="col-md-12 col-lg-8">
                <input type="text" class="form-control" placeholder="Enter Product name / SKU / Scan bar code" wire:model.live.debounce.500ms="search">
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="btn-list d-flex flex-wrap">
                    <button class="btn btn-primary btn-w-sm" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Filter <i
                            class="fa-solid fa-arrow-down-short-wide"></i> </button>
                </div>
            </div>
        </div>


        <div class="pos-products" x-data="{ hasMore: @entangle('hasMore'), loading: @entangle('loading') }" x-init="
            const sentinel = $refs.sentinel;
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting && hasMore && !loading) {
                        $wire.loadMore();
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0.1 });
    
            observer.observe(sentinel);
    
            // stop observing once there are no more pages
            $watch('hasMore', (v) => { if (!v) observer.disconnect(); }); ">

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                        <div class="product-info default-cover card">
                            <a href="javascript:void(0);" class="img-bg">
                                <img src="{{ $product->images ? asset($product->images) : asset('assets/images/image-not-found.avif') }}" alt="{{ $product->name }}" />
                            </a>
                            <h6 class="product-name"><a href="javascript:void(0);">{{ $product->name }}</a></h6>
                            <div class="d-flex align-items-center justify-content-between price">
                                <span>30 Pcs</span>
                                <p>$15800</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div x-show="loading" class="py-6 text-center text-muted">
                Loading…
            </div>
            {{-- Sentinel: the observer watches this element to trigger loadMore --}}
            <div x-show="hasMore" x-ref="sentinel" class="h-10"></div>

            {{-- Optional fallback button if needed --}}
            <div class="mt-4 text-center" x-show="hasMore">
                <button type="button" class="px-4 py-2 rounded-lg border" @click="$wire.loadMore()" :disabled="loading">
                    <span x-show="!loading">Load more</span>
                    <span x-show="loading">Loading…</span>
                </button>
            </div>        
        </div>
    </div>
    {{-- Filter Product --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Product Filter</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body" style="overflow-y: auto; width: 90vh;">
            <div class="categoyr-list">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6>Select Category</h6>
                    </div>
                    @foreach($categories as $key => $category)
                    <div class="col-4">
                        <div class="post-profile-checkbox-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="category_{{ $key+1 }}" wire:model="pendingCategoryIds">
                                <label class="form-check-label" for="category_{{ $key+1 }}">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="post-profile-avatar">
                                    <span class="post-profile-name">{{ $category->name }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="categoyr-list mt-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6>Select Brand</h6>
                    </div>
                    @foreach($brands as $key => $brand)
                        <div class="col-4">
                            <div class="post-profile-checkbox-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $brand->id }}" id="brand{{ $key }}" wire:model="pendingBrandIds">
                                    <label class="form-check-label" for="brand{{ $key }}">
                                        <span class="post-profile-name">{{ $brand->name }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-outline-secondary" wire:click="clearFilters">Clear</button>
                <button type="button" class="btn btn-primary" wire:click="applyFilters" data-bs-dismiss="offcanvas">Apply Filters</button>
            </div>
        </div>
    </div>
    {{-- filter end --}}
</div>