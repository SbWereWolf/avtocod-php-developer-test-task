<div class="row wall-message">
    <div class="col-md-1 col-xs-2">
        <?php
        $size = (string)(100 + $message->author->id);
        ?>
        <img src="http://lorempixel.com/{{$size}}/{{$size}}/people/"
             alt="{{ $message->author->name }}"
             class="img-circle user-avatar"/>
    </div>
    <div class="col-md-11 col-xs-10">
        <p>
            <strong>{{ $message->author->name }}:</strong>
        </p>
        <blockquote>
            <p>{{ $message->content }}</p>
        </blockquote>
    </div>
</div>
