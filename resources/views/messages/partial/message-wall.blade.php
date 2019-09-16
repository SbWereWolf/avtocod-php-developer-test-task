@isset($messages)
    @foreach ($messages as $message)

        <?php $userId = auth()->id() ?>
        @include('messages.partial.message')
    @endforeach
@endisset
