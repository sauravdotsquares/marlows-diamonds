@inject('footer_settings', 'App\Models\Settings') 
<!-- Footer start here -->
<footer class="footer-main">
    <div class="container">
        <div class="footer-wraper">
            <div class="footer-links-row flexed flex-flex-wrap">
                <div class="column-one-fifth about-footer">
                    <div class="footer-title">
                        <h4>{!!$footer_settings->get_options('footer_sec1-title')!!}</h4>
                    </div>
                    <div class="footerabout-col footer-inn-text">
                        <p>{!!$footer_settings->get_options('about')!!}</p>
                        <div class="footer-social">
                            @if($footer_settings->get_options('facebook')!='')
                                <a href="{{$footer_settings->get_options('facebook')}}" target="_blank" rel="nofollow"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            @endif
                            @if($footer_settings->get_options('twitter')!='')
                                <a href="{{$footer_settings->get_options('twitter')}}" target="_blank" rel="nofollow"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            @endif
                            @if($footer_settings->get_options('instagram')!='')
                                <a href="{{$footer_settings->get_options('instagram')}}" target="_blank" rel="nofollow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            @endif
                            @if($footer_settings->get_options('pinterest')!='')
                                <a href="{{$footer_settings->get_options('pinterest')}}" target="_blank" rel="nofollow"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            @endif
                            @if($footer_settings->get_options('youtube')!='')
                                <a href="{{$footer_settings->get_options('youtube')}}" target="_blank" rel="nofollow"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                            @endif
                            @if($footer_settings->get_options('linkedin')!='')
                                <a href="{{$footer_settings->get_options('linkedin')}}" target="_blank" rel="nofollow"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$footer_settings->get_options('footer_sec2-title')!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$footer_settings->get_options('catalogue')!!}
                    </div>
                </div>
                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$footer_settings->get_options('footer_sec3-title')!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$footer_settings->get_options('resources')!!}
                    </div>
                </div>
                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$footer_settings->get_options('footer_sec4-title')!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$footer_settings->get_options('sec-resources')!!}
                    </div>
                </div>

                <div class="column-one-fifth">
                    <div class="footer-title">
                        <h4 class="accordian-toggle">{!!$footer_settings->get_options('footer_sec5-title')!!}</h4>
                    </div>
                    <div class="footerlinks-col footer-inn-text">
                        {!!$footer_settings->get_options('policies')!!}
                    </div>
                </div>
            </div>

            <div class="footer-content-wrap flexed flex-flex-wrap">
                <div class="fcontent-column icon-payment">
                    {!!$footer_settings->get_options('footer-left')!!}
                </div>
                <div class="fcontent-column disclaimer-content">
                    {!!$footer_settings->get_options('footer-center')!!}
                </div>
                <div class="fcontent-column disclaimer-content">
                    <b>Birmingham Store:</b> 46-47 Warstone Lane Hockley, Birmingham B18 6JJ.<br><b>Email: </b><a style="color:#fff; text-decoration: none;" href="mailto:hello@marlows-diamonds.co.uk">hello@marlows-diamonds.co.uk</a><br>
                    <b>London Store:</b> 20 Beauchamp Pl, Knightsbridge, London SW3 1NQ. <br> Registraton No. 00867377. VAT No. GB 111114741<br>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom to top -->
    <div class="botto-to-top" style="display:none;">
        <div class="container">
            <span id="scroll-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
        </div>
    </div>
    <div class="whatspp-num-1" style="display:none;">
        <div class="container">
            <a class="whatspp-num" target="_blank" href="https://api.whatsapp.com/send?phone=447449262928">
            <span id="scroll-to-top">
                WhatsApp
            </span>
            </a>
        </div>
    </div>
</footer>
<!-- Footer end here -->