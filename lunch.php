<?php
/*
Прога, в которой каждый человек будет отмечаться о том, в какое время он идет на обед и идет ли вообще
Напротив каждого имени будут 3 радио-баттона и два тайм-пикера.
Радио: Иду, Не иду, Не определился(лась)
Тайм-пикеры: Готов(а) пойти в ..., но не позже ...
Тайм-пикеры будут неактивны, пока не выбран "иду"
Данные сохраняются сразу после изменения (если не лень будет прикручивать ajax) или при нажатии на "Сохранить"
Если выбрано "иду", то подкрашить поле, чтобы было заметней
 */

define("SEX_MALE", 0);
define("SEX_FEMALE", 1);

define("VOTE_YES", 0);
define("VOTE_NO", 1);
define("VOTE_UNKNOWN", 2);

define("DATA_STORAGE", 'data.srl');

function inPost($name, $default = false)
{
    return (isset($_POST[$name]) ? $_POST[$name] : $default);
}

//Юзеры и их значения полей по умолчанию
$aPeople = array(
    1 => array("name" => "Артем Тымченко", "sex" => SEX_MALE, "vote" => VOTE_UNKNOWN, "time_start" => '', "time_end" => ''),
    2 => array("name" => "Денис Гуров", "sex" => SEX_MALE, "vote" => VOTE_UNKNOWN, "time_start" => '', "time_end" => ''),
    3 => array("name" => "Максим Липовский", "sex" => SEX_MALE, "vote" => VOTE_UNKNOWN, "time_start" => '', "time_end" => ''),
    4 => array("name" => "Оля Политыко", "sex" => SEX_FEMALE, "vote" => VOTE_UNKNOWN, "time_start" => '', "time_end" => ''),
    5 => array("name" => "Юля Власова", "sex" => SEX_FEMALE, "vote" => VOTE_UNKNOWN, "time_start" => '', "time_end" => ''),
);

if (!file_exists(DATA_STORAGE)) {
    echo "Не найден файл данных";
    exit;
}

//Если файл данных устаревший (редактировался более дня назад), его надо очистить
$iModificationDay = date("Ymd", filemtime(DATA_STORAGE));
$iToday = date("Ymd");
if ($iModificationDay < $iToday) {
    file_put_contents(DATA_STORAGE, '');
}

//Сохранение данных на диск
//Если нажата кнопка "Сохранить"
if (inPost('save')) {

    $aPeopleToSave = array();
    $aVotes = inPost('votes');
    $aTimeStart = inPost('time_start');
    $aTimeEnd = inPost('time_end');

    //Собрать значения каждого человека
    foreach ($aPeople as $iPersonId => $aPerson) {

        if (isset($aVotes[$iPersonId]) && is_numeric($aVotes[$iPersonId])) {
            $aPeopleToSave[$iPersonId]['vote'] = $aVotes[$iPersonId];
        }
        if (isset($aTimeStart[$iPersonId])) {
            $aPeopleToSave[$iPersonId]['time_start'] = $aTimeStart[$iPersonId];
        }
        if (isset($aTimeEnd[$iPersonId])) {
            $aPeopleToSave[$iPersonId]['time_end'] = $aTimeEnd[$iPersonId];
        }
    }

    $sPeopleToSave = serialize($aPeopleToSave);
    file_put_contents(DATA_STORAGE, $sPeopleToSave);

    //Можно было бы и без редиректа, но тогда при обновлении страницы юзер может пересохранить данные
    header("Location: ".$_SERVER['PHP_SELF']);
}


//Получение данных с диска
$sPeopleSaved = file_get_contents(DATA_STORAGE);
$aPeopleSaved = unserialize($sPeopleSaved);

//Установить значения полей, сохраненные ранее
foreach ($aPeopleSaved as $iPersonId => $aPersonSaved) {

    if (isset($aPersonSaved['vote'])) {
        $aPeople[$iPersonId]['vote'] = $aPersonSaved['vote'];

        if ($aPersonSaved['vote'] == VOTE_YES) {
            $aPeople[$iPersonId]['name_color'] = "red";
        } elseif ($aPersonSaved['vote'] == VOTE_NO) {
            $aPeople[$iPersonId]['name_color'] = "gray";
        } else {
            $aPeople[$iPersonId]['name_color'] = "black";
        }
    }

    if (isset($aPersonSaved['time_start'])) {
        $aPeople[$iPersonId]['time_start'] = $aPersonSaved['time_start'];
    }
    if (isset($aPersonSaved['time_end'])) {
        $aPeople[$iPersonId]['time_end'] = $aPersonSaved['time_end'];
    }
}

require_once "template.php";