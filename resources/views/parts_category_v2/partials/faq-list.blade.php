@if(isset($faqItems) && count($faqItems))
<div class="au-faq">
    @foreach($faqItems as $faqItem)
        <details class="au-faq__item" @if($loop->first) open @endif>
            <summary>{{ $faqItem->question }}</summary>
            <div class="au-faq__answer">{!! nl2br(e($faqItem->answer)) !!}</div>
        </details>
    @endforeach
</div>
@endif
