<li>
    <a href="javascript:;">{{ $industry->industry_name }}@if ($industry->children->count())<i class="fa fa-angle-right"></i>@endif</a>
    @if ($industry->children->count())
        <ul class="sub-menu">
            @foreach ($industry->children as $child)
                @include('submenu', ['industry' => $child])
            @endforeach
        </ul>
    @endif
</li>
