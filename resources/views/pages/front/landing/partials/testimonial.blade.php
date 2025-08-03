<!-- Testimonial Section START -->
<section class="testimonial-section">
    <div class="testimonial-container-wrapper style1">
        <div class="container">
            <div class="testimonial-wrapper style1 section-padding fix">
                <div class="shape1">
                    <img src="{{ asset('front/assets/images/shape/testimonialShape1_1.png') }}" alt="shape" />
                </div>
                <div class="shape2">
                    <img src="{{ asset('front/assets/images/shape/testimonialShape1_2.png') }}" alt="shape" />
                </div>
                <div class="container">
                    <div class="section-title text-center mxw-685 mx-auto">
                        <div class="subtitle">
                            Testimonial
                            <img src="{{ asset('front/assets/images/icon/fireIcon.svg') }}" alt="icon" />
                        </div>
                        <h2 class="title">What our clients say?</h2>
                    </div>
                    <div class="slider-area testimonialSliderOne">
                        <div class="swiper gt-slider" id="testimonialSliderOne"
                            data-slider-options='{"loop": true,"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":1,"centeredSlides":true},"768":{"slidesPerView":2},"992":{"slidesPerView":2},"1200":{"slidesPerView":3}}}'>
                            <div class="swiper-wrapper">
                                @foreach ([['thumb' => 'testimonialProfileThumb1_1.jpg', 'name' => 'Jacob Jones', 'role' => 'Team Leader'], ['thumb' => 'testimonialProfileThumb1_2.jpg', 'name' => 'Masirul Jones', 'role' => 'Team Leader'], ['thumb' => 'testimonialProfileThumb1_3.jpg', 'name' => 'Adam Jones', 'role' => 'Team Leader'], ['thumb' => 'testimonialProfileThumb1_1.jpg', 'name' => 'Wade Warren', 'role' => 'Team Leader'], ['thumb' => 'testimonialProfileThumb1_2.jpg', 'name' => 'Masirul Jones', 'role' => 'Team Leader'], ['thumb' => 'testimonialProfileThumb1_3.jpg', 'name' => 'Adam Jones', 'role' => 'Team Leader']] as $item)
                                    <div class="swiper-slide">
                                        <div class="testimonial-card style1">
                                            <div class="testimonial-header">
                                                <div class="profile-thumb">
                                                    <img src="{{ asset('front/assets/images/testimoial/' . $item['thumb']) }}"
                                                        alt="thumb" />
                                                </div>
                                                <div class="content">
                                                    <h5>{{ $item['name'] }}</h5>
                                                    <p class="text">{{ $item['role'] }}</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-body">
                                                <ul class="star-wrapper style1">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <li>
                                                            <img src="{{ asset('front/assets/images/icon/starIcon1_1.svg') }}"
                                                                alt="icon" />
                                                        </li>
                                                    @endfor
                                                </ul>
                                                <p class="desc">
                                                    There are many variations of passages of Lorem Ipsum available, but
                                                    the majority have suffered alteration in some form, by injected
                                                    humour,
                                                    or randomised words which don't look even slightly
                                                </p>
                                            </div>
                                            <div class="quote-icon">
                                                <img src="{{ asset('front/assets/images/icon/quoteIcon.svg') }}"
                                                    alt="icon" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section END -->
