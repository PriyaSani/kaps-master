@section('title', 'TFM')
@extends('layouts.website')
@section('content')
  <div class="wrapper">
    <a href="#" class="scroll_top"><img src="{{ asset('assets/front/images/scroll-top.svg') }}" alt=""></a>
    <div class="hamburger_icon">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>

    <header>
      <div class="container">
        <div class="row">
          <a href="{{ route('front.index.page') }}" class="logo" title="The Family Member">
            <i><img src="{{ asset('assets/front/images/logo.svg')}}" alt=""></i>
          </a>
          <div class="right_nav">
            <nav>
              <ul>
                <li><a href="{{route('front.about.page')}}" title="About Us">About Us</a></li>
                <li><a href="#" scoll-id="tfm_services" title="TFM Services">TFM Services</a></li>
                <li><a href="#" scoll-id="emergency_card" title="ERC">ERC</a></li>
                <li><a href="#" scoll-id="join_us" title="Join Us">Join Us</a></li>
                <li><a href="#" scoll-id="faq" title="FAQs">FAQs</a></li>
                <li><a href="#" scoll-id="contact_us" title="Contact">Contact</a></li>
                <li><a href="#" class="hidden-xs-link" data-toggle="modal" data-target="#book_service_main" title="Book A Service">Book A Service</a></li>
              </ul>
            </nav>
            <a href="#" class="blue_btn hidden-xs" title="Book A Service" data-toggle="modal" data-target="#book_service_main">Book A Service</a>&nbsp;&nbsp;
            <a href="http://thefamilymember.com/user" class="green_btn_header" title="Book A Service">Become A Member</a>
          </div>
        </div>
      </div>
    </header>

    <main>
      <section class="hero_slider">
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url({{ asset('assets/front/images/banner01.jpg')}}">
              <div class="container">
                <h2>Healthcare Support at Home</h2>
                <p>Get nurse or care taker for elders at home</p>
                <div>
                  <a href="javascript:void(0);" scoll-id="tfm_services" class="green_btn scrollfun" title="Explore More">Explore More</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="background-image: url({{ asset('assets/img/companionship.png')}}">
              <div class="container">
                <h2>Companionship</h2>
                <p>Get TFM Companions to give quality time to your elders</p>
                <div>
                  <a href="javascript:void(0);" scoll-id="tfm_services" class="green_btn scrollfun" title="Explore More">Explore More</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="background-image: url({{ asset('assets/img/wellnesspartner.png')}}">
              <div class="container">
                <h2>Your wellness partner</h2>
                <p>For all preventive wellness TFM is there for you.</p>
                <p class="devp">- Individual wellness   - Family wellness   - Corporate wellness</p>
                <div>
                  <a href="javascript:void(0);" scoll-id="tfm_services" class="green_btn scrollfun" title="Explore More">Explore More</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="background-image: url({{ asset('assets/img/erc-banner.jpg')}}">
              <div class="container">
                <h2>Emergency Response Card</h2>
                <p>The unique response system for medical emergency</p>
                <div>
                  <a href="javascript:void(0);" scoll-id="emergency_card" class="green_btn scrollfun" title="Explore More">Explore More</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="background-image: url({{ asset('assets/img/volunteerhero.png')}}">
              <div class="container">
                <h2>Be a volunteer, be a hero!</h2>
                <p>Join the TFM elder care to give a smile to someone</p>
                <div>
                  <a href="javascript:void(0);" scoll-id="join_us" class="green_btn scrollfun" title="Join Us">Join Us</a>
                </div>
              </div>
            </div>
          </div>

          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>

          <div class="swiper-pagination"></div>
        </div>
      </section>

      <section class="about_tfm">
        <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <h2 class="d-none d-sm-block d-md-block d-lg-none">About TFM</h2>
              <div class="img_block">
                <img src="{{ asset('assets/front/images/about_tfm.jpg')}}" alt="">
                <i class="yellow_circle"><img src="{{ asset('assets/front/images/circle yellow.png')}}" alt=""></i>
                <i class="yellow_dots"><img src="{{ asset('assets/front/images/yellow-dots.png')}}" alt=""></i>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="about_tfm_content">
                <h2>About TFM</h2>
                <p>The family member is the fastest growing social venture for senior citizen care and patient care. We are always been a part of your family as a true family member for any bed ridden patient care, senior citizen care or preventive care.</p>
                <a href="{{ route('front.about.page') }}" class="green_btn" title="Learn More">Learn More</a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="tfm_services" id="tfm_services" style="background-image: url({{ asset('assets/front/images/tfm_services_bg.jpg')}}">
        <div class="container">
          <div class="row">
            <div class="col-xl-10 offset-xl-1">
              <h2>TFM Services</h2>
              <div class="custom_tabbing">
                <div class="custom_tabbing_nav">
                  <ul>
                    <li><a href="#" class="active" title="Home Healthcare" data-link="Home Healthcare">Home Healthcare</a></li>
                    <li><a href="#" title="Companionship" data-link="Companionship">Companionship</a></li>
                    <li><a href="#" title="TFM Path Lab" data-link="TFM Path Lab">TFM Path Lab</a></li>
                    <li><a href="#" title="Wellness Support" data-link="Wellness Support">Wellness Support</a></li>
                  </ul>
                </div>
                <div class="custom_tabbing_nav_mob">
                  <select class="custom_dropdown">
                    <option>Home Healthcare</option>
                    <option>Companionship</option>
                    <option>TFM Path Lab</option>
                    <option>Wellness Support</option>
                  </select>
                </div>
                <div class="custom_tabbing_content_wrapper">
                  <div class="tabbing_content_outer active" data-id="Home Healthcare">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="home_healthcare_info" style="background-image: url({{ asset('assets/front/images/care-managers.png')}}">
                          <h3>Care Managers</h3>
                          <p>We provide professional, trustworthy and empathy based care managers for bed ridden patients and elders at home. We are committed to share your hidden pain to take care for such instances.</p>
                          <a href="#" class="green_btn small modalTitle" title="Book A Service" data-toggle="modal" data-target="#book_service_common" data-title="Book Care Managers" data-service="Care Managers">Book A Service</a>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="home_healthcare_info" style="background-image: url({{ asset('assets/front/images/nursing-care.png')}}">
                          <h3>Nursing Care</h3>
                          <p>Trained and equipped Nursing services are most essential for critical medical conditions at home or for constant medical supervision. Our team of trained nurses perform various nursing duties with care and efficiency.</p>
                          <a href="#" class="green_btn small modalTitle" title="Book A Service" data-toggle="modal" data-target="#book_service_common" data-title="Book Nursing Care" data-service="Nursing Care">Book A Service</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tabbing_content_outer" data-id="Companionship">
                    <div class="row companionship_data">
                      <div class="col-md-5 img_block">
                        <img src="{{ asset('assets/img/service-companionship.png')}}" alt="">
                      </div>
                      <div class="col-md-7">
                        <div class="content_block">
                          <div>
                            <p>Are your parents alone? They need someone to talk with? They need someone to talk out? They need some empathy and care who just listen to them? You are not able to spend time with them?</p>
                            <p>Don't worry. Our caring companions will spend quality time with them. They are trained, educated and trustworthy. They are students, housewives and retired senior citizens who will spend time with your elders.</p>
                          </div>
                          <div>
                            <a href="#" class="green_btn small modalTitle" title="Book A Service" data-toggle="modal" data-target="#book_service_common" data-title="Book Companionship" data-service="Companionship">Book A Service</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tabbing_content_outer" data-id="TFM Path Lab">
                    <div class="row tfm_path_lab">
                      <div class="col-md-5 img_block">
                        <img src="{{ asset('assets/img/service-pathology.png')}}" alt="">
                      </div>
                      <div class="col-md-7">
                        <div class="content_block">
                          <p>TFM is running a fully automated equipped laboratory for faster and accurate results for its members and seniors. Our association with Thyrocare is giving us upper edge for extended and specialized laboratory services.</p>

                          <h5>Our Profiles</h5>
                          <ul>
                            <li>- Basic body profile</li>
                            <li>- Gold body profile</li>
                            <li>- Extended body profile</li>
                          </ul>
                          <a href="#" class="green_btn small modalTitle" title="Book A Service" data-toggle="modal" data-target="#book_service_common" data-title="Book TFM Path Lab" data-service="TFM Path Lab">Book A Service</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tabbing_content_outer" data-id="Wellness Support">
                    <div class="row wellness_support_data">
                      <div class="col-md-7 left_content">
                        <p>We believe that “visiting TFM for your wellness is more beneficiary rather visiting doctor or hospital later”.</p>
                        <p>Our expert medical support team assist you in taking preventive steps for your wellness.</p>
                        <p>We guide you in taking various preventive steps for yourself and your family members according to your lifestyle, heredity, primary medical analysis and other parameters.</p>
                        <p>Our partners will ensure that you will get best in class support at best rates as well, so even your pocket can afford the same.</p>
                      </div>
                      <div class="col-md-5 right_content">
                        <ul class="custom_tick_list">
                          <li>Medical care</li>
                          <li>Preventive lab</li>
                          <li>Preventive physiotherapy</li>
                          <li>Preventive radiology</li>
                          <li>Preventive dental treatment</li>
                          <li>Eye and ear treatment</li>
                          <li>Diabetes & cardiac care</li>
                        </ul>
                        <div class="btn_block">
                          <p>Book Services</p>
                          <a href="#" class="white_border_btn modalTitle" title="Individual Care" data-toggle="modal" data-target="#book_service_common" data-title="Book Individual Care" data-service="Individual Care">Individual Care</a>
                          <a href="#" class="white_border_btn modalTitle" title="Family Care" data-toggle="modal" data-target="#book_service_common" data-title="Book Family Care" data-service="Family Care">Family Care</a>
                          <a href="#" class="white_border_btn modalTitle" title="Corporate Care" data-toggle="modal" data-target="#book_service_common" data-title="Book Corporate Care" data-service="Corporate Care">Corporate Care</a>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="emergency_card" id="emergency_card">
        <div class="container">
          <h2>Emergency Response Card</h2>
          <div class="row">
            <div class="col-lg-5">
              <div class="hidden-sm">
                <p>Emergency response card is a revolution in the wellness industry to provide immediate support in any medical emergency.</p>
                <p>This is physical or virtual card which one can carry with him/her. The biometric card carries all basic as well as important during medical or other emergency.</p>
                <p>The other important aspect of ERC is to store and regularly update medical records of the individual, so he/she never has to carry their medical records with them.</p>
              </div>
            </div>
            <div class="col-lg-6 offset-xl-1">
              <div class="img_block">
                <img src="{{ asset('assets/front/images/erc.png')}}" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="card_steps">
          <div class="container">
            <h3 class="hidden-sm">Emergency Response Card (ERC) Steps</h3>
            <h3 class="visible-sm">ERC Steps</h3>

            <div class="swiper-container">
              <div class="row swiper-wrapper">
                <div class="col-md-4 swiper-slide">
                  <div class="steps_outer">
                    <i><img src="{{ asset('assets/front/images/erc-1.png')}}" alt=""></i>
                    <em class="count">1</em>
                    <p>Scan Emergency Response Card through TFM app or any scanner app</p>
                  </div>
                </div>
                <div class="col-md-4 swiper-slide">
                  <div class="steps_outer">
                    <i><img src="{{ asset('assets/front/images/erc-2.png')}}" alt=""></i>
                    <em class="count">2</em>
                    <p>View all the information related to public details, Emergency Contacts and Private Details easily</p>
                  </div>
                </div>
                <div class="col-md-4 swiper-slide">
                  <div class="steps_outer">
                    <i><img src="{{ asset('assets/front/images/erc-3.png')}}" alt=""></i>
                    <em class="count">3</em>
                    <p>Verify your mobile number from TFM through OTP and access all private details of the user </p>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>

          </div>
        </div>
      </section>

      <section class="testimonials">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">

              <div class="swiper-container">
                <div class="swiper-wrapper">

                  <div class="swiper-slide">
                    <i class="testimonial_dp"><img src="{{ asset('website_images/MOONMOON ROY- Testimonial.jpg')}}" alt=""></i>
                    <h3>Moonmoon Roy</h3>
                    <p>All the staff of The Family Member is very co-operative, services are of best quality and I have made great recovery from critical physiotherapy problem.</p>
                  </div>

                  <div class="swiper-slide">
                    <i class="testimonial_dp"><img src="{{ asset('website_images/BHARGAV DAVE- Testimonial.jpg')}}" alt=""></i>
                    <h3>Bhargav Dave</h3>
                    <p>The Family Member group is doing excellent social service for the society. It is quite commendable and excellent job done by The Family Member.</p>
                  </div>

                  <div class="swiper-slide">
                    <i class="testimonial_dp"><img src="{{ asset('website_images/Heena Shah- Testimonial.jpeg')}}" alt=""></i>
                    <h3>Heena Shah</h3>
                    <p>The home care service from TFM is very carrying, hygenic and soft spoken. The office staff is very supportive and the management is excellent to recommend.</p>
                  </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
              </div>

            </div>
          </div>
        </div>
      </section>

      <section class="join_us" id="join_us">
        <div class="container">
          <h2>Join Us</h2>
          <div class="row">
            <div class="col-xl-10 offset-xl-1">
              <div class="custom_tabbing light_theme">

                <div class="custom_tabbing_nav">
                  <ul>
                    <li><a href="#" class="active" title="Volunteer" data-link="Volunteer">Volunteer</a></li>
                    <li><a href="#" title="Companionship" data-link="Companionship">Companionship</a></li>
                    <li><a href="#" title="Partner" data-link="Partner">Partner</a></li>
                  </ul>
                </div>

                <div class="custom_tabbing_nav_mob">
                  <select class="custom_dropdown">
                    <option>Volunteer</option>
                    <option>Companionship</option>
                    <option>Partner</option>
                  </select>
                </div>

                <div class="custom_tabbing_content_wrapper">
                  <div class="tabbing_content_outer join_companionship_tab active" data-id="Volunteer">
                    <div class="row">
                      <div class="col-md-5 img_block"><i><img src="{{ asset('assets/img/joinus-volunteers.png')}}" alt=""></i></div>
                      <div class="col-md-7 content_block">
                        <p>If you have social values to follow and you can spend time for serving senior citizens in any manner, just join us.</p>

                        <form method="post" action="{{ route('joinUs') }}">
                          @csrf
                          <input type="hidden" name="type" value="Volunteer">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="tel" class="form-control numeric" maxlength="10" name="contact_number" placeholder="" required="">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>City</label>
                                <select class="custom_dropdown" name="city" required>
                                    @if(count($cityList) > 0)
                                        @foreach($cityList as $ck => $cv)
                                            <option value="{{ $cv->id }}">{{ $cv->city_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>About you</label>
                                <select class="custom_dropdown" name="about" required>
                                  <option value="Student">Student</option>
                                  <option value="Professional">Professional</option>
                                  <option value="Social Worker">Social Worker</option>
                                  <option value="House Wife">House Wife</option>
                                  <option value="Retired">Retired</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="recaptchaResponse_join_volunteer" id="recaptchaResponse_join_volunteer">
                          <button type="submit" class="green_btn">Submit</button>
                        </form>
                      </div>
                    </div>

                  </div>

                  <div class="tabbing_content_outer join_companionship_tab" data-id="Companionship">
                    <div class="row">
                      <div class="col-md-5 img_block"><i><img src="{{ asset('assets/img/joinus-companionship.png')}}" alt=""></i></div>
                      <div class="col-md-7 content_block">
                        <p>If you have care and empathy, you can spend regular time with someone, you have basic understanding skills, than join us for a bright career of companionship.</p>

                        <form method="post" action="{{ route('joinUs') }}">
                         @csrf
                          <input type="hidden" name="type" value="Companionship">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="tel" class="form-control width" maxlength="10" name="contact_number" placeholder="" required="">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>City</label>
                                <select class="custom_dropdown" name="city" required>
                                    @if(count($cityList) > 0)
                                        @foreach($cityList as $ck => $cv)
                                            <option value="{{ $cv->id }}">{{ $cv->city_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>About you</label>
                                <select class="custom_dropdown" name="about" required>
                                  <option value="Student">Student</option>
                                  <option value="Professional">Professional</option>
                                  <option value="Social Worker">Social Worker</option>
                                  <option value="House Wife">House Wife</option>
                                  <option value="Retired">Retired</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="recaptchaResponse_join_companionship_tab" id="recaptchaResponse_join_companionship_tab">
                          <button type="submit" class="green_btn">Submit</button>
                        </form>
                      </div>
                    </div>

                  </div>

                  <div class="tabbing_content_outer join_companionship_tab" data-id="Partner">
                    <div class="row">
                      <div class="col-md-5 img_block"><i><img src="{{ asset('assets/img/joinus-partner.png')}}" alt=""></i></div>
                      <div class="col-md-7 content_block">
                        <p>If you are a hospital, doctor, laboratory, wellness center, medical store or any other medical-related business entity, join us to provide best services at discounted rates to our members.</p>

                        <form method="post" action="{{ route('joinUs') }}">
                          @csrf
                          <input type="hidden" name="type" value="Partner">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="tel" class="form-control numeric" maxlength="10" name="contact_number" placeholder="" required="">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>City</label>
                                <select class="custom_dropdown" name="city" required>
                                    @if(count($cityList) > 0)
                                        @foreach($cityList as $ck => $cv)
                                            <option value="{{ $cv->id }}">{{ $cv->city_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>About you</label>
                                <select class="custom_dropdown" name="about" required>
                                  <option value="Student">Student</option>
                                  <option value="Professional">Professional</option>
                                  <option value="Social Worker">Social Worker</option>
                                  <option value="House Wife">House Wife</option>
                                  <option value="Retired">Retired</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="recaptchaResponse_partner" id="recaptchaResponse_partner">
                          <button type="submit" class="green_btn">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="download_mobile_app" style="background-image: url({{ asset('assets/front/images/mobile-app-bg.jpg')}}">
        <div class="container">
          <div class="row">
            <div class="col-lg-5 img-block">
              <img src="{{ asset('assets/front/images/mobiles.png')}}" alt="">
            </div>
            <div class="col-lg-6 offset-lg-1">
              <div class="content">
                <h2>Download Our Mobile App</h2>
                <p>Help any patient at any given point of time during emergency through ERC.</p>
                <p>Get all type of medical service bookings with a click of a button through our app.</p>
                <div class="btn_block">
                  <a href="#" title="Android App"><img src="{{ asset('assets/front/images/google-play.png')}}" alt=""></a>
                  <a href="#" title="iPhone App"><img src="{{ asset('assets/front/images/apple-store.png')}}" alt=""></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="faq_section" id="faq">
        <div class="container">
          <h2>FAQs</h2>
          <div class="row">
            <div class="col-xl-10 offset-xl-1">
              <div class="custom_tabbing light_theme">

                <div class="custom_tabbing_nav">
                  <ul>
                    <li><a href="#" class="active" title="Home Healthcare" data-link="home_healthcare">Home Healthcare</a></li>
                    <li><a href="#" title="Companionship" data-link="companionship">Companionship</a></li>
                    <li><a href="#" title="ERC" data-link="ERC">ERC</a></li>
                  </ul>
                </div>

                <div class="custom_tabbing_nav_mob">
                  <select class="custom_dropdown">
                    <option>Home Healthcare</option>
                    <option>Companionship</option>
                    <option>ERC</option>
                  </select>
                </div>

                <div class="custom_tabbing_content_wrapper">
                  <div class="tabbing_content_outer faq_tab active" data-id="home_healthcare">
                    <div class="row">
                      <div class="col-xl-10 offset-xl-1">
                        <div class="accordion_wrapper">

                          <div class="accordion_outer active">
                            <div class="accordion_title">What services are there in Home Healthcare ?</div>
                            <div class="accordion_content">The Family Member is providing care taker services and nursing services at home or any other place.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">For whom these services are required?</div>
                            <div class="accordion_content">For any elderly person, or bed ridden person or post hospitalisation support these services are available.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Are these people trained and Experienced?</div>
                            <div class="accordion_content">Yes generally all the care takers are trained and experienced. Nurses are certified.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">For How much duration these services are available?</div>
                            <div class="accordion_content">These services are available from 1 day to any specific time period.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">What are normal duty times for home care?</div>
                            <div class="accordion_content">Normally home care is given for 1-2 hours, 10 hours, 12 hours & 24 hours.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">What are the duties of a care giver & nurse?</div>
                            <div class="accordion_content">The work profile is given in service page.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Where these services are available right now?</div>
                            <div class="accordion_content">Currently we are in entire Ahmedabad and nearby areas only.</div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tabbing_content_outer faq_tab" data-id="companionship">
                    <div class="row">
                      <div class="col-xl-10 offset-xl-1">
                        <div class="accordion_wrapper">

                          <div class="accordion_outer active">
                            <div class="accordion_title">What is Companionship?</div>
                            <div class="accordion_content">Companionship is quality time spending with your loved ones in your absence.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Who are beneficiaries for Companionship?</div>
                            <div class="accordion_content">Lonely elders, people under depression or people requiring some company for short time are end beneficiaries.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Who are Companionship?</div>
                            <div class="accordion_content">School & college students, housewives and active senior citizens are the companions.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Is there any specific skillset needed for companions?</div>
                            <div class="accordion_content">No, basic good background, empathy based nature, and basic subject knowledge of medical, finance, art etc is required.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Do you provide training to your companions?</div>
                            <div class="accordion_content">Yes 3 days training is given to the companions.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">How much time these companions spend with the beneficiary?</div>
                            <div class="accordion_content">It totally depends upon the requirement of the family member from 1 hour to full day.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">What is the work profile?</div>
                            <div class="accordion_content">The work profile always varies on person to person, you need to ask the office for your specific requirement.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">What are the charges for the Companionship?</div>
                            <div class="accordion_content">The charges varies from person to person and time duration. You need to ask the office for the same.</div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tabbing_content_outer faq_tab" data-id="ERC">
                    <div class="row">
                      <div class="col-xl-10 offset-xl-1">
                        <div class="accordion_wrapper">

                          <div class="accordion_outer active">
                            <div class="accordion_title">What is ERC?</div>
                            <div class="accordion_content">ERC is Emergency Response Card.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">For what purpose erc is useful?</div>
                            <div class="accordion_content">Erc is useful for any medical emergency and to respond and communicate fast.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Which kind of information will be there in erc?</div>
                            <div class="accordion_content">Erc carries all personal details like name, number, age, address, blood group, medical allergy and medical issue etc. It also carries all the names and number of family / friend / relatives who should be contacted during any emergency. Thirdly erc carries all the medical data of a person in digital form.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">How to get the information from erc?</div>
                            <div class="accordion_content">Anyone who is using normal android phone or higher version can scan the qr code of the card and get basic information and ice (in case of emergency) numbers of a person during any medical or other emergency from any part of the world.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Who can scan the card?</div>
                            <div class="accordion_content">During any emergency anyone can scan the erc.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Who can see the private details of medical data?</div>
                            <div class="accordion_content">Only the card owner or his/her ice people can see the medical data by following security procedures.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">How can i insert medical data?</div>
                            <div class="accordion_content">You can insert data by scanning the card or by application or by web back office. You need to scan the documents and upload them in different folders.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">Can i book various tfm services through this erc or application?</div>
                            <div class="accordion_content">yes you can book any of tfm’s services through erc or tfm application.</div>
                          </div>

                          <div class="accordion_outer">
                            <div class="accordion_title">How can i get erc?</div>
                            <div class="accordion_content">You can fill in the form from website and submit the application, the office will contact you for further assistance. You can also call tfm team at your office, society or place if you have any bulk inquiry for the same.</div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="contact_us" id="contact_us">
        <div class="container">
          <h2 class="d-none d-sm-block d-md-block d-lg-none">Contact Us</h2>
          <div class="row">
            <div class="col-lg-6">
              <div class="map_block">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14690.95526153929!2d72.516055!3d22.99663!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd15dbd4f889a7765!2sThe%20Family%20Member%20Office!5e0!3m2!1sen!2sin!4v1570728240421!5m2!1sen!2sin" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="contact_wrapper">
                <h2>Contact Us</h2>
                <ul class="contact_info">
                  <li>
                    <i><img src="{{ asset('assets/front/images/call.svg')}}" alt=""></i>
                    <span><a href="tel:+91 97730 54513">+91 97730 54513</a> / <a href="tel:+91 72269 94001">+91 72269 94001</a> / <a href="tel:+91 72269 94002">+91 72269 94002</a> / <a href="tel:+91 72269 94003">+91 72269 94003</a> / <a href="tel:+91 72269 94005">+91 72269 94005</a></span>
                  </li>
                  <li>
                    <i><img src="{{ asset('assets/front/images/mail.svg')}}" alt=""></i>
                    <span><a href="mailto:info@thefamilymember.com">info@thefamilymember.com</a>/<a href="mailto:piyush@thefamilymember.com">piyush@thefamilymember.com</a></span>
                  </li>
                  <li>
                    <i><img src="{{ asset('assets/front/images/location.svg')}}" alt=""></i>
                    <span>Opp Shivanta, Bakeri City, Vejalpur-380051.</span>
                  </li>
                </ul>
                <form method="post" action="{{ route('contactUs') }}">
                  @csrf
                  <div class="row">
                    <div class="col-xl-10">
                      <div class="form-group">
                        <label>Email ID</label>
                        <input type="email" name="email" class="form-control" placeholder="Your Email ID" required>
                      </div>
                      <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message" placeholder="Drop us a message" required></textarea>
                      </div>
                      <input type="hidden" name="recaptchaResponse_contact" id="recaptchaResponse_contact">
                      <button type="submit" class="green_btn">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <div class="modal fade" id="book_service_common" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered small" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h2 id="modal_title"></h2>
            <div class="book_service_content">
              <form method="post" action="{{ route('bookService') }}">
                @csrf
                <input type="hidden" name="service" id="service_type" value="">
                <input type="hidden" name="service_type" value="1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" required>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>Mobile</label>
                      <input type="tel" class="form-control numeric" maxlength="10" name="contact_number" placeholder="" required="">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>City</label>
                      <select class="custom_dropdown" name="city" required>
                        @if(count($cityList) > 0)
                          @foreach($cityList as $ck => $cv)
                              <option value="{{ $cv->id }}">{{ $cv->city_name }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <div class="btn_block">
                  <input type="hidden" name="recaptchaResponse_book_service_comman" id="recaptchaResponse_book_service_comman">
                  <button type="submit" class="green_btn">Submit</button>
                  <a href="#" class="white_border_btn grey" data-dismiss="modal">Cancel</a>
                </div>
              </form>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="book_service_main" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h2>Book A Service</h2>

          <div class="book_service_content">
            <form method="post" action="{{ route('bookService') }}">
              @csrf
              <input type="hidden" name="service_type" value="2">
              <h3>TFM Services</h3>
              <div class="checkbox_wrapper">
                @if(count($serviceList) > 0)
                    @foreach($serviceList as $sk => $sv)
                        <div class="checkbox_outer">
                          <input type="checkbox" class="custom_checkbox service_checkbox" name="service" data-value="{{ $sv->name }}" value="{{$sv->name}}">
                          <div class="borders"></div>
                          <label>{{$sv->name}}</label>
                        </div>
                    @endforeach
                @endif
              </div>
              <div class="row preference_row">
                <input type="hidden" name="form_id" class="form_id">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>City</label>
                    <select class="custom_dropdown" name="city" >
                        @if(count($cityList) > 0)
                            @foreach($cityList as $ck => $cv)
                                <option value="{{ $cv->id }}">{{ $cv->city_name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-lg-12 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Full Name of Service Recipient(s) / Baby(s)</label>
                    <input type="text" name="service_recipient_name" class="form-control service_recipient_name" autocomplete="off">
                  </div>
                </div>

                <div class="col-lg-12 number_of_service_recipient_div" style="display: none;">
                  <div class="form-group">
                    <label>Number of Service Recipient(s) /Baby(s) </label>
                    <select class="custom_dropdown service_recipient" name="service_recipient" >
                        
                        <option value="1">1</option>   
                        <option value="2">2</option>   
                    </select>
                  </div>
                </div>
                
                <div class="col-lg-12 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Address of Service Recipient</label>
                    <textarea class="form-control address_recipient" name="address_recipient" placeholder="Address of Service Recipient" data-placeholder="Address of Service Recipient" autocomplete="off"></textarea>
                  </div>
                </div>
                
                <div class="col-lg-6 gender_service_recipient_div" style="display: none;">
                  <div class="form-group">
                    <label>Gender of Service Recipient(s) </label>
                    <select class="custom_dropdown gender_service_recipient" name="gender_number_recipient" >
                        
                        <option value="Male">Male</option>   
                        <option value="Female">Female</option> 
                        <option value="Both">Both</option>   
                    </select>
                  </div>
                </div>
                
                <div class="col-lg-6 date_of_birth_div" style="display: none;">
                  <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" id="birthday" name="birthday_date" class="form-control date_of_birth" max="<?php echo date("Y-m-d") ?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 weight_of_service_recipient_div" style="display: none;">
                  <div class="form-group">
                    <label>Weight of Service Recipient </label>
                    <select class="custom_dropdown weight_of_service_recipient" name="weight_of_service_recipient">
                      <option value="0">Less than 30</option>
                      <option value="1">30 to 40</option>
                      <option value="2">40 to 50</option>
                      <option value="3">50 to 60</option>
                      <option value="4">60 to 70</option>
                      <option value="5">70 to 80</option>
                      <option value="6">80 to 90</option>
                      <option value="7">Above 90</option>
                    </select>
                  </div>
                </div>
                
                <div class="col-lg-6 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Full Name of Decision Maker</label>
                    <input type="text" name="name_of_decision_maker" class="form-control name_of_decision_maker" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Mobile of Decision Maker</label>
                    <input type="tel" class="form-control numeric contact_number_decision_maker" maxlength="10" name="contact_number_decision_maker" placeholder="" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Email ID of Decision Maker </label>
                    <input type="email" class="form-control contact_email" name="contact_email" placeholder="" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 service_required_at_div" style="display: none;">
                  <div class="form-group">
                    <label>Service required at</label>
                    <select class="custom_dropdown service_required_at" name="service_required_at" >
                        
                        <option value="Home">Home</option>   
                        <option value="Hospital">Hospital</option>   
                        <option value="Both">Both</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 number_of_family_member_div" style="display: none;">
                  <div class="form-group">
                    <label>Number of Family Members </label>
                    <input type="tel" class="form-control numeric number_of_family_member" name="number_of_family_member" placeholder="" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-12 physical_condition_service_recipient_div" style="display: none;">
                  <div class="form-group">
                    <label>Physical Condition of the Service Recipient</label>
                    <select class="custom_dropdown physical_condition_service_recipient" name="physical_condition_recipient" >
                        
                        <option value="Can not walk">Can not walk</option>   
                        <option value="upport Required for Mobility">Support Required for Mobility</option>   
                        <option value="Fully Mobile">Fully Mobile</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 physical_disorder_div" style="display: none;">
                  <div class="form-group">
                    <label>Psychological Disorder</label>
                    <select class="custom_dropdown physical_disorder" name="psychological_disorder">
                        
                        <option value="Yes">Yes</option>   
                        <option value="No">No</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-12 physical_disorder_type_div" style="display: none;">
                  <div class="form-group">
                    <label>Mention The Type of Psychological Disorder </label>
                    <input type="text" class="form-control physical_disorder_type" name="type_of_psychological_disorder" placeholder="" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 child_differently_abled_div" style="display: none;">
                  <div class="form-group">
                    <label>Is the Child Differently Abled?</label>
                    <select class="custom_dropdown child_abled" name="child_abled" >
                        
                        <option value="Yes">Yes</option>   
                        <option value="No">No</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-12 type_of_disablility_div" style="display: none;">
                  <div class="form-group">
                    <label>Mention The Type of Disability</label>
                    <input type="text" class="form-control type_of_disablility" name="type_disability" placeholder="" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 service_timing_div" style="display: none;">
                  <div class="form-group">
                    <label>Service Timing</label>
                    <select class="custom_dropdown shift_selection_timing" name="shift_selection_timing" >
                        
                        <option value="8">8 hrs</option>   
                        <option value="10">10 hrs</option>   
                        <option value="12">12 hrs</option>   
                        <option value="24">24 hrs</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 shift_selection_div" style="display: none;">
                  <div class="form-group">
                    <label>Shift Selection </label>
                    <select class="custom_dropdown shift_selection" name="shift_selection" >
                        
                        <option value="1">Day</option>   
                        <option value="2">Night</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 other_div" style="display: none;">
                  <div class="form-group">
                  <label>Start time</label>
                  <input type="time" id="start_time" name="start_time" class="form-control start_time" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6 other_div" style="display: none;">
                    <div class="form-group">
                    <label>Duration of Service</label>
                    <input type="text" id="duration_of_service" name="duration_of_service" class="form-control duration_of_service" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-6 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Staff Required For</label>
                    <select class="custom_dropdown staff_require_for" name="staff_require_for" >
                        
                        <option value="1">Replacing Existing Staff</option>   
                        <option value="2">Assisting Existing Staff</option>   
                        <option value="3">New Requirement</option>   
                    </select>
                  </div>
                </div>
                <div class="col-lg-12 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Whether Service Recipient or Any of the Family Member Has Been Infected With Corona/COVID19 During Last 6 Months?</label>
                    <input type="text" name="infected_with_corona" class="form-control infected_with_corona" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-12 other_div" style="display: none;">
                  <div class="form-group">
                    <label>Any Specific Requirement, This Will Help Us to Serve You Better</label>
                    <input type="text" name="specific_requirement" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-12 other_div" style="display: none;">
                  <div class="form-group">
                    <label>FOR OFFICE PURPOSE ONLY</label>
                    <input type="text" name="office_purpose_only" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>

              <div class="row other_row">
                <input type="hidden" name="form_id" class="form_id">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control first_name" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Mobile</label>
                    <input type="tel" class="form-control numeric mobile_numer" maxlength="10" name="contact_number" placeholder="" autocomplete="off">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>City</label>
                    <select class="custom_dropdown city_selection" name="city" >
                        @if(count($cityList) > 0)
                            @foreach($cityList as $ck => $cv)
                                <option value="{{ $cv->id }}">{{ $cv->city_name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                </div>
              </div>
              <div class="btn_block">
                <input type="hidden" name="recaptchaResponse_book_service" id="recaptchaResponse_book_service">
                <button type="submit" class="green_btn">Submit</button>
                <a href="#" class="white_border_btn grey" data-dismiss="modal">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('js')
<script>
  $( document ).ready(function() {
      $('.preference_row').hide();
      $('.other_row').hide();
  });
  $(document).on('click', '.service_checkbox', function() {      
      $('.service_checkbox').not(this).prop('checked', false);      
      var value = $(this).data('value');
      console.log(value);
      if(value == 'Care Taker'){
        $('.preference_row').show();
        $('.other_row').hide();
        $('.number_of_service_recipient_div').show();
        $('.service_recipient').prop('required',true);
        $('.gender_service_recipient_div').show();
        $('.gender_service_recipient').prop('required',true);
        $('.date_of_birth_div').show();
        $('.date_of_birth').prop('required',true);
        $('.weight_of_service_recipient_div').show();
        $('.weight_of_service_recipient').prop('required',true);
        $('.service_required_at_div').show();
        $('.service_required_at').prop('required',true);
        $('.number_of_family_member_div').show();
        $('.number_of_family_member').prop('required',true);
        $('.physical_condition_service_recipient_div').show();
        $('.physical_condition_service_recipient').prop('required',true);
        $('.physical_disorder_div').show();
        $('.physical_disorder').prop('required',true);
        $('.physical_disorder_type_div').hide();
        $('.physical_disorder_type').prop('required',false);
        $('.child_differently_abled_div').hide();
        $('.child_abled').prop('required',false);
        $('.type_of_disablility_div').hide();
        $('.type_of_disablility').prop('required',false);
        $('.service_timing_div').show();
        $('.shift_selection_timing').prop('required',true);
        $('.shift_selection_div').show();
        $('.shift_selection').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);
        $('.infected_with_corona').prop('required',true);

        $('.service_recipient_name').prop('required',true);
        $('.address_recipient').prop('required',true);
        $('.name_of_decision_maker').prop('required',true);
        $('.contact_number_decision_maker').prop('required',true);
        $('.contact_email').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);

        $('.first_name').prop('required',false);
        $('.mobile_numer').prop('required',false);
        $('.city_selection').prop('required',false);
        $('.other_div').show();
        $('.form_id').val(0);

      }else if(value == 'Baby Sitter'){

        $('.preference_row').show();
        $('.other_row').hide();
        $('.number_of_service_recipient_div').show();
        $('.service_recipient').prop('required',true);
        $('.gender_service_recipient_div').show();
        $('.gender_service_recipient').prop('required',true);
        $('.date_of_birth_div').show();
        $('.date_of_birth').prop('required',true);
        $('.weight_of_service_recipient_div').hide();
        $('.weight_of_service_recipient').prop('required',false);
        $('.service_required_at_div').show();
        $('.service_required_at').prop('required',true);
        $('.number_of_family_member_div').hide();
        $('.number_of_family_member').prop('required',false);
        $('.physical_condition_service_recipient_div').hide();
        $('.physical_condition_service_recipient').prop('required',false);
        $('.physical_disorder_div').hide();
        $('.physical_disorder').prop('required',false);
        $('.physical_disorder_type_div').hide();
        $('.physical_disorder_type').prop('required',false);
        $('.child_differently_abled_div').show();
        $('.child_abled').prop('required',true);
        $('.type_of_disablility_div').hide();
        $('.type_of_disablility').prop('required',true);
        $('.service_timing_div').show();
        $('.shift_selection_timing').prop('required',true);
        $('.shift_selection_div').show();
        $('.shift_selection').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);
        $('.infected_with_corona').prop('required',true);

        $('.service_recipient_name').prop('required',true);
        $('.address_recipient').prop('required',true);
        $('.name_of_decision_maker').prop('required',true);
        $('.contact_number_decision_maker').prop('required',true);
        $('.contact_email').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);

        $('.first_name').prop('required',false);
        $('.mobile_numer').prop('required',false);
        $('.city_selection').prop('required',false);
        $('.other_div').show();
        $('.form_id').val(0);

      }else if(value == 'Nursing'){

        $('.preference_row').show();
        $('.other_row').hide();
        $('.number_of_service_recipient_div').show();
        $('.service_recipient').prop('required',true);
        $('.gender_service_recipient_div').show();
        $('.gender_service_recipient').prop('required',true);
        $('.date_of_birth_div').show();
        $('.date_of_birth').prop('required',true);
        $('.weight_of_service_recipient_div').show();
        $('.weight_of_service_recipient').prop('required',false);
        $('.service_required_at_div').show();
        $('.service_required_at').prop('required',true);
        $('.number_of_family_member_div').show();
        $('.number_of_family_member').prop('required',true);
        $('.physical_condition_service_recipient_div').show();
        $('.physical_condition_service_recipient').prop('required',true);
        $('.physical_disorder_div').show();
        $('.physical_disorder').prop('required',true);
        $('.physical_disorder_type_div').hide();
        $('.physical_disorder_type').prop('required',false);
        $('.child_differently_abled_div').hide();
        $('.child_abled').prop('required',false);
        $('.type_of_disablility_div').hide();
        $('.type_of_disablility').prop('required',false);
        $('.service_timing_div').show();
        $('.shift_selection_timing').prop('required',true);
        $('.shift_selection_div').show();
        $('.shift_selection').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);
        $('.infected_with_corona').prop('required',true);

        $('.service_recipient_name').prop('required',true);
        $('.address_recipient').prop('required',true);
        $('.name_of_decision_maker').prop('required',true);
        $('.contact_number_decision_maker').prop('required',true);
        $('.contact_email').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);

        $('.first_name').prop('required',false);
        $('.mobile_numer').prop('required',false);
        $('.city_selection').prop('required',false);
        $('.other_div').show();
        $('.form_id').val(0);

      }else if(value == 'Home Attendant'){

        $('.preference_row').show();
        $('.other_row').hide();
        $('.number_of_service_recipient_div').hide();
        $('.service_recipient').prop('required',false);
        $('.gender_service_recipient_div').hide();
        $('.gender_service_recipient').prop('required',false);
        $('.date_of_birth_div').hide();
        $('.date_of_birth').prop('required',false);
        $('.weight_of_service_recipient_div').hide();
        $('.weight_of_service_recipient').prop('required',false);
        $('.service_required_at_div').hide();
        $('.service_required_at').prop('required',false);
        $('.number_of_family_member_div').show();
        $('.number_of_family_member').prop('required',true);
        $('.physical_disorder_div').show();
        $('.physical_disorder').prop('required',true);
        $('.physical_disorder_type_div').hide();
        $('.physical_disorder_type').prop('required',false);
        $('.child_differently_abled_div').hide();
        $('.child_abled').prop('required',false);
        $('.type_of_disablility_div').hide();
        $('.type_of_disablility').prop('required',false);
        $('.service_timing_div').show();
        $('.shift_selection_timing').prop('required',true);
        $('.shift_selection_div').show();
        $('.shift_selection').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);
        $('.infected_with_corona').prop('required',true);
        
        $('.service_recipient_name').prop('required',true);
        $('.address_recipient').prop('required',true);
        $('.name_of_decision_maker').prop('required',true);
        $('.contact_number_decision_maker').prop('required',true);
        $('.contact_email').prop('required',true);
        $('.start_time').prop('required',true);
        $('.duration_of_service').prop('required',true);
        $('.staff_require_for').prop('required',true);

        $('.first_name').prop('required',false);
        $('.mobile_numer').prop('required',false);
        $('.city_selection').prop('required',false);
        $('.other_div').show();
        $('.form_id').val(0);

      }else{

        $('.preference_row').hide();
        $('.other_row').show();
        $('.number_of_service_recipient_div').hide();
        $('.gender_service_recipient_div').hide();
        $('.date_of_birth_div').hide();
        $('.weight_of_service_recipient_div').hide();
        $('.service_required_at_div').hide();
        $('.number_of_family_member_div').hide();
        $('.physical_condition_service_recipient_div').hide();
        $('.physical_disorder_div').hide();
        $('.physical_disorder_type_div').hide();
        $('.child_differently_abled_div').hide();
        $('.type_of_disablility_div').hide();
        $('.service_timing_div').hide();
        $('.shift_selection_div').hide();
        $('.other_div').hide();
        $('.service_recipient').prop('required',false);
        $('.gender_service_recipient').prop('required',false);
        $('.date_of_birth').prop('required',false);
        $('.weight_of_service_recipient').prop('required',false);
        $('.service_required_at').prop('required',false);
        $('.number_of_family_member').prop('required',false);
        $('.physical_disorder').prop('required',false);
        $('.physical_disorder_type').prop('required',false);
        $('.child_abled').prop('required',false);
        $('.type_of_disablility').prop('required',false);
        $('.shift_selection_timing').prop('required',false);
        $('.shift_selection').prop('required',false);
        $('.start_time').prop('required',false);
        $('.duration_of_service').prop('required',false);
        $('.staff_require_for').prop('required',false);
        $('.infected_with_corona').prop('required',false);

        $('.service_recipient_name').prop('required',false);
        $('.address_recipient').prop('required',false);
        $('.name_of_decision_maker').prop('required',false);
        $('.contact_number_decision_maker').prop('required',false);
        $('.contact_email').prop('required',false);
        $('.start_time').prop('required',false);
        $('.duration_of_service').prop('required',false);
        $('.staff_require_for').prop('required',false);

        $('.first_name').prop('required',true);
        $('.mobile_numer').prop('required',true);
        $('.city_selection').prop('required',true);
        $('.form_id').val(1);

      }
      
  });

  $(document).on('change', '.physical_disorder', function() {    
    var value = $(this).val();
    if(value == 'Yes'){
      $('.physical_disorder_type_div').show();
      $('.physical_disorder_type').prop('required',true);
    }else{
      $('.physical_disorder_type_div').hide();
      $('.physical_disorder_type').prop('required',false);
    }
  });

  $(document).on('change', '.child_abled', function() {    
    var value = $(this).val();
    if(value == 'Yes'){
      $('.type_of_disablility_div').show();
      $('.type_of_disablility').prop('required',true);
    }else{
      $('.type_of_disablility_div').hide();
      $('.type_of_disablility').prop('required',false);
    }
  });

  $(document).on('change', '.shift_selection_timing', function() {    
    var value = $(this).val();
    if(value == '24'){
      $('.shift_selection_div').hide();
      $('.shift_selection').prop('required',false);
    }else{
      $('.shift_selection_div').show();
      $('.shift_selection').prop('required',true);
    }
  });
  
</script>
<script>

</script>
<script src="https://www.google.com/recaptcha/api.js?render=6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR"></script>
<script>
  $(document).on("input", ".numeric", function() {
  	this.value = this.value.replace(/\D/g,'');  
  });

  grecaptcha.ready(function () {
    grecaptcha.execute('6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR', { action: 'contact' }).then(function (token) {
      var recaptchaResponse = document.getElementById('recaptchaResponse_contact');
        recaptchaResponse.value = token;
    });
  });

  grecaptcha.ready(function () {
      grecaptcha.execute('6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR', { action: 'contact' }).then(function (token) {
          var recaptchaResponse = document.getElementById('recaptchaResponse_book_service_comman');
          recaptchaResponse.value = token;
      });
  });

  grecaptcha.ready(function () {
      grecaptcha.execute('6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR', { action: 'contact' }).then(function (token) {
          var recaptchaResponse = document.getElementById('recaptchaResponse_book_service');
          recaptchaResponse.value = token;
      });
  });

  grecaptcha.ready(function () {
      grecaptcha.execute('6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR', { action: 'contact' }).then(function (token) {
          var recaptchaResponse = document.getElementById('recaptchaResponse_partner');
          recaptchaResponse.value = token;
      });
  });

  grecaptcha.ready(function () {
      grecaptcha.execute('6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR', { action: 'contact' }).then(function (token) {
          var recaptchaResponse = document.getElementById('recaptchaResponse_join_companionship_tab');
          recaptchaResponse.value = token;
      });
  });

  grecaptcha.ready(function () {
      grecaptcha.execute('6LfPseAUAAAAAE149grAA8ieqNvK5uaU5Pyt51bR', { action: 'contact' }).then(function (token) {
          var recaptchaResponse = document.getElementById('recaptchaResponse_join_volunteer');
          recaptchaResponse.value = token;
      });
  });
</script>
@endsection