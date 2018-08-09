<?php
require './hamtim-amocrm.php'; 
header("Content-Type: text/html; charset=utf-8");

$data = $_POST;
$action = $data['action'];
$id = $_GET["id"];


if($action == "print")
{
    $amo = new HamtimAmocrm('taxiphuket@yandex.ru'/*логин*/, '319994b438a25f2645e2538d1cce1785'/*api ключ*/, 'phuket'/*субдомен*/);
    if(!$amo->auth) die('Нет соединения с amoCRM');

    $path = '/api/v2/notes';
    $data = array (
        'add' =>
        array (
          0 =>
          array (
            'element_id' => $data['id'],
            'element_type' => '2',
            'text' => 'Курьер распечатал ваучер!',
            'note_type' => '4',
            'responsible_user_id' => '819939',
            'created_by' => '819939',
          ),
        ),
      );
    
    $amo->q($path, $data);
}
else if($action == "update")
{
    $amo = new HamtimAmocrm('taxiphuket@yandex.ru'/*логин*/, '319994b438a25f2645e2538d1cce1785'/*api ключ*/, 'phuket'/*субдомен*/);
    if(!$amo->auth) die('Нет соединения с amoCRM');

    $path = '/api/v2/leads';
    $leads['update']= array(
        array(
        'id'=> $data['id'],
        'updated_at'=> time(),
        'custom_fields'=>array(
                array(
                    'id'=>461721, 
                    'values'=>array( 
                        array(
                            'value' => $data['value']
                        )
                    )
                )
            )
        )
    );
    
    $amo->q($path, $leads);
}
else 
{
    if (!empty($id))
    {
        $amo = new HamtimAmocrm('taxiphuket@yandex.ru'/*логин*/, '319994b438a25f2645e2538d1cce1785'/*api ключ*/, 'phuket'/*субдомен*/);

        if(!$amo->auth) die('Нет соединения с amoCRM');

        $path_lead = '/api/v2/leads?id='.$id;
        $leads = $amo->q($path_lead);

        //print_r('Сделка: #'.$id.'<br>');

        //echo '<pre>';	
        //print_r($leads->_embedded->items[0]);
        //echo '</pre>';    

        $path_contact = $leads->_embedded->items[0]->contacts->_links->self->href;
        $contact = $amo->q($path_contact);
        //print_r('Контакт: '.$contact->_embedded->items[0]->name);
        //echo '<pre>';	
        //print_r($contact);
        //echo '</pre>';

        //Ваучер
        $vaucher = $leads->_embedded->items[0]->name;

        //Стоимость
        $sale = $leads->_embedded->items[0]->sale;

        //Дата экскурсии и название
        $leads_custom_fields = $leads->_embedded->items[0]->custom_fields;
        $eks_date = "Нет даты";
        $eks_name = "Нет названия";

        for($i = 0; $i < count($leads_custom_fields); $i++)
        {
            if($leads_custom_fields[$i]->id == "40151")
            {
                $eks_date = $leads_custom_fields[$i]->values[0]->value;
                list($a, $b) = explode(' ', $eks_date);
                list ($year, $month, $day) = explode('-', $a);
                $eks_date = $day.'.'.$month.'.'.$year;
            }

            if($leads_custom_fields[$i]->id == "460399")
            {
                $eks_name = $leads_custom_fields[$i]->values[0]->value;
            }
        }    

        //Контакт, телефон, данные

        $contact_custom_fields = $contact->_embedded->items[0]->custom_fields;
        $contact_name;
        $contact_phone;
        $contact_room;
        $contact_adult;
        $contact_child;
        $contact_infant;
        $contact_beach;
        $contact_hotel;

        for($i = 0; $i < count($contact_custom_fields); $i++)
        {
            //Name
            if($contact_custom_fields[$i]->id == "460415")
            {
                $contact_name = $contact_custom_fields[$i]->values[0]->value;
            }
            //Phone
            if($contact_custom_fields[$i]->id == "39723")
            {
                $contact_phone = $contact_custom_fields[$i]->values[0]->value;
            }
            //Hotel
            if($contact_custom_fields[$i]->id == "453799")
            {
                $contact_hotel = $contact_custom_fields[$i]->values[0]->value;
            }
            //Room
            if($contact_custom_fields[$i]->id == "453803")
            {
                $contact_room = $contact_custom_fields[$i]->values[0]->value;
            }
            //Adult
            if($contact_custom_fields[$i]->id == "453805")
            {
                $contact_adult = $contact_custom_fields[$i]->values[0]->value;
            }
            //Child
            if($contact_custom_fields[$i]->id == "453807")
            {
                $contact_child = $contact_custom_fields[$i]->values[0]->value;
            }
            //Infant
            if($contact_custom_fields[$i]->id == "453809")
            {
                $contact_infant = $contact_custom_fields[$i]->values[0]->value;
            }
            //Beach
            if($contact_custom_fields[$i]->id == "460389")
            {
                $contact_beach = $contact_custom_fields[$i]->values[0]->value;
            }
        }   
        
        $contact_hotel = str_replace("&amp;",  "and",  $contact_hotel);
        $contact_beach = str_replace("&amp;",  "and",  $contact_beach);
        $eks_name = str_replace("&amp;",  "and",  $eks_name);

        ?>
        <html>
            <head>
                <title>Print</title>
                <style type="text/css">
                           button.print {
                            background: -moz-linear-gradient(#00BBD6, #EBFFFF);
                            background: -webkit-gradient(linear, 0 0, 0 100%, from(#00BBD6), to(#EBFFFF));
                            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00BBD6', endColorstr='#EBFFFF');
                            padding: 30px 100px;
                            color: #333;
                            -moz-border-radius: 5px;
                            -webkit-border-radius: 5px;
                            border-radius: 5px;
                            border: 1px solid #666;
                           }
                </style>
                <script src="js/jquery-3.3.1.min.js"></script> 
            </head>
            <body>
                <button class="print">
                PRINT
                </button>
                <xmp id="report" style="">
                    <img align="1" src="http://bild.phuketpost.ru/logo/logo_bild.png">
                    <h7 align="1">Phuket 7 Dimension</h7>
                    <p align="1">+66805380333</p>
                    <br>
                    <text size="2">Voucher:</text>
                    <h1 align="1"><?= $vaucher ?></h1>
                    <br>
                    <text size="2">Booking on: <?= $eks_date ?></text>
                    <br>
                    <text size="2">Excursion: <?= $eks_name ?></text>
                    <br>
                    <text size="2" align="0" under="1">Costumer Information</text>
                    <text size="2">Name:<?= $contact_name ?></text>
                    <text size="2">Phone:<?= $contact_phone ?></text>
                    <text size="2">Room:<?= $contact_room ?></text>
                    <text size="2">Adult:<?= $contact_adult ?></text>
                    <text size="2">Child:<?= $contact_child ?></text>
                    <text size="2">Infant:<?= $contact_infant ?></text>
                    <br>                    
                    <text size="2">Beach:<?= $contact_beach ?></text>
                    <text size="2">Hotel:<?= $contact_hotel ?></text>
                    <br>
                    <p reversed="1"></p>
                    <text size="2" align="2" under="1">TOTAL</text><h4 align="2"><?= $sale ?> THB</h4>
                    <br>
                    <p>* Условия бронирования по ссылке: denisphuket.ru/term</p>
                    <p>* В случае если Вас не забрали в указанное время - позвоните нам по телефону +66805380333!</p>
                    <br>
                    <br>
                </xmp>
            </body>
            <script>
                $('.print').on('click', function (event)
                {  
                    //
                    $.ajax(
                    {
                        url: "createLink.php",
                        type: 'POST',            
                        data: 
                        {
                            action: "print",
                            id: <?= $id; ?>
                        },
                        dataType: "html",
                        success: function (data)
                        {       
                            window.location='printerplus://send?text='+document.getElementById('report').innerHTML;                            
                        } 
                    });  
                }); 
            </script>
        </html>

        <?php
    }
    else 
    {
        print_r('ID не найдено!');
    }
}
