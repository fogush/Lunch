<!doctype html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <title>Кто идет на обед?</title>
    <link type="text/css" href="css/redmond/jquery-ui-1.10.2.custom.min.css" rel="stylesheet" />
    <link type="text/css" href="css/jquery.ui.timepicker.css" rel="stylesheet" />
    <link type="text/css" href="css/styles.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
    <script type="text/javascript" src="js/lunch.js"></script>
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
    <table>
    <?php
        foreach ($aPeople as $iPersonId => $aPerson) {
        ?>
        <tr>
            <td class="person-name" style="color: <?php echo ($aPerson['name_color']);?>">
                <?php echo $aPerson['name'];?>
            </td>

            <td class="vote-yes">
                <input type='radio' name='votes[<?php echo $iPersonId;?>]' value='0' id='vote-yes-<?php echo $iPersonId;?>'
                    <?php echo ($aPerson['vote'] == VOTE_YES ? "checked='checked'" : "");?> />
                <label for='vote-yes-<?php echo $iPersonId;?>'>Иду</label>
            </td>
            <td class="vote-no">
                <input type='radio' name='votes[<?php echo $iPersonId;?>]' value='1' id='vote-no-<?php echo $iPersonId;?>'
                    <?php echo ($aPerson['vote'] == VOTE_NO ? "checked='checked'" : "");?> />
                <label for='vote-no-<?php echo $iPersonId;?>'>Не иду</label>
            </td>
            <td class="vote-unknown">
                <input type='radio' name='votes[<?php echo $iPersonId;?>]' value='2' id='vote-unknown-<?php echo $iPersonId;?>'
                    <?php echo ($aPerson['vote'] == VOTE_UNKNOWN ? "checked='checked'" : "");?> />
                <label for='vote-unknown-<?php echo $iPersonId;?>'>Не определил<?php echo ($aPerson['sex'] == SEX_MALE ? "ся" : "ась");?></label>
            </td>

            <td class="time-picker">
                Готов<?php echo ($aPerson['sex'] == SEX_MALE ? "" : "а");?> пойти в
                <input type='text' name='time_start[<?php echo $iPersonId;?>]' value='<?php echo $aPerson['time_start']?>'
                       class="time-start" id='time-start-<?php echo $iPersonId;?>' />
                , но не позже
                <input type='text' name='time_end[<?php echo $iPersonId;?>]' value='<?php echo $aPerson['time_end']?>'
                       class="time-end" id='time-end-<?php echo $iPersonId;?>' />
            <td>
        </tr>
        <?php }
    ?>
        <tr>
            <td colspan="4"></td>
            <td>Итого: не раньше <span id="time-start-total"></span>, не позже <span id="time-end-total"></span></td>
        </tr>
    </table>
    <input type="submit" name="save" value="Сохранить" id="save"/>
</form>
</body>
</html>