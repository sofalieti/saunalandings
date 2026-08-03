@php
    $relatedPages = [];
    foreach (['how_to_choose' => 'How to choose', 'troubleshooting' => 'Troubleshooting', 'repair' => 'Repair / Fix', 'faq' => 'FAQ'] as $var => $label) {
        if (page_template($var)) {
            $relatedPages[] = [
                'label' => $label,
                'url' => route('page_template_without_state', ['slug' => $var]),
            ];
        }
    }
    $relatedCategories = request()->get('brand')->categories()
        ->where('active', true)
        ->orderBy('position')
        ->orderBy('name')
        ->get();
@endphp
<section class="pc-section pc-related">
    <div class="container">
        <span class="pc-section-kicker">Navigate</span>
        <h2>Helpful links</h2>
        <ul class="pc-related-list">
            <li><a href="/">Home</a></li>
            @foreach($relatedPages as $page)
                <li><a href="{{ $page['url'] }}">{{ $page['label'] }}</a></li>
            @endforeach
            @foreach($relatedCategories as $relCategory)
                <li><a href="{{ route('category', ['slug' => $relCategory->slug]) }}">{{ $relCategory->name }} goods</a></li>
            @endforeach
        </ul>
    </div>
</section>
