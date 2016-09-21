<!-- Навигационная панель с 3 вкладками --> 
<ul class="nav nav-tabs" role="tablist" id="tab-product">
  <li class="nav_li active"><a href="#homeExample" role="tab" data-toggle="tab">Главная</a></li>
  <li class="nav_li"><a href="#questionsExample" role="tab" data-toggle="tab">Вопросы</a></li>
  <li class="nav_li"><a href="#articlesExample" role="tab" data-toggle="tab">Статьи</a></li>
</ul>
 
<!-- Содержимое вкладок -->
<div class="tab-content">
  <!-- Содержимое 1 вкладки -->
  <div class="tab-pane active" id="homeExample"> 
    <?=$message['$items'][$message['$iid']]['description'];?>
  </div>
  <!-- Содержимое 2 вкладки -->
  <div class="tab-pane active" id="questionsExample"> 
    <?=$message['$items'][$message['$iid']]['specifications'];?>
  </div>
  <!-- Содержимое 3 вкладки -->
  <div class="tab-pane active" id="articlesExample"> 
    <?=$message['$docs'];?>
  </div>
</div>