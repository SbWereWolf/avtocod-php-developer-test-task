<div class="row wall-message">
    <div class="col-md-1 col-xs-2">
        <?php
        $size = (string)(100 + $message->author->id);
        ?>
        <img src="http://lorempixel.com/{{$size}}/{{$size}}/people/"

             alt="{{ $message->author->name }}"
             class="img-circle user-avatar"/>
    </div>
    <div class="col-md-10 col-xs-9">
        <p>
            <strong>{{ $message->author->name }}:</strong>
        </p>
        <blockquote>
            <?php
            foreach (explode(PHP_EOL, $message->content) as $row):?>
            <p>{{ $row }}</p>
            <?php endforeach; ?>

        </blockquote>
    </div>
    <div class="col-md-1 col-xs-1">
        <form action="/message/destroy/{{$message->id}}"
              method="post"
              <?php use \App\BusinessLogic\Css; ?>
              @if($userId === (int)$message->users_id || $isAdmin)
              class="{{Css::VISIBLE}}"
              @endif
              @if($userId !== (int)$message->users_id)
              class="{{ Css::INVISIBLE}}"
            @endif
        >
            <button type="submit">X</button>
            {{ csrf_field() }}
        </form>
    </div>
</div>
