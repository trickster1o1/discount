<section class="package-section">
    <div class="container">
       <div class="section-heading text-center">
          <div class="row">
             <div class="col-lg-8 offset-lg-2">
                <h5 class="dash-style">{{$homeSetting->popular_tag_line}}</h5>
                <h2>{{$homeSetting->popular_title}}</h2>
                <p>{{$homeSetting->popular_desc}}</p>
             </div>
          </div>
       </div>
       <div class="package-inner">
          <div class="row">
            @foreach ($popularProd as $prod)
            <div class="col-lg-4 col-md-6">
               <div class="package-wrap">
                  <figure class="feature-image col-img-size">
                     <a href="/product/{{ $prod->slug }}">
                        <img class="i-fit" src="{{ !$prod->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($prod->thumb_image, 'http') ? $prod->thumb_image : '/' . $prod->thumb_image) }}" alt="">
                     </a>
                  </figure>
                  <div class="package-price">
                     <h6>
                        <span>Rs.1,900 </span>
                     </h6>
                  </div>
                  <div class="package-content-wrap">
                     <div class="package-meta text-center">
                        <ul>
                           <li>
                              <i class="far fa-clock"></i>
                              7D/6N
                           </li>
                           <li>
                              <i class="fas fa-user-friends"></i>
                              Area: 5 sq m</li>
                           <li>
                              <i class="fas fa-map-marker-alt"></i>
                              Nepal
                           </li>
                        </ul>
                     </div>
                     <div class="package-content">
                        <h3>
                           <a href="/product/{{ $prod->slug }}">{{$prod->title}}</a>
                        </h3>
                        <div class="review-area">
                           <span class="review-text">(25 reviews)</span>
                           <div class="rating-start" title="Rated 5 out of 5">
                              <span style="width: 60%"></span>
                           </div>
                        </div>
                        {!! $prod->short_description !!}
                        <div class="btn-wrap">
                           <a href="#" class="button-text width-6">Order Now<i class="fas fa-arrow-right"></i></a>
                           <a href="#" class="button-text width-6">Wish List<i class="far fa-heart"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
             </div>
          </div>
          <div class="btn-wrap text-center">
             <a href="/products" class="button-primary">VIEW ALL PACKAGES</a>
          </div>
       </div>
    </div>
 </section>