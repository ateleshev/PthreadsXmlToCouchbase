#!/usr/bin/env php
<?php

include '_init.php';

$sxe = new SimpleXmlElement(__DIR__ . DIRECTORY_SEPARATOR . 'gta.xml', LIBXML_NOCDATA, 1);

foreach ($sxe->ResponseDetails->PriceCacheResponse->Hotels->Hotel as $hotelElement)
{
  $city = strtoupper(trim($hotelElement['City']));
  $item = strtoupper(trim($hotelElement['Item']));
  
  foreach ($hotelElement->Nights->Night as $nightElement)
  {
    $date = trim($nightElement['Date']);

    foreach ($nightElement->Rates->Rate as $rateElement)
    {
      $meals = strtoupper(trim($rateElement['Meals']));
      $minNights = (int) trim($rateElement['MinNights']);
      $minPax = (int) trim($rateElement['MinPax']);

      foreach ($rateElement->Room as $roomElement)
      {
        $room = strtoupper(trim($roomElement['Code']));

        foreach ($roomElement->Prices->Price as $priceElement)
        {
          $price = trim($priceElement[0]);
          $currency = trim($priceElement['Currency']);

          // Random increment
          // $price += (rand(0.11, 0.99) * 10);

          $offer = [
            'city' => $city,
            'item' => $item,
            'room' => $room,
            'date' => $date,
            'meals' => $meals,
            'min' => [
              'nights' => $minNights,
              'pax' => $minPax,
            ],
            'price' => $price,
            'currency' => $currency,
          ];

          if (isset($roomElement['FromAge']))
          {
            $offer['from']['age'] = (int) trim($roomElement['FromAge']);
          }

          if (isset($roomElement['ToAge']))
          {
            $offer['ToAge'] = (int) trim($roomElement['ToAge']);
          }

          $key = implode('-', array_values($offer));

          // $key .= '-' . uniqid(); 

          $cb->set($key, json_encode($offer));
        }
      }
    }
  }
}

