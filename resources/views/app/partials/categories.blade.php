@foreach($categories as $category)
    <span class="sidebar-nav-item-title">
        <a href="{{ route('home.products',['search' => request()->search,'sort' => request()->sort,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands,'category' => $category->slug]) }}" class="d-inline">
            {{ $category->name }}
        </a>
        @if($category->children->count() > 0)
            <i class="fa fa-angle-left"></i>
        @endif
    </span>
    @include('app.partials.sub-categories',['categories' => $category->children])

@endforeach

