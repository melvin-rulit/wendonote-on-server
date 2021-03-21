{{--
/**
 * Created by PhpStorm.
 * User: ic
 * Date: 26.04.2017
 * Time: 13:14
 */
--}}

<div class="Mmenu">
<a class="bt{{  $selected == 'home' ? '_act' : '' }}" href="/" >главная</a>
<a class="bt{{  $selected == 'preparation' ? '_act' : '' }}" href="/podgotovka_prazdnik" >подготовка праздника</a>
<a class="bt{{  $selected == 'catalog' ? '_act' : '' }}" href="/catalog" >каталог</a>
<a class="bt{{  $selected == 'newlyweds' ? '_act' : '' }}" href="/molodojeny.php" >молодожёны</a>
<a class="bt{{  $selected == 'reports' ? '_act' : '' }}" href="/otchety.php" >отчёты</a>
<a class="bt{{  $selected == 'news' ? '_act' : '' }}" href="/news.php" >новости</a>
<a class="bt{{  $selected == 'contacts' ? '_act' : '' }}"  href="/contakty.php">контакты</a>
</div>

