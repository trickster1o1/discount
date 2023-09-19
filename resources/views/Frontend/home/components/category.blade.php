<section class="category-section">
    @if ($homeSetting->proda)
        @php
            $proda = $homeSetting->getProd($homeSetting->proda);
        @endphp
        <div
            style="background-image: url('{{!$proda->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($proda->thumb_image, 'http') ? $proda->thumb_image : '/' . $proda->thumb_image) }}')">
            <div class="overlay" onmouseover="displayBtn('1')" onmouseout="hideBtn('1')"><span
                    id="p-1">{{ $proda->title }} <br>
                    Rs.{{ $proda->price }}</span><a href="/product/{{$proda->slug}}" class="banner-btn text-center" id="b-1">Shop Now</a></div>
        </div>
    @endif
    @if ($homeSetting->cata)
        @php
            $cata = $homeSetting->getCat($homeSetting->cata);
        @endphp
        <div
            style="background-image: url('{{!$cata->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($cata->thumb_image, 'http') ? $cata->thumb_image : '/' . $cata->thumb_image) }}');background-attachment:fixed;">
            <div class="overlay"><span class="category-cat"><a href="/products/category/{{$cata->slug}}" class="text-light"> {{ $cata->title }} </a> </span></div>
        </div>
    @endif
    @if ($homeSetting->catb)
        @php
            $catb = $homeSetting->getCat($homeSetting->catb);
        @endphp
        <div
            style="background-image: url('{{!$catb->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($catb->thumb_image, 'http') ? $catb->thumb_image : '/' . $catb->thumb_image) }}');background-attachment:fixed;">
            <div class="overlay"><span class="category-cat"><a href="/products/category/{{$catb->slug}}" class="text-light"> {{ $catb->title }}</a></span></div>
        </div>
    @endif
    @if ($homeSetting->prodb)
        @php
            $prodb = $homeSetting->getProd($homeSetting->prodb);
        @endphp
        <div style="background-image: url('{{!$prodb->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($prodb->thumb_image, 'http') ? $prodb->thumb_image : '/' . $prodb->thumb_image) }}');">
            <div class="overlay" onmouseover="displayBtn('2')" onmouseout="hideBtn('2')"><span id="p-2">{{$prodb->title}}
                    <br>Rs.{{$prodb->price}}</span><a href="/product/{{$prodb->slug}}" class="banner-btn text-center" id="b-2">Shop Now</a></div>
        </div>
    @endif
</section>
