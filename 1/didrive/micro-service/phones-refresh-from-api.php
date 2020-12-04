<?php

try {

//    $date = $in['date'] ?? $_REQUEST['date'] ?? null;
//
//    if (empty($date))
//        throw new \Exception('нет даты');

    if (isset($skip_start) && $skip_start === true) {
        
    } else {
        require_once '0start.php';
    }

    if (\Nyos\Nyos::checkSecret($_REQUEST['s'], $_REQUEST['id'])) {
        
    } else {
        throw new \Exception('что то пошло не так, повторите и обратитесь в тех. поддержку', false);
    }

    \Nyos\mod\items::$search['who_added'] = $_SESSION['now_user_di']['id'];
    \Nyos\mod\items::$search['id'] = $_REQUEST['id'];
    \Nyos\mod\items::$type_module = 3;
    $dogs = \Nyos\mod\items::get($db, '701.beeline_dogovors');

    // \f\end2('asd',true,$dogs);

    if (!empty($dogs)) {
        foreach ($dogs as $v) {

            if (empty($v['login']) || empty($v['pass']))
                throw new \Exception('что то пошло не так #' . __LINE__ . ', повторите и обратитесь в тех. поддержку', false);

            \Nyos\api\Beeline::$login = trim('A' . $v['login']);
            \Nyos\api\Beeline::$ban = trim($v['login']);
            \Nyos\api\Beeline::$pass = trim($v['pass']);

            break;
        }
    }

//    $list = \Nyos\api\Beeline::getToten($db);
//    \f\pa($list);
//    \f\end2('23');
    $list = (array) \Nyos\api\Beeline::getListNumber($db);
    // \f\pa( $list );
    // \f\pa((array) $list['CTNInfoList']);
    $res = (array) $list['CTNInfoList'];

//    \f\pa(sizeof( $res ));
// \f\pa( $res );
    // if ( sizeof( $res ) == 8 ) {

    \Nyos\mod\Bibi_v1::deletePhonesFromDogovor($db, (int) $_REQUEST['id']);

    \Nyos\mod\items::$type_module = 3;
    // \f\pa( (array) $list['CTNInfoList']);
    $res['dogovor_id'] = $_REQUEST['id'];
    if (isset($res['status'])) {
        $res['phone_status'] = $res['status'];
        unset($res['status']);
    }
    \Nyos\mod\items::add($db, \Nyos\mod\Bibi_v1::$mod_phones, $res);

    \f\end2('(обработано) номеров в договоре 1', true);

    // }


    \f\end2('end', false);
//
//
//    // \f\pa($_REQUEST);
////    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'db.2.php' );
////    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.2.php' );
//// $_SESSION['status1'] = true;
//// $status = '';
//
//    $e = array('id' => (int) $_POST['item_id']);
//
//    $ff = $db->prepare('DELETE FROM `mitems-dops` WHERE `id_item` = :id_item AND `name` = :name ');
//    $ff->execute(
//            array(
//                ':id_item' => $_POST['item_id'],
//                ':name' => $_POST['dop_name']
//            )
//    );
//
//
//    if (isset($_POST['new_val'])) {
//        $sql = 'INSERT INTO `mitems-dops` ( `id_item`, `name`, `value` ) values ( :id, :name , :val ) ';
//        // \f\pa($sql);
//        $ff = $db->prepare($sql);
//        $in_sql = [
//            ':id' => $_POST['item_id'],
//            ':name' => $_POST['dop_name'],
//            ':val' => $_POST['new_val'] ?? 0,
//        ];
//        // \f\pa($in_sql);
//        $ff->execute($in_sql);
//    }
//
////    $dir_for_cash = DR . dir_site;
////    $list_cash = scandir($dir_for_cash);
////    foreach ($list_cash as $k => $v) {
////        if (strpos($v, 'cash.items.') !== false) {
////            unlink($dir_for_cash . $v);
////        }
////    }
//// f\end2( 'новый статус ' . $status);
//    f\end2('ок');
} catch (\Exception $exc) {

    $msg = '';

    if (isset($exc->detail->UssWsApiException->errorCode))
        $msg .= ' ошибка #' . $exc->detail->UssWsApiException->errorCode . ' / ';

    if (isset($exc->detail->UssWsApiException->errorDescription))
        $msg .= $exc->detail->UssWsApiException->errorDescription;

    // \f\pa($exc);

    \f\end2($msg . ' ( #' . $exc->getCode() . ' ' . $exc->getMessage() . ' )', false, (array) $exc);

//    echo '<pre>';
//    print_r($exc);
//    echo '</pre>';
    // echo $exc->getTraceAsString();
}