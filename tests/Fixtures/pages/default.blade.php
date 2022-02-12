<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $page->title }}</title>

    @forelse($page->getMeta() as $key => $value)
        <meta name="{{ $key }}" content="{{ $value }}">
    @empty
    @endforelse
</head>
<body>
    {!! $page->content !!}
</body>
</html>
