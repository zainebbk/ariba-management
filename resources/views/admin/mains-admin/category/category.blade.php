
    @if ($category->children()->count() > 0 )
        @php $margin+=7; @endphp
            @foreach($category->children as $category)
                <ol class="breadcrumb breadcrumb-arrow mt-3 ml-{{$margin}}"  style="color:white;margin-left:{{$margin}}rem !important;">
                    <li><a href='{{route('category-show',[$category->category_id])}}'>{{ $category->names[0]->name  ?? ''}}</a></li>
                </ol> 
                @include('admin.mains-admin.category.category', $category)
            @endforeach      
    @endif
 