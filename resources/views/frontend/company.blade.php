<h1>Company:  @if (app()->getLocale() == 'ne')
    {{ $company->title_ne }}
@else
    {{ $company->title }}
@endif </h1>
