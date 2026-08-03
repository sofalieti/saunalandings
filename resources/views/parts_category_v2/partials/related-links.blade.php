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
<section class="au-section au-reveal">
    <div class="au-shell">
        <div class="au-head">
            <span class="au-label">Navigate</span>
            <h2 class="au-title">Helpful links</h2>
        </div>
        <div class="au-pills">
            <a href="/">Home</a>
            @foreach($relatedPages as $page)
                <a href="{{ $page['url'] }}">{{ $page['label'] }}</a>
            @endforeach
            @foreach($relatedCategories as $relCategory)
                <a href="{{ route('category', ['slug' => $relCategory->slug]) }}">{{ $relCategory->name }}</a>
            @endforeach
        </div>
    </div>
</section>
