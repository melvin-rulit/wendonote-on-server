<h3>Добрый день, {{ $event->user->username }}!</h3>

Вами было создано событие, вот информация по нему:

<ul>
    <li><strong>Ваш никнейм: </strong>{{$event->user->username}}</li>
    <li><strong>E-mail: </strong>{{$event->user->email}}</li>
</ul>

<hr>

<ul>
    <li><strong>Название: </strong>{{ $event->name}}</li>
    <li><strong>Город: </strong>{{ $event->city->name }}</li>
    <li><strong>Род события: </strong>{{ $event->event_type->name }}</li>
    <li><strong>Дата: </strong>{{ $event->date}}</li>
</ul>

<br>

Хорошего дня!


