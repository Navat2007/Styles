<?php

/**
 * Description of helper
 *
 * @author Navat
 */

class helper 
{
    function getDateStr($date) 
    {
        $dateFormat = 'Y-m-d';

        $msgDate = DateTime::createFromFormat($dateFormat, $date);
        $msgYear = intval($msgDate->format('Y'));
        $msgMonth = intval($msgDate->format('m'));
        $msgDay = intval($msgDate->format('d'));

        $nowDate = getdate();
        $nowYear = $nowDate[year];
        $nowMonth = $nowDate[mon];

        $returnDate;

        if ($nowYear != $msgYear) 
        {
            $returnDate = $msgDay . ' ' . $this->getMonth($msgMonth) . ' ' . $msgYear;
        } 
        else
        {
            
            $returnDate = $msgDay . ' ' . $this->getMonth($msgMonth);
        } 

        return $returnDate;
    }
    
    function getDateTimeStr($date, $time = false) 
    {
        $dateFormat = 'Y-m-d H:i:s';

        $msgDate = DateTime::createFromFormat($dateFormat, $date);
        $msgYear = intval($msgDate->format('Y'));
        $msgMonth = intval($msgDate->format('m'));
        $msgDay = intval($msgDate->format('d'));
        $msgHour = $msgDate->format('H');
        $msgMinute = $msgDate->format('i');

        $nowDate = getdate();
        $nowYear = $nowDate[year];
        $nowMonth = $nowDate[mon];
        $nowDay = $nowDate[mday];

        $returnDate;
        $tTime = $time ? $msgHour . ':' . $msgMinute : '';

        if ($nowYear != $msgYear) 
        {
            $returnDate = $tTime . " " . $msgDay . ' ' . $this->getMonth($msgMonth) . ' ' . $msgYear;
        } 
        else if ($nowMonth != $msgMonth || $nowDay != $msgDay) 
        {
            
            $returnDate = $tTime . " " . $msgDay . ' ' . $this->getMonth($msgMonth);
        } 
        else 
        {
            $returnDate = $msgHour . ':' . $msgMinute;
        }

        return $returnDate;
    }

    function getMonth($value) {
        switch ($value) {
            case 1: return 'янв';
            case 2: return 'фев';
            case 3: return 'мар';
            case 4: return 'апр';
            case 5: return 'мая';
            case 6: return 'июн';
            case 7: return 'июл';
            case 8: return 'авг';
            case 9: return 'сен';
            case 10: return 'окт';
            case 11: return 'ноя';
            case 12: return 'дек';
        }
    }
}
