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
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div><div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("shopping in shibuya"),
    'text1' => clienttranslate("Shibuya [she•boo•ya] is a neighborhood famous for Scramble Crossing. As many as 3,000 people cross this intersection at the same time."),
    'text2' => clienttranslate("Be in awe of Scramble Crossing"),
    'text3' => clienttranslate(""),
    'gaintotal' => '14<div class="pvtool"></div>',
  ],

  '14' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="h2tool"></div><div class="h2tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("shopping in shibuya"),
    'text1' => clienttranslate("Shibuya [she•boo•ya] is a neighborhood famous for Scramble Crossing. As many as 3,000 people cross this intersection at the same time."),
    'text2' => clienttranslate("Buy a gift for someone back home"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="ytool decal"></div>',
  ],

  '15' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="traveltool"></div> <div class="traveltool"></div>',
    'pv' => 4,
    'name' => clienttranslate("see the hachiko statue"),
    'text1' => clienttranslate("The Hachiko [ha•chee•kōh] statue at Shibuya Station imortalizes the famous dog that waited at the station every day for his owner, even nine years after his passing."),
    'text2' => clienttranslate("Take a photo with the statue"),
    'text3' => clienttranslate("If you have traveled twice this bonus scores"),
    'gaintotal' => '8<div class="pvtool"></div> <div class="btool decal"></div>',
  ],

  '16' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("watch sumo"),
    'text1' => clienttranslate("Japan’s national sport was originally performed to entertain Shinto deities. The goal is to force the other wrestler to touch outside the ring with any body part other than the bottom of their feet."),
    'text2' => clienttranslate("Score ringside seats"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="btool decal"></div>',
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
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 5,
    'name' => clienttranslate("go to a baseball game"),
    'text1' => clienttranslate("Designer Josh Wood and several co-workers each chose a Japanese baseball team to support in case they visited Japan together. He chose the Yakult Swallows, one of Tokyo’s two teams."),
    'text2' => clienttranslate("The game goes into extra innings"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="btool decal"></div><div class="ytool decal"></div>',
  ],

  '19' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("go to a baseball game"),
    'text1' => clienttranslate("Japanese baseball games are known for their exciting cheering sections, in which fans sing fight songs, yell chants, and do dances."),
    'text2' => clienttranslate("Learn the songs and chants"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="btool decal"></div><div class="btool decal"></div>',
  ],

  '20' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div>',
    'pv' => 4,
    'name' => clienttranslate("tokyo metropolitan govt. building"),
    'text1' => clienttranslate("Called Tocho for short, this is a common sightseeing spot due to its large observation decks that are free to the public. On clear days visitors can see Mount Fuji in the distance."),
    'text2' => clienttranslate("See all the way to Mount Fuji"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div>',
  ],

  '21' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div><div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 4,
    'name' => clienttranslate("tokyo metropolitan govt. building"),
    'text1' => clienttranslate("Called Tocho for short, this is a common sightseeing spot due to its large observation decks that are free to the public. On clear days visitors can see Mount Fuji in the distance."),
    'text2' => clienttranslate("See all the way to Mount Fuji"),
    'text3' => clienttranslate(""),
    'gaintotal' => '11<div class="pvtool"></div>',
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div><div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 7,
    'name' => clienttranslate("tokyo tower"),
    'text1' => clienttranslate("Tokyo Tower is a symbol to Japan’s postwar rebirth and one of the most outstanding Japanese landmarks. It was the tallest selfsupported steel structure at the time of its completion in 1958."),
    'text2' => clienttranslate("Admire the city"),
    'text3' => clienttranslate(""),
    'gaintotal' => '10<div class="pvtool"></div>',
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 7,
    'name' => clienttranslate("tokyo tower"),
    'text1' => clienttranslate("Tokyo Tower is a symbol to Japan’s postwar rebirth and one of the most outstanding Japanese landmarks. It was the tallest selfsupported steel structure at the time of its completion in 1958."),
    'text2' => clienttranslate("Take in the view"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="gtool decal"></div>]',
  ],

  '24' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="h1tool"></div><div class="h1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("miyashita park"),
    'text1' => clienttranslate("Miyashita [me•ya•she•ta] Park is a large shopping center with a park and sports facilities on the roof. The redeveloped park opened in 2020."),
    'text2' => clienttranslate("Enjoy the park while shopping"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ptool decal"></div>',
  ],

  '25' => [
    'bonus' => [0, 0, 1, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("miyashita park"),
    'text1' => clienttranslate("Miyashita [me•ya•she•ta] Park is a large shopping center with a park and sports facilities on the roof. The redeveloped park opened in 2020."),
    'text2' => clienttranslate("Exercise before shopping"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="ptool decal"></div>]',
  ],

  '26' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="h1tool"></div><div class="h1tool"></div>',
    'pv' => 3,
    'name' => clienttranslate("imperial palace gardens"),
    'text1' => clienttranslate("The grounds of Tokyo Imperial Palace contain the ruins of the former Edo Castle and the beautiful East Gardens, which are open to the public, unlike the palace itself."),
    'text2' => clienttranslate("Take a relaxing break"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div>',
  ],
 
  '27' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("imperial palace gardens"),
    'text1' => clienttranslate("The grounds of Tokyo Imperial Palace contain the ruins of the former Edo Castle and the beautiful East Gardens, which are open to the public, unlike the palace itself."),
    'text2' => clienttranslate("Take a special tour"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="rtool decal"></div>]',
  ],

  '28' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("visit a rescue cat cafe"),
    'text1' => clienttranslate("While there are many types of animal cafés in Japan, cat cafés are the most common. Some cat cafés provide ways to adopt the cats that they rescue."),
    'text2' => clienttranslate("Take time to drink some tea"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="h1tool decal"></div>',
  ],

  '29' => [
    'bonus' => [0, 1, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("visit a rescue cat cafe"),
    'text1' => clienttranslate("While there are many types of animal cafés in Japan, cat cafés are the most common. Some cat cafés provide ways to adopt the cats that they rescue."),
    'text2' => clienttranslate("Let a cat nap on you"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ptool decal"></div>',
  ],

  '30' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="h2tool"></div><div class="h2tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("board game store in akihabara"),
    'text1' => clienttranslate("Akihabara [ah•key•ha•ba•ra] is the nexus of otaku (geek) culture in Tokyo. The many exceptional and innovative board games coming from Japan can be found in stores in this neighborhood."),
    'text2' => clienttranslate("Buy just one more game"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div> <div class="ytool decal"></div>',
  ],

  '31' => [
    'bonus' => [0, 0, 0, 2, 0, 0, 0, 1, 1],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("board game store in akihabara"),
    'text1' => clienttranslate("Akihabara [ah•key•ha•ba•ra] is the nexus of otaku (geek) culture in Tokyo. This bustling, colorful neighborhood is packed with stores devoted to anime, manga, and gaming."),
    'text2' => clienttranslate("Spend hours geeking out"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ytool decal"></div>',
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div>',
    'pv' => 4,
    'name' => clienttranslate("ueno park"),
    'text1' => clienttranslate("Ueno [oo•eh•no] Park is a spacious public park with over 10 million visitors a year. Attractions include museums, temples, shrines, a zoo, a concert hall, a pond, and over 800 cherry blossom trees."),
    'text2' => clienttranslate("Visit the zoo and Toshogu Shrine"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> <div class="btool decal"></div><div class="rtool decal"></div><div class="ptool decal"></div>',
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="h1tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("ueno park"),
    'text1' => clienttranslate("Ueno [oo•eh•no] Park is a spacious public park with over 10 million visitors a year. Attractions include museums, temples, shrines, a zoo, a concert hall, a pond, and over 800 cherry blossom trees."),
    'text2' => clienttranslate("Visit Kaneiji and Kiyomizu Kannon Temples"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> <div class="rtool decal"></div><div class="rtool decal"></div><div class="h2tool decal"></div>',
  ],

  '34' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 3,
    'name' => clienttranslate("shinjuku gyoen park"),
    'text1' => clienttranslate("Shinjuku Gyoen [shin•joo•koo•gyo•en] Park was originally a feudal lord’s residence. It was almost completely destroyed in World War II but was rebuilt and reopened in 1949."),
    'text2' => clienttranslate("Enjoy the escape from the city"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="a1tool decal"></div>',
  ],

  '35' => [
    'bonus' => [0, 0, 1, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="h1tool"></div><div class="h1tool"></div><div class="h1tool"></div>',
    'pv' => 3,
    'name' => clienttranslate("shinjuku gyoen park"),
    'text1' => clienttranslate("Shinjuku Gyoen [shin•joo•koo•gyo•en] Park was originally a feudal lord’s residence. It was almost completely destroyed in World War II but was rebuilt and reopened in 1949."),
    'text2' => clienttranslate("Admire the cherry blossoms"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ptool decal"></div>',
  ],

  '36' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="h2tool"></div><div class="h2tool"></div><div class="h2tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("gachapon vending machines"),
    'text1' => clienttranslate("Gachapon [ga•cha•pon] vending machines are found throughout Tokyo and dispense small, intricately detailed collectible toys, often licensed from popular anime, manga, and video games."),
    'text2' => clienttranslate("Grab some inexpensive souvenirs"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="witool decal"></div><div class="ytool decal"></div>',
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("sushi at the tsukiji market"),
    'text1' => clienttranslate("Adjacent to a former wholesale fish market, Tsukiji [tsu•key•jee] Outer Market is lined with crowded restaurants known for some of the best sushi in Tokyo"),
    'text2' => clienttranslate("Get some street food"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="btool decal"></div>',
  ],

  '38' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div>',
    'pv' => 1,
    'name' => clienttranslate("sushi at the tsukiji market"),
    'text1' => clienttranslate("Adjacent to a former wholesale fish market, Tsukiji [tsu•key•jee] Outer Market is lined with crowded restaurants known for some of the best sushi in Tokyo."),
    'text2' => clienttranslate("Buy some cooking supplies"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="gtool decal"></div>',
  ],

  '39' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("get yakitori in omoide yokocho"),
    'text1' => clienttranslate('Omoide Yokocho [oh•mo•ee•deh•yo•ko•cho], which translates to "memory lane", is a narrow street filled with small restaurants serving a variety of foods like yakitori.'),
    'text2' => clienttranslate("Order like the locals"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],

  '40' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="noa1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("get yakitori in omoide yokocho"),
    'text1' => clienttranslate('Omoide Yokocho [oh•mo•ee•deh•yo•ko•cho], which translates to "memory lane", is a narrow street filled with small restaurants serving a variety of foods like yakitori.'),
    'text2' => clienttranslate("Hit up several spots"),
    'text3' => clienttranslate('If you have no <div class="littlea1tool"></div>, this bonus scores'),
    'gaintotal' => '4<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="gtool decal"></div>',
  ],

  '41' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'prerequis' => '<div class="a1tool"></div>',
    'pv' => 1,
    'name' => clienttranslate("stay in a capsule hotel"),
    'text1' => clienttranslate("Capsule hotels developed as inexpensive accommodations for businessmen to spend the night in the city. The pods are typically the size of a single bed, with only enough room to sit up."),
    'text2' => clienttranslate("Post photos on social media"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],
 
  '42' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 2, 0, 0],
    'prerequis' => '<div class="h2tool"></div><div class="h2tool"></div><div class="h2tool"></div><div class="h2tool"></div>',
    'pv' => 1,
    'name' => clienttranslate("stay in a capsule hotel"),
    'text1' => clienttranslate("Capsule hotels developed as inexpensive accommodations for businessmen to spend the night in the city. The pods are typically the size of a single bed, with only enough room to sit up."),
    'text2' => clienttranslate("Enjoy the pleasure of being thrifty"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per <div class="h2tool decal"></div>',
  ],

  '43' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="traveltool"></div> <div class="traveltool"></div> <div class="traveltool"></div>',
    'pv' => 3,
    'name' => clienttranslate("tokyo station"),
    'text1' => clienttranslate("Over 3,000 trains stop daily at Tokyo Station, which opened in 1914. The sprawling depot contains a department store and connects underground to surrounding shopping centers."),
    'text2' => clienttranslate("Walk to the Imperial Palace"),
    'text3' => clienttranslate("If you have traveled 3 times, this bonus scores"),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],

  '44' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("tokyo station"),
    'text1' => clienttranslate("Over 3,000 trains stop daily at Tokyo Station, which opened in 1914. The sprawling depot contains a department store and connects underground to surrounding shopping centers."),
    'text2' => clienttranslate("Make a unique purchase"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="btool decal"></div>]',
  ],

  '45' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 5,
    'name' => clienttranslate("tokyo national museum"),
    'text1' => clienttranslate("Located inside Ueno Park, the Tokyo National Museum hosts a large collection of historical treasures and items of cultural significance from Japan."),
    'text2' => clienttranslate("Learn about samurai history"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> per<br>[<div class="gtool decal"></div><div class="ytool decal"></div><div class="ptool decal"></div><div class="rtool decal"></div>]',
  ],

  '46' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("get a new outfit in harajuku"),
    'text1' => clienttranslate("Harajuku [ha•ra•joo•koo] neighborhood is world famous as the center of Japanese youth culture. The main street, Takeshita Dori, has trendy fashion boutiques, crepe stands, and cosplay stores."),
    'text2' => clienttranslate("Walk to nearby Togo Shrine"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="rtool decal"></div>',
  ],
 
  '47' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("get crepes in harajuku"),
    'text1' => clienttranslate("Harajuku [ha•ra•joo•koo] neighborhood is world famous as the center of Japanese youth culture. The main street, Takeshita Dori, has trendy fashion boutiques, crepe stands, and cosplay stores."),
    'text2' => clienttranslate("Shop in nearby stores"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="ytool decal"></div><div class="ytool decal"></div>',
  ],

  '48' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div>',
    'pv' => 3,
    'name' => clienttranslate("ikebukuro"),
    'text1' => clienttranslate("Ikebukuro [ee•keh•boo•koo•ro] is a hub for otaku (geek) culture. It houses Sunshine City, a city-within-a-city, with numerous shops, an anime theme park, an aquarium, and a planetarium."),
    'text2' => clienttranslate("Go to the planetarium"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '49' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a1tool"></div>',
    'pv' => 3,
    'name' => clienttranslate("ikebukuro"),
    'text1' => clienttranslate("Ikebukuro [ee•keh•boo•koo•ro] is a hub for otaku (geek) culture. Unlike Akihabara, it caters more to female clientele. Otome Road is a great place to find self-published manga aimed at women."),
    'text2' => clienttranslate("Find a new favorite manga series"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="a1tool decal"></div>',
  ],

  '50' => [
    'bonus' => [0, 0, 0, 1, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("daikanyama"),
    'text1' => clienttranslate("The neighborhood of Daikanyama [die•kahn•ya•ma], just south of Shibuya, is loved by young locals for its mix of boutique shops selling records, books, and streetwear."),
    'text2' => clienttranslate("Discover an amazing book store"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],

  '51' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("daikanyama"),
    'text1' => clienttranslate("The neighborhood of Daikanyama [die•kahn•ya•ma], just south of Shibuya, is loved by young locals for its mix of boutique shops selling records, books, and streetwear."),
    'text2' => clienttranslate("Browse some J-rock vinyl"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],
 
  '52' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 1],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div>',
    'pv' => 3,
    'name' => clienttranslate("go to a themed cafe"),
    'text1' => clienttranslate("Japan is famous for its many immersive cafés, where the décor, food, and servers reflect a singular theme: robots, vampires, ninjas, maids, trains, or even popular anime."),
    'text2' => clienttranslate("Dress up for the occasion"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="btool decal"></div>',
  ],

  '53' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("go to a themed cafe"),
    'text1' => clienttranslate("Japan is famous for its many immersive cafés, where the décor, food, and servers reflect a singular theme: robots, vampires, ninjas, maids, trains, or even popular anime."),
    'text2' => clienttranslate("Really get into the theme"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="gtool decal"></div>]',
  ],

  '54' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("see a kabuki show"),
    'text1' => clienttranslate("Kabuki [ka•boo•key] is a classical form of Japanese theater marked by exaggerated acting, elaborate costumes, outlandish wigs and makeup, dramatic music, and highly stylized movements."),
    'text2' => clienttranslate("Learn about the nuances"),
    'text3' => clienttranslate('This bonus scores 1<div class="littlepvtool"></div> per <div class="littlertool"></div> and gives you 2 <div class="littlebtool"></div>'),
    'gaintotal' => '1<div class="pvtool"></div> per <div class="rtool decal"></div><br><div class="btool decal"></div><div class="btool decal"></div>',
  ],

  '55' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("see a kabuki show"),
    'text1' => clienttranslate("Kabuki [ka•boo•key] is a classical form of Japanese theater marked by exaggerated acting, elaborate costumes, outlandish wigs and makeup, dramatic music, and highly stylized movements."),
    'text2' => clienttranslate("Respect the tradition"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '56' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 2],
    'prerequis' => '<div class="a1tool"></div><div class="a1tool"></div>',
    'pv' => 7,
    'name' => clienttranslate("stay at a really nice hotel"),
    'text1' => clienttranslate("Tokyo is home to some of the most luxurious hotels in the world, with lavish rooms, top-of-the-line service, and stunning views of the city that make it well worth the splurge."),
    'text2' => clienttranslate("Get a good night’s sleep"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="h1tool decal"></div><div class="h1tool decal"></div><div class="h1tool decal"></div><div class="h1tool decal"></div>',
  ],
 
  '57' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div>',
    'pv' => 6,
    'name' => clienttranslate("stay at a really nice hotel"),
    'text1' => clienttranslate("Tokyo is home to some of the most luxurious hotels in the world, with lavish rooms, top-of-the-line service, and stunning views of the city that make it well worth the splurge."),
    'text2' => clienttranslate("Stay in and pamper yourself"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="h1tool decal"></div>',
  ],

  '58' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 1,
    'name' => clienttranslate("dine at a top restaurant"),
    'text1' => clienttranslate("Tokyo is a foodie’s paradise, with more Michelin-starred restaurants than any other city in the world. Such exemplary cuisine often comes at a premium cost, but is well worth it for the connoisseur."),
    'text2' => clienttranslate("Eat the best meal of your life"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div><br><div class="btool decal"></div><div class="btool decal"></div><div class="btool decal"></div>',
  ],

  '59' => [
    'bonus' => [0, 2, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 1,
    'name' => clienttranslate("dine at a top restaurant"),
    'text1' => clienttranslate("Tokyo is a foodie’s paradise, with more Michelin-starred restaurants than any other city in the world. Such exemplary cuisine often comes at a premium cost, but is well worth it for the connoisseur."),
    'text2' => clienttranslate("Don’t worry about the cost"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="a2tool decal"></div>',
  ],

  '60' => [
    'bonus' => [0, 1, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("monjayaki in tsukishima"),
    'text1' => clienttranslate("Monjayaki [mohn•ja•ya•key] is a kind of runny pancake similar to okonomiyaki. Guests are given their ingredients in a bowl and cook them at their tables."),
    'text2' => clienttranslate("Enjoy the fresh seafood"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ptool decal"></div><div class="gtool decal"></div>]',
  ],

  '61' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("monjayaki in tsukishima"),
    'text1' => clienttranslate("Monjayaki [mohn•ja•ya•key] is a kind of runny pancake similar to okonomiyaki. Guests are given their ingredients in a bowl and cook them at their tables."),
    'text2' => clienttranslate("Order extra things on the menu"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="gtool decal"></div>',
  ],
 
  '62' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="h2tool"></div><div class="h2tool"></div><div class="h2tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("conveyor belt sushi"),
    'text1' => clienttranslate("Kaitenzushi, known in America as conveyor belt sushi, is an affordable dining experience in which conveyor belts carry plates of sushi to patrons seated around the restaurant."),
    'text2' => clienttranslate("Eat as much as you can"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div>',
  ],

  '63' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div>',
    'pv' => 1,
    'name' => clienttranslate("nezu shrine"),
    'text1' => clienttranslate("Nezu [neh•zoo] Shrine, located near Ueno Park, is home to the awe-inspiring Bunkyo Azalea Festival in April."),
    'text2' => clienttranslate("Walk around the azaleas"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div>',
  ],

  '64' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="h1tool"></div><div class="rtool"></div>',
    'pv' => 5,
    'name' => clienttranslate("todoroki valley Park"),
    'text1' => clienttranslate("Todoroki [toh•doh•ro•key] Valley Park, located in the heavily populated ward of Setagaya, has a walking trail along a small river that leads to Todoroki Fudo Temple."),
    'text2' => clienttranslate("Hike to the temple"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="rtool decal"></div><div class="btool decal"></div>',
  ],

  '65' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div><div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("todoroki valley Park"),
    'text1' => clienttranslate("Todoroki [toh•doh•ro•key] Valley Park, located in the heavily populated ward of Setagaya, has a walking trail along a small river that leads to Todoroki Fudo Temple."),
    'text2' => clienttranslate("Find the secluded temple"),
    'text3' => clienttranslate(""),
    'gaintotal' => '11<div class="pvtool"></div>',
  ],

  '66' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kanda shrine"),
    'text1' => clienttranslate("Kanda [kahn•da] Shrine near Akihabara is host to Kanda Matsuri, recognized as one of the three major Shinto festivals in Tokyo. It is held every other year in May."),
    'text2' => clienttranslate("Walk around Akihabara"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="rtool decal"></div>]',
  ],
 
  '67' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="wtool"></div> <div class="wtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kanda shrine"),
    'text1' => clienttranslate("Kanda [kahn•da] Shrine near Akihabara is host to Kanda Matsuri, recognized as one of the three major Shinto festivals in Tokyo. It is held every other year in May."),
    'text2' => clienttranslate("Shop in Akihabara"),
    'text3' => clienttranslate("If you have walked twice (including flipped cards), this bonus scores "),
    'gaintotal' => '5<div class="pvtool"></div> <div class="ytool decal"></div><div class="ytool decal"></div>',
  ],

  '68' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("get food from a konbini"),
    'text1' => clienttranslate("A konbini [kohn•be•nee] is a Japanese convenience store. Unlike in many other countries, quality food can be purchased there alongside Japanese snacks and drinks. "),
    'text2' => clienttranslate("Buy some limited-edition snacks to bring home"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div> <div class="ytool decal"></div>',
  ],

  '69' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 3,
    'name' => clienttranslate("grab some street food"),
    'text1' => clienttranslate("There are many types of delicious street food in Japan. Pictured above is okonomiyaki, a savory pancake made with cabbage and many other ingredients."),
    'text2' => clienttranslate("Walk it off at a nearby park"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ptool decal"></div><div class="gtool decal"></div>]',
  ],

  '70' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 3,
    'name' => clienttranslate("grab some street food"),
    'text1' => clienttranslate("There are many types of delicious street food in Japan. Pictured above is taiyaki, a fish-shaped pancake filled with red bean paste."),
    'text2' => clienttranslate("Try many types"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="gtool decal"></div><div class="gtool decal"></div>',
  ],

  '71' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="gtool"></div><div class="btool"></div>',
    'pv' => 3,
    'name' => clienttranslate("soba and tempura"),
    'text1' => clienttranslate("Tempura (fried seafood and vegetables) can be enjoyed as an entrée on its own but is often served as a side dish at restaurants specializing in soba, a type of noodle often dipped in broth."),
    'text2' => clienttranslate("Enjoy a little bit of everything"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],
 
  '72' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("attend a festival"),
    'text1' => clienttranslate("Festivals, known as matsuri, are held throughout Japan, often at major shrines. Three major festivals in Tokyo are Sanno Matsuri, Fukagawa Matsuri, and Kanda Matsuri. "),
    'text2' => clienttranslate("Get into the celebration"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="gtool decal"></div>]',
  ],

  '73' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="wtool"> </div><div class="wtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("take a hike outside of town"),
    'text1' => clienttranslate("With an abundance of national parks and picturesque landscapes, Japan is a haven for hikers. Mountains cover over 70 percent of the country, with enjoyable treks for hikers at any experience level. "),
    'text2' => clienttranslate("Make it all the way to the peak"),
    'text3' => clienttranslate("If you have walked twice (including flipped cards), this bonus scores"),
    'gaintotal' => '7<div class="pvtool"></div> <div class="ptool decal"></div>',
  ],

  '74' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("see some cherry blossoms"),
    'text1' => clienttranslate("Cherry blossom viewing, known as Ohanami, is one of Japan’s most splendid sights. As the flowers bloom for only a short period in the spring, visiting at that time is more expensive. "),
    'text2' => clienttranslate("Visit during peak time"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div> <div class="ptool decal"></div><div class="btool decal"></div>',
  ],

  '75' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("eat ramen at the best place!"),
    'text1' => clienttranslate("Originally from China, ramen is one of the most popular dishes in Japan. It can be found throughout Japan with many regional varieties that differ in flavor, broth, and ingredients."),
    'text2' => clienttranslate("Watch the master chef at work"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="gtool decal"></div>',
  ],

  '76' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="gtool"></div>',
    'pv' => 2,
    'name' => clienttranslate("visit a small shrine"),
    'text1' => clienttranslate("Japan has an estimated 80,000 Shinto shrines dedicated to various gods and causes. It is quite common to find them in unexpected places."),
    'text2' => clienttranslate("Admire the unique location"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="rtool decal"></div>',
  ],
 
  '77' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("photo sticker booth"),
    'text1' => clienttranslate("Known as Purikura, these photo booths with whimsical filters and backgrounds are found in arcades across the country. They were introduced in the 1990’s and quickly adopted by kawaii culture."),
    'text2' => clienttranslate("Try all the backgrounds"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="ptool decal"></div>]',
  ],

  '78' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("buy a gift in an interesting shop"),
    'text1' => clienttranslate("In Japan, gifts are often wrapped in furoshiki, a type of cloth that is reusable by either the giver or the receiver of the gift."),
    'text2' => clienttranslate("Spend a little extra"),
    'text3' => clienttranslate(""),
    'gaintotal' => '9<div class="pvtool"></div> <div class="a2tool decal"></div><div class="btool decal"></div>',
  ],

  '79' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("take a cooking class"),
    'text1' => clienttranslate("Cooking classes are a great way to further one’s experience of a country’s cuisine. Kappabashi Street in Tokyo is a prime location to shop for cookware."),
    'text2' => clienttranslate("Cook a complete kaiseki meal"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="gtool decal"></div>',
  ],

  '80' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("see a concert"),
    'text1' => clienttranslate("Music performances in Japan reflect the country’s blend of the traditional and the modern. Visitors can hear classic instruments such as koto or the most current stars in J-pop and J-rock."),
    'text2' => clienttranslate("Dance!"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],


];

$this->kyotocards = [
  '1' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="noytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("ginkakuji temple"),
    'text1' => clienttranslate("Ginkakuji [geen•ka•koo•jee] is also known as the Silver Pavilion. It was originally a shogun’s retirement villa that was modeled after his grandfather’s villa, Kinkakuji, the Golden Pavilion."),
    'text2' => clienttranslate("Become immersed"),
    'text3' => clienttranslate('If you have no <div class="littleytool"></div>, this bonus scores'),
    'gaintotal' => '5<div class="pvtool"></div> <div class="ptool decal"></div>',
  ],
 
  '2' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("tofukuji temple"),
    'text1' => clienttranslate("Tofukuji [tōh•foo•koo•jee] is a popular temple to visit in the fall when the changing colors of the leaves of the surrounding maple trees make it a beautiful sight."),
    'text2' => clienttranslate("See an amazing view"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ptool decal"></div>',
  ],

  '3' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="a1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("ryoanji temple"),
    'text1' => clienttranslate("Ryoanji [ryōh•ahn•jee] Temple is home to one of the most famous rock gardens in the world. The temple’s grounds also feature a spacious park with a pond."),
    'text2' => clienttranslate("Meditate at the rock garden"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="h1tool decal"></div><div class="h1tool decal"></div>',
  ],

  '4' => [
    'bonus' => [1, 0, 0, 0, 0, 1, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("ryoanji temple"),
    'text1' => clienttranslate("Ryoanji [ryōh•ahn•jee] Temple is home to one of the most famous rock gardens in the world. The temple’s grounds also feature a spacious park with a pond."),
    'text2' => clienttranslate("Feel at peace"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per <div class="h1tool decal"></div>',
  ],

  '5' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("kinkakuji temple"),
    'text1' => clienttranslate("Kinkakuji [keen•ka•koo•jee] is a stunning temple whose top half is covered in gold leaf while the bottom is made of wood. The temple overlooks a pond and is one of Kyoto’s most iconic landmarks."),
    'text2' => clienttranslate("Walk around the pond"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="ptool decal"></div>',
  ],

  '6' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div>',
    'pv' => 3,
    'name' => clienttranslate("kinkakuji temple"),
    'text1' => clienttranslate("Kinkakuji [keen•ka•koo•jee] is a stunning temple whose top half is covered in gold leaf while the bottom is made of wood. The temple overlooks a pond and is one of Kyoto’s most iconic landmarks."),
    'text2' => clienttranslate("Stand in awe of its beauty"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],
 
  '7' => [
    'bonus' => [1, 0, 1, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 1,
    'name' => clienttranslate("kiyomizudera temple"),
    'text1' => clienttranslate("On the way to the top of Kiyomizudera [key•yo•me•zoo•deh•ra] Temple, tourists can visit the many shops that line the pathway of stairs."),
    'text2' => clienttranslate("Visit shops on the way up"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="ptool decal"></div>]',
  ],

  '8' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 2,
    'name' => clienttranslate("kiyomizudera temple"),
    'text1' => clienttranslate("Kiyomizudera [key•yo•me•zoo•deh•ra] is famous for its large wooden pavilion deck and is a great place to view cherry blossoms in the spring and maple trees in the fall."),
    'text2' => clienttranslate("Get a breathtaking view from the wooden pavilion"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="btool decal"></div>',
  ],

  '9' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="h1tool"></div>',
    'pv' => 3,
    'name' => clienttranslate("nanzenji temple"),
    'text1' => clienttranslate("Nanzenji [nahn•zen•jee] Temple’s expansive grounds house a rock garden, the massive Sammon Gate, sub-temples, and, most distinctively, a large brick aqueduct built during the Meiji period."),
    'text2' => clienttranslate("Visit the rock garden"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> <div class="h1tool decal"></div><div class="rtool decal"></div>',
  ],

  '10' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div>',
    'pv' => 3,
    'name' => clienttranslate("nanzenji temple"),
    'text1' => clienttranslate("Nanzenji [nahn•zen•jee] Temple’s expansive grounds house a rock garden, the massive Sammon Gate, sub-temples, and, most distinctively, a large brick aqueduct built during the Meiji period."),
    'text2' => clienttranslate("Make an offering"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per <div class="h2tool decal"></div>',
  ],

  '11' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="wtool"></div> <div class="wtool"></div>',
    'pv' => 1,
    'name' => clienttranslate("fushimi inari shrine"),
    'text1' => clienttranslate("The shrine of Fushimi Inari [foo•she•me•ee•nah•ri], with its thousands of vermilion torii gates, is one of Kyoto’s most famous sights. Hiking to the top and back takes two to three hours. "),
    'text2' => clienttranslate("Make it all the way to the top"),
    'text3' => clienttranslate("If you have walked twice (including flipped cards), this bonus scores "),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="btool decal"></div>]',
  ],
 
  '12' => [
    'bonus' => [2, 0, 0, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="h1tool"></div><div class="h1tool"></div>',
    'pv' => 1,
    'name' => clienttranslate("fushimi inari shrine"),
    'text1' => clienttranslate("The shrine of Fushimi Inari [foo•she•me•ee•nah•ri], with its thousands of vermilion torii gates, is one of Kyoto’s most famous sights. Hiking to the top and back takes two to three hours. "),
    'text2' => clienttranslate("Walk every trail"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="rtool decal"></div>',
  ],

  '13' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("yasaka shrine"),
    'text1' => clienttranslate("Yasaka [ya•sah•ka) Shrine hosts the most famous festival in Japan, the summertime Gion Matsuri, with massive floats on display. The shrine features hundreds of lanterns lit for local businesses."),
    'text2' => clienttranslate("Admire the lanterns"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="gtool decal"></div>]',
  ],

  '14' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("yasaka shrine"),
    'text1' => clienttranslate("Yasaka [ya•sah•ka) Shrine hosts the most famous festival in Japan, the summertime Gion Matsuri, with massive floats on display. The shrine features hundreds of lanterns lit for local businesses."),
    'text2' => clienttranslate("Patronize local businesses"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="gtool decal"></div>]',
  ],

  '15' => [
    'bonus' => [1, 0, 1, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 2,
    'name' => clienttranslate("heian shrine"),
    'text1' => clienttranslate("Heian [hey•ahn] Shrine, modeled after the original Imperial Palace from the Heian Period, has a lovely garden behind the main buildings featuring late-blooming cherry blossom trees."),
    'text2' => clienttranslate("Walk along nearby Okazaki Canal"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '16' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div><div class="btool"></div>',
    'pv' => 1,
    'name' => clienttranslate("tea ceremony"),
    'text1' => clienttranslate("Kyoto is an excellent place to experience an authentic Japanese tea ceremony, in which matcha green tea is prepared using traditional instruments and methods in a formal presentation"),
    'text2' => clienttranslate("Learn the way of the tea"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="btool decal"></div><div class="gtool decal"></div>]',
  ],
 
  '17' => [
    'bonus' => [0, 1, 0, 0, 1, 1, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div>',
    'pv' => 1,
    'name' => clienttranslate("tea ceremony"),
    'text1' => clienttranslate("Kyoto is an excellent place to experience an authentic Japanese tea ceremony, in which matcha green tea is prepared using traditional instruments and methods in a formal presentation"),
    'text2' => clienttranslate("Really get into the custom"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="btool decal"></div>',
  ],

  '18' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="nortool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kyoto tower"),
    'text1' => clienttranslate("At 131 meters, Kyoto Tower is Kyoto’s tallest structure and sits atop a shopping center. The modern look of this beloved icon was a controversial addition to the city’s skyline when it opened in 1964."),
    'text2' => clienttranslate("Love the modern parts of Kyoto"),
    'text3' => clienttranslate('If you have no <div class="littlertool"></div>, this bonus scores'),
    'gaintotal' => '4<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ytool decal"></div>',
  ],

  '19' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kyoto tower"),
    'text1' => clienttranslate("At 131 meters, Kyoto Tower is Kyoto’s tallest structure and sits atop a shopping center. The modern look of this beloved icon was a controversial addition to the city’s skyline when it opened in 1964."),
    'text2' => clienttranslate("Gaze at the city’s famed temples"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="ptool decal"></div>]',
  ],

  '20' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 4,
    'name' => clienttranslate("monkey park"),
    'text1' => clienttranslate("Home to over a hundred free-roaming monkeys, Arashiyama Monkey Park Iwatayama is a unique attraction where visitors can feed and interact with monkeys."),
    'text2' => clienttranslate("Feed the monkeys"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="btool decal"></div><div class="btool decal"></div>',
  ],

  '21' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="h1tool"></div><div class="h1tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("monkey park"),
    'text1' => clienttranslate("Home to over a hundred free-roaming monkeys, Arashiyama Monkey Park Iwatayama is a unique attraction where visitors can feed and interact with monkeys."),
    'text2' => clienttranslate("See the monkeys up close"),
    'text3' => clienttranslate(""),
    'gaintotal' => '6<div class="pvtool"></div> <div class="btool decal"></div><div class="btool decal"></div>',
  ],
 
  '22' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 5,
    'name' => clienttranslate("manga museum"),
    'text1' => clienttranslate('The Kyoto International Manga Museum has multiple floors lined with shelves of manga. Visitors can browse over 50,000 titles in the collection, known as the "Wall of Manga".'),
    'text2' => clienttranslate("Locate a hard-to-find manga"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="h1tool decal"></div>',
  ],

  '23' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="noptool"></div>',
    'pv' => 5,
    'name' => clienttranslate("manga museum"),
    'text1' => clienttranslate('The Kyoto International Manga Museum has multiple floors lined with shelves of manga. Visitors can browse over 50,000 titles in the collection, known as the "Wall of Manga".'),
    'text2' => clienttranslate("Geek out like an otaku"),
    'text3' => clienttranslate('If you have no <div class="littleptool"></div>, this bonus scores'),
    'gaintotal' => '4<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ytool decal"></div>',
  ],

  '24' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="a2tool"></div><div class="a2tool"></div>',
    'pv' => 4,
    'name' => clienttranslate("sannenzaka slope"),
    'text1' => clienttranslate("Sannenzaka [sahn•nen•za•ka], a sloping street near Kiyomizudera Temple, is part of an historic area in Kyoto filled with cafés and shops selling traditional goods"),
    'text2' => clienttranslate("Explore nearby Ninenzaka street"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ytool decal"></div><div class="gtool decal"></div>]',
  ],

  '25' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("sannenzaka slope"),
    'text1' => clienttranslate("Sannenzaka [sahn•nen•za•ka], a sloping street near Kiyomizudera Temple, is part of an historic area in Kyoto filled with cafés and shops selling traditional goods"),
    'text2' => clienttranslate("Go to the temple"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '26' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="wtool"></div> <div class="wtool"></div>',
    'pv' => 1,
    'name' => clienttranslate("take an ikebana class"),
    'text1' => clienttranslate("Ikebana [ee•kay•bah•nah] is the classical Japanese art of flower arrangement. Different schools emerged, some emphasizing creativity while others adhere to strict rules of line and form. "),
    'text2' => clienttranslate("Find a new passion"),
    'text3' => clienttranslate("If you have walked twice (including flipped cards), this bonus scores "),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ptool decal"></div>',
  ],
 
  '27' => [
    'bonus' => [0, 0, 2, 0, 0, 0, 0, 0, 1],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 1,
    'name' => clienttranslate("take an ikebana class"),
    'text1' => clienttranslate("Ikebana [ee•kay•bah•nah] is the classical Japanese art of flower arrangement. Different schools emerged, some emphasizing creativity while others adhere to strict rules of line and form. "),
    'text2' => clienttranslate("Discover a hidden talent"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ptool decal"></div><div class="btool decal"></div>]',
  ],

  '28' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("geisha show at gion corner"),
    'text1' => clienttranslate("At Gion [gee•on] Corner, theatergoers can see a wide range of historical shows, including bunraku puppet shows, instrumental koto performances, and geisha dances."),
    'text2' => clienttranslate("Revere the tradition"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="btool decal"></div><div class="btool decal"></div>',
  ],

  '29' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("geisha show at gion corner"),
    'text1' => clienttranslate("At Gion [gee•on] Corner, theatergoers can see a wide range of historical shows, including bunraku puppet shows, instrumental koto performances, and geisha dances."),
    'text2' => clienttranslate("Stay for a bunraku show"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],

  '30' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kyoto imperial palace"),
    'text1' => clienttranslate("This was the former home of the Imperial Family before the capital moved from Kyoto to Tokyo in 1868. It is located in the Kyoto Imperial Park, which also houses Sento Imperial Palace."),
    'text2' => clienttranslate("See more of historic Kyoto"),
    'text3' => clienttranslate('This bonus scores 3 <div class="littlepvtool"></div> for each day spent only in Kyoto'),
    'gaintotal' => '3<div class="pvtool"></div> per <div class="kyototool"></div> ',
  ],

  '31' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 4,'name' => clienttranslate("kyoto imperial palace"),
    'text1' => clienttranslate("This was the former home of the Imperial Family before the capital moved from Kyoto to Tokyo in 1868. It is located in the Kyoto Imperial Park, which also houses Sento Imperial Palace."),
    'text2' => clienttranslate("Tour Sento Imperial Palace"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ptool decal"></div><div class="rtool decal"></div>]',
  ],
 
  '32' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 4,
    'name' => clienttranslate("philosopher’s path"),
    'text1' => clienttranslate("This famed stone walking path lined with cherry blossoms alongside a canal takes its name from noted philosopher Nishida Kitaro, who meditated there on his walks to Kyoto University."),
    'text2' => clienttranslate("Feel inspired"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> <div class="h1tool decal"></div><div class="h1tool decal"></div><div class="h1tool decal"></div>',
  ],

  '33' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 0, 1, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("philosopher’s path"),
    'text1' => clienttranslate("This famed stone walking path lined with cherry blossoms alongside a canal takes its name from noted philosopher Nishida Kitaro, who meditated there on his walks to Kyoto University."),
    'text2' => clienttranslate("Find new meaning in life"),
    'text3' => clienttranslate(""),
    'gaintotal' => '8<div class="pvtool"></div> <div class="witool decal"></div>
',
  ],

  '34' => [
    'bonus' => [0, 0, 0, 0, 1, 0, 0, 0, 0],
    'prerequis' => '<div class="traveltool"></div> <div class="traveltool"></div>',
    'pv' => 3,
    'name' => clienttranslate("kyoto railway museum"),
    'text1' => clienttranslate("With over 50 preserved trains, from early steam locomotives to Shinkansen bullet trains, the Kyoto Railway Museum presents a fascinating chronicle of Japan’s advances in train technology"),
    'text2' => clienttranslate("Reflect on your journeys"),
    'text3' => clienttranslate("If you have traveled twice, this bonus scores for each train ride you have taken."),
    'gaintotal' => '5<div class="pvtool"></div> and <br>2<div class="pvtool"></div> per <div class="traveltool decal"></div>',
  ],

  '35' => [
    'bonus' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="traveltool"></div> <div class="traveltool"></div> <div class="traveltool"></div>',
    'pv' => 5,
    'name' => clienttranslate("kyoto railway museum"),
    'text1' => clienttranslate("With over 50 preserved trains, from early steam locomotives to Shinkansen bullet trains, the Kyoto Railway Museum presents a fascinating chronicle of Japan’s advances in train technology"),
    'text2' => clienttranslate("Geek out over trains"),
    'text3' => clienttranslate("If you have traveled 3 times, this bonus scores."),
    'gaintotal' => '9<div class="pvtool"></div>',
  ],

  '36' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 4,
    'name' => clienttranslate("nishiki market"),
    'text1' => clienttranslate("Nishiki [nee•she•key] Market is a five-block area with over 100 shops and restaurants specializing in fresh food, cookware, and local cuisine."),
    'text2' => clienttranslate("Eat some fresh food"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="ptool decal"></div><div class="gtool decal"></div>]',
  ],
 
  '37' => [
    'bonus' => [0, 1, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="gtool"></div><div class="gtool"></div><div class="gtool"></div>',
    'pv' => 4,
    'name' => clienttranslate("nishiki market"),
    'text1' => clienttranslate("Nishiki [nee•she•key] Market is a five-block area with over 100 shops and restaurants specializing in fresh food, cookware, and local cuisine."),
    'text2' => clienttranslate("Try some street food"),
    'text3' => clienttranslate('This bonus scores 1 <div class="littlepvtool"></div> per <div class="littlebtool"></div> and gives you 2 <div class="littlegtool"></div>.'),
    'gaintotal' => '1<div class="pvtool"></div> per <div class="btool decal"></div><br><div class="gtool decal"></div><div class="gtool decal"></div>',
  ],

  '38' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kyoto handicraft center"),
    'text1' => clienttranslate("Kyoto Handicraft Center is a central locale for buying exquisite crafts such as folding fans, kokeshi dolls, ornamental swords, woodblock prints, kimonos, and iron teapots. "),
    'text2' => clienttranslate("Buy traditional souvenirs"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="ytool decal"></div>]',
  ],

  '39' => [
    'bonus' => [0, 0, 0, 1, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ytool"></div><div class="ytool"></div><div class="ytool"></div>',
    'pv' => 4,
    'name' => clienttranslate("kyoto handicraft center"),
    'text1' => clienttranslate("Kyoto Handicraft Center is a central locale for buying exquisite crafts such as folding fans, kokeshi dolls, ornamental swords, woodblock prints, kimonos, and iron teapots. "),
    'text2' => clienttranslate("Load up on souvenirs"),
    'text3' => clienttranslate(""),
    'gaintotal' => '7<div class="pvtool"></div>',
  ],

  '40' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 3,
    'name' => clienttranslate("otagi nenbutsuji temple"),
    'text1' => clienttranslate("Otagi Nenbutsuji [oh•ta•gee nen•boo•tsu•jee] Temple features 1,200 stone statues of rakan, disciples of Buddha. Carved mostly by amateurs, they were added during refurbishment in the 1980s."),
    'text2' => clienttranslate("Attend a sacred bonfire"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="btool decal"></div>',
  ],

  '41' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 0, 0, 0],
    'prerequis' => '<div class="ptool"></div><div class="ptool"></div><div class="ptool"></div>',
    'pv' => 3,
    'name' => clienttranslate("otagi nenbutsuji temple"),
    'text1' => clienttranslate("Otagi Nenbutsuji [oh•ta•gee nen•boo•tsu•jee] Temple features 1,200 stone statues of rakan, disciples of Buddha. Carved mostly by amateurs, they were added during refurbishment in the 1980s."),
    'text2' => clienttranslate("Enjoy the seclusion"),
    'text3' => clienttranslate(""),
    'gaintotal' => '2<div class="pvtool"></div> per [<div class="rtool decal"></div><div class="btool decal"></div>]',
  ],
 
  '42' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="rtool"></div><div class="rtool"></div><div class="rtool"></div>',
    'pv' => 2,
    'name' => clienttranslate("temple lodging"),
    'text1' => clienttranslate("Certain temples in Kyoto allow visitors of any faith to spend the night and experience the austere lifestyle of a Buddhist monk, including vegetarian meals called shojin ryori."),
    'text2' => clienttranslate("Have a shojin ryori meal"),
    'text3' => clienttranslate(""),
    'gaintotal' => '4<div class="pvtool"></div> <div class="h2tool decal"></div><div class="rtool decal"></div><div class="gtool decal"></div>',
  ],

  '43' => [
    'bonus' => [1, 0, 0, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="noytool"></div>',
    'pv' => 2,
    'name' => clienttranslate("temple lodging"),
    'text1' => clienttranslate("Certain temples in Kyoto allow visitors of any faith to spend the night and experience the austere lifestyle of a Buddhist monk, including vegetarian meals called shojin ryori."),
    'text2' => clienttranslate("Let go of the modern world"),
    'text3' => clienttranslate('If you have no <div class="littleytool"></div>, this bonus scores'),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="rtool decal"></div>',
  ],

  '44' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="h1tool"></div>',
    'pv' => 2,
    'name' => clienttranslate("arashiyama bamboo grove"),
    'text1' => clienttranslate("One of Kyoto’s most photographed sights, this forest of towering, swaying bamboo located in the western district of Arashiyama [ah•ra•she•ya•ma] feels otherworldly to visitors. "),
    'text2' => clienttranslate("Enjoy the free experience"),
    'text3' => clienttranslate(""),
    'gaintotal' => '5<div class="pvtool"></div> <div class="h2tool decal"></div>',
  ],

  '45' => [
    'bonus' => [0, 0, 1, 0, 0, 0, 1, 0, 0],
    'prerequis' => '<div class="btool"></div><div class="btool"></div>',
    'pv' => 2,
    'name' => clienttranslate("arashiyama bamboo grove"),
    'text1' => clienttranslate("One of Kyoto’s most photographed sights, this forest of towering, swaying bamboo located in the western district of Arashiyama [ah•ra•she•ya•ma] feels otherworldly to visitors. "),
    'text2' => clienttranslate("See it illuminated at night"),
    'text3' => clienttranslate(""),
    'gaintotal' => '3<div class="pvtool"></div> and <br>1<div class="pvtool"></div> per <div class="ptool decal"></div>',
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


