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
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("visit an anime museum"),
    'text1' => clienttranslate("Tokyo has multiple anime museums (including Studio Ghibli, Toei, and Suginami) where visitors can deep dive into their favorite animated Japanese films and TV shows."),
    'text2' => clienttranslate("Buy an exclusive item in the gift shop"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="btool decal"></div>]',
  ],
 
  '2' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("visit an anime museum"),
    'text1' => clienttranslate("Tokyo has multiple anime museums (including Studio Ghibli, Toei, and Suginami) where visitors can deep dive into their favorite animated Japanese films and TV shows."),
    'text2' => clienttranslate("Pick up a gift for a friend"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ytool decal"></div>',
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("zojoji temple"),
    'text1' => clienttranslate("Zojoji [zōh•jōh•jee] Temple sits near the base of the city’s iconic Tokyo Tower. The temple’s main gate, Sangedatsumon, was constructed in 1622 and is the oldest wooden building in Tokyo."),
    'text2' => clienttranslate("Admire the two icons together"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div>',
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("zojoji temple"),
    'text1' => clienttranslate("Zojoji [zōh•jōh•jee] Temple sits near the base of the city’s iconic Tokyo Tower. The temple’s main gate, Sangedatsumon, was constructed in 1622 and is the oldest wooden building in Tokyo."),
    'text2' => clienttranslate("Go to nearby Tsukiji fish market"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '5' => [
    'bonus' => [1, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 2,
    'name' => clienttranslate("sensoji temple and nakamise"),
    'text1' => clienttranslate("One of Tokyo’s oldest and most popular temples, Sensoji [sen•sōh•jee] stands next to a busy shopping street called Nakamise [na•ka•me•seh] with souvenirs and local snacks."),
    'text2' => clienttranslate("Try some snacks along Nakamise"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="gtool decal"></div>',
  ],

  '6' => [
    'bonus' => [1, 1, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 1,
    'name' => clienttranslate("sensoji temple and nakamise"),
    'text1' => clienttranslate("One of Tokyo’s oldest and most popular temples, Sensoji [sen•sōh•jee] stands next to a busy shopping street called Nakamise [na•ka•me•seh] with souvenirs and local snacks."),
    'text2' => clienttranslate("Explore Nakamise"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="gtool decal"></div>]',
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("meiji jingu shrine"),
    'text1' => clienttranslate("Meiji Jingu [may•jee•jeen•goo] is dedicated to Emporer Meiji and Empress Shoken. Built in a dense forest, it has spacious grounds and is a perfect way to take a walk in nature while in Tokyo."),
    'text2' => clienttranslate("See a different side of Tokyo"),
    'text3' => clienttranslate('This bonus scores 3 <div class="littlepvtool"></div> for each day spent only in Tokyo'), 
    'gaintotal' => '3<div class="pvtool"></div> per <div class="tokyotool"></div> ',
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("meiji jingu shrine"),
    'text1' => clienttranslate("Meiji Jingu [may•jee•jeen•goo] is dedicated to Emporer Meiji and Empress Shoken. Built in a dense forest, it has spacious grounds and is a perfect way to take a walk in nature while in Tokyo."),
    'text2' => clienttranslate("Walk to Yoyogi Park"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="ptool decal"></div>]',
  ],

  '9' => [
    'bonus' => [1, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("gotokuji temple"),
    'text1' => clienttranslate('Gotokuji [go•toh•koo•jee] is thought to be the birthplace of maneki-neko, "the beckoning cats." Vistors are allowed to buy these statues to leave at the temple.'),
    'text2' => clienttranslate("Buy a maneki-neko statue"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="ytool decal"></div>]',
  ],

  '10' => [
    'bonus' => [1, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("gotokuji temple"),
    'text1' => clienttranslate('Gotokuji [go•toh•koo•jee] is thought to be the birthplace of maneki-neko, "the beckoning cats." Legend has it in the Edo period, a cat living there beckoned a samurai lord inside, saving his life.'),
    'text2' => clienttranslate("Gain some luck"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div>',
  ],

  '11' => [
    'bonus' => [0, 1, 0, 2, 0, 0, 0, 0, 2],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 1,
    'name' => clienttranslate("department stores in ginza"),
    'text1' => clienttranslate('Tokyo is known for its many upscale, multi-level department stores, some as high as ten stories. Typically the basement floor is an expansive food hall, called a “depachika.”'),
    'text2' => clienttranslate("Try expensive delicacies"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="a2tool decal"></div><div class="gtool decal"></div>]',
  ],
 
  '12' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("department stores in ginza"),
    'text1' => clienttranslate('Tokyo is known for its many upscale, multi-level department stores, some as high as ten stories. Typically the basement floor is an expansive food hall, called a “depachika.”'),
    'text2' => clienttranslate("Shop for luxury goods"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '13' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("shopping in shibuya"),
    'text1' => clienttranslate("Shibuya [she•boo•ya] is a neighborhood famous for Scramble Crossing. As many as 3,000 people cross this intersection at the same time."),
    'text2' => clienttranslate("Be in awe of Scramble Crossing"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '14' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("shopping in shibuya"),
    'text1' => clienttranslate("Shibuya [she•boo•ya] is a neighborhood famous for Scramble Crossing. As many as 3,000 people cross this intersection at the same time."),
    'text2' => clienttranslate("Buy a gift for someone back home"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '15' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("see the hachiko statue"),
    'text1' => clienttranslate("The Hachiko [ha•chee•kōh] statue at Shibuya Station imortalizes the famous dog that waited at the station every day for his owner, even nine years after his passing."),
    'text2' => clienttranslate("Take a photo with the statue"),
    'text3' => clienttranslate("If you have traveled twice this bonus scores"),
    'gaintotal' => '',
  ],

  '16' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("watch sumo"),
    'text1' => clienttranslate("Japan’s national sport was originally performed to entertain Shinto deities. The goal is to force the other wrestler to touch outside the ring with any body part other than the bottom of their feet."),
    'text2' => clienttranslate("Score ringside seats"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '17' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '<div class="gtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("watch sumo"),
    'text1' => clienttranslate("Sumo is Japan’s national sport. Many former competitors run restaurants serving chanko nabe, a type of stew commonly eaten by sumo wrestlers."),
    'text2' => clienttranslate("Eat at a chanko nabe restaurant"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="gtool decal"></div>',
  ],

  '18' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("go to a baseball game"),
    'text1' => clienttranslate("Designer Josh Wood and several co-workers each chose a Japanese baseball team to support in case they visited Japan together. He chose the Yakult Swallows, one of Tokyo’s two teams."),
    'text2' => clienttranslate("The game goes into extra innings"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '19' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("go to a baseball game"),
    'text1' => clienttranslate("Japanese baseball games are known for their exciting cheering sections, in which fans sing fight songs, yell chants, and do dances."),
    'text2' => clienttranslate("Learn the songs and chants"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '20' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("tokyo metropolitan govt. building"),
    'text1' => clienttranslate("Called Tocho for short, this is a common sightseeing spot due to its large observation decks that are free to the public. On clear days visitors can see Mount Fuji in the distance."),
    'text2' => clienttranslate("See all the way to Mount Fuji"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '21' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("tokyo metropolitan govt. building"),
    'text1' => clienttranslate("Called Tocho for short, this is a common sightseeing spot due to its large observation decks that are free to the public. On clear days visitors can see Mount Fuji in the distance."),
    'text2' => clienttranslate("See all the way to Mount Fuji"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 7,
    'name' => clienttranslate("tokyo tower"),
    'text1' => clienttranslate("Tokyo Tower is a symbol to Japan’s postwar rebirth and one of the most outstanding Japanese landmarks. It was the tallest selfsupported steel structure at the time of its completion in 1958."),
    'text2' => clienttranslate("Admire the city"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 7,
    'name' => clienttranslate("tokyo tower"),
    'text1' => clienttranslate("Tokyo Tower is a symbol to Japan’s postwar rebirth and one of the most outstanding Japanese landmarks. It was the tallest selfsupported steel structure at the time of its completion in 1958."),
    'text2' => clienttranslate("Take in the view"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '24' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("miyashita park"),
    'text1' => clienttranslate("Miyashita [me•ya•she•ta] Park is a large shopping center with a park and sports facilities on the roof. The redeveloped park opened in 2020."),
    'text2' => clienttranslate("Enjoy the park while shopping"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '25' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("miyashita park"),
    'text1' => clienttranslate("Miyashita [me•ya•she•ta] Park is a large shopping center with a park and sports facilities on the roof. The redeveloped park opened in 2020."),
    'text2' => clienttranslate("Exercise before shopping"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '26' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("imperial palace gardens"),
    'text1' => clienttranslate("The grounds of Tokyo Imperial Palace contain the ruins of the former Edo Castle and the beautiful East Gardens, which are open to the public, unlike the palace itself."),
    'text2' => clienttranslate("Take a relaxing break"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '27' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("imperial palace gardens"),
    'text1' => clienttranslate("The grounds of Tokyo Imperial Palace contain the ruins of the former Edo Castle and the beautiful East Gardens, which are open to the public, unlike the palace itself."),
    'text2' => clienttranslate("Take a special tour"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '28' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("visit a rescue cat cafe"),
    'text1' => clienttranslate("While there are many types of animal cafés in Japan, cat cafés are the most common. Some cat cafés provide ways to adopt the cats that they rescue."),
    'text2' => clienttranslate("Take time to drink some tea"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '29' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("visit a rescue cat cafe"),
    'text1' => clienttranslate("While there are many types of animal cafés in Japan, cat cafés are the most common. Some cat cafés provide ways to adopt the cats that they rescue."),
    'text2' => clienttranslate("Let a cat nap on you"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '30' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("board game store in akihabara"),
    'text1' => clienttranslate("Akihabara [ah•key•ha•ba•ra] is the nexus of otaku (geek) culture in Tokyo. The many exceptional and innovative board games coming from Japan can be found in stores in this neighborhood."),
    'text2' => clienttranslate("Buy just one more game"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '31' => [
    'bonus' => [0, 0, 0, 2, 0, 0, 0, 1, 1],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("board game store in akihabara"),
    'text1' => clienttranslate("Akihabara [ah•key•ha•ba•ra] is the nexus of otaku (geek) culture in Tokyo. This bustling, colorful neighborhood is packed with stores devoted to anime, manga, and gaming."),
    'text2' => clienttranslate("Spend hours geeking out"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("ueno park"),
    'text1' => clienttranslate("Ueno [oo•eh•no] Park is a spacious public park with over 10 million visitors a year. Attractions include museums, temples, shrines, a zoo, a concert hall, a pond, and over 800 cherry blossom trees."),
    'text2' => clienttranslate("Visit the zoo and Toshogu Shrine"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("ueno park"),
    'text1' => clienttranslate("Ueno [oo•eh•no] Park is a spacious public park with over 10 million visitors a year. Attractions include museums, temples, shrines, a zoo, a concert hall, a pond, and over 800 cherry blossom trees."),
    'text2' => clienttranslate("Visit Kaneiji and Kiyomizu Kannon Temples"),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '34' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("shinjuku gyoen park"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '35' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("shinjuku gyoen park"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '36' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("gachapon vending machines"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("sushi at the tsukiji market"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '38' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 1, 0],
    'pv' => 1,
    'name' => clienttranslate("sushi at the tsukiji market"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '39' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("get yakitori in omoide yokocho"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '40' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("get yakitori in omoide yokocho"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '41' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("stay in a capsule hotel"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '42' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("stay in a capsule hotel"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '43' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("tokyo station"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '44' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("tokyo station"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '45' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("tokyo national museum"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '46' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("get a new outfit in harajuku"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("get crepes in harajuku"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '48' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("ikebukuro"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '49' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("ikebukuro"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '50' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("daikanyama"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '51' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("daikanyama"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '52' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("go to a themed cafe"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("go to a themed cafe"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '54' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("see a kabuki show"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '55' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("see a kabuki show"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '56' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 2],
    'prerequis' => '',
    'pv' => 7,
    'name' => clienttranslate("stay at a really nice hotel"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 6,
    'name' => clienttranslate("stay at a really nice hotel"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '58' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("dine at a top restaurant"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '59' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("dine at a top restaurant"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '60' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("monjayaki in tsukishima"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '61' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("monjayaki in tsukishima"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '62' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("conveyor belt sushi"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '63' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("nezu shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '64' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("todoroki valley Park"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '65' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("todoroki valley Park"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '66' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kanda shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '67' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kanda shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '68' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("get food from a konbini"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '69' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("grab some street food"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '70' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("grab some street food"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '71' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("soba and tempura"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("attend a festival"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("take a hike outside of town"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("see some cherry blossoms"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("eat ramen at the best place!"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("visit a small shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("photo sticker booth"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("buy a gift in an interesting shop"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("take a cooking class"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("see a concert"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],


];

$this->kyotocards = [
  '1' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("ginkakuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
    'gaintotal' => '',
  ],
 
  '2' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("tofukuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
    'gaintotal' => '',
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("ryoanji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("ryoanji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '5' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("kinkakuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '6' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("kinkakuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("kiyomizudera temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("kiyomizudera temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '9' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("nanzenji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '10' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("nanzenji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '11' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("fushimi inari shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '12' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("fushimi inari shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '13' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("yasaka shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '14' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("yasaka shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '15' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("heian shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '16' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("tea ceremony"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '17' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("tea ceremony"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '18' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kyoto tower"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '19' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kyoto tower"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '20' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("monkey park"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '21' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("monkey park"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("manga museum"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("manga museum"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '24' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("sannenzaka slope"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '25' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("sannenzaka slope"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '26' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("take an ikebana class"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '27' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("take an ikebana class"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '28' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("geisha show at gion corner"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '29' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("geisha show at gion corner"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '30' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kyoto imperial palace"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> per <div class="kyototool"></div> ',
  ],

  '31' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 4,'name' => clienttranslate("kyoto imperial palace"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("philosopher’s path"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("philosopher’s path"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '34' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("kyoto railway museum"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '35' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("kyoto railway museum"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '36' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("nishiki market"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("nishiki market"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '38' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kyoto handicraft center"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '39' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("kyoto handicraft center"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '40' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("otagi nenbutsuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '41' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("otagi nenbutsuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '42' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("temple lodging"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '43' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("temple lodging"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '44' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("arashiyama bamboo grove"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '45' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("arashiyama bamboo grove"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '46' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("stay at a ryokan"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("stay at a ryokan"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '48' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("stay at a machiya"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '49' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("stay at a machiya"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '50' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("nijo castle"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '51' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("nijo castle"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '52' => [
    'bonus' => [0, 1, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("ponto-cho"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("ponto-cho"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '54' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("tour shugakuin villa"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '55' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("tour shugakuin villa"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '56' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("higashiyama district"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("higashiyama district"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '58' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("tenryuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '59' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("tenryuji temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '60' => [
    'bonus' => [1, 0, 2, 0, 1, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 0,
    'name' => clienttranslate("kokedera temple"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '61' => [
    'bonus' => [0, 0, 0, 0, 0, 2, 0, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("onsen"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '62' => [
    'bonus' => [0, 0, 0, 0, 0, 2, 0, 0, 0],
    'prerequis' => '',
    'pv' => 1,
    'name' => clienttranslate("onsen"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '63' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("tour the sake district"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '64' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("tour the sake district"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '65' => [
    'bonus' => [0, 1, 0, 1, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("shopping arcades"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '66' => [
    'bonus' => [0, 1, 0, 1, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 4,
    'name' => clienttranslate("shopping arcades"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '67' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("flea market"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '68' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("flea market"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '69' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("kyoto national museum"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '70' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 2, 0],
    'prerequis' => '',
    'pv' => 5,
    'name' => clienttranslate("take a drumming class"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '71' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 2, 0],
    'prerequis' => '',
    'pv' => 7,
    'name' => clienttranslate("take a drumming class"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("attend a festival"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("take a hike outside of town"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("see some cherry blossoms"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("eat ramen at the best place!"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("visit a small shrine"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("photo sticker booth"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("buy a gift in an interesting shop"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '',
    'pv' => 3,
    'name' => clienttranslate("take a cooking class"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '',
    'pv' => 2,
    'name' => clienttranslate("see a concert"),
    'text1' => clienttranslate(""),
    'text2' => clienttranslate(""),
    'text3' => clienttranslate(""),
    'gaintotal' => '',
  ],


];


