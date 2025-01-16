<?php

use Kint\Kint;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

 const HORARIOS = [
    '05:00:00' => '05h00',
    '05:30:00' => '05h30',
    '06:00:00' => '06h00',
    '06:30:00' => '06h30',
    '07:00:00' => '07h00',
    '07:30:00' => '07h30',
    '08:00:00' => '08h00',
    '08:30:00' => '08h30',
    '09:00:00' => '09h00',
    '09:30:00' => '09h30',
    '10:00:00' => '10h00',
    '10:30:00' => '10h30',
    '11:00:00' => '11h00',
    '11:30:00' => '11h30',
    '12:00:00' => '12h00',
    '12:30:00' => '12h30',
    '13:00:00' => '13h00',
    '13:30:00' => '13h30',
    '14:00:00' => '14h00',
    '14:30:00' => '14h30',
    '15:00:00' => '15h00',
    '15:30:00' => '15h30',
    '16:00:00' => '16h00',
    '16:30:00' => '16h30',
    '17:00:00' => '17h00',
    '17:30:00' => '17h30',
    '18:00:00' => '18h00',
    '18:30:00' => '18h30',
    '19:00:00' => '19h00',
    '19:30:00' => '19h30',
    '20:00:00' => '20h00',
    '20:30:00' => '20h30',
    '21:00:00' => '21h00',
    '21:30:00' => '21h30',
    '22:00:00' => '22h00',
    '22:30:00' => '22h30',
    '23:00:00' => '23h00',
    '23:30:00' => '23h30',
 ];

 const WEEKDAYS = [
    '1' => 'Segunda-Feira',
    '2' => 'Terça-Feira',
    '3' => 'Quarta-Feira',
    '4' => 'Quinta-Feira',
    '5' => 'Sexta-Feira',
    '6' => 'Sábado',
    '7' => 'Domingo',
    '0' => 'Domingo',
 ];

 function dd($whatever) {
     echo '<pre>';
    print_r($whatever);
     echo '</pre>';
     die();
 }

 function getFeriados($ano = null) {
   $client = service('curlrequest');
   $url = 'https://brasilapi.com.br/api/feriados/v1/' . ($ano ?? date('Y'));
   $response = $client->request('GET', $url, ['verify' => false]);
   $feriados = json_decode($response->getBody(), true);
   $feriados = array_combine(array_column($feriados, 'date'), array_column($feriados, 'name'));
   return $feriados;
 }