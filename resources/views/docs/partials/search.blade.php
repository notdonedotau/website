<form class="docs-search {{ $class ?? '' }}" action="{{ route('docs.index') }}" method="GET" role="search">
    <label for="{{ $inputId }}">Search docs</label>
    <div class="docs-search__control">
        <input
            id="{{ $inputId }}"
            name="q"
            type="search"
            value="{{ $searchQuery ?? '' }}"
            placeholder="Search setup, incidents, domains..."
            autocomplete="off"
        >
        <button type="submit">Search</button>
    </div>
</form>
