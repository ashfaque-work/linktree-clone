@extends('layouts.app')
@section('content')
    <style>
        body {
            margin-top: 20px;
        }

        .price_plan_area {
            position: relative;
            z-index: 1;
            background-color: #f5f5ff;
        }

        .single_price_plan {
            position: relative;
            z-index: 1;
            border-radius: 0.5rem 0.5rem 0 0;
            -webkit-transition-duration: 500ms;
            transition-duration: 500ms;
            margin-bottom: 50px;
            background-color: #ffffff;
            padding: 3rem 4rem;
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .single_price_plan {
                padding: 3rem;
            }
        }

        @media only screen and (max-width: 575px) {
            .single_price_plan {
                padding: 3rem;
            }
        }

        .single_price_plan::after {
            position: absolute;
            content: "";
            background-image: url("https://bootdey.com/img/half-circle-pricing.png");
            background-repeat: repeat;
            width: 100%;
            height: 17px;
            bottom: -17px;
            z-index: 1;
            left: 0;
        }

        .single_price_plan .title {
            text-transform: capitalize;
            -webkit-transition-duration: 500ms;
            transition-duration: 500ms;
            margin-bottom: 2rem;
        }

        .single_price_plan .title span {
            color: #ffffff;
            padding: 0.2rem 0.6rem;
            font-size: 12px;
            text-transform: uppercase;
            background-color: #2ecc71;
            display: inline-block;
            margin-bottom: 0.5rem;
            border-radius: 0.25rem;
        }

        .single_price_plan .title h3 {
            font-size: 1.25rem;
        }

        .single_price_plan .title p {
            font-weight: 300;
            line-height: 1;
            font-size: 14px;
        }

        .single_price_plan .title .line {
            width: 80px;
            height: 4px;
            border-radius: 10px;
            background-color: #3f43fd;
        }

        .single_price_plan .price {
            margin-bottom: 1.5rem;
        }

        .single_price_plan .price h4 {
            position: relative;
            z-index: 1;
            font-size: 2.4rem;
            line-height: 1;
            margin-bottom: 0;
            color: #3f43fd;
            display: inline-block;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-color: transparent;
            background-image: -webkit-gradient(linear, left top, right top, from(#e24997), to(#2d2ed4));
            background-image: linear-gradient(90deg, #e24997, #2d2ed4);
        }

        .single_price_plan .description {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .single_price_plan .description p {
            line-height: 16px;
            margin: 0;
            padding: 10px 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -ms-grid-row-align: center;
            align-items: center;
        }

        .single_price_plan .description p i {
            color: #2ecc71;
            margin-right: 0.5rem;
        }

        .single_price_plan .description p .lni-close {
            color: #e74c3c;
        }

        .single_price_plan.active,
        .single_price_plan:hover,
        .single_price_plan:focus {
            -webkit-box-shadow: 0 6px 50px 8px rgba(21, 131, 233, 0.15);
            box-shadow: 0 6px 50px 8px rgba(21, 131, 233, 0.15);
        }

        .single_price_plan .side-shape img {
            position: absolute;
            width: auto;
            top: 0;
            right: 0;
            z-index: -2;
        }

        .section-heading h3 {
            margin-bottom: 1rem;
            font-size: 3.125rem;
            letter-spacing: -1px;
        }

        .section-heading p {
            margin-bottom: 0;
            font-size: 1.25rem;
        }

        .section-heading .line {
            width: 120px;
            height: 5px;
            margin: 30px auto 0;
            border-radius: 6px;
            background: #2d2ed4;
            background: -webkit-gradient(linear, left top, right top, from(#e24997), to(#2d2ed4));
            background: linear-gradient(to right, #e24997, #2d2ed4);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css">
    <section class="price_plan_area section_padding_130_80" id="pricing">
        <div class="container">
            <button class="btn btn-outline-primary btn-sm" onclick="goBack()"><i class="fa-solid fa-less-than mx-1"></i>Go Back</button>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-8 col-lg-6">
                    <!-- Section Heading-->
                    <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <h6>Pricing Plans</h6>
                        <h3>Let's find a way together</h3>
                        <p>You can change the plan anytime.</p>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <!-- Single Price Plan Area-->
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="title">
                            <h3>Free</h3>
                            <p>Forever</p>
                            <div class="line"></div>
                        </div>
                        <div class="price">
                            <h4>$0</h4>
                        </div>
                        <div class="description">
                            <p><i class="lni lni-checkmark-circle"></i>Duration: Lifetime</p>
                            <p><i class="lni lni-close"></i>Multiple Accounts</p>
                            <p><i class="lni lni-checkmark-circle"></i>Few Themes</p>
                            <p><i class="lni lni-checkmark-circle"></i>No Hidden Fees</p>
                            <p><i class="lni lni-close"></i>No Custom Themes </p>
                            <p><i class="lni lni-close"></i>No Customizations</p>
                        </div>
                        <div class="button"><a class="btn btn-success btn-2" href="{{Route('dashboard')}}">Get Started</a></div>
                    </div>
                </div>
                <!-- Single Price Plan Area-->
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="single_price_plan active wow fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <!-- Side Shape-->
                        <div class="side-shape"><img src="https://bootdey.com/img/popular-pricing.png" alt=""></div>
                        <div class="title"><span>Popular</span>
                            <h3>Pro</h3>
                            <p>1 Account/Month</p>
                            <div class="line"></div>
                        </div>
                        <div class="price">
                            <h4>$3.00</h4>
                        </div>
                        <div class="description">
                            <p><i class="lni lni-checkmark-circle"></i>Duration: 1 Month</p>
                            <p><i class="lni lni-close"></i>Multiple Accounts</p>
                            <p><i class="lni lni-checkmark-circle"></i>More Themes</p>
                            <p><i class="lni lni-checkmark-circle"></i>No Hidden Fees</p>
                            <p><i class="lni lni-checkmark-circle"></i>Custom Themes</p>
                            <p><i class="lni lni-checkmark-circle"></i>Few Customizations</p>
                        </div>
                        <div class="button"><a class="btn btn-warning" href="{{Route('pay')}}?plan=pro">Get Started</a></div>
                    </div>
                </div>
                <!-- Single Price Plan Area-->
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="title">
                            <h3>Premium</h3>
                            <p>10 Accounts/Month</p>
                            <div class="line"></div>
                        </div>
                        <div class="price">
                            <h4>$32.00</h4>
                        </div>
                        <div class="description">
                            <p><i class="lni lni-checkmark-circle"></i>Duration: 1 month</p>
                            <p><i class="lni lni-checkmark-circle"></i>Multiple Accounts Using Single Login</p>
                            <p><i class="lni lni-checkmark-circle"></i>More Themes</p>
                            <p><i class="lni lni-checkmark-circle"></i>No Hidden Fees</p>
                            <p><i class="lni lni-checkmark-circle"></i>Custom Themes</p>
                            <p><i class="lni lni-checkmark-circle"></i>More Customizations</p>
                        </div>
                        <div class="button"><a class="btn btn-info" href="{{Route('pay')}}?plan=premium">Get Started</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    function goBack() {
        window.history.back();
    }
</script>