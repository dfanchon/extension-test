Testing BLADE
@foreach ($articles as $article)
<h1>[[ $article['title'] ]]</h1>
<br>Date: [[ $article['date'] ]]<br><br>
@if ($article['tags'])
Tags:
@foreach ($article['tags'] as $tag)
<a href="[[ $tag['uri'] ]]">[[ $tag['label'] ]]</a>
@endforeach
<br>
@endif
@if (substr($article['title'],0,5)!='VIDEO')
{!! $article['html'] !!}
@else
<br>Video:
{!! $article['videos'][0]['url'] !!}
@endif
@endforeach
