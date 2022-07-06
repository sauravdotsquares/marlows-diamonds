@extends('layouts.front.app')
@section('content')

<!-- guide main -->
<div class="buying-engagementguide-page">
	<div class="main-guide-blok">
		<div class="container">
			<h1>{!!isset($data->title)?$data->title:""!!}</h1>
				{!!isset($data->short_description)?$data->short_description:""!!}
		</div>
	</div>

	<!-- Newsletter -->
	<div class="buying-guuides-newsletter">
		<div class="container">
			<!-- Join our mailing list section start -->
			<div class="joinour-mailing">
				<div class="joinour-wraper">
					<div class="joinour-heading">
						<div class="heading-h-two white-text">
							Subscribe to our Newsletter!
						</div>
						<p>Sign up to our newsletter to enter our yearly draw and win back the value of your first order!</p>
					</div>
					<div class="joinour-mailing-form">
						<form method="post" action="{{ route('maillist') }}">
							@csrf
							<div class="form-rows flexed flex-flex-wrap">
								<div class="form-col width-50">
									<label>Yor Name<sup>*</sup></label>
									<input required class="input-control {{ $errors->has('title') ? 'error' : '' }}" type="text" name="title" placeholder="Your Name">
									<!-- Error -->
									@if ($errors->has('title'))
									<div class="error">
										{{ $errors->first('title') }}
									</div>
									@endif
								</div>
								<div class="form-col width-50">
									<label>Email<sup>*</sup></label>
									<input required class="input-control {{ $errors->has('email') ? 'error' : '' }}" type="text" name="email" placeholder="Email Address">
									@if ($errors->has('email'))
									<div class="error">
										{{ $errors->first('email') }}
									</div>
									@endif
								</div>
							</div>
							<div class="form-rows flexed flex-flex-wrap">
								<div class="form-col">
									<label>Message</label>
									<textarea name="description" class="input-control {{ $errors->has('description') ? 'error' : '' }}" placeholder="Message"></textarea>

								</div>
							</div>
							<div class="action-btn">
								<button class="white-bg-btn">Subscribe</button>

							</div>
						</form>

					</div>
					<!-- @if(Session::has('success'))
						<div class="alert alert-success">
							{{Session::get('success')}}
						</div>
					@endif !-->
				</div>
			</div>

		</div>
	</div>
		<!-- Join our mailing list section End -->

	<!-- should buy --->
	<div class="should-buy-wraper">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="should-buy-col">
						<h2>Should You Buy Diamond Engagement Rings Online? Guide To Buying An Engagement Ring Online During Lockdown</h2>
					</div>
				</div>
				<div class="col-md-6">
					<div class="should-buy-col">
						<p>We understand there’s a lot of things to consider when buying an engagement ring from an online jeweller,
							and that’s why we’ll guide you through every step of the way to find the perfect choice of engagement ring with our expert help!</p>
						<p>This guide will help you better your knowledge of diamonds and their key factors, which are crucial to ensuring you get a fair
							purchase and the true quality of the diamond is reflected in the price.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- guides even odd list of image text -->
	<div class="buying-guides-img-text">
		<div class="container">
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-text">
							<h3>Is Buying An Engagement Ring Online A Good Idea?</h3>
							<p>The idea of whether you should buy an engagement ring
								online is only as good as the jeweller. So, to this
								question, we’d say YES! However, keep in mind that it's not straightforward,
								especially if you don’t know where to start or what ring style to go for.
								But don’t worry if you’re currently in this predicament, as we’ve got you covered.</p>
						</div>
					</div>
					<div class="col-lg-6  col-md-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-06.jpg" alt="img guide">
						</div>
					</div>
				</div>
			</div>
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6  col-md-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-04.jpg" alt="img guide">
						</div>
					</div>
					<div class="col-lg-6  col-md-6">
						<div class="buying-guidelist-text">
							<h3>Planning To Propose Over Lockdown?</h3>
							<p>Despite the current pandemic, the rate of people popping the big question has not dropped at all - if anything, we’ve seen this number grow.
								 With quarantined couples put to the test, many of them realised that they are capable of being committed to their relationship for life.</p>
							<p>Buying an engagement ring during lockdown brings its own challenges, with nowhere open to allow you to view the rings in person and
								consultations being taken digitally. But even before COVID was a thing, choosing the right engagement ring online was never
								going to be an easy task. With that in mind, here are some essentials that you should have prepared if you’re ordering a ring as a surprise.</p>
						</div>
					</div>
				</div>
			</div>
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss ">
				<div class="row">
					<div class="col-lg-6  col-md-6">
						<div class="buying-guidelist-text">
							<h3>Things To Consider When Buying An Engagement Ring Online</h3>
							<p>If you were looking for a guide to choosing an engagement ring, to help you choose
								 the best style, stone or ring colour - you’ve found it. Learn the key lingo and get expert inspiration along the way.</p>
								 <p>Buying an engagement ring online can be a daunting task, so where do you begin? Start by asking yourself the following questions one step at a time.
									  Build your knowledge of engagement rings and learn the difference between various metals, stones and settings, and don’t forget the essentials.</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-05.jpg" alt="img guide">
						</div>
					</div>
				</div>
			</div>
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-03.jpg" alt="img guide">
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-text">
							<h3>Should You Buy A GIA Certified Diamond Engagement Ring?</h3>
							<p>Our first piece of advice is that you need to buy a GIA Certified diamond engagement ring.
								 Not only because we stock a stunning range of GIA certified diamond engagement rings,
								 but also because you’ll receive a true representation of the product quality. So, rather than trusting a jeweller that
								  speaks about the relevant diamond terms, trust one that has had them certified</p>
						</div>
					</div>
				</div>
			</div>
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-text">
							<h3>What Should The Budget Be?</h3>
							<p>This is custom heading element</p>
							<p>There’s no ideal budget figure for an engagement ring because the national average changes depending on where you search. Plus,
								the jeweller will always suggest that you spend more to get the highest quality ring possible. The only ideal ring budget
								 will be one that allows you to comfortably afford the most beautiful option for your partner, without having to struggle
								 or compromise on things like the wedding and honeymoon.</p>
							<p>This is custom heading element</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-02.jpg" alt="img guide">
						</div>
					</div>
				</div>
			</div>
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-01.jpg" alt="img guide">
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="buying-guidelist-text">
							<h3>What Is The Right Ring Size?</h3>
							<p>Are you buying an engagement ring without knowing size? The ring size is sometimes overlooked until the final moments of engagement
								ring shopping, but if you don’t want any disappointment then it’s best to be clued up before going online and hunting
								for the perfect engagement ring. After all, you want the proposal to be as perfect as possible.</p>
							<p>However, finding the right engagement ring size is not a straightforward task if you want to keep things secret. Fortunately,
								we can recommend a few ways to find out the ring size without spilling the beans.</p>
						</div>
					</div>
				</div>
			</div>
			<!-- list end -->
		</div>
	</div>

	<!--How To Buy An Engagement Ring Without Knowing Size? -->
	<div class="howtobuy-engage-ring">
		<div class="container">
			<h3>How To Buy An Engagement Ring Without Knowing Size?</h3>
			<p>If your partner wears rings frequently, then you’ve got a good opportunity to check the ring size from their existing collection and take measurements.
				You can also see how the ring size fits on your own finger. Additionally, you can also download our online ring size guide.
				This works best with a simple band that can lay flat on the guide once you’ve printed it off.</p>
				<p>Simply hold it up to the various sizes to get a good idea and remember, you’re checking the inner diameter and inner circumference, not the outer edge of the ring.</p>
				<div class="download-btn">
					<a href="{{asset('')}}files/Marlows1-Engagement-Ring-Guide-4.3.pdf">Download Guide Size</a>
				</div>
				<p>And if you’re stuck between two particular ring sizes, it's best to go with the bigger size for two reasons. Firstly, you don’t want to offend your partner by making it seem that they have fatter fingers than you’d expected. Secondly, it’s not cheap to resize a ring to the correct size.</p>

		</div>
	</div>

	<!--What Diamond Setting To Go For? -->
	<div class="whatdiamond-to">
		<div class="container">
			<h3>What Diamond Setting To Go For?</h3>
			<p>There are four main types of settings available for diamond engagement rings. When buying online, you’ll often come across <br>
				the setting as the main way to categorise and filter down your options. Each of these styles has a unique look and purpose.<br>
				 Learn about their differences below:</p>
			<div class="whatdiamond-list">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="whatdimond-cols">
							<div class="whatdimond-cols-img">
								<img src="assets/images/pasted-image-0-1-300x300.png" alt="image1">
							</div>
							<div class="whatdimond-cols-text">
								Solitaire Diamond Engagement Rings
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="whatdimond-cols">
							<div class="whatdimond-cols-img">
								<img src="assets/images/unnamed-300x300.png" alt="image1">
							</div>
							<div class="whatdimond-cols-text">
								Halo Diamond Engagement Rings
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="whatdimond-cols">
							<div class="whatdimond-cols-img">
								<img src="assets/images/pasted-image-0-300x300.png" alt="image1">
							</div>
							<div class="whatdimond-cols-text">
								Shoulder Set Diamond Engagement Rings
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="whatdimond-cols">
							<div class="whatdimond-cols-img">
								<img src="assets/images/unnamed-1-300x300.png" alt="image1">
							</div>
							<div class="whatdimond-cols-text">
								Multistone Diamond Engagement Rings
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- What Diamond Quality To Choose? -->
	<div class="whatdiamond-quality">
		<div class="container">
			<div class="center-head-para text-center">
				<h3>What Diamond Quality To Choose?</h3>
				<p>Choosing a diamond style isn’t straightforward unless you’re clued up on the many different terms. Here, we’ll explain the<br>
				main characteristics of a diamond so you can understand the important factors and ensure that you’re not paying more than <br>
				what you should be.
				</p>
			</div>
			<div class="before-heading">
				<span>The 4 C's Explained</span>
			</div>
			<div class="cfour-explained-one">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whatdiamond-cols">
							<div class="whatdimond-cols-text">
							What Is Diamond Clarity?
							</div>
							<p>
								Diamond clarity is measured by the number of imperfections, also described as inclusions.
								The imperfections can be found either inside the stone or on the surface. The clarity chart for
								GIA diamonds ranges from Flawless (FL), which means the diamond is free from any blemishes or inclusions,
								to Included (I1, I2, and I3), where the brilliance and transparency may be compromised.
								There are 11 categories in total and each describes the level in which the clarity of the
								stone is affected when looking under 10x magnification. To the naked eye, it’s hard to spot
								any difference at all, therefore the clarity chart is required to grade the true quality of the diamond.
							</p>
							<div class="whatdiamond-imgs">
								<img src="assets/images/diamond-clarity.png" alt="diamond-clarity">
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whatdiamond-cols">
							<div class="whatdimond-cols-text">
								What Is Diamond Cut?
							</div>
							<p>
							The diamond cut is how we describe the shape of the diamond internally, as well as the polish and symmetry. Usually,
							when people think of the cut, they think of round, marquise or pear, for example. However, the cut is actually how we
							define how well the diamond interacts with light. The more precise the cut and craftsmanship, the better the symmetry
							and polish, and the more light that is reflected. The cut ultimately defines how the sparkle will appear in terms of:
							</p>
							<ul>
								<li><strong> Brightness:</strong>White light reflected from the diamond</li>
								<li><strong> Fire:</strong>scattered white light into all the colours of the rainbow</li>
								<li><strong> Scintillation:</strong>The level of sparkle, and the pattern of light and dark areas caused by the reflections within the diamond</li>
							</ul>
							<div class="whatdiamond-imgs">
								<img src="assets/images/diamond-cut.png" alt="diamond-cut">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="cfour-explained-one">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whatdiamond-cols">
							<div class="whatdimond-cols-text">
								What Is Diamond Carat Weight?
							</div>
							<p>
							Carat ultimately represents the metric used to measure diamond weight. A single “carat” is equal to 200 milligrams. Each carat is then split into 100 points
							and presented as a decimal. This weight is a huge defining factor when it comes to price, a 1-carat diamond could be up to six times more expensive
							 than a 0.5 carat. However, you still need to take into account the clarity and quality of the cut for example, as you may be paying for a heavier
							  diamond, only to compromise on the sparkle factor. The dealer may decide to describe the carat as a decimal rather than the more common fraction,
							  so we’ve provided a small chart here for you to convert carat metrics from fraction to decimal if required.
							</p>
							<div class="whatdiamond-tables">
								<table border-collpase="collapse">
									<thead>
									<tr>
										<th>Carat Fraction</th>
										<th>Decimal Equivalent</th>
										</tr>
									</thead>
									<tbody>

										<tr>
											<td>1/10</td>
											<td>.09-.11</td>
										</tr>
										<tr>
											<td>1/8</td>
											<td>.12-.13</td>
										</tr>
										<tr>
											<td>1/7</td>
											<td>.14-.15</td>
										</tr>
										<tr>
											<td>1/6</td>
											<td>.16-.17</td>
										</tr>
										<tr>
											<td>1/5</td>
											<td>..18-.22</td>
										</tr>
										<tr>
											<td>1/4</td>
											<td>.23-.28</td>
										</tr>
										<tr>
											<td>1/3</td>
											<td>.29-.36</td>
										</tr>
										<tr>
											<td>3/8</td>
											<td>.37-.44</td>
										</tr>
										<tr>
											<td>1/2</td>
											<td>..45-.58</td>
										</tr>
										<tr>
											<td>5/8</td>
											<td>.59-.68</td>
										</tr>
										<tr>
											<td>3/4</td>
											<td>.69-.82</td>
										</tr>
										<tr>
											<td>7/8</td>
											<td>.83-.94</td>
										</tr>
										<tr>
											<td>1.0</td>
											<td>.95-1.05</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whatdiamond-cols">
							<div class="whatdimond-cols-text">
								What Is Diamond Colour?
							</div>
							<p>
							We often think of all diamonds being transparent or white, although they can come in a range of colours including pink, blue, green and even yellow.
							 However, if your white diamond has a yellow tint, this will reflect less true colour and will ultimately reduce the cost.
							 The GIA colour scale grades diamonds from D at the high end (colourless), down to Z (light colour) at the lower end of the scale.
							  So, while your white diamond might be white by definition, it may appear slightly tinted. The less body colour that they have, the greater their value will be.
							</p>
							<div class="whatdiamond-imgs">
								<img src="assets/images/marlows-diamond-colour.png" alt="diamond-cut">
							</div>
							<p>
								The colour is tested when the stone is upside down so that less light is reflected, and it's easier to judge the colour or lack of.
								This also means that when the diamond is set, the colour may appear whiter.
							</p>
							<p>
								Tip: a gold band may disguise the yellow tint of a J coloured stone for example, whereas a silver or platinum band is likely to highlight the defect more.
							</p>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="whichring-metal-wrap">
		<div class="container">
			<div class="whichring-rows">
				<div class="row">
					<div class="col-lg-5 col-md-5">
						<div class="whichring-col">
							<div class="whatdimond-cols-text">
								Which Ring Metal Colour To Choose?
							</div>
							<p>Choosing the band colour for an engagement ring can be a tough factor to decide on unless your partner already has their heart
								set fully on a particular metal colour - this makes things very easy for you! However, if you’re buying a ring online then it
								makes sense to understand the benefits of one metal over another, so take a look at our ring metal comparison chart.
							</p>
						</div>
					</div>
					<div class="col-lg-7 col-md-7">
						<div class="whichring-col">
							<div class="whichring-table">
								<table border-collapse="collapse">
									<thead>
										<tr>
											<th>Metal Colour</th>
											<th>Description</th>
											<th>Pros</th>
											<th>Cons</th>
										</tr>
									</thead>
									<tbody>

										<tr>
											<td>Platinum</td>
											<td>Toughest and lasts longest</td>
											<td>Durable colour and shape</td>
											<td>Most expensive</td>
										</tr>
										<tr>
											<td>Gold</td>
											<td>Natural rich yellow colour</td>
											<td>Rare and classic</td>
											<td>It’s soft, needs strong alloys</td>
										</tr>
										<tr>
											<td>White Gold</td>
											<td>Gold mixed with rhodium alloys</td>
											<td>Colour like platinum but more affordable</td>
											<td>Rhodium fades, needs recoating</td>
										</tr>
										<tr>
											<td>Rose Gold</td>
											<td>Gold with rose copper alloy</td>
											<td>Will not scratch and appears vintage</td>
											<td>Redness fades over time</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="whichring-rows">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whichring-col">
							<img src="assets/images/metal-colours.png" alt="">
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whichring-col">
							<p>So, there are a few ways to decide on the best metal choice for your engagement ring, however,
								 if you wanted to class them by popularity and quality, we’d rank them in this order:</p>
							<p>1) Platinum. It's luxurious to touch and is highly durable, so go with this if you have the budget.</p>
							<p>2) Yellow gold. Versatile in price and rich in colour, so go with this if your partner likes the classic gold look.</p>
							<p>3) White gold. While we love it just as much as platinum, it requires a little maintenance over time as the alloys fade.</p>
							<p>4) Rose gold. Like white gold, it may require maintenance in the future.</p>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!--Does Lifestyle Affect Choice Of Engagement Ring? -->
	<div class="doeslifestyle-wraper">
		<div class="container">
			<div class="lifestyle-heading">
				Does Lifestyle Affect Choice Of Engagement Ring?
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="lifestyle-text">
						<p>Indeed, the lifestyle of your fiance-to-be could affect your choice when buying a diamond engagement ring online,
							as the intention is to find one that they’ll be able to wear every day. But there are some cases where people
							 will remove their ring for certain activities to protect it and ensure they don’t lose any of the diamonds.
							 However, the more they remove the ring, the more chance there is of losing it, so you might want to avoid certain settings.</p>
						<p>This is custom heading element</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="lifestyle-text">
						<p>If your fiance-to-be works with their hands mostly in a manual based job, you should avoid diamond engagement rings
							with a defined prong setting, as there is more risk of catching it on something and losing a stone. In this case,
							we would recommend a ring with a bezel setting that holds the diamond in place with a rim around the perimeter of
							 the stone. This style of ring is much less likely to snag on clothing and features fewer crevices to keep clean.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Does Style & Personality Affect Choice Of Engagement Rings? -->
	<div class="doesstyle-wraper">
		<div class="container">
			<div class="center-head-para text-center">
					<h3>Does Style & Personality Affect Choice Of Engagement Rings?</h3>
					<p>When looking at diamond engagement rings online, a good way to whittle down the last few options can be to look at the style <br>
						and personality of your fiance-to-be. A diamond engagement ring is also a testament to how well you know your partner, so if <br>
						you have no idea what to go for, start to think about their style of fashion and jewellery, as well as what the various diamond <br>
						shapes say about the personality of those who wear it.
					</p>
				</div>
			<div class="doesstyle-blocks">
				<div class="whatdimond-cols-text">
					Which Ring Metal Colour To Choose?
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whatsdoes-col">
							<p>This can give you hints as to what they will be happy to wear and what will go with most of their daily attire. For example:</p>
							<p>Someone who only wears silver coloured jewellery would probably go with a platinum/white gold engagement ring over gold.</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whatsdoes-col">
							<p>This is custom heading element</p>
							<p>Someone with a more discrete style would prefer something like a single solitaire over a cluster or multistone engagement ring</p>
						</div>
					</div>
				</div>
			</div>

			<div class="doesstyle-blocks">
				<div class="whatdimond-cols-text">
					What Do Different Ring Settings Symbolise?
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whatsdoes-col">
							<p>In addition to the clothes that they wear, you could also look at matching up your choice of engagement ring with your partner’s personality and characteristics.
								Allow us to explain:</p>
							<p><strong>Round Brilliant Cut Diamond</strong> - One of the oldest cut styles, classic and representative of a strong family ethos and the desire for a stable, comfortable life.
							 It's said that people who wear these diamond rings are strong, direct and honest.</p>
							<p><strong>Square/Princess Cut Diamond</strong> - A more modern style cut, often chosen for its deep sparkle. It’s an ideal choice for someone who takes chances
							 and enjoys the spotlight.</p>
							<p><strong>Emerald Cut Diamond</strong> - Glamorous but with a vintage feel about it. An emerald cut is an ideal choice for someone with strong self-confidence,
								assured and in control. Emerald cut stones make stunning large stones while their clean lines ensure it doesn't look too over the top.</p>
							<p>This is custom heading element</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whatsdoes-col">
							<p><strong>Heart Cut Diamond</strong> - The heart cut represents the true sentiment of traditional love. An ideal diamond cut for those who are playful and bubbly,
							perfect for the true romantic.</p>
							<p><strong>Pear Cut Diamond</strong>- A unique edge for those who like to stand out from the rest and take risks. The pear cut diamond represents someone who is
							 outgoing and likes new experiences.</p>
							<p><strong>Marquise Cut Diamond</strong> - For those who are larger than life, this vintage-styled cut is perfect for those who like to break tradition and
							stand out with a creative edge</p>
							<p><strong>Cushion Cut Diamond </strong> - The cushion cut diamond provides a soft look for those who still like to sparkle a lot. This bold yet elegant cut is ideal for those who love tradition.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- What Is Their Hand Type? -->
	<div class="whatsthere-wraper">
		<div class="container">
			<div class="whatsthere-rows">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whatsthere-cols">
							<div class="whatdimond-cols-text">
								What Is Their Hand Type?
							</div>
							<p>Choosing a diamond engagement ring based on hand type might sound slightly specific, however, this is an important part of narrowing down the options.
								Your fiance-to-be most likely has an idea of what ring styles don’t match their hand type, therefore these details can't afford to be missed
								when buying an engagement ring online.</p>
							<p>All hands have a unique personality, so you must find a style of ring that is going to flatter and compliment this personality. The table below gives a starting point,
								however, remember to bear in mind their personal style too. Your partner's taste may not reflect the most flattering choice of ring, so you may
								need to get a second opinion if that's the case.</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whatsthere-cols">
							<div class="whatdiamond-tables">
								<table>
									<thead>
										<tr>
											<th>Hand / Finger Type</th>
											<th>Most Flattering Ring Designs</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Wide or Large Fingers</td>
											<td>Wide band, Split shanks, Elongated diamond</td>
										</tr>
										<tr>
											<td>Slender Fingers</td>
											<td>Smaller stones, Medium-thick bands</td>
										</tr>
										<tr>
											<td>Long Fingers</td>
											<td>Most cuts and sizes, Wide band will elongate</td>
										</tr>
										<tr>
											<td>Short Fingers</td>
											<td>Oval Pear and Marquise cut, Narrow band</td>
										</tr>
										<tr>
											<td>Big Knuckles</td>
											<td>Wider band, Multistone, Coloured stones</td>
										</tr>
										<tr>
											<td>Small Hands</td>
											<td>Round, Princess and Heart cut</td>
										</tr>
										<tr>
											<td>Large Hands</td>
											<td>Wider band, Multistone, Coloured stones</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="whatsthere-rows">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="whatsthere-cols text-center">
							<img src="assets/images/unnamed-2.png" alt="image">
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="whatsthere-cols">
							<div class="whatdimond-cols-text">
								Is Buying An Engagement Ring Online Safe?
							</div>
							<p>This is custom heading element.</p>
							<p>If you are worried about the idea of having an engagement ring delivered by mail, you can rest assured that you’re carrying out a safe and secure purchase with Marlow’s,
								and we will ensure that your ring arrives safely by recorded delivery.</p>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

	<!-- Diamond Terms Explained -->
	<div class="diamondterms-wraper">
		<div class="container">
			<div class="center-head-para text-center">
				<h3>Diamond Terms Explained</h3>
				</p>
			</div>
			<div class="diamondterm-faq">
			<div class="faq-list">
					<div class="accordion" id="accordionExample">
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingAe">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAe" aria-expanded="true" aria-controls="collapseAe">
								A - E
							</button>
							</h2>
							<div id="collapseAe" class="accordion-collapse collapse" aria-labelledby="headingAe" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<b>Abrasion</b> – A small scratch on the surface of the diamond.
									<br><br>
									<b>Bezel Set</b> – A setting in which the diamond is mounted with a thin metal strip rather than prongs. Bezel settings can be of any shape and will snag less on clothing.
									<br><br>
									<b>Blemish</b> – An umbrella term for abrasions, nicks, extra facets, polish marks, natural defects, and scratches. Most are invisible to the naked eye and are shown on a plotting diagram.
									<br><br>
									<b>Brilliance</b> – The amount of white light thrown from the diamond’s crown. Brilliance is affected by the diamond's clarity, polish, proportions, symmetry, and the quality of the cut.
									<br><br>
									<b>Brilliant Cut</b> – A round-cut diamond that features triangular facets (or kite shaped) extending from the diamond’s centre, out to the edges of the stone’s crown and pavilion.
									<br><br>
									<b>Bruise</b> – An imperfection (or inclusion) that breaks the surface of the diamond, like a very shallow graze likely to be caused by wear and tear.
									<br><br>
									<b>Carat</b> – 1 carat is equal to 0.2 grams (200 milligrams), and this is a measure of weight, not size (size is measured by Total Carat Weight)
									<br><br>
									<b>Cavity</b> – A tiny defect (inclusion) in the form of an opening that breaks the surface of a diamond.
									<br><br>
									<b>Chip</b> – A jagged, shallow break that affects the diamond’s value and decreases the level of durability.
									<br><br>
									<b>Clarity</b> – A rating that affects the beauty, ultimately this is a score that shows the lack of inclusions such as chips or blemishes.
									<br><br>
									<b>Cleavage</b> – A breakable weak point that could split the diamond upon hitting a hard surface.
									<br><br>
									<b>Cloud</b> – An inclusion that can make a diamond appear slightly foggy but most clouds are invisible to the naked eye, magnification is required.
									<br><br>
									<b>Colour</b> – A grading that determines the tint of the diamond, and how pure it is. This ranges from colourless (D) to saturated (Z).

									<br><br>
									<b>Cushion-Cut</b> –  A brilliant-cut rectangular/square diamond shape featuring curved sides, and rounded corners for a soft look and strong sparkle.
									<br><br>
									<b>Cut</b> – This describes the diamond’s surfaces or facets that strongly affect the beauty of the stone. Various diamond cuts are made to increase sparkle (dispersion, brilliance, and scintillation), or by making it appear bigger.
									<br><br>
									<b>Dispersion</b> – Also known as “fire,” this is where the light reflected from the cut separates into the different colours of the rainbow.
									<br><br>
									<b>Durability</b> – The toughness, stability, and hardness of a diamond, and how well it can resist damage.
									<br><br>
									<b>Emerald Cut</b> – A square / rectangular-shaped diamond with diagonal corners and a flatter table.

								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingFj">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFj" aria-expanded="true" aria-controls="collapseFj">
								F - J
							</button>
							</h2>
							<div id="collapseFj" class="accordion-collapse collapse" aria-labelledby="headingFj" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<b>Facet</b> – one of the many faces cut into the shape of the diamond, the flat edges of the stone.
									<br><br>
									<b>Feather</b> – A small fracture inside of the diamond, which can be either completely inside, or extend out to the surface.
									<br><br>
									<b>Fire</b> – The amount of colour that reflects from the diamond’s when it is moved in light, also known as the brilliance.
									<br><br>
									<b>Flaw</b> – Any inclusion on the diamond, natural or manmade.
									<br><br>
									<b>Four C's</b> –  measures that enable certification and comparison the quality of the diamonds - cut, colour, clarity, and carat weight.
									<br><br>
									<b>Graining</b> – And inclusion that shows the growth pattern of a diamond. Can be found both internally and externally.
									<br><br>
									<b>Heart Cut</b> – A brilliant-cut diamond shaped into a heart.
									<br><br>
									<b>Inclusion</b> – An umbrella term used for describing any imperfections and flaws that appear on the diamond - despite the high level of craftsmanship, most diamonds will have inclusions.
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingPz">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePz" aria-expanded="true" aria-controls="collapsePz">
								P - Z
							</button>
							</h2>
							<div id="collapsePz" class="accordion-collapse collapse" aria-labelledby="headingPz" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<b>Pear Shape</b> – A brilliant-cut diamond with a round end and a pointed end, like a tear shape.
									<br><br>
									<b>Plotting Diagram</b> – like an x-ray of the diamond that calculates the quality of the shape and style of a diamond, and for spotting inclusions.
									<br><br>
									<b>Point</b> – A measurement of weight equal to 1/100 carat.
									<br><br>
									<b>Princess Cut</b> – A brilliant-cut diamond shaped like a square/rectangle, with pointed corners - a very classic shaped diamond
									<br><br>
									<b>Radiance</b> – The amount of light reflected by a diamond, in other words, the level of “sparkle” is possessed.
									<br><br>
									<b>Round Brilliant Cut</b> – A classic round cut diamond, usually featuring up to 58 facets, but can feature even more on occasion.
									<br><br>
									<b>Scintillation</b> – The mirror-like reflections made by the diamond’s facets when exposed to light.
									<br><br>
									<b>Symmetry</b> – how symmetrical the cut is, measuring from poor to ideal, and contributes to the level of radiance and scintillation.
									<br><br>
									<b>Table</b> – The largest surface of a cut diamond, the top facet.
									<br><br>
									<b>Twinning Wisp</b> – A ribbon-like inclusion that could be featured inside the stone.
									<br><br>
									<b>Wisp</b> – A thin, curved inclusion that can appear hair-like or cloud-like
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>


</div>
<!-- main end of page middle text-->


<!-- Section Reviews -->
<div class="container">
<div class="rating-review-block">
				<div class="owl-carousel owl-theme slider-review">
				@include('front.pages.reviews')
				</div>
			</div>
</div><!-- insta photos section start -->
@include('front.includes.instagram-section')
<!-- insta photos section end -->

@endsection
