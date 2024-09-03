<?php
/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * letsgotojapan implementation : © <Mathieu Chatrain> <mathieu.chatrain@gmail.com>
 * 
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * material.inc.php
 *
 * letsgotojapan game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *   
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */


/*

Example:

$this->card_types = array(
    1 => array( "card_name" => ...,
                ...
              )
);

*/

$this->days = [
  '1' => [
    'name' => clienttranslate("Monday"),
  ],
 
  '2' => [
    'name' => clienttranslate("Tuesday"),
  ],

  '3' => [
    'name' => clienttranslate("Wednesday"),
  ],

  '4' => [
    'name' => clienttranslate("Thursday"),
  ],

  '5' => [
    'name' => clienttranslate("Friday"),
  ],

  '6' => [
    'name' => clienttranslate("Saturday"),
  ],


];

$this->walk = [
  '0' => [
    'bonus' => [0, 0, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 1,
  ],

];


$this->tokyocards = [
  '1' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit an anime museum",
    'text1' => "Tokyo has multiple anime museums (including Studio Ghibli, Toei, and Suginami) where visitors can deep dive into their favorite animated Japanese films and TV shows.",
    'text2' => "Buy an exclusive item in the gift shop",
    'text3' => "",
  ],
 
  '2' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit an anime museum",
    'text1' => "Tokyo has multiple anime museums (including Studio Ghibli, Toei, and Suginami) where visitors can deep dive into their favorite animated Japanese films and TV shows.",
    'text2' => "Pick up a gift for a friend",
    'text3' => "",
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "zojoji temple",
    'text1' => "Zojoji [zōh•jōh•jee] Temple sits near the base of the city’s iconic Tokyo Tower. The temple’s main gate, Sangedatsumon, was constructed in 1622 and is the oldest wooden building in Tokyo.",
    'text2' => "Admire the two icons together",
    'text3' => "",
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "zojoji temple",
    'text1' => "Zojoji [zōh•jōh•jee] Temple sits near the base of the city’s iconic Tokyo Tower. The temple’s main gate, Sangedatsumon, was constructed in 1622 and is the oldest wooden building in Tokyo.",
    'text2' => "Go to nearby Tsukiji fish market",
    'text3' => "",
  ],

  '5' => [
    'bonus' => [1, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "sensoji temple and nakamise",
    'text1' => "One of Tokyo’s oldest and most popular temples, Sensoji [sen•sōh•jee] stands next to a busy shopping street called Nakamise [na•ka•me•seh] with souvenirs and local snacks.",
    'text2' => "Try some snacks along Nakamise",
    'text3' => "",
  ],

  '6' => [
    'bonus' => [1, 1, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 1,
    'name' => "sensoji temple and nakamise",
    'text1' => "One of Tokyo’s oldest and most popular temples, Sensoji [sen•sōh•jee] stands next to a busy shopping street called Nakamise [na•ka•me•seh] with souvenirs and local snacks.",
    'text2' => "Explore Nakamise",
    'text3' => "",
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "meiji jingu shrine",
    'text1' => "Meiji Jingu [may•jee•jeen•goo] is dedicated to Emporer Meiji and Empress Shoken. Built in a dense forest, it has spacious grounds and is a perfect way to take a walk in nature while in Tokyo.",
    'text2' => "See a different side of Tokyo",
    'text3' => 'This bonus scores 3 <div class="pvtool"></div> for each day spent only in Tokyo', //icon
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "meiji jingu shrine",
    'text1' => "Meiji Jingu [may•jee•jeen•goo] is dedicated to Emporer Meiji and Empress Shoken. Built in a dense forest, it has spacious grounds and is a perfect way to take a walk in nature while in Tokyo.",
    'text2' => "Walk to Yoyogi Park",
    'text3' => "",
  ],

  '9' => [
    'bonus' => [1, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "gotokuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '10' => [
    'bonus' => [1, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "gotokuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '11' => [
    'bonus' => [0, 1, 0, 2, 0, 0, 0, 0, 2],
    'pv' => 1,
    'name' => "department stores in ginza",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '12' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "department stores in ginza",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '13' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "shopping in shibuya",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '14' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "shopping in shibuya",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '15' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "see the hachiko statue",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '16' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "watch sumo",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '17' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "watch sumo",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '18' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "go to a baseball game",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '19' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "go to a baseball game",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '20' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "tokyo metropolitan govt. building",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '21' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "tokyo metropolitan govt. building",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 7,
    'name' => "tokyo tower",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 7,
    'name' => "tokyo tower",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '24' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "miyashita park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '25' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "miyashita park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '26' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "imperial palace gardens",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '27' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "imperial palace gardens",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '28' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a rescue cat cafe",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '29' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a rescue cat cafe",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '30' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "board game store in akihabara",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '31' => [
    'bonus' => [0, 0, 0, 2, 0, 0, 0, 1, 1],
    'pv' => 2,
    'name' => "board game store in akihabara",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "ueno park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "ueno park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '34' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "shinjuku gyoen park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '35' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "shinjuku gyoen park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '36' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "gachapon vending machines",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "sushi at the tsukiji market",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '38' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "sushi at the tsukiji market",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '39' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "get yakitori in omoide yokocho",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '40' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "get yakitori in omoide yokocho",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '41' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'pv' => 1,
    'name' => "stay in a capsule hotel",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '42' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'pv' => 1,
    'name' => "stay in a capsule hotel",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '43' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "tokyo station",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '44' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "tokyo station",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '45' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "tokyo national museum",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '46' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "get a new outfit in harajuku",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "get crepes in harajuku",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '48' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "ikebukuro",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '49' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "ikebukuro",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '50' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "daikanyama",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '51' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "daikanyama",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '52' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "go to a themed cafe",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "go to a themed cafe",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '54' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "see a kabuki show",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '55' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "see a kabuki show",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '56' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 2],
    'pv' => 7,
    'name' => "stay at a really nice hotel",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 6,
    'name' => "stay at a really nice hotel",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '58' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "dine at a top restaurant",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '59' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "dine at a top restaurant",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '60' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "monjayaki in tsukishima",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '61' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "monjayaki in tsukishima",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '62' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "conveyor belt sushi",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '63' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "nezu shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '64' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 5,
    'name' => "todoroki valley Park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '65' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "todoroki valley Park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '66' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kanda shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '67' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kanda shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '68' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "get food from a konbini",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '69' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "grab some street food",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '70' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "grab some street food",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '71' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "soba and tempura",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "attend a festival",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 3,
    'name' => "take a hike outside of town",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see some cherry blossoms",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "eat ramen at the best place!",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a small shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "photo sticker booth",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "buy a gift in an interesting shop",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "take a cooking class",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see a concert",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],


];

$this->kyotocards = [
  '1' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "ginkakuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '2' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "tofukuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "ryoanji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "ryoanji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '5' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "kinkakuji temple",
  ],

  '6' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "kinkakuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 1, 0, 0, 0, 0],
    'pv' => 1,
    'name' => "kiyomizudera temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "kiyomizudera temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '9' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nanzenji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '10' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nanzenji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '11' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "fushimi inari shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '12' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "fushimi inari shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '13' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "yasaka shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '14' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "yasaka shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '15' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "heian shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '16' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'pv' => 1,
    'name' => "tea ceremony",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '17' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'pv' => 1,
    'name' => "tea ceremony",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '18' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto tower",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '19' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto tower",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '20' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "monkey park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '21' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "monkey park",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "manga museum",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "manga museum",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '24' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "sannenzaka slope",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '25' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "sannenzaka slope",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '26' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "take an ikebana class",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '27' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "take an ikebana class",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '28' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "geisha show at gion corner",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '29' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "geisha show at gion corner",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '30' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "kyoto imperial palace",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '31' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,'name' => "kyoto imperial palace",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "philosopher’s path",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "philosopher’s path",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '34' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "kyoto railway museum",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '35' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "kyoto railway museum",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '36' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "nishiki market",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "nishiki market",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '38' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto handicraft center",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '39' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto handicraft center",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '40' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "otagi nenbutsuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '41' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "otagi nenbutsuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '42' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "temple lodging",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '43' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "temple lodging",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '44' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "arashiyama bamboo grove",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '45' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "arashiyama bamboo grove",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '46' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "stay at a ryokan",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "stay at a ryokan",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '48' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "stay at a machiya",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '49' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "stay at a machiya",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '50' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nijo castle",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '51' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nijo castle",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '52' => [
    'bonus' => [0, 1, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "ponto-cho",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "ponto-cho",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '54' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "tour shugakuin villa",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '55' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "tour shugakuin villa",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '56' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 5,
    'name' => "higashiyama district",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 5,
    'name' => "higashiyama district",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '58' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "tenryuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '59' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "tenryuji temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '60' => [
    'bonus' => [1, 0, 2, 0, 1, 0, 0, 0, 1],
    'pv' => 0,
    'name' => "kokedera temple",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '61' => [
    'bonus' => [0, 0, 0, 0, 0, 2, 0, 0, 0],
    'pv' => 1,
    'name' => "onsen",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '62' => [
    'bonus' => [0, 0, 0, 0, 0, 2, 0, 0, 0],
    'pv' => 1,
    'name' => "onsen",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '63' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "tour the sake district",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '64' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "tour the sake district",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '65' => [
    'bonus' => [0, 1, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "shopping arcades",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '66' => [
    'bonus' => [0, 1, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "shopping arcades",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '67' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "flea market",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '68' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "flea market",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '69' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "kyoto national museum",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '70' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 2, 0],
    'pv' => 5,
    'name' => "take a drumming class",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '71' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 2, 0],
    'pv' => 7,
    'name' => "take a drumming class",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "attend a festival",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 3,
    'name' => "take a hike outside of town",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see some cherry blossoms",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "eat ramen at the best place!",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a small shrine",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "photo sticker booth",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "buy a gift in an interesting shop",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "take a cooking class",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see a concert",
    'text1' => "",
    'text2' => "",
    'text3' => "",
  ],


];


