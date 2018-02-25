<?php

use Misc\Security;

include $controller->getPathView() . 'header.php';
?>

<div class="wrap-content">


    <div id="group-character" class="choice-list">
        <form id="submitCharacter" action="" style="display: inline-block">
            <div class="row row-label col-xs-12">
                <span class="label-rech">Chọn nhân vật nạp</span>
            </div>
            <div class="row row-label col-xs-12">
                Game: <span class="label-rech  game-list-name"><?php echo $gameDetail['name'] ?></span>
				
				<input type="hidden" id="game-list" name="game-list" value="<?php echo $gameDetail['app_id'] ?>"/>
				
				<input type="hidden" value="<?php echo $hashToken ?>" name="token" id="token" />
                <input type="hidden" value="<?php echo $event ?>" name="event" id="event" />
            </div>
            <div class="choice-item">
        <span class="header-line">
            <span class="icon"></span>
            <span class="title">Chọn máy chủ:</span>
        </span>
                <select id="serverlist" name="serverlist" class="form-control required">
                    <option value="">Chọn máy chủ</option>
                    <?php
                    if ($serverList == true) {
                        foreach ($serverList as $key => $value) {
                            if ($value["is_test_server"] == 1 && !in_array(Misc\Http\Util::get_remote_ip(), array("127.0.0.1", "118.69.76.212", "115.78.161.88", "115.78.161.124", "115.78.161.134"))) {
                                continue;
                            }
                            ?>
                            <option value="<?php echo $value["server_id_merge"] ?>"
                                    token-data="<?php echo $value["server_id"] ?>" hashToken="<?php echo $hashToken ?>"
                                    maintenance="<?php echo $value["is_maintenance"] ?>"><?php
                                $position = strpos($value["server_name"], "[");
                                //                                    if ($position != -1)
                                //                                        $serverName = substr($value["server_name"], 0, $position);
                                //                                    else
                                $serverName = $value["server_name"];
                                //var_dump($value["server_name"]);die;
                                echo trim($serverName) . ($value["is_maintenance"] == 1 ? " (Đang bảo trì)" : "");
                                ?></option>
                            <?php
                        }
                    }
                    ?>

                </select>
            </div>
            <div class="choice-item">
        <span class="header-line">
            <span class="icon"></span>
            <span class="title">Chọn nhân vật:</span>
        </span>
                <select id="character" name="character" class="form-control required">
                    <option value="">Chọn nhân vật</option>
                </select>
            </div>
            <div class="row-line">
                <span class="btn-button next">Tiếp tục</span>
            </div>

        </form>
    </div>


    <div id="group-card" class="choice-list">
        <form id="submitCard" action="/topup" style="display: inline-block;width:100%">

            <div class="row row-label col-xs-12">
                <span class="label-rech">Chọn loại thẻ nạp</span>
            </div>

            <div class="row row-label col-xs-12">
                Game: <span class="label-rech"><?php echo $gameDetail['name'] ?></span>
            </div>
            <div class="">
                <?php if (is_array($paymentList) && isset($paymentList["card"]["data"])) { ?>
                    <?php
                    foreach ($paymentList["card"]["data"] as $key => $value) {
                        $icon_img = '/v2/nap/images/' . $value['card'] . ".png";
                        ?>

                        <div class="card-telco">
                            <div class="card-content-telco">
                                <a href="#" class="target-game-telco"></a>
                                <div class="cover-telco">
                                    <div class="cover-image-container-telco">
                                        <div class="cover-outer-align-telco">
                                            <div class="cover-inner-align-telco">
                                                <label>
                                                    <input type="radio" name="cardType" class="required"
                                                           value="<?php echo $value["card"]; ?>" title="<?php echo $value['message'];?>"/>
                                                    <img alt="" class="cover-image-telco" src="<?php echo $icon_img; ?>"
                                                         aria-hidden="true">
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                <?php } ?>

            </div>
            <div class="choice-item">
                <span class="choice-value"><span style="line-height: 24px">Thẻ <span class="typecardchone">Viettel</span> có thể nạp trực tiếp tại đây vào các game của Làng Game</span></span>
            </div>
            <div class="card-info">
                <div class="choice-item">
            <span class="header-line" for="serial">
                <span class="icon"></span>
                <span class="title required">Số Serial:</span>
            </span>
                    <input type="text" id="serial" name="serial" autocomplete="false" class="form-control required"
                           placeholder="Số Seri" maxlength="15"/>
                </div>
                <div class="choice-item">
            <span class="header-line" for="pin">
                <span class="icon"></span>
                <span class="title required">Số Pin:</span>
            </span>
                    <input type="text" id="pin" name="pin" autocomplete="off" class="form-control required"
                           placeholder="Số Pin" maxlength="15"/>
                </div>

            </div>
            <div class="package">
                <div class="choice-item">
                    <span class="header-line">
                        <span class="icon"></span>
                        <span class="title">Chọn gói nạp:</span>
                    </span>

                    <select id="card_type" name="card_type" class="form-control">
                        <option value="0">Nạp thường</option>
                        <?php
                        if ($itemList == TRUE) {
                            foreach ($itemList as $key => $value) {
                                ?>
                                <option
                                    value="<?php echo $value["card_type"] ?>"><?php echo $value["desc"][1] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>

                </div>
            </div>
            <br>
            <div class="row-line">
                <span class="previous"><img src="/v2/nap/images/back.png"></span><span class="btn-button exec">Tiến hành thanh toán</span>
            </div>

            <?php
            if (!empty($note)) {
                ?>
                <div class="col-xs-12 note">
                    <label style="color: red">Lưu ý: </label><br>
                    <span><?php echo $note ?></span>
                </div>
                <?php
            }
            ?>

            <div class="rate" style="">
        <span class="header-line">
            <span class="icon info"></span>
            <span class="header-line-group">
                <span class="line"></span>
                <span class="title">Tỷ giá:</span> <span class="title subtype"></span>
            </span>
        </span>

                <div class="list-rate">
                    <div class="row-tr">
                        <div class="row-th">Giá</div>
                        <div class="row-th">Kim Cương</div>
						 
                    </div>

                    <div id="exchangeList" class="exchange-list">
                        <?php
                        if (is_array($exchangeRate)) {
                            foreach ($exchangeRate as $key => $value) {
                                ?>
                                <div class="row-tr">
                                    </div>
									
                                    <div class="row-td"><span> <?php echo number_format($value["money"], 0) ?>
                                            VNĐ</span>
                                    </div>
                                    <div class="row-td">Kim Cương
                                        x <?php echo number_format($value["knb"], 0) . " " . $value["unit"] ?></div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

        </form>

    </div>
    <div id="group-result" class="choice-list">
        <div class="row row-label col-xs-12">
            <span class="label-rech">Kết quả nạp thẻ</span>
        </div>
        <div class="box-result">

        </div>
        <div class="row-line">
            <span class="btn-button r-next">Nạp tiếp</span>
        </div>
    </div>


</div>

<div id="dialog-result"></div>

<?php
include $controller->getPathView() . 'footer.php';
?>

