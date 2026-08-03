@if(isset($faqItems) && count($faqItems))
<div class="pc-faq-list">
    @foreach($faqItems as $faqItem)
        <div class="pc-faq-item">
            <details @if($loop->first) open @endif>
                <summary>{{ $faqItem->question }}</summary>
                <div class="pc-faq-a">{!! nl2br(e($faqItem->answer)) !!}</div>
            </details>
        </div>
    @endforeach
</div>
@endif
