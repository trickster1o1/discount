<div class="client-section">
    <div class="container">
        <div class="client-wrap client-slider secondary-bg">
            @foreach ($supporters as $supp)
                <div class="client-item" style="height:150px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                    <figure>
                        <img class="i-fit" src="{{ !$supp->logo ? '/uploads/defaults/banner.jpg' : (str_starts_with($supp->logo, 'http') ? $supp->logo : '/' . $supp->logo) }}" alt="">
                    </figure>
                </div>
            @endforeach
            {{-- <div class="client-item">
             <figure>
                <img src="{{asset('Frontend/assets/images/logo2.png')}}" alt="">
             </figure>
          </div>
          <div class="client-item">
             <figure>
                <img src="{{asset('Frontend/assets/images/logo3.png')}}" alt="">
             </figure>
          </div>
          <div class="client-item">
             <figure>
                <img src="{{asset('Frontend/assets/images/logo4.png')}}" alt="">
             </figure>
          </div>
          <div class="client-item">
             <figure>
                <img src="{{asset('Frontend/assets/images/logo5.png')}}" alt="">
             </figure>
          </div>
          <div class="client-item">
             <figure>
                <img src="{{asset('Frontend/assets/images/logo2.png')}}" alt="">
             </figure>
          </div> --}}
        </div>
    </div>
</div>
