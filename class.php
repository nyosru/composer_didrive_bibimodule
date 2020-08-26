<?php

/**
  класс модуля
 * */

namespace Nyos\mod;

// if (!defined('IN_NYOS_PROJECT'))
//    throw new \Exception('Сработала защита от розовых хакеров, обратитесь к администрратору');

class Bibi_v1 {

    /**
     * модуль с договорами
     * @var type 
     */
    public static $mod_server = '701.beeline_dogovors';

    /**
     * модуль с телефонами
     * @var type 
     */
    public static $mod_phones = '701.beeline_phones';

    public static function start() {
        
    }

    /**
     * получаем списки серверов
     * @param type $db
     * @return type
     */
    public static function getServers($db) {
        return \Nyos\mod\items::get($db, self::$mod_server);
    }

    /**
     * удаление номеров на договоре
     * @param type $db
     * @param type $dogovor_id
     * @return boolean
     */
    public static function deletePhonesFromDogovor( $db, int $dogovor_id) {

        $sql = 'UPDATE `mod_701_beeline_phones` SET `status` = \'delete\' WHERE `mod_701_beeline_phones`.`dogovor_id` = :d_id ;';
        $ff = $db->prepare($sql);
        $d[':d_id'] = $dogovor_id;
        $ff->execute($d);

        return true;
    }

}
