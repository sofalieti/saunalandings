@php
    $auQuoteFormId = isset($formId) ? $formId : 2;
    $auQuoteLabel = isset($label) ? $label : 'Fitment check';
    $auQuoteTitle = isset($title) ? $title : 'Send a photo, get the exact part';
@endphp
<section class="au-section au-reveal" id="quote">
    <div class="au-shell">
        <div class="au-quote">
            <div class="au-quote__copy">
                <span class="au-label">{{ $auQuoteLabel }}</span>
                <h2 class="au-title">{{ $auQuoteTitle }}</h2>
                <div class="au-quote__points">
                    <div class="au-quote__point">
                        <strong>Photograph the old part</strong>
                        Include the wiring, the mounting frame and any label with a model or serial number.
                    </div>
                    <div class="au-quote__point">
                        <strong>A specialist checks the fitment</strong>
                        We compare it against the cabin brand and model before anything is charged.
                    </div>
                    <div class="au-quote__point">
                        <strong>You order the confirmed part</strong>
                        Shipping across the USA and Canada, free on orders above $300.
                    </div>
                </div>
                <div class="au-contacts">
                    <div><span>Toll free</span> <a href="tel:+18885597278">+1-888-559-PART (7278)</a></div>
                    <div><span>Texting / SMS 24/7</span> <a href="tel:+13477461765">+1-347-746-1765</a></div>
                </div>
            </div>
            <div class="au-form-card">
                @include('forms.form', ['form_id' => $auQuoteFormId])
            </div>
        </div>
    </div>
</section>
