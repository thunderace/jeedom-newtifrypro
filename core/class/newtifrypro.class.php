<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

define('NEWTIFRYADDR', 'https://newtifry.appspot.com/newtifry');
define('GCMADDR', 'https://newtifry.appspot.com/newtifry');



class newtifrypro extends eqLogic {
    
}

class newtifryproCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    public function preSave() {
		$newtifrypro = $this->getEqLogic();
        if ($newtifrypro->getConfiguration('apikey') == '') {
            throw new Exception('Api_Key ne peut etre vide');
        }
        if ($newtifrypro->getConfiguration('devid') == '') {
            throw new Exception('Dev_id ne peut etre vide');
        }
    }

    public function execute($_options = null) {
		$newtifrypro = $this->getEqLogic();
        if ($_options === null) {
            throw new Exception(__('Les options de la fonction ne peuvent etre null', __FILE__));
        }
        if ($_options['title'] == '') {
            $_options['title'] = __('Jeedom Notification', __FILE__);
        }
        $url = GCMADDR . '?source=' . trim($newtifrypro->getConfiguration('devid')) . '&title=' . urlencode($_options['title']) . '&message=' . urlencode($_options['message']) . '&priority=' . trim($this->getConfiguration('priority'));
        $ch = curl_init($url);
        curl_exec($ch);
        curl_close($ch);
    }


    /*     * **********************Getteur Setteur*************************** */
}

?>