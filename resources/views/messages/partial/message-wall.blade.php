@isset($messages)
    @foreach ($messages as $message)

        <?php $diff = 0;?>
        @include('messages.partial.message')
    @endforeach
@endisset
