@if ($paginator->hasPages())
    {{-- Навигация по страницам --}}
    <nav aria-label="Навигация по страницам">
        <ul class="pagination justify-content-center">
            {{-- Ссылка на предыдущую страницу --}}
            @if ($paginator->onFirstPage())
                {{-- Если текущая страница первая, показываем неактивную кнопку --}}
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                {{-- Активная ссылка на предыдущую страницу --}}
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Элементы пагинации (номера страниц) --}}
            @foreach ($elements as $element)
                {{-- Разделитель "Три точки" (пропущенные страницы) --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Массив ссылок на страницы --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Текущая активная страница --}}
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            {{-- Ссылка на другую страницу --}}
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Ссылка на следующую страницу --}}
            @if ($paginator->hasMorePages())
                {{-- Активная ссылка на следующую страницу --}}
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                {{-- Если текущая страница последняя, показываем неактивную кнопку --}}
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif