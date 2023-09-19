<section class="category-section-two container-fluid">
    @if ($homeSetting->pagea)
        @php
            $pa = $homeSetting->getPage($homeSetting->pagea);
        @endphp
        <div
            style="background-image: url('{{ !$pa->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($pa->thumb_image, 'http') ? $pa->thumb_image : '/' . $pa->thumb_image) }}')">
            <div class="overlay">
                <span class="cat2-tag">{{$pa->tagline}}</span>
                <span class="cat2-title">{{$pa->title}}</span>
                <a class="cat2-link" href='/{{$pa->slug}}'>Read More</a>
            </div>
        </div>
    @endif
    @if ($homeSetting->pageb)
        @php
            $pb = $homeSetting->getPage($homeSetting->pageb);
        @endphp
        <div
            style="background-image: url('{{ !$pb->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($pb->thumb_image, 'http') ? $pb->thumb_image : '/' . $pb->thumb_image) }}')">
            <div class="overlay">
                <span class="cat2-tag">{{$pb->tagline}}</span>
                <span class="cat2-title">{{$pb->title}}</span>
                <a class="cat2-link" href='/{{$pb->slug}}'>Read More</a>
            </div>
        </div>
    @endif
    @if ($homeSetting->pagec)
        @php
            $pc = $homeSetting->getPage($homeSetting->pagec);
        @endphp
        <div
            style="background-image: url('{{ !$pc->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($pc->thumb_image, 'http') ? $pc->thumb_image : '/' . $pc->thumb_image) }}')">
            <div class="overlay">
                <span class="cat2-tag">{{$pc->tagline}}</span>
                <span class="cat2-title">{{$pc->title}}</span>
                <a class="cat2-link" href='/{{$pc->slug}}'>Read More</a>
            </div>
        </div>
    @endif
</section>
