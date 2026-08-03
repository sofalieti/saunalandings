@if(isset($faqItems) && count($faqItems))
<div class="pc-faq-list">
    @foreach($faqItems as $faqItem)
        <div class="pc-faq-item">
            <h3 class="pc-faq-q">{{ $faqItem->question }}</h3>
            <div class="pc-faq-a">{!! nl2br(e($faqItem->answer)) !!}</div>
        </div>
    @endforeach
</div>
@endif
