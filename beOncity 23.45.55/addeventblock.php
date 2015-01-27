<div id="addeventblock" class="block fl_r">
    <div class="title">Новое событие</div>
    <div id="sendEvent">ОК</div>
    <div class="content">
        <div id="eventtype" class="item">
            <div id="checkType"></div>
            <div class="clearfix"></div>
        </div>
        <div class="item">
            <div class="image fl_l"><div class="cover"><img src="/img/plus.png" alt="icon"/></div></div>
            <div class="text fl_r"><input type="text" id="eventname" placeholder="Название события" maxlength="100"/></div>
            <div class="clearfix"></div>
        </div>
        <div class="item">
            <div class="image fl_l"><div class="cover"><img src="/img/location.png" alt="icon"/></div></div>
            <div class="text fl_r"><input type="text" id="eventloc" placeholder="Москва, улица Арбат, д 15"/></div>
            <div class="clearfix"></div>
        </div>
        <div id="eventdate" class="item">
            <div class="image fl_l"><div class="cover"><img src="/img/date.png" alt="icon"/></div></div>
            <div class="text fl_r"><input type="text" id="datepicker" placeholder="15 Августа, 2013  09:15" readonly/></div>
            <div class="clearfix"></div>
        </div>
        <div class="item">
            <div class="image fl_l"><div class="cover"><img src="/img/desc.png" alt="icon"/></div></div>
            <div class="text fl_r" id="eventdescription"><textarea onfocus="descfocus('eventdesc')" onblur="descblur('eventdesc')" type="text" onKeyDown="limitText(this,800)" onKeyUp="limitText(this,800)" id="eventdesc" maxlength="800" placeholder="Описание события"></textarea></div>
            <div class="clearfix"></div>
        </div>
        <div id="extended">
            <div class="title">&mdash; А еще есть &mdash;</div>
            <a href="/update" title="Extended and Detailed Form"><div id="moreParams">Расширенная форма</div></a>
        </div>
    </div>
    <div id="errorText"></div>
    <div id="controlls">
        <div id="centeredButtons">
            <div id="confirm" class="fl_l">Да</div>
            <div id="cancel" class="fl_r">Нет</div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>