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
  ],
 
  '2' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit an anime museum",
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "zojoji temple",
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "zojoji temple",
  ],

  '5' => [
    'bonus' => [1, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "sensoji temple and nakamise",
  ],

  '6' => [
    'bonus' => [1, 1, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 1,
    'name' => "sensoji temple and nakamise",
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "meiji jingu shrine",
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "meiji jingu shrine",
  ],

  '9' => [
    'bonus' => [1, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "gotokuji temple",
  ],

  '10' => [
    'bonus' => [1, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "gotokuji temple",
  ],

  '11' => [
    'bonus' => [0, 1, 0, 2, 0, 0, 0, 0, 2],
    'pv' => 1,
    'name' => "department stores in ginza",
  ],
 
  '12' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "department stores in ginza",
  ],

  '13' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "shopping in shibuya",
  ],

  '14' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "shopping in shibuya",
  ],

  '15' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "see the hachiko statue",
  ],

  '16' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "watch sumo",
  ],
 
  '17' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "watch sumo",
  ],

  '18' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "go to a baseball game",
  ],

  '19' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "go to a baseball game",
  ],

  '20' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "tokyo metropolitan govt. building",
  ],

  '21' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "tokyo metropolitan govt. building",
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 7,
    'name' => "tokyo tower",
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 7,
    'name' => "tokyo tower",
  ],

  '24' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "miyashita park",
  ],

  '25' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "miyashita park",
  ],

  '26' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "imperial palace gardens 
",
  ],
 
  '27' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "imperial palace gardens 
",
  ],

  '28' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a rescue cat cafe",
  ],

  '29' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a rescue cat cafe",
  ],

  '30' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "board game store in akihabara",
  ],

  '31' => [
    'bonus' => [0, 0, 0, 2, 0, 0, 0, 1, 1],
    'pv' => 2,
    'name' => "board game store in akihabara",
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "ueno park",
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "ueno park",
  ],

  '34' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "shinjuku gyoen park",
  ],

  '35' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 3,
    'name' => "shinjuku gyoen park",
  ],

  '36' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "gachapon vending machines",
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "sushi at the tsukiji market",
  ],

  '38' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "sushi at the tsukiji market",
  ],

  '39' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "get yakitori in omoide yokocho",
  ],

  '40' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "get yakitori in omoide yokocho",
  ],

  '41' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'pv' => 1,
    'name' => "stay in a capsule hotel",
  ],
 
  '42' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'pv' => 1,
    'name' => "stay in a capsule hotel",
  ],

  '43' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "tokyo station",
  ],

  '44' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "tokyo station",
  ],

  '45' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "tokyo national museum",
  ],

  '46' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "get a new outfit in harajuku",
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "get crepes in harajuku",
  ],

  '48' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "ikebukuro",
  ],

  '49' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "ikebukuro",
  ],

  '50' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "daikanyama",
  ],

  '51' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "daikanyama",
  ],
 
  '52' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "go to a themed cafe",
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "go to a themed cafe",
  ],

  '54' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "see a kabuki show",
  ],

  '55' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "see a kabuki show",
  ],

  '56' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 2],
    'pv' => 7,
    'name' => "stay at a really nice hotel",
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 6,
    'name' => "stay at a really nice hotel",
  ],

  '58' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "dine at a top restaurant",
  ],

  '59' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "dine at a top restaurant",
  ],

  '60' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "monjayaki in tsukishima",
  ],

  '61' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "monjayaki in tsukishima",
  ],
 
  '62' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "conveyor belt sushi",
  ],

  '63' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "nezu shrine",
  ],

  '64' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 5,
    'name' => "todoroki valley Park",
  ],

  '65' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "todoroki valley Park",
  ],

  '66' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kanda shrine",
  ],
 
  '67' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kanda shrine",
  ],

  '68' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "get food from a konbini",
  ],

  '69' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "grab some street food",
  ],

  '70' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "grab some street food",
  ],

  '71' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "soba and tempura",
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "attend a festival",
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 3,
    'name' => "take a hike outside of town",
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see some cherry blossoms",
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "eat ramen at the best place!",
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a small shrine",
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "photo sticker booth",
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "buy a gift in an interesting shop",
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "take a cooking class",
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see a concert",
  ],


];

$this->kyotocards = [
  '1' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "ginkakuji temple",
  ],
 
  '2' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "tofukuji temple",
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "ryoanji temple",
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "ryoanji temple",
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
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 1, 0, 0, 0, 0],
    'pv' => 1,
    'name' => "kiyomizudera temple",
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "kiyomizudera temple",
  ],

  '9' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nanzenji temple",
  ],

  '10' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nanzenji temple",
  ],

  '11' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "fushimi inari shrine",
  ],
 
  '12' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => "fushimi inari shrine",
  ],

  '13' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "yasaka shrine",
  ],

  '14' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "yasaka shrine",
  ],

  '15' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "heian shrine",
  ],

  '16' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'pv' => 1,
    'name' => "tea ceremony",
  ],
 
  '17' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'pv' => 1,
    'name' => "tea ceremony",
  ],

  '18' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto tower",
  ],

  '19' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto tower",
  ],

  '20' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "monkey park",
  ],

  '21' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "monkey park",
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "manga museum",
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "manga museum",
  ],

  '24' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "sannenzaka slope",
  ],

  '25' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "sannenzaka slope",
  ],

  '26' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "take an ikebana class",
  ],
 
  '27' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'pv' => 1,
    'name' => "take an ikebana class",
  ],

  '28' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "geisha show at gion corner",
  ],

  '29' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "geisha show at gion corner",
  ],

  '30' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,
    'name' => "kyoto imperial palace",
  ],

  '31' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 4,'name' => "kyoto imperial palace",
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "philosopher’s path",
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "philosopher’s path",
  ],

  '34' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "kyoto railway museum",
  ],

  '35' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "kyoto railway museum",
  ],

  '36' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "nishiki market",
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "nishiki market",
  ],

  '38' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto handicraft center",
  ],

  '39' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "kyoto handicraft center",
  ],

  '40' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "otagi nenbutsuji temple",
  ],

  '41' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "otagi nenbutsuji temple",
  ],
 
  '42' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "temple lodging",
  ],

  '43' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "temple lodging",
  ],

  '44' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "arashiyama bamboo grove",
  ],

  '45' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'pv' => 2,
    'name' => "arashiyama bamboo grove",
  ],

  '46' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "stay at a ryokan",
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "stay at a ryokan",
  ],

  '48' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "stay at a machiya",
  ],

  '49' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'pv' => 4,
    'name' => "stay at a machiya",
  ],

  '50' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nijo castle",
  ],

  '51' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 3,
    'name' => "nijo castle",
  ],
 
  '52' => [
    'bonus' => [0, 1, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "ponto-cho",
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "ponto-cho",
  ],

  '54' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "tour shugakuin villa",
  ],

  '55' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'pv' => 2,
    'name' => "tour shugakuin villa",
  ],

  '56' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 5,
    'name' => "higashiyama district",
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 5,
    'name' => "higashiyama district",
  ],

  '58' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "tenryuji temple",
  ],

  '59' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "tenryuji temple",
  ],

  '60' => [
    'bonus' => [1, 0, 2, 0, 1, 0, 0, 0, 1],
    'pv' => 0,
    'name' => "kokedera temple",
  ],

  '61' => [
    'bonus' => [0, 0, 0, 0, 0, 2, 0, 0, 0],
    'pv' => 1,
    'name' => "onsen",
  ],
 
  '62' => [
    'bonus' => [0, 0, 0, 0, 0, 2, 0, 0, 0],
    'pv' => 1,
    'name' => "onsen",
  ],

  '63' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "tour the sake district",
  ],

  '64' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 4,
    'name' => "tour the sake district",
  ],

  '65' => [
    'bonus' => [0, 1, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "shopping arcades",
  ],

  '66' => [
    'bonus' => [0, 1, 0, 1, 0, 0, 0, 1, 0],
    'pv' => 4,
    'name' => "shopping arcades",
  ],
 
  '67' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "flea market",
  ],

  '68' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'pv' => 3,
    'name' => "flea market",
  ],

  '69' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 5,
    'name' => "kyoto national museum",
  ],

  '70' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 2, 0],
    'pv' => 5,
    'name' => "take a drumming class",
  ],

  '71' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 2, 0],
    'pv' => 7,
    'name' => "take a drumming class",
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "attend a festival",
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'pv' => 3,
    'name' => "take a hike outside of town",
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see some cherry blossoms",
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "eat ramen at the best place!",
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "visit a small shrine",
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "photo sticker booth",
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "buy a gift in an interesting shop",
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'pv' => 3,
    'name' => "take a cooking class",
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'pv' => 2,
    'name' => "see a concert",
  ],


];


