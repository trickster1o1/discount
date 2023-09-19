<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="contact-img"
                    style="background-image: url('{{ !$homeSetting->contact_img ? '/uploads/defaults/banner.jpg' : (str_starts_with($homeSetting->contact_img, 'http') ? $homeSetting->contact_img : '/' . $homeSetting->contact_img) }}');">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact-details-wrap">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="contact-details">
                                <div class="contact-icon">
                                    <img src="{{ asset('Frontend/assets/images/icon12.png') }}" alt="">
                                </div>
                                <ul>
                                    <li>
                                        <a href="mailto:{{$siteSetting->pri_email}}" target="_blank" rel="noopener noreferrer">{{ $siteSetting->pri_email }}</a>
                                    </li>
                                    @php
                                        $emails = $siteSetting->sec_email ? explode(',', $siteSetting->sec_email) : [];
                                        $phones = $siteSetting->sec_phone ? explode(',', $siteSetting->sec_phone) : [];
                                    @endphp
                                    @foreach ($emails as $email)
                                        <li>
                                            <a href="mailto: {{$email}}" target="_blank" rel="noopener noreferrer">{{ $email }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="contact-details">
                                <div class="contact-icon">
                                    <img src="{{ asset('Frontend/assets/images/icon13.png') }}" alt="">
                                </div>
                                <ul>
                                    <li>
                                        <a href="tel:{{$siteSetting->pri_phone}}">{{ $siteSetting->pri_phone }}</a>
                                    </li>
                                    @foreach ($phones as $phone)
                                        <li>
                                            <a href="tel:{{$phone}}">{{ $phone }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="contact-details">
                                <div class="contact-icon">
                                    <img src="{{ asset('Frontend/assets/images/icon14.png') }}" alt="">
                                </div>
                                <ul>
                                    @if ($siteSetting)
                                        <li>
                                            {{ strip_tags($siteSetting->pri_address) }}
                                        </li>

                                        <li>
                                            {{ strip_tags($siteSetting->sec_address)}}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-btn-wrap">
                    <h3>{{ $homeSetting->contact_title }}</h3>
                    <a href="{{ $homeSetting->contact_link }}"
                        class="button-primary">{{ $homeSetting->contact_btn }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
