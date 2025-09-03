@php
    $getEngagementFaqs = getFaqByCategory(explode(',', $categoryData->faq_category));
@endphp

@if (isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
    <!-- FAQ Section start here -->
    <div class="faq-section engagement-ring-faq">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">
                    {{ isset($data->faq_title) ? $data->faq_title : "FAQ's" }}
                </h2>
                <p>Some of the most common Q&A's</p>
            </div>
            <div class="faq-list">
                <div class="accordion" id="accordionExample">
                    @foreach ($getEngagementFaqs as $key => $faq)
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="{{ $faq->id }}">
                                @if ($key == 0)
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true"
                                        aria-controls="collapse{{ $faq->id }}">{{ isset($faq->title) ? $faq->title : '' }}
                                    </button>
                                @else
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true"
                                        aria-controls="collapse{{ $faq->id }}">{{ isset($faq->title) ? $faq->title : '' }}
                                    </button>
                                @endif

                            </h3>
                            @if ($key == 0)
                                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse show"
                                    aria-labelledby="{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! isset($faq->description) ? $faq->description : '' !!}
                                    </div>
                                </div>
                            @else
                                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! isset($faq->description) ? $faq->description : '' !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->
@endif
