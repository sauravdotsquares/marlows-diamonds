@extends('layouts.front.app')
@section('content')
<!--<div class="category-banner" style="background-image:url({{asset('storage/'.$data->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{$data->title}}</h1>
			<p>{!!$data->subtitle!!}</p>
		</div>
	</div>
</div>-->

<div class="ring-guide-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="ring-personal-desc">
                    <h1>{{$data->title}}</h1>
                    <!-- <p>In the ancient times, the Egyptians believed that a circle represented eternity which led to the tradition of married couples wearing breaded reed rings on the ring finger of their left hand which is said to have veins connecting directly to the heart.</p> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="ring-personal-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/ring-personal-gold.png'}}" alt=""></div>
            </div>
        </div>
    </div>
</div>
<div class="ring-size-content">
    <div class="container">
    <p>In the ancient times, the Egyptians believed that a circle represented eternity which led to the tradition of married couples wearing breaded reed rings on the ring finger of their left hand which is said to have veins connecting directly to the heart.</p>
    <p>Fast forward to 1940s that produced a viral ad campaign saying “A diamond is forever” and <a href="/engagement-rings" target="_blank">diamond engagement rings</a> became a representation of love and lifetime commitment. In fact, in today’s time, you will not see any engagement or proposal deemed complete without a <a href="/gia-certified-diamonds/" target="_blank">GIA certified diamond rin</a><strong><a href="/gia-certified-diamonds/" target="_blank">g</a></strong>&nbsp;donning the hands of the girl.</p>

    <p>Now since the GIA certified diamond rin<strong>gs</strong>&nbsp;could be highly valued, it becomes extremely important to select not just a ring that would be liked by your partner but also the correct size of the band. The best way to get the right size of your finger is by visiting a jeweller and getting him to measure it.</p>

    <p>However, we have some other methods that would help you measure the ring size at home so that you can place your ring order online with ease.</p>

    <div class="ring-size-tabing">
        <h3>RING SIZE CONVERSION CHARTS</h3>
        <!-- <nav>
            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">UK RING SIZES</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">UK to US Ring Size Conversion</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">UK to EU Ring Size Conversion</button>
            </div>
        </nav> -->
        <div class="tab-content p-3 border bg-light" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="panel-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Ring Size</th>
                                <th>Circumference (mm)</th>
                                <th>Ring Size</th>
                                <th>Circumference (mm)</th>
                                <th>Ring Size</th>
                                <th>Circumference (mm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A</td>
                                <td>37.8</td>
                                <td>J</td>
                                <td>48.7</td>
                                <td>S</td>
                                <td>60.2</td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td>39.1</td>
                                <td>K</td>
                                <td>50.0</td>
                                <td>T</td>
                                <td>61.4</td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>40.4</td>
                                <td>L</td>
                                <td>51.2</td>
                                <td>U</td>
                                <td>62.7</td>
                            </tr>
                            <tr>
                                <td>D</td>
                                <td>41.7</td>
                                <td>M</td>
                                <td>52.5</td>
                                <td>V</td>
                                <td>64.0</td>
                            </tr>
                            <tr>
                                <td>E</td>
                                <td>42.9</td>
                                <td>N</td>
                                <td>53.8</td>
                                <td>W</td>
                                <td>65.3</td>
                            </tr>
                            <tr>
                                <td>F</td>
                                <td>44.2</td>
                                <td>O</td>
                                <td>55.1</td>
                                <td>X</td>
                                <td>66.6</td>
                            </tr>
                            <tr>
                                <td>G</td>
                                <td>45.5</td>
                                <td>P</td>
                                <td>56.3</td>
                                <td>Y</td>
                                <td>67.8</td>
                            </tr>
                            <tr>
                                <td>H</td>
                                <td>46.8</td>
                                <td>Q</td>
                                <td>57.6</td>
                                <td>Z</td>
                                <td>68.5</td>
                            </tr>
                            <tr>
                                <td>I</td>
                                <td>48.0</td>
                                <td>R</td>
                                <td>58.9</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr> </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="panel-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>UK</th>
                                <th>US &amp; Canada</th>
                                <th>UK</th>
                                <th>US &amp; Canada</th>
                                <th>UK</th>
                                <th>US &amp; Canada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A</td>
                                <td>1/2</td>
                                <td>K</td>
                                <td>5 <span class="small-text">1/4</span></td>
                                <td>S <span class="small-text">1/2</span></td>
                                <td>9 <span class="small-text">1/4</span></td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td>1</td>
                                <td>K <span class="small-text">1/2</span></td>
                                <td>5 <span class="small-text">1/2</span></td>
                                <td>-</td>
                                <td>9 <span class="small-text">1/2</span></td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>1 <span class="small-text">1/2</span></td>
                                <td>L</td>
                                <td>5 <span class="small-text">3/4</span></td>
                                <td>T</td>
                                <td>9 <span class="small-text">3/4</span></td>
                            </tr>
                            <tr>
                                <td>D</td>
                                <td>2</td>
                                <td>L <span class="small-text">1/2</span></td>
                                <td>6</td>
                                <td>T <span class="small-text">1/2</span></td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>D <span class="small-text">1/2</span></td>
                                <td>2 <span class="small-text">1/4</span></td>
                                <td>M</td>
                                <td>6 <span class="small-text">1/4</span></td>
                                <td>U</td>
                                <td>10 <span class="small-text">1/4</span></td>
                            </tr>
                            <tr>
                                <td>E</td>
                                <td>2 <span class="small-text">1/2</span></td>
                                <td>M <span class="small-text">1/2</span></td>
                                <td>6 <span class="small-text">1/2</span></td>
                                <td>U <span class="small-text">1/2</span></td>
                                <td>10 <span class="small-text">1/2</span></td>
                            </tr>
                            <tr>
                                <td>E <span class="small-text">1/2</span></td>
                                <td>2 <span class="small-text">3/4</span></td>
                                <td>N</td>
                                <td>6 <span class="small-text">3/4</span></td>
                                <td>V</td>
                                <td>10 <span class="small-text">3/4</span></td>
                            </tr>
                            <tr>
                                <td>F</td>
                                <td>3</td>
                                <td>O</td>
                                <td>7</td>
                                <td>V <span class="small-text">1/2</span></td>
                                <td>11</td>
                            </tr>
                            <tr>
                                <td>F <span class="small-text">1/2</span></td>
                                <td>3 <span class="small-text">1/4</span></td>
                                <td>O <span class="small-text">1/2</span></td>
                                <td>7 <span class="small-text">1/4</span></td>
                                <td>W</td>
                                <td>11 <span class="small-text">1/4</span></td>
                            </tr>
                            <tr>
                                <td>G</td>
                                <td>3 <span class="small-text">1/2</span></td>
                                <td>P</td>
                                <td>7 <span class="small-text">1/2</span></td>
                                <td>W <span class="small-text">1/2</span></td>
                                <td>11 <span class="small-text">1/2</span></td>
                            </tr>
                            <tr>
                                <td>G <span class="small-text">1/2</span></td>
                                <td>3 <span class="small-text">3/4</span></td>
                                <td>P <span class="small-text">1/2</span></td>
                                <td>7 <span class="small-text">3/4</span></td>
                                <td>X</td>
                                <td>11 <span class="small-text">3/4</span></td>
                            </tr>
                            <tr>
                                <td>H</td>
                                <td>4</td>
                                <td>Q</td>
                                <td>8</td>
                                <td>Y</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td>H <span class="small-text">1/2</span></td>
                                <td>4 <span class="small-text">1/4</span></td>
                                <td>Q <span class="small-text">1/2</span></td>
                                <td>8 <span class="small-text">1/4</span></td>
                                <td>Y <span class="small-text">1/2</span></td>
                                <td>12 <span class="small-text">1/4</span></td>
                            </tr>
                            <tr>
                                <td>I</td>
                                <td>4 <span class="small-text">1/2</span></td>
                                <td>R</td>
                                <td>8 <span class="small-text">1/2</span></td>
                                <td>Z</td>
                                <td>12 <span class="small-text">1/2</span></td>
                            </tr>
                            <tr>
                                <td>J</td>
                                <td>4 <span class="small-text">3/4</span></td>
                                <td>R <span class="small-text">1/2</span></td>
                                <td>8 <span class="small-text">3/4</span></td>
                                <td>Z <span class="small-text">1/2</span></td>
                                <td>12 <span class="small-text">3/4</span></td>
                            </tr>
                            <tr>
                                <td>J <span class="small-text">1/2</span></td>
                                <td>5</td>
                                <td>S</td>
                                <td>9</td>
                                <td>-</td>
                                <td>13</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="panel-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>UK</th>
                                <th>EU</th>
                                <th>UK</th>
                                <th>EU</th>
                                <th>UK</th>
                                <th>EU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A</td>
                                <td></td>
                                <td>K</td>
                                <td>49 <span class="small-text">5/8</span></td>
                                <td>S <span class="small-text">1/2</span></td>
                                <td>60 <span class="small-text">1/4</span></td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td></td>
                                <td>K <span class="small-text">1/2</span></td>
                                <td>50 <span class="small-text">1/4</span></td>
                                <td>T</td>
                                <td>60 <span class="small-text">7/8</span></td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>40 <span class="small-text">1/2</span></td>
                                <td>L</td>
                                <td>50 <span class="small-text">7/8</span></td>
                                <td>T <span class="small-text">1/2</span></td>
                                <td>61 <span class="small-text">1/2</span></td>
                            </tr>
                            <tr>
                                <td>D</td>
                                <td>41 <span class="small-text">1/2</span></td>
                                <td>L <span class="small-text">1/2</span></td>
                                <td>51 <span class="small-text">1/2</span></td>
                                <td>U</td>
                                <td>62 <span class="small-text">1/8</span></td>
                            </tr>
                            <tr>
                                <td>D <span class="small-text">1/2</span></td>
                                <td>42 <span class="small-text">1/8</span></td>
                                <td>M</td>
                                <td>52 <span class="small-text">1/8</span></td>
                                <td>U <span class="small-text">1/2</span></td>
                                <td>62 <span class="small-text">3/4</span></td>
                            </tr>
                            <tr>
                                <td>E</td>
                                <td>42 <span class="small-text">3/4</span></td>
                                <td>M <span class="small-text">1/2</span></td>
                                <td>52 <span class="small-text">3/4</span></td>
                                <td>V</td>
                                <td>63 <span class="small-text">3/8</span></td>
                            </tr>
                            <tr>
                                <td>E <span class="small-text">1/2</span></td>
                                <td>43 <span class="small-text">3/8</span></td>
                                <td>N</td>
                                <td>53 <span class="small-text">3/8</span></td>
                                <td>V <span class="small-text">1/2</span></td>
                                <td>63 <span class="small-text">3/8</span></td>
                            </tr>
                            <tr>
                                <td>F</td>
                                <td>44</td>
                                <td>O</td>
                                <td>54 <span class="small-text">5/8</span></td>
                                <td>W</td>
                                <td>64 <span class="small-text">5/8</span></td>
                            </tr>
                            <tr>
                                <td>F <span class="small-text">1/2</span></td>
                                <td>44 <span class="small-text">5/8</span></td>
                                <td>O <span class="small-text">1/2</span></td>
                                <td>55 <span class="small-text">1/2</span></td>
                                <td>W <span class="small-text">1/2</span></td>
                                <td>65 <span class="small-text">1/4</span></td>
                            </tr>
                            <tr>
                                <td>G</td>
                                <td>45 <span class="small-text">1/4</span></td>
                                <td>P</td>
                                <td>55 <span class="small-text">7/8</span></td>
                                <td>X</td>
                                <td>65 <span class="small-text">7/8</span></td>
                            </tr>
                            <tr>
                                <td>G <span class="small-text">1/2</span></td>
                                <td>45 <span class="small-text">7/8</span></td>
                                <td>P <span class="small-text">1/2</span></td>
                                <td>56 <span class="small-text">3/4</span></td>
                                <td>Y</td>
                                <td>67 <span class="small-text">1/8</span></td>
                            </tr>
                            <tr>
                                <td>H</td>
                                <td>46 <span class="small-text">1/2</span></td>
                                <td>Q</td>
                                <td>57 <span class="small-text">1/8</span></td>
                                <td>Y <span class="small-text">1/2</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>H <span class="small-text">1/2</span></td>
                                <td></td>
                                <td>Q <span class="small-text">1/2</span></td>
                                <td>58</td>
                                <td>Z</td>
                                <td>67 <span class="small-text">3/4</span></td>
                            </tr>
                            <tr>
                                <td>I</td>
                                <td>47 <span class="small-text">1/8</span></td>
                                <td>R</td>
                                <td>58 <span class="small-text">3/8</span></td>
                                <td>Z <span class="small-text">1/2</span></td>
                                <td>68 <span class="small-text">3/8</span></td>
                            </tr>
                            <tr>
                                <td>J</td>
                                <td>48 <span class="small-text">3/8</span></td>
                                <td>R <span class="small-text">1/2</span></td>
                                <td>59</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>J <span class="small-text">1/2</span></td>
                                <td>49</td>
                                <td>S</td>
                                <td>59 <span class="small-text">5/8</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <h5>Measure your UK ring size in mm before using our UK to US ring size chart to find your perfect fit in US (and Canadian) measurements.</h5>
    </div>
</div>
</div>

<!-- <div class="printing-ring-chart">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="guide-chart-desc">
                    <h3>How to measure UK ring size at home</h3>
                    <p>We've created a printable ring sizer chart (actual size) to make finding your perfect ring size easy - just follow these simple steps!</p>

                    <ol>
                        <li>Download and print off our ring sizer on A4 paper</li>
                        <li>Cut around the sizer tool</li>
                        <li>Place the tool around your finger</li>
                        <li>Pull the end through the slot</li>
                        <li>Pull it to fit snugly around your finger</li>
                        <li>Make sure it slides over your knuckle</li>
                        <li>Find the letter the arrow is pointing to and reveal your ring size</li>
                        <li>Remember that thicker band widths need a larger size</li>
                    </ol>
                    <p>Please note that this is only a guide and will not take into account the style of ring.</p>

                    <a href="#" class="btn-bg-large">Download The ring size guide</a>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="guide-chart-img">
                    <a href="{{env('APP_IMAGE_URL').'/assets/images/marlos-ring-size.jpg'}}" target="_blank"><img src="{{env('APP_IMAGE_URL').'/assets/images/marlos-ring-size-2.jpg'}}" alt=""></a>
                </div>
            </div>


        </div>
    </div>

</div> -->


<!-- <div class="search-engage">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="search-engage-box">
                    <a href="#">
                        <div class="search-engage-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/enage-ring1.jpg'}}" alt=""></div>

                        <div class="search-engage-desc">
                            <h3>Searching for the perfect engagement ring?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                            <a href="#" class="btn-bg-large">View More</a>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="search-engage-box">
                    <a href="#">
                        <div class="search-engage-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/enage-ring2.jpg'}}" alt=""></div>

                        <div class="search-engage-desc">
                            <h3>Searching for the perfect engagement ring?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                            <a href="#" class="btn-bg-large">View More</a>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

</div> -->

<div class="sizing-tip-sec">

    <div class="container">
        <div class="sizing-tip-sec-inner">
            <div class="row">
                <div class="sizing-tip-desc">
                    <h2>How to measure a ring in secret</h2>
                    <p>When you’re measuring ring size, don’t forget these useful tips.</p>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="sizing-tip-box">
                        <div class="sizing-tip-desc-head">
                        <span><img src="{{env('APP_IMAGE_URL').'/assets/images/engage-ring-1.png'}}" alt=""></span>
                        <p><strong>Method 1: Refer a Perfectly Fitting Ring</strong></p>
                    </div>
                       
                                <div class="sizing-tip-box-inner">
                                    <h5>Things You Need:</h5>
                                    <ul>
                                        <li>A ring that fits the engagement ring finger</li>
                                        <li>A measuring ruler</li>
                                    </ul>
                                </div>
                                <div class="sizing-tip-box-inner">
                                    <h5>How to Measure:</h5>
                                    <ul>
                                        <li>Measure the internal diameter of the ring (excluding the metal part) in millimetres.</li>
                                        <li>Use the size conversion chart available on the jeweller's website to know the right size of your ring.</li>
                                    </ul>
                                </div>
                        <p>This is one of the simplest methods to measure the size of the ring.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="sizing-tip-box">
                        <div class="sizing-tip-desc-head">
                        <span><img src="{{env('APP_IMAGE_URL').'/assets/images/enage-ring-3.jpg'}}" alt=""></span>
                            <p><strong>Method 2: Use a Floss or String</strong></p>
                        </div>
                                <div class="sizing-tip-box-inner">
                                    <h5>Things You Need:</h5>
                                    <ul>
                                        <li>Floss or String</li>
                                        <li>A measuring ruler</li>
                                        <li>Marker or Pen</li>
                                    </ul>
                                </div>
                                <div class="sizing-tip-box-inner">
                                    <h5>How to Measure:</h5>
                                    <ul>
                                        <li>Cut a 6-inch long floss or string.</li>
                                        <li>Roll the string around the base (just below the knuckles) of the ring finger.</li>
                                        <li>Take a pen and mark the string wherever it ends.</li>
                                        <li>Unfold the string and place it adjacent to a measuring ruler. The number appearing closest to the marked point is
                                            the size of your ring in millimetres.</li>
                                        <li>Use the size conversion chart available on the jeweller's website to know the right size of your ring.</li>
                                    </ul>
                                </div>
                            </div>
                         </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="sizing-tip-box">
                        <div class="sizing-tip-desc-head">
                        <span><img src="{{env('APP_IMAGE_URL').'/assets/images/engage-ring-2.png'}}" alt=""></span>
                        <p><strong>Method 3: Use a Paper Strip</strong></p>
                    </div>
                                <div class="sizing-tip-box-inner">
                                    <h5>Things You Need:</h5>
                                    <ul>
                                        <li>A paper strip</li>
                                        <li>A measuring ruler</li>
                                        <li>Marker or Pen</li>
                                    </ul>
                                </div>
                                <div class="sizing-tip-box-inner">
                                    <h5>How to Measure:</h5>
                                    <ul>
                                        <li>Cut a 100-millimetre long thin paper strip.</li>
                                        <li>Roll the paper around the base (just below the knuckles) of the ring finger.</li>
                                        <li>Take a pen and mark the point wherever the two ends of the paper meet.</li>
                                        <li>Unfold the paper and place it adjacent to a measuring ruler. The number appearing closest to the marked point is
                                            the size of your ring in millimetres.</li>
                                        <li>Use the size conversion chart available on the jeweller’s website to know the right size of your ring.</li>
                                    </ul>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="ring-personal-tips">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="ring-personal-desc">
                    <h3>Ready to shop rings or need some proposal tips?</h3>
                    <p>Whether you're looking for an engagement ring, wedding ring or a designer piece, explore our ring collection and find the one you love. Need some ideas on how to propose? Our helpful guide has you covered.</p>
                    <a href="#" class="btn-bg-large">Shop All Rings</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="ring-personal-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/ring-personal-gold.png'}}" alt=""></div>
            </div>
        </div>
    </div>

</div> -->

<div class="guide-secret">

    <div class="container">
        <div class="">
            <h2 class=""> Get a Ring of Your Choice at Home At <a href="/" target="_blank">Marlow's Diamonds</a></h2>
            <p>you can choose among a variety of GIA certified diamond rings and we will resize it according to your requirements. Though the above methods work perfectly to find the correct size of the ring, you can connect with our team of experts and we will guide you in taking the measurements properly.</p>
        </div>
        <!-- <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                            <h3>Try On For Size</h3>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                            <h3>Try On For Size</h3>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                            <h3>Try On For Size</h3>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

</div>


<!-- <div class="friendy-expert-sec">
    <div class="friendly-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/friendly-expert.jpg'}}" alt=""></div>

    <div class="friendy-expert-desc">
        <h3>Lorem ipsum dolar simple</h3>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution</p>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has</p>

        <a href="#" class="btn-bg-large">Fing Out More</a>
    </div>
</div> -->



<!-- <div class="inspiration-sec">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 ">
                <div class="inspiration-box">
                    <a href="#">
                        <div class="inspiration-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/inspiration-img-1.jpg'}}" alt=""></div>
                        <h3>Diamond Buying Guide</h3>
                    </a>
                </div>
            </div>


            <div class="col-sm-12 col-md-6 col-lg-4 ">
                <div class="inspiration-box">
                    <a href="#">
                        <div class="inspiration-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/inspiration-img-2.jpg'}}" alt=""></div>
                        <h3>Diamond Buying Guide</h3>
                    </a>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4 ">
                <div class="inspiration-box">
                    <a href="#">
                        <div class="inspiration-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/inspiration-img-3.jpg'}}" alt=""></div>
                        <h3>Diamond Buying Guide</h3>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div> -->
@endsection