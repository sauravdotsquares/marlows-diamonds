{{-- @inject('header_settings', 'App\Models\Settings')  --}}
<!-- Footer start here -->
<footer class="footer-main">
    <div class="container">
        <div class="footer-wraper">
            <div class="footer-links-row flexed flex-flex-wrap">
                <div class="column-one-fifth about-footer">
                    <div class="footer-title">
                        <h4>{!!$header_settings['footer_sec1-title']!!}</h4>
                    </div>
                    <div class="footerabout-col footer-inn-text">
                        <p>{!!$header_settings['about']!!}</p>

                    </div>
                </div>
                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$header_settings['footer_sec2-title']!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$header_settings['catalogue']!!}
                    </div>
                </div>
                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$header_settings['footer_sec3-title']!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$header_settings['resources']!!}
                    </div>
                </div>
                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$header_settings['footer_sec4-title']!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$header_settings['sec-resources']!!}
                    </div>
                </div>

                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$header_settings['footer_sec5-title']!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$header_settings['policies']!!}
                    </div>
                </div>
            </div>

            <div class="footer-content-wrap flexed flex-flex-wrap">
                <div class="fcontent-column icon-payment">
                <div class="fcontent-column disclaimer-content">
                    {!!$header_settings['footer-center']!!}
                </div>
                <div class="footer-social">
                            @if($header_settings['facebook']!='')
                                <a href="{{$header_settings['facebook']}}" target="_blank" rel="follow"><i class="fa fa-facebook" aria-hidden="true" aria-label="facebook"></i></a>
                            @endif
                            @if($header_settings['twitter']!='')
                                <a href="{{$header_settings['twitter']}}" target="_blank" rel="follow"><i class="fa fa-twitter" aria-hidden="true" aria-label="twitter"></i></a>
                            @endif
                            @if($header_settings['instagram']!='')
                                <a href="{{$header_settings['instagram']}}" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"aria-label="instagram"></i></a>
                            @endif
                            @if($header_settings['pinterest']!='')
                                <a href="{{$header_settings['pinterest']}}" target="_blank" rel="follow"><i class="fa fa-pinterest" aria-hidden="true"aria-label="pinterest"></i></a>
                            @endif
                            @if($header_settings['youtube']!='')
                                <a href="{{$header_settings['youtube']}}" target="_blank" rel="follow"><i class="fa fa-youtube" aria-hidden="true"aria-label="youtube"></i></a>
                            @endif
                            @if($header_settings['linkedin']!='')
                                <a href="{{$header_settings['linkedin']}}" target="_blank" rel="follow"><i class="fa fa-linkedin" aria-hidden="true"aria-label="linkedin"></i></a>
                            @endif
                        </div>
                        <div class="fcontent-column disclaimer-content">
                    <b>Birmingham Store:</b> 46-47 Warstone Lane Hockley, Birmingham B18 6JJ.
<b>Email: </b><a style="color:#fff; text-decoration: none;" href="mailto:hello@marlows-diamonds.co.uk">hello@marlows-diamonds.co.uk</a>

                    <b>London Store:</b> 20 Beauchamp Pl, Knightsbridge, London SW3 1NQ. 
 Registraton No. 00867377. VAT No. GB 111114741

                </div>
                </div>
                {!!$header_settings['footer-left']!!}

            </div>
        </div>
    </div>
     {{-- eye icon --}}
     <div class="bottom-eye-icon">
        {{-- <a href="#"> --}}
           <img class="eye-num" src="{{asset('assets/images/wp-tooltip.png')}}" alt="whatsApp" class="position-realtive">
           <span class="tooltiptext">10% Price beat service through Whatsapp. Send us a link of what you have seen elsewhere to get a minimum of 10% off competitor's price. Only through whatsapp contact on any lab grown product</span>
       {{-- </a> --}}
    </div>
   {{-- eye icon --}}
       {{-- whatsapp icon --}}
       <div class="bottom-whatsapp-icon">
        <a class="whatspp-num" target="_blank" href="https://api.whatsapp.com/send?phone=447535425059">
            <img src="{{asset('assets/images/whatsapp.png')}}" alt="whatsApp" class="position-realtive">
            <span class="tooltiptext">10% Price beat service through Whatsapp. Send us a link of what you have seen elsewhere to get a minimum of 10% off competitor's price. Only through whatsapp contact on any lab grown product</span>
        </a>
    </div>
    {{-- whatsapp icon --}}

    <!-- Bottom to top -->
    <div class="botto-to-top" style="display:none;">
        <div class="container">
            <span id="scroll-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
        </div>
    </div>
    <div class="whatspp-num-1" style="display:none;">
    </div>
</footer>
<!-- Footer end here -->
<script>
    document.addEventListener('scroll', function() {
        const footer = document.querySelector('.footer-main');
        const trustpilotWidget = document.getElementById('trustpilot-gtm-floating-wrapper');

        if (footer && trustpilotWidget) {
            const footerPosition = footer.getBoundingClientRect();
            const viewportHeight = window.innerHeight;

            if (footerPosition.top < viewportHeight && footerPosition.bottom >= 0) {
                trustpilotWidget.style.display = 'none';
            } else {
                trustpilotWidget.style.display = 'block';
            }
        }
    });
</script>
 