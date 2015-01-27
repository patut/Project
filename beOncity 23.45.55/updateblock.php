<div id="filters">
                <div class="title fl_l">Перенесите маркер в нужную Вам точку на карте, чтобы указать место проведения события</div>
            </div>
            <div id="mapcontainer">
                <div id="map"></div>
            </div>
            <div id="modeside" class="fl_r">
                <div id="currdate"></div>
                <div id="addeventblock" class="block fl_r" style="min-height:502px">
                    <div class="title">Добавить событие</div>
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
                            <div class="text fl_r" id="eventdescription"><textarea type="text" onKeyDown="limitText(this,800)" onKeyUp="limitText(this,800)" id="eventdesc" maxlength="800" placeholder="Описание события"></textarea></div>
                            <div class="clearfix"></div>
                        </div>
                        <form style="height:0;overflow:hidden" method="post" action="/server/e-upload.php" id="uploadform" enctype="multipart/form-data">
                            <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
                                <tr> 
                                    <td width="246">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10240000">
                                        <input name="userfile" accept="image" type="file" id="userfile">
                                        <input name="id" id="fileid" type="hidden" value="">
                                    </td>
                                    <td width="80">
                                        <input name="upload" type="submit" class="box" id="upload" value=" Выбрать ">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div class="item">
                            <div class="image fl_l"><div class="cover"><img src="/img/image.png" alt="icon"/></div></div>
                            <div id="chooseImg" class="fl_r">Выбрать</div>
                            <div class="text fl_l" id="filename"><input type="text" id="filenameholder" placeholder="Изображение" readonly/></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div id="errorText"></div>
                    <div id="controlls">
                        <div id="centeredButtons">
                            <div id="confirm" class="fl_l">ДА</div>
                            <div id="cancel" class="fl_r">НЕТ</div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>