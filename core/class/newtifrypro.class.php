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

require_once ("NewtifryPro.php");

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
        if ($this->getConfiguration('devid') == '') {
            throw new Exception('Dev_id ne peut etre vide');
        }        
    }

    public function execute($_options = null) {
        if ($_options === null) {
            throw new Exception(__('Les options de la fonction doivent être définis', __FILE__));
        }
        if ($_options['source'] == '') {
            $_options['source'] = __('Jeedom', __FILE__);
        }
        newtifryProPush(    $this->getConfiguration('apikey'),
                            $this->getConfiguration('devid'), 
                            $_options['title'], 
                            'Jeedom Notification', 
                            $_options['message'], 
                            0, 
                            NULL, 
                            NULL, // image
                            -1,  
                            false,  
                            0,  
                            -1);
    }


    /*     * **********************Getteur Setteur*************************** */
}

?>