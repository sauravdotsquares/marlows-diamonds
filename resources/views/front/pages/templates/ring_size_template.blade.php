@extends('layouts.front.app')
@section('content')
@section('css')
<style>
    .tab-content>.tab-pane {
        display: block;
    }
    .fade:not(.show) {
        opacity: 1;
    }
</style>
@endsection
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
                    <!-- <h1>{{isset($data->short_description)?$data->short_description:''}}</h1> -->
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
        <p>
            A proposal marks a pivotal moment in your romantic journey. With the placement of a diamond engagement ring on your loved one’s finger, you are deepening the love and commitment you share.
        </p>
        <p>
            For a perfect proposal, you need to plan various details, from the location to the words to the sizing of your engagement ring. Imagine the scenario: the ambience is perfect, the mood is set, and as you bend down on one knee with a heart full of emotions, the ring doesn't fit. Such a misstep can distract from the beauty of the moment.
        </p>
        <p>
            We're here to ensure that your chosen engagement ring reflects the significance of your love and your proposal in every way. Dive into our ring size guide UK to ensure a perfectly fitted ring.
        </p>
        <div class="ring-size-tabing">
            <h2>Ring Size Charts</h2>
            <p>
                When looking at engagement rings in different countries, you will notice a variation in the ring sizing options. From letters to numbers, the standards vary greatly.
            </p>
            <p>
                Here we explore the sizing guide for rings in different regions:
            </p>
            <h3>UK Ring Sizes</h3>
            <p>
                Ring sizes are determined by letters in the UK, starting from A and going up to Z. For larger sizes, it continues with Z+1, Z+2, Z+3, and Z+4.
            </p>
            <p>
                The alphabet corresponds to a specific diameter and circumference. To ensure you select the right size, use a tape measure and measure the circumference around the ring finger (or the fourth finger on your left hand) in millimetres (mm). Then, use the UK ring size chart below to find the corresponding letter.
            </p>
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
            </div>

            <h3>Ring Size Conversion Charts</h3>
            <p>
                As we previously mentioned, there are different measurement standards in different regions. This is where ring size conversion charts are essential. By converting the international sizes, these charts ensure that wherever you buy the ring from, it fits like it was meant to be.
            </p>
            <p>
                Here are the most popular ring size conversion charts:
            </p>
            <h4>UK to US Ring Size Conversion</h4>
            <p>
                US and UK ring sizes are not direct matches. For example, a UK size D might be a US size 2. Measure your UK ring size in mm before using our UK to US ring size chart to find your perfect fit in US (and Canadian) measurements.
            </p>
            <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>UK</th>
                                    <th>US & Canadian</th>
                                    <th>UK</th>
                                    <th>US & Canadian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>-</td>
                                    <td>N</td>
                                    <td>6.75</td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>-</td>
                                    <td>O</td>
                                    <td>7.25</td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>P</td>
                                    <td>7.75</td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>2.25</td>
                                    <td>Q</td>
                                    <td>8.25</td>
                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>2.75</td>
                                    <td>R</td>
                                    <td>8.75</td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td>3.25</td>
                                    <td>S</td>
                                    <td>9.25</td>
                                </tr>
                                <tr>
                                    <td>G</td>
                                    <td>3.75</td>
                                    <td>T</td>
                                    <td>9.75</td>
                                </tr>
                                <tr>
                                    <td>H</td>
                                    <td>4.25</td>
                                    <td>U</td>
                                    <td>10.25</td>
                                </tr>
                                <tr>
                                    <td>I</td>
                                    <td>4.75</td>
                                    <td>V</td>
                                    <td>10.75</td>
                                </tr>
                                <tr>
                                    <td>J</td>
                                    <td>5</td>
                                    <td>W</td>
                                    <td>11.25</td>
                                </tr>
                                <tr>
                                    <td>K</td>
                                    <td>5.5</td>
                                    <td>X</td>
                                    <td>11.75</td>
                                </tr>
                                <tr>
                                    <td>L</td>
                                    <td>6</td>
                                    <td>Y</td>
                                    <td>12.25</td>
                                </tr>
                                <tr>
                                    <td>M</td>
                                    <td>6.25</td>
                                    <td>Z</td>
                                    <td>12.75</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h4>UK to EU Ring Size Conversion</h4>
            <p>
                When comparing UK to EU ring sizes, you'll find the EU system uses numbers like the US standards. For example, a UK L will be an EU 50.875. To navigate this difference, use our conversion chart below.
            </p>
            <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>UK</th>
                                    <th>EU</th>
                                    <th>UK</th>
                                    <th>EU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>-</td>
                                    <td>N</td>
                                    <td>53.5</td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>-</td>
                                    <td>O</td>
                                    <td>54.75</td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>40.5</td>
                                    <td>P</td>
                                    <td>56</td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>41.5</td>
                                    <td>Q</td>
                                    <td>57.25</td>
                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>42.75</td>
                                    <td>R</td>
                                    <td>58.5</td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td>44</td>
                                    <td>S</td>
                                    <td>59.75</td>
                                </tr>
                                <tr>
                                    <td>G</td>
                                    <td>45.25</td>
                                    <td>T</td>
                                    <td>61</td>
                                </tr>
                                <tr>
                                    <td>H</td>
                                    <td>46.5</td>
                                    <td>U</td>
                                    <td>62.25</td>
                                </tr>
                                <tr>
                                    <td>I</td>
                                    <td>47.75</td>
                                    <td>V</td>
                                    <td>63.5</td>
                                </tr>
                                <tr>
                                    <td>J</td>
                                    <td>49</td>
                                    <td>W</td>
                                    <td>64.75</td>
                                </tr>
                                <tr>
                                    <td>K</td>
                                    <td>50</td>
                                    <td>X</td>
                                    <td>66</td>
                                </tr>
                                <tr>
                                    <td>L</td>
                                    <td>50.875</td>
                                    <td>Y</td>
                                    <td>67.25</td>
                                </tr>
                                <tr>
                                    <td>M</td>
                                    <td>52.125</td>
                                    <td>Z</td>
                                    <td>68.5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <h5>Measure your UK ring size in mm before using our UK to US ring size chart to find your perfect fit in US (and Canadian) measurements.</h5> -->
        </div>
        
    </div>
</div>

<div class="printing-ring-chart">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="guide-chart-desc">
                    <h3>Printable Ring Size Chart</h3>
                    <p>
                        There are so many factors that go into choosing the perfect ring. From designs and diamonds to budgets and brands, every aspect of your engagement ring requires careful consideration. To ensure that all your thought and effort is reflected in your magical moment, you need to present a ring that isn’t too tight or too loose.
                    </p>
                    <p>
                        To make this easier, we have created a ring sizing chart. This brings the expertise of our jewellers right to your home, allowing you to select the right ring size quickly and accurately. Simply download the printable ring size guide, print it, and follow the clear instructions.
                    </p>
                    <a target="_blank" href="{{env('APP_IMAGE_URL').'/assets/images/marlos-ring-size-2.jpg'}}" class="btn-bg-large">download the printable ring size guide</a>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="guide-chart-img">
                    <a href="{{env('APP_IMAGE_URL').'/assets/images/marlos-ring-size.jpg'}}" target="_blank"><img src="{{env('APP_IMAGE_URL').'/assets/images/marlos-ring-size-2.jpg'}}" alt=""></a>
                </div>
            </div>

        </div>
    </div>

</div>



<div class="sizing-tip-sec">

    <div class="container">
        <div class="sizing-tip-sec-inner">
            <div class="row">
                <div class="sizing-tip-desc">
                    <h2>How To Measure UK Ring Size At Home</h2>
                    <p>Visiting a jeweller to get a ring sizing down for your engagement ring, wedding ring, or statement ring isn’t always a possibility. Luckily, measuring your correct ring size at home is both convenient and straightforward. You can either print our downloadable ring size guide, or follow the methods below:</p>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="sizing-tip-box">
                        <div class="sizing-tip-desc-head">
                            <span><img src="{{env('APP_IMAGE_URL').'/assets/images/engage-ring-1.png'}}" alt=""></span>
                            <h3>Method 1: Use a Perfectly Fitting Ring </h3>
                        </div>
                        <p>
                            Using an existing ring is a dependable way to determine the ideal ring size, especially if the ring is worn frequently by your loved one. If you're certain it fits the engagement finger comfortably, this method is ideal.
                        </p>
                        <div class="sizing-tip-box-inner">
                            <h4>Things You'll Need:</h4>
                            <ul>
                                <li>A ring that fits the engagement finger.</li>
                                <li>A ruler.</li>
                                <li>A calculator.</li>
                            </ul>
                        </div>
                        <div class="sizing-tip-box-inner">
                            <h4>How To Measure Ring Size:</h4>
                            <ol>
                                <li>
                                    <strong>
                                        Position Ring on a Ruler:
                                    </strong>
                                    Lay the ring on a flat surface and align its inner edge with a ruler to measure the inside diameter. Ensure you take the measurement in millimetres for precision.
                                </li>
                                <li>
                                    <strong>
                                        Determine the Diameter:
                                    </strong>
                                    Measure the straight-line distance across the inside of the ring, from one edge to the other. This is the inner diameter of the ring.
                                </li>
                                <li>
                                    <strong>
                                        Calculate the Circumference:
                                    </strong>
                                    Use the diameter to determine the circumference. The formula is: Circumference = π X Diameter. π (Pi) is approximately 3.14159.
                                </li>
                                <li>
                                    <strong>
                                        Consult a UK Ring Size Chart:
                                    </strong>
                                    With the calculated circumference, refer to a UK ring size chart. Match your measurement to find the corresponding UK ring size.
                                </li>
                            </ol>
                        </div>
                        <div class="sizing-tip-box-inner">
                            <h4>Measurement Example:</h4>
                            <p>
                                Imagine you measure the inner diameter of the ring, and it comes to 19.95 mm.
                                <br>
                                Circumference = π x Diameter
                                <br>
                                Circumference = 3.14159 x 20 mm
                                <br>
                                Circumference ≈ 62.7 mm
                                <br>
                                UK Ring Size = U
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="sizing-tip-box">
                        <div class="sizing-tip-desc-head">
                            <span><img src="{{env('APP_IMAGE_URL').'/assets/images/enage-ring-3.jpg'}}" alt=""></span>
                            <h3>Method 2: Use String or Floss</h3>

                        </div>
                        <p>
                            If your loved one doesn't wear rings regularly, using string or floss can be a great alternative. This method does require your loved one to know you are measuring their finger, so should be avoided for surprise engagements.
                        </p>
                        <div class="sizing-tip-box-inner">
                            <h4>Things You’ll Need:</h4>
                            <ul>
                                <li>A piece of non-stretchy string or dental floss.</li>
                                <li>A ruler.</li>
                                <li>Scissors.</li>
                                <li>A marker or pen.</li>
                            </ul>
                        </div>
                        <div class="sizing-tip-box-inner">
                            <h4>How To Measure Ring Size:</h4>
                            <ol>
                                <li>
                                    <strong>
                                        Wrap the String or Floss:
                                    </strong>
                                    Gently wind the string or floss around the base of the engagement finger, where the ring will sit. Ensure it's comfortable and not too tight.
                                </li>
                                <li>
                                    <strong>
                                        Mark the Measurement:
                                    </strong>
                                    Once wrapped, use the marker or pen to mark the spot where the string or floss meets its end.
                                </li>
                                <li>
                                    <strong>
                                        Measure the String or Floss:
                                    </strong>
                                    Straighten the string or floss and measure the distance from the end to the marked spot in millimetres using the ruler.
                                </li>
                                <li>
                                    <strong>
                                        Consult a UK Ring Size Chart:
                                    </strong>
                                    Take the measurement you've acquired, which represents the circumference, and compare it to a UK ring size chart. This will help you find the corresponding UK ring size.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="sizing-tip-box">
                        <div class="sizing-tip-desc-head">
                            <span><img src="{{env('APP_IMAGE_URL').'/assets/images/engage-ring-2.png'}}" alt=""></span>
                            <h3>Method 3: Use a Paper Strip</h3>

                        </div>
                        <p>
                            When you need a quick and simple way to determine the ring size for an engagement ring, wedding ring, or fashion ring, using a paper strip can be quite effective. Again, this method is not suitable for surprise engagements.
                        </p>
                        <div class="sizing-tip-box-inner">
                            <h5>Things You'll Need:</h5>
                            <ul>
                                <li>A strip of paper about 1cm wide and 10cm long.</li>
                                <li>A ruler.</li>
                                <li>Scissors.</li>
                                <li>A pen or marker.</li>
                            </ul>
                        </div>
                        <div class="sizing-tip-box-inner">
                            <h5>How To Measure Ring Size:</h5>
                            <ol>
                                <li>
                                    <strong>
                                        Wrap the Paper Strip:
                                    </strong>
                                    Begin by wrapping the strip of paper around the base of the engagement finger. Ensure it's neither too tight nor too loose but snugly fitting.
                                </li>
                                <li>
                                    <strong>
                                        Mark the Meeting Point:
                                    </strong>
                                    When the paper strip overlaps, use the pen or marker to mark the spot where it meets the end.
                                </li>
                                <li>
                                    <strong>
                                        Measure the Paper Strip:
                                    </strong>
                                    Unwind the strip from the finger and straighten it out. Use the ruler to measure the distance from the end of the strip to the marked spot in millimetres.
                                </li>
                                <li>
                                    <strong>
                                        Consult a UK Ring Size Chart:
                                    </strong>
                                    With the measurement in hand, which is the circumference of the finger, refer to a UK ring size chart. This will guide you to the equivalent UK ring size.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="guide-secret">
    <div class="container">
        <div class="">
            <h2 class="">Helpful Ring Sizing Tips</h2>
            <p>
                Choosing the ideal ring size is crucial, especially when creating custom engagement rings. Ensuring a perfect fit not only adds comfort but also complements the unique design of the ring, highlighting the special bond it represents.
            </p>
            <p>
                Below are our helpful ring sizing tips:
            </p>
        </div>
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                            <h3>Temperature Matters</h3>
                            <p>
                                Temperature has a direct impact on our fingers. In warmer conditions, fingers may swell, while they might shrink in cooler temperatures. It's best to measure ring size at room temperature to ensure an accurate fit.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                            <h3>Measure Multiple Times</h3>
                            <p>
                                The saying “measure twice, cut once” applies here. To get a reliable measurement, consider taking the size more than once, preferably at different moments during the day. This ensures that you account for any slight changes in finger size.
                            </p>
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
        </div>
    </div>
</div>


<div class="friendy-expert-sec">
    <div class="friendly-img"><img src="{{env('APP_IMAGE_URL').'/assets/images/friendly-expert.jpg'}}" alt=""></div>
    <div class="friendy-expert-desc">
        <h2>
            How To Find Out Someone's Ring Size
        </h2>
        <p>
            Surprising a loved one with an engagement ring is extremely romantic. However, determining their size without them knowing can be a challenge. Still, with a touch of creativity and observation, it's possible.
        </p>
        <h3>
            How To Measure UK Ring Size In Secret
        </h3>
        <p>
            Here are some discrete methods to determine your loved one’s ring size without them knowing:
        </p>
        <ul>
            <li>
                <strong>
                    Enlist a Friend's Help:
                </strong>
                Often, friends might have discussed ring sizes or even tried on each other's rings out of curiosity. A close friend might be able to get the information more casually without raising suspicions.
            </li>
            <li>
                <strong>
                    Trace the Ring:
                </strong>
                If they take off their rings when showering or sleeping, quickly trace the inside of the ring on a piece of paper. Later, you can use this traced outline to compare with standard size charts or even show it to a jeweller for more accurate sizing.
            </li>
            <li>
                <strong>
                    The String Method During Sleep:
                </strong>
                This is a riskier move, but if you're confident they won't wake up, you can lightly wrap a piece of string or floss around their ring finger while they sleep. Mark the point where the string meets and measure it later against a ring sizing chart.
            </li>
        </ul>
    </div>
</div>



<div class="inspiration-sec">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 ">
                <h2>
                    Find Perfectly Sized Diamond Engagement Rings at Marlow’s Diamonds
                </h2>
                <p>
                    Discover your perfect fit with Marlow's Diamonds, where precise sizing meets unparalleled elegance in our diamond engagement rings. Our extensive collection of GIA-certified diamond rings ensures a perfect match for every finger. The expert jewellers in our team will happily resize your ring according to your requirements, ensuring a flawless fit.
                </p>
                <p>
                    Though the above methods in our guide for ring sizes work perfectly, you can reach out for personalised ring size recommendations
                </p>
            </div>
        </div>
    </div>
</div>
@endsection