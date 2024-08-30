/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * letsgotojapan implementation : © <Mathieu Chatrain> <mathieu.chatrain@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * letsgotojapan.js
 *
 * letsgotojapan user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo","dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter"
],
function (dojo, declare) {
    return declare("bgagame.letsgotojapan", ebg.core.gamegui, {
        constructor: function(){
            console.log('letsgotojapan constructor');

                          
            // Here, you can init the global variables of your user interface
            // Example:
            // this.myGlobalValue = 0;

        },

    updatePlayerOrdering() {
        
        this.inherited(arguments);
        dojo.place(this.format_block('jstpl_titre', {}), 'player_boards', 'first');

    }, 

      
        
        /*
            setup:
            
            This method must set up the game user interface according to current game situation specified
            in parameters.
            
            The method is called each time the game interface is displayed to a player, ie:
            _ when the game starts
            _ when a player refreshes the game page (F5)
            
            "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
        */
        
            setup: function( gamedatas )
            {
                console.log( "Starting game setup" );

/////////////////////////////////////////////////////////////////////////////////           
//    _____                      _____        _            
//   / ____|                    |  __ \      | |           
//  | |  __  __ _ _ __ ___   ___| |  | | __ _| |_ __ _ ___ 
//  | | |_ |/ _` | '_ ` _ \ / _ \ |  | |/ _` | __/ _` / __|
//  | |__| | (_| | | | | | |  __/ |__| | (_| | || (_| \__ \
//   \_____|\__,_|_| |_| |_|\___|_____/ \__,_|\__\__,_|___/
//                                                        
/////////////////////////////////////////////////////////////////////////////////  
                
                this.players = gamedatas.players;
    
    
                // Setting up player boards
                for( var player_id in gamedatas.players )
                {
                    var player = gamedatas.players[player_id];
                             
                    // TODO: Setting up players boards if needed
                }

                for( var player_id in gamedatas.players )   
                    {
                                         
                        var player_board_div = $('player_board_'+player_id);
                        dojo.place( this.format_block('jstpl_player_compteurs', {id: player_id} ), player_board_div );
                        if (gamedatas.countplayers == 1)
                        {
                            if(gamedatas.lvl == 1)
                            {
                                dojo.place( this.format_block('jstpl_infolvl', {id: player_id} ), player_board_div );
                                var info = _("Easy level: Your opponent must meet the requirements of their “Highlight of the Day” bonuses in order to score them. It does not use Train tokens.");
                                $('infolvl_'+player_id).innerHTML = info;

                            }

                            if(gamedatas.lvl == 2)
                            {
                                dojo.place( this.format_block('jstpl_infolvl', {id: player_id} ), player_board_div );
                                var info = _("Normal level: Your opponent always scores all his “Highlights of the Day”. It does not use Train tokens.");
                                $('infolvl_'+player_id).innerHTML = info;

                            }

                            if(gamedatas.lvl == 3)
                            {
                                dojo.place( this.format_block('jstpl_infolvl', {id: player_id} ), player_board_div );
                                var info = _("Difficult level: Your opponent always scores all his “Highlights of the Day” and places a Luxury Train token each time he travels.");
                                $('infolvl_'+player_id).innerHTML = info;

                            }
                        }
                        
                        
                    }

                for( var player_id in gamedatas.players )   
                    {
                                            
                        
                        $('nbrerecherche_'+player_id).innerHTML = gamedatas.nbrerecherche[player_id];
                        $('nbretrain_'+player_id).innerHTML = gamedatas.nbretrain[player_id];
                        $('nbrewild_'+player_id).innerHTML = gamedatas.nbrewild[player_id];
                        $('nbretrainstart_'+player_id).innerHTML = gamedatas.nbretrainstart[player_id];
                        
                        
                    }

                for( var player_id in gamedatas.players )   
                    {
                                            
                        
                        $('compteurcardtokyodiscard_'+player_id).innerHTML = gamedatas.compteurcardtokyodiscard[player_id];
                        $('compteurcardkyotodiscard_'+player_id).innerHTML = gamedatas.compteurcardkyotodiscard[player_id];
                        
                        
                        
                    }


                if (gamedatas.countplayers >= 2)
                {
                for( var player_id in gamedatas.players )   
                {
                                        
                    var eyes = document.getElementById('eye_'+player_id);
                    if (eyes !== null)
                    {
                        dojo.destroy('eye_'+player_id)
                    }
                    
                    var player_board_div = $('player_board_'+player_id);
                    var elementScore = player_board_div.querySelector(".player_score");
                    dojo.place(this.format_block('jstpl_eye', {id: player_id }), elementScore);
  
                }
                }

                
                for( var player_id in gamedatas.players )
                    {
                        var player = gamedatas.players[player_id].id;
                        if(player != this.getCurrentPlayerId())
                        {
                            dojo.query("#playerview_"+player).addClass("masque");
                        }
    
                                                    
                        
                    }

                if((this.isSpectator)&&(gamedatas.countplayers >= 2))
                    {
                        var player = gamedatas.listplayers[0];
                        dojo.query("#playerview_"+player).removeClass("masque");
                        dojo.query(".playerhandtitle").addClass("masque");
                        dojo.query(".playerhand").addClass("masque");
                        dojo.query("#mask_turn").addClass("masque");
                        dojo.query("#mask_hand").addClass("masque");
                        dojo.query("#mask_score").addClass("hidden");

                        if (gamedatas.turn < 14)
                        {
                        var elements = document.querySelectorAll("[id^='playerview']");
                        elements.forEach(function(element) {
                            element.style.top = "151px"; 
                          });

                        var global = document.getElementById('global');
                        global.style.height = "1170px"; 
                        }

                        if (gamedatas.turn == 14)
                        {
                        dojo.query(".turn_board").addClass("hidden");

                        var elements = document.querySelectorAll("[id^='playerview']");
                        elements.forEach(function(element) {
                            element.style.top = "5px"; 
                            });

                        var global = document.getElementById('global');
                        global.style.height = "1020px"; 
                        }

                        if (gamedatas.turn >= 15)
                        {
                            dojo.query(".turn_board").addClass("hidden");
                            dojo.query(".scorepad").removeClass("hidden");

                            var elements = document.querySelectorAll("[id^='playerview']");
                        elements.forEach(function(element) {
                            element.style.top = "467px"; 
                            });

                        var global = document.getElementById('global');
                        global.style.height = "1476px"; 
                        }


                    }


                this.addTurn(gamedatas.turn);

                if ((gamedatas.turn >= 14)&&(!this.isSpectator)&&(gamedatas.countplayers >=2))
                {
                    

                    this.addMask();

                    dojo.query("#mask_turn").addClass("masque");
                    dojo.query("#mask_hand").addClass("masque");




                }

                if ((gamedatas.turn >= 15)&&(!this.isSpectator)&&(gamedatas.countplayers >= 2))
                    {
                        
                        dojo.query(".scorepad").removeClass("hidden");
                        dojo.query("#mask_score").removeClass("hidden");
                        var elements = document.querySelectorAll("[id^='playerview']");
                    elements.forEach(function(element) {
                        element.style.top = "525px"; 
                        });

                    var global = document.getElementById('global');
                    global.style.height = "1530px"; 
                        
    
    
    
    
                    }

                ////////////////////////////////   CARD PLAYER HAND AND TRIP   ///////////////////////////////

                
                for( var tokyo in gamedatas.tokyo)
                    {
                        
                        var tokyo = gamedatas.tokyo[tokyo];

                        
                        
                        if (tokyo.location.startsWith("playerhand"))
                        {
                            this.addCardTokyoHand(tokyo.id, tokyo.type, tokyo.type_arg, tokyo.location, tokyo.location_arg);
                        }
                        
                        
                        if (tokyo.location.startsWith("cardposition"))
                        {
                        
                            this.addCardTokyoTrip(tokyo.id, tokyo.type, tokyo.type_arg, tokyo.location, tokyo.location_arg, tokyo.walk, tokyo.finallocation, tokyo.finalwalk);

                        }

                        if(tokyo.train != 0)
                        {
                            this.addTrain (tokyo.id, tokyo.type_arg, tokyo.train)
                        }

                        if(tokyo.checkcard != 0)
                            {
                                this.addCheck (tokyo.id, tokyo.type_arg, tokyo.checkcard)
                            }
                        
                        
                        
                    }

                for( var kyoto in gamedatas.kyoto)
                    {
                        var kyoto = gamedatas.kyoto[kyoto];

                        if (kyoto.location.startsWith("playerhand"))
                        {
                            this.addCardKyotoHand(kyoto.id, kyoto.type, kyoto.type_arg, kyoto.location, kyoto.location_arg);
                        }
                       
                        
                        if (kyoto.location.startsWith("cardposition"))
                            {
                            
                            this.addCardKyotoTrip(kyoto.id, kyoto.type, kyoto.type_arg, kyoto.location, kyoto.location_arg, kyoto.walk, kyoto.finallocation, kyoto.finalwalk);
                            }

                        if(kyoto.train != 0)
                            {
                                this.addTrain (kyoto.id, kyoto.type_arg, kyoto.train)
                            }

                        if(kyoto.checkcard != 0)
                            {
                                this.addCheck (kyoto.id, kyoto.type_arg, kyoto.checkcard)
                            }
                        
                        
                    }

                    for( var player_id in gamedatas.players )
                        {
                            for( var jour in gamedatas.tokenjour)
                                {
                                    var tokenjour = gamedatas.tokenjour[jour];

                                    this.addTokenJour(tokenjour.name, tokenjour.level, player_id);
                                    
                                }
                        }
    
                for( var player_id in gamedatas.players )
                    {
                        var smile = gamedatas.smile[player_id];
                        var happy = gamedatas.happy[player_id];
                        var angry = gamedatas.angry[player_id];
                        var color = gamedatas.color[player_id];
                        
                        this.addHappy(smile, happy, angry, player_id, color);

                        var r = gamedatas.r[player_id];
                        var g = gamedatas.g[player_id];
                        var p = gamedatas.p[player_id];
                        var y = gamedatas.y[player_id];
                        var b = gamedatas.b[player_id];

                        this.addMarqueur(r, g, p, y, b, player_id);
                                                
                                                    
                        
                    }

                    for( var player_id in gamedatas.players )
                        {
                            var numero = gamedatas.numero[player_id];
                            var j1 = gamedatas.lundi[player_id];
                            var j2 = gamedatas.mardi[player_id];
                            var j3 = gamedatas.mercredi[player_id];
                            var j4 = gamedatas.jeudi[player_id];
                            var j5 = gamedatas.vendredi[player_id];
                            var j6 = gamedatas.samedi[player_id];

                            if (j1 != 0)
                            {
                                $('score_'+numero+'_1').innerHTML = j1;
                            }

                            if (j2 != 0)
                            {
                                $('score_'+numero+'_2').innerHTML = j2;
                            }

                            if (j3 != 0)
                            {
                                $('score_'+numero+'_3').innerHTML = j3;
                            }

                            if (j4 != 0)
                            {
                                $('score_'+numero+'_4').innerHTML = j4;
                            }
  
                            if (j5 != 0)
                            {
                                $('score_'+numero+'_5').innerHTML = j5;
                            }

                            if (j6 != 0)
                            {
                                $('score_'+numero+'_6').innerHTML = j6;
                            }


                            var scorehumeur = gamedatas.scorehumeur[player_id];
                            var scoretoken = gamedatas.scoretoken[player_id];
                            var scoretrain = gamedatas.scoretrain[player_id];
                            var scorerecherche = gamedatas.scorerecherche[player_id];
                            var scoretotal = gamedatas.scoretotal[player_id];
    
                            if (j6 != 0)
                            {
                                $('score_'+numero+'_7').innerHTML = scorehumeur;
                                $('score_'+numero+'_8').innerHTML = scoretoken;
                                $('score_'+numero+'_9').innerHTML = scoretrain;
                                $('score_'+numero+'_10').innerHTML = scorerecherche;
                                $('score_'+numero+'_11').innerHTML = scoretotal;

                            }

                            var jc1 = gamedatas.lundicheck[player_id];
                            var jc2 = gamedatas.mardicheck[player_id];
                            var jc3 = gamedatas.mercredicheck[player_id];
                            var jc4 = gamedatas.jeudicheck[player_id];
                            var jc5 = gamedatas.vendredicheck[player_id];
                            var jc6 = gamedatas.samedicheck[player_id];
                                
                            
                            if (jc1 == 1)
                            {
                                dojo.query("#checkscore_"+numero+"_1").addClass("checkscoreok");
                                
                            }
                            
                            if (jc1 == 2)
                            {
                                
                                dojo.query("#checkscore_"+numero+"_1").addClass("checkscoreko");
                            } 

                            if (jc2 == 1)
                            {
                                dojo.query("#checkscore_"+numero+"_2").addClass("checkscoreok");
                                
                            }
                            
                            if (jc2 == 2)
                            {
                               
                                dojo.query("#checkscore_"+numero+"_2").addClass("checkscoreko");
                            }
                            
                            if (jc3== 1)
                            {
                                dojo.query("#checkscore_"+numero+"_3").addClass("checkscoreok");
                                
                            }
                            
                            if (jc3 == 2)
                            {
                                
                                dojo.query("#checkscore_"+numero+"_3").addClass("checkscoreko");
                            } 

                            if (jc4 == 1)
                            {
                                dojo.query("#checkscore_"+numero+"_4").addClass("checkscoreok");
                                
                            }
                            
                            if (jc4 == 2)
                            {
                                
                                dojo.query("#checkscore_"+numero+"_4").addClass("checkscoreko");
                            } 

                            if (jc5 == 1)
                            {
                                dojo.query("#checkscore_"+numero+"_5").addClass("checkscoreok");
                                
                            }
                            
                            if (jc5 == 2)
                            {
                                
                                dojo.query("#checkscore_"+numero+"_5").addClass("checkscoreko");
                            } 

                            if (jc6 == 1)
                            {
                                dojo.query("#checkscore_"+numero+"_6").addClass("checkscoreok");
                                
                            }
                            
                            if (jc6 == 2)
                            {
                                
                                dojo.query("#checkscore_"+numero+"_6").addClass("checkscoreko");
                            } 
                            
                        }
                    
                
                        for( var player_id in gamedatas.players )
                            {
                                var num = gamedatas.numero[player_id];
                                var avatar ='avatar_'+player_id;

                                var avatarImage = document.getElementById(avatar);
                                var avatarSrc = avatarImage.src;

                                var newImage = document.createElement('img');
                                newImage.src = avatarSrc;
                                newImage.id = 'newavatar_'+player_id; 
                                var container = document.getElementById('scorename_'+num);                         
                                container.appendChild(newImage);
                                this.addTooltipHtml( 'newavatar_'+player_id, gamedatas.name[player_id],'' );

                                if (gamedatas.countplayers == 1)
                                {
                                    dojo.place( this.format_block( 'jstpl_avataragent', {
                                                                                                    
                                    } ) , 'scorename_2' );

                                    this.addTooltipHtml( 'avataragent', 'Travel Agent','' );

                                }
                            }
                

                ///// TOOL TIPS ////

                for( var player_id in gamedatas.players )
                {
                var textbonus1 = _("Move the Mood Tracker token 1 space to the right");
                var htmlbonus1 = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textbonus1})+'</div></div>';
                this.addTooltipHtml( 'bonusjournee_1_1_'+player_id, htmlbonus1,1000);

                var textbonus2 = _("Take 2 Research tokens");
                var htmlbonus2 = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textbonus2})+'</div></div>';
                this.addTooltipHtml( 'bonusjournee_2_1_'+player_id, htmlbonus2,1000);

                var textbonus3 = _("Take 1 Wild token. During the trip, discard a Wild token to advance an Experience token of your choice one space.");
                var htmlbonus3 = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textbonus3})+'</div></div>';
                this.addTooltipHtml( 'bonusjournee_2_2_'+player_id, htmlbonus3,1000);

                var textbonus4 = _("Take 1 Luxury Train token");
                var htmlbonus4 = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textbonus4})+'</div></div>';
                this.addTooltipHtml( 'bonusjournee_3_1_'+player_id, htmlbonus4,1000);

                var textbonus5 = _("Go on an Extra Walk: Add a walk to that day. Do not take a Research token");
                var htmlbonus5 = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textbonus5})+'</div></div>';
                this.addTooltipHtml( 'bonusjournee_3_2_'+player_id, htmlbonus5,1000);


                }


                ////////////////////// MODE SOLO ////////////////////

                if (gamedatas.countplayers == 1)
                {
                    dojo.query(".left").addClass("hidden");
                    dojo.query(".right").addClass("hidden");
                    dojo.query("#playerview_agent").removeClass("hidden");

                    var global = document.getElementById('global');
                    global.style.height = "2270px"; 
                    var agent = document.querySelector('.playerview_agent');
                    agent.style.top = "1150px"; 


                    for( var jour in gamedatas.tokenjour)
                    {
                        var tokenjour = gamedatas.tokenjour[jour];

                        this.addTokenJour(tokenjour.name, tokenjour.level, 0);
                        
                    }


                    var r = gamedatas.r[0];
                    var g = gamedatas.g[0];
                    var p = gamedatas.p[0];
                    var y = gamedatas.y[0];
                    var b = gamedatas.b[0];

                    this.addMarqueur(r, g, p, y, b, 0);

                    var smile = gamedatas.smile[0];
                    var happy = gamedatas.happy[0];
                    var angry = gamedatas.angry[0];
                    var color = gamedatas.color[0];
                    
                    this.addHappy(smile, happy, angry, 0, 'f285a1');


                    if(this.isSpectator)
                    {
                        var player = gamedatas.listplayers[0];
                        dojo.query("#playerview_"+player).removeClass("masque");
                        dojo.query("#mask_turn").addClass("masque");
                        dojo.query("#mask_hand").addClass("masque");
                        dojo.query("#mask_score").addClass("hidden");

                    }


                    if (gamedatas.turn == 14)
                        {
                            
        
                            this.addMask();
                            
        
                            dojo.query("#mask_turn").addClass("masque");
                            dojo.query("#mask_hand").addClass("masque");
        
        
        
        
                        }

                    if ((gamedatas.turn >= 15)&&(!this.isSpectator))
                        {
                            
        
                            this.addMask();
                            
        
                            dojo.query("#mask_turn").addClass("masque");
                            dojo.query("#mask_hand").addClass("masque");
                            dojo.query("#mask_score").removeClass("hidden");
                            dojo.query(".scorepad").removeClass("hidden");

                            var playerview = document.querySelector('.playerview');
                            playerview.style.top = "525px"; 

                            var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1380px"; 
    
                            var global = document.getElementById('global');
                            global.style.height = "2180px";
        
        
        
        
                        }

                    if ((gamedatas.turn >= 15)&&(this.isSpectator))
                        {
                            
        
                            this.addMask();
                            
        
                            dojo.query("#mask_turn").addClass("masque");
                            dojo.query("#mask_hand").addClass("masque");
                            dojo.query(".scorepad").removeClass("hidden");

                            var playerview = document.querySelector('.playerview');
                            playerview.style.top = "470px"; 

                            var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1325px"; 
    
                            var global = document.getElementById('global');
                            global.style.height = "2125px";
        
        
        
        
                        }


                    /////// AGENT SCOREPAD/////

                    var j1a = gamedatas.lundi[0];
                    var j2a = gamedatas.mardi[0];
                    var j3a = gamedatas.mercredi[0];
                    var j4a = gamedatas.jeudi[0];
                    var j5a = gamedatas.vendredi[0];
                    var j6a = gamedatas.samedi[0];

                    if (j1a != 0)
                    {
                        $('score_2_1').innerHTML = j1a;
                    }

                    if (j2a != 0)
                    {
                        $('score_2_2').innerHTML = j2a;
                    }

                    if (j3a != 0)
                    {
                        $('score_2_3').innerHTML = j3a;
                    }

                    if (j4a != 0)
                    {
                        $('score_2_4').innerHTML = j4a;
                    }

                    if (j5a != 0)
                    {
                        $('score_2_5').innerHTML = j5a;
                    }

                    if (j6a != 0)
                    {
                        $('score_2_6').innerHTML = j6a;
                    }


                    var scorehumeura = gamedatas.scorehumeur[0];
                    var scoretokena = gamedatas.scoretoken[0];
                    var scoretraina = gamedatas.scoretrain[0];
                    var scorerecherchea = gamedatas.scorerecherche[0];
                    var scoretotala = gamedatas.scoretotal[0];

                    if (j6a != 0)
                    {
                        $('score_2_7').innerHTML = scorehumeura;
                        $('score_2_8').innerHTML = scoretokena;
                        $('score_2_9').innerHTML = scoretraina;
                        $('score_2_10').innerHTML = scorerecherchea;
                        $('score_2_11').innerHTML = scoretotala;

                    }

                    var jc1a = gamedatas.lundicheck[0];
                    var jc2a = gamedatas.mardicheck[0];
                    var jc3a = gamedatas.mercredicheck[0];
                    var jc4a = gamedatas.jeudicheck[0];
                    var jc5a = gamedatas.vendredicheck[0];
                    var jc6a = gamedatas.samedicheck[0];
                        
                    
                    if (jc1a == 1)
                    {
                        dojo.query("#checkscore_2_1").addClass("checkscoreok");
                        
                    }
                    
                    if (jc1a == 2)
                    {
                        
                        dojo.query("#checkscore_2_1").addClass("checkscoreko");
                    } 

                    if (jc2a == 1)
                    {
                        dojo.query("#checkscore_2_2").addClass("checkscoreok");
                        
                    }
                    
                    if (jc2a == 2)
                    {
                        
                        dojo.query("#checkscore_2_2").addClass("checkscoreko");
                    }
                    
                    if (jc3a== 1)
                    {
                        dojo.query("#checkscore_2_3").addClass("checkscoreok");
                        
                    }
                    
                    if (jc3a == 2)
                    {
                        
                        dojo.query("#checkscore_2_3").addClass("checkscoreko");
                    } 

                    if (jc4a == 1)
                    {
                        dojo.query("#checkscore_2_4").addClass("checkscoreok");
                        
                    }
                    
                    if (jc4a == 2)
                    {
                        
                        dojo.query("#checkscore_2_4").addClass("checkscoreko");
                    } 

                    if (jc5a == 1)
                    {
                        dojo.query("#checkscore_2_5").addClass("checkscoreok");
                        
                    }
                    
                    if (jc5a == 2)
                    {
                        
                        dojo.query("#checkscore_2_5").addClass("checkscoreko");
                    } 

                    if (jc6a == 1)
                    {
                        dojo.query("#checkscore_2_6").addClass("checkscoreok");
                        
                    }
                    
                    if (jc6a == 2)
                    {
                        
                        dojo.query("#checkscore_2_6").addClass("checkscoreko");
                    }



                }

                if (gamedatas.turn < 14)
                {


                if ((gamedatas.maxtrip[0] == 1)&&((gamedatas.phase[0] == "SoloPhase1Step2")||(gamedatas.phase[0] == "SoloPhase2Step2")))
                {

                    var agent = document.querySelector('.playerview_agent');
                        agent.style.top = "1254px";

                }

                if ((gamedatas.maxtrip[0] == 1)&&(gamedatas.phase[0] != "SoloPhase1Step2")&&(gamedatas.phase[0] != "SoloPhase2Step2"))
                    {
    
                        var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1254px";
    
                    }

                if ((gamedatas.maxtrip[0] == 2)&&(gamedatas.phase[0] != "SoloPhase1Step2")&&(gamedatas.phase[0] != "SoloPhase2Step2"))
                    {
    
                        var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1202px";
    
                    }

                if ((gamedatas.maxtrip[0] == 2)&&((gamedatas.phase[0] == "SoloPhase1Step2")||(gamedatas.phase[0] == "SoloPhase2Step2")))
                    {
    
                        var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1358px";
    
                    }

                if ((gamedatas.maxtrip[0] == 3)&&(gamedatas.phase[0] != "SoloPhase1Step2")&&(gamedatas.phase[0] != "SoloPhase2Step2"))
                    {
    
                        var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1254px";
    
                    }

                if ((gamedatas.maxtrip[0] == 3)&&((gamedatas.phase[0] == "SoloPhase1Step2")||(gamedatas.phase[0] == "SoloPhase2Step2")))
                    {
    
                        var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1358px";
    
                    }
                }



                ////////////////////// FIN DE MODE SOLO ////////////////////






     
                // Setup game notifications to handle (see "setupNotifications" method below)
                this.setupNotifications();
    
                dojo.query(".left").connect('onclick', this, 'onPrev' );
                dojo.query(".right").connect('onclick', this, 'onNext' );
                dojo.query(".cardposition").connect('onclick', this, 'onSelect' );
                dojo.query(".eye").connect('onclick', this, 'onEye' );
                dojo.query("#mask_turn").connect('onclick', this, 'onMaskTurn' );
                dojo.query("#mask_hand").connect('onclick', this, 'onMaskHand' );
                dojo.query(".bonusjournee").connect('onclick', this, 'onSelect' );
                dojo.query(".bonusjournee2").connect('onclick', this, 'onSelect' );
                dojo.query("#mask_score").connect('onclick', this, 'onMaskScore' );
                

                
    
    
                console.log( "Ending game setup" );
            },
           
/////////////////////////////////////////////////////////////////////////////////   
//         _____ _        _            
//        / ____| |      | |           
//       | (___ | |_ __ _| |_ ___  ___ 
//        \___ \| __/ _` | __/ _ \/ __|
//        ____) | || (_| | ||  __/\__ \
//       |_____/ \__\__,_|\__\___||___/
//                                    
/////////////////////////////////////////////////////////////////////////////////  
            
            // onEnteringState: this method is called each time we are entering into a new game state.
            //                  You can use this method to perform some user interface changes at this moment.
            //
            onEnteringState: function( stateName, args )
            {
                console.log( 'Entering state: '+stateName );
    
                dojo.query(".selectable").removeClass("selectable"); 
                dojo.query(".selectableswitch").removeClass("selectableswitch"); 
                dojo.query(".selected").removeClass("selected"); 
                dojo.query(".selectable2").removeClass("selectable2"); 
                dojo.query(".selected2").removeClass("selected2");
                dojo.query(".selected3").removeClass("selected3");  
                dojo.query(".selectable3discard").removeClass("selectable3discard"); 
                dojo.query(".selected3discard").removeClass("selected3discard"); 
                dojo.query(".noanimation").removeClass("noanimation"); 
                
                switch( stateName )
                {
                    case 'playerTurn':
                        this.args = args.args;
                        
                        if ((this.getCurrentPlayerId())&&(this.args[this.getCurrentPlayerId()])&&(this.isCurrentPlayerActive()))
                        {
                            if (this.args[this.getCurrentPlayerId()][0].selectable)
                            {
                            for( var sid in this.args[this.getCurrentPlayerId()][0].selectable)
                                {
                                        dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selectable[sid]).addClass("selectable");
                                       
    
                                }
                            }

                            if (this.args[this.getCurrentPlayerId()][0].selectableswitch)
                                {
                                for( var sid in this.args[this.getCurrentPlayerId()][0].selectableswitch)
                                    {
                                            dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selectableswitch[sid]).addClass("selectableswitch");
                                           
        
                                    }
                                }

                            if (this.args[this.getCurrentPlayerId()][0].selectable2)
                                {
                                for( var sid in this.args[this.getCurrentPlayerId()][0].selectable2)
                                    {
                                            dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selectable2[sid]).addClass("selectable2");
                                           
        
                                    }
                                }

                            if (this.args[this.getCurrentPlayerId()][0].selectable3discard)
                                {
                                for( var sid in this.args[this.getCurrentPlayerId()][0].selectable3discard)
                                    {
                                            dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selectable3discard[sid]).addClass("selectable3discard");
                                           
        
                                    }
                                }


                            if (this.args[this.getCurrentPlayerId()][0].selected)
                                {
                                for( var sid in this.args[this.getCurrentPlayerId()][0].selected)
                                    {
                                        
                                            
                                            dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selected[sid]).addClass("selected");
        
                                    }
                                }

                            if (this.args[this.getCurrentPlayerId()][0].selected2)
                                {
                                for( var sid in this.args[this.getCurrentPlayerId()][0].selected2)
                                    {
                                        
                                            
                                            dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selected2[sid]).addClass("selected2");
        
                                    }
                                }

                                if (this.args[this.getCurrentPlayerId()][0].selected3)
                                    {
                                    for( var sid in this.args[this.getCurrentPlayerId()][0].selected3)
                                        {
                                            
                                                
                                                dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selected3[sid]).addClass("selected3");
            
                                        }
                                    }
    
                            
                            if(this.args[this.getCurrentPlayerId()][0].titleyou != null)
                            {
                                $('pagemaintitletext').innerHTML = 	this.format_string_recursive(_(this.args[this.getCurrentPlayerId()][0].titleyou).replace('${you}', this.divYou()).replace('#nb#',args.args.nb).replace('#nb2#',args.args.nb2).replace('#icon#',args.args.icon), args.args);
                            }


                            if (this.prefs[100].value == 2)
                                {
                                    var flash = document.querySelectorAll('.card.selected3');
                                    
                
                                    flash.forEach(function(element) {
                                        // Ajout d'une classe spéciale pour annuler l'animation
                                        element.classList.add('noanimation');
                                    });
                
                                    
                
                                }


                            var boutonvalidate = document.getElementById('validate3discard');
                            var elements = document.querySelectorAll('.selectable2');
                            var nombreElements = elements.length;
                            if (boutonvalidate !== null)
                            {
                                if (nombreElements == 3)
                                    {
                                    dojo.removeClass( 'validate3discard', 'disabled');
                                    }
                                if (nombreElements != 3)
                                    {
                                    dojo.addClass( 'validate3discard', 'disabled');
                                    }
                        }


                                 
                            
                        }
                            
                        
                        break;
               
               
                case 'dummmy':
                    break;
                }
            },
    
            // onLeavingState: this method is called each time we are leaving a game state.
            //                 You can use this method to perform some user interface changes at this moment.
            //
            onLeavingState: function( stateName )
            {
                console.log( 'Leaving state: '+stateName );
                
                switch( stateName )
                {
                
                       
                case 'dummmy':
                    break;
                }               
            }, 
    
            // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
            //                        action status bar (ie: the HTML links in the status bar).
            //        
    
            onUpdateActionButtons: function( stateName, args )
            {
                console.log( 'onUpdateActionButtons: '+stateName );
    
                if(this.isCurrentPlayerActive())
                {            
                    switch( stateName )
                    {
    
                        case "playerTurn":
    
                        if((args[this.getCurrentPlayerId()])&&(args[this.getCurrentPlayerId()][0].buttons))
                        {
                            for( var nb in args[this.getCurrentPlayerId()][0].buttons)
                            { 
                                    
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "cancel")
                                    {
                                        this.addActionButton( 'cancel', _("Cancel") ,'onOpButton', null, null, 'red' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "pass")
                                    {
                                        this.addActionButton( 'pass', _("Pass") ,'onOpButton', null, null, 'red' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "walk")
                                    {
                                        this.addActionButton( 'walk', `<div class="iconwalk"></div>` ,'onOpButton', null, null, 'none' );
                                        var textwalk = _("Discard 1 card from your hand and take a card from the Tokyo deck or Kyoto and place it face down in the itinerary. Gain 1 Research token");
                                        var htmlwalk = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textwalk})+'</div></div>';
                                        this.addTooltipHtml( 'walk', htmlwalk,1000);

                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "recherche")
                                    {
                                        this.addActionButton( 'recherche', `<div class="iconrecherche"></div>` ,'onOpButton', null, null, 'none' );
                                        var textrecherche = _("Discard a Research token to draw 3 cards from any combination of the Tokyo and Kyoto decks. Then IMMEDIATELY discard any 3 cards");
                                        var htmlrecherche = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textrecherche})+'</div></div>';
                                        this.addTooltipHtml( 'recherche', htmlrecherche,1000);
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "tokyo")
                                    {
                                        this.addActionButton( 'tokyo', `<div class="boutontokyo">Tokyo</div>` ,'onOpButton', null, null, 'none' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "kyoto")
                                    {
                                        this.addActionButton( 'kyoto', `<div class="boutonkyoto">Kyoto</div>` ,'onOpButton', null, null, 'none' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "validate3discard")
                                    {
                                    this.addActionButton( 'validate3discard', _("Validate selection") ,'onOpValidate3Discard', null, null, 'blue' );

                                    
                            
                                    
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "continue")
                                    {
                                        this.addActionButton( 'continue', _("Continue") ,'onOpButton', null, null, 'blue' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "confirm")
                                    {
                                        this.addActionButton( 'confirm', _("Confirm") ,'onOpButton', null, null, 'blue' );
                                    }

                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "cardtokyoverso")
                                        {
                                                                                        
                                            this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardtokyoversobouton"></div>`, 'onOpButton', null, null, 'none');
                                            var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyowalktool')+'</div></div>';
                                            this.addTooltipHtml( 'cardtokyoverso', html,1000);

                                    

                                        }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "cardkyotoverso")
                                        {
                                                                                        
                                            this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardkyotoversobouton"></div>`, 'onOpButton', null, null, 'none');
                                            var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyotowalktool')+'</div></div>';
                                            this.addTooltipHtml( 'cardkyotoverso', html,1000);
                                        }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb].startsWith("cardbouton_1"))
                                        {
                                            var card = args[this.getCurrentPlayerId()][0].buttons[nb].split("_");
                                            if((card[3]>=1)&&(card[3] <= 10))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: 0%; background-position-x: ${((card[3]-1)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card[3]-1)*(-100), y: 0})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=11)&&(card[3] <= 20))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -100%; background-position-x: ${((card[3]-11)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card[3]-11)*(-100), y: -100})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=21)&&(card[3] <= 30))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -200%; background-position-x: ${((card[3]-21)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card[3]-21)*(-100), y: -200})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
    

                                            if((card[3]>=31)&&(card[3] <= 40))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -300%; background-position-x: ${((card[3]-31)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card[3]-31)*(-100), y: -300})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=41)&&(card[3] <= 50))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: 0%; background-position-x: ${((card[3]-41)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card[3]-41)*(-100), y: 0})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
    
                                            if((card[3]>=51)&&(card[3] <= 60))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -100%; background-position-x: ${((card[3]-51)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card[3]-51)*(-100), y: -100})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=61)&&(card[3] <= 70))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -200%; background-position-x: ${((card[3]-61)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card[3]-61)*(-100), y: -200})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
    

                                            if((card[3]>=71)&&(card[3] <= 80))
                                                {
                                                    var img = g_gamethemeurl+"img/tokyo2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -300%; background-position-x: ${((card[3]-71)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card[3]-71)*(-100), y: -300})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
                                            
                                                                                        
                                            
                                        }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb].startsWith("cardbouton_2"))
                                        {
                                                                                        
                                            var card = args[this.getCurrentPlayerId()][0].buttons[nb].split("_");
                                            if((card[3]>=1)&&(card[3] <= 10))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: 0%; background-position-x: ${((card[3]-1)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card[3]-1)*(-100), y: 0})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=11)&&(card[3] <= 20))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -100%; background-position-x: ${((card[3]-11)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card[3]-11)*(-100), y: -100})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=21)&&(card[3] <= 30))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -200%; background-position-x: ${((card[3]-21)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card[3]-21)*(-100), y: -200})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
    

                                            if((card[3]>=31)&&(card[3] <= 40))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto1.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -300%; background-position-x: ${((card[3]-31)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card[3]-31)*(-100), y: -300})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=41)&&(card[3] <= 50))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto2.jpg";
                                                        this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: 0%; background-position-x: ${((card[3]-41)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card[3]-41)*(-100), y: 0})+'</div></div>';
                                                        this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
    
                                            if((card[3]>=51)&&(card[3] <= 60))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -100%; background-position-x: ${((card[3]-51)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card[3]-51)*(-100), y: -100})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }

                                            if((card[3]>=61)&&(card[3] <= 70))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -200%; background-position-x: ${((card[3]-61)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card[3]-61)*(-100), y: -200})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
    

                                            if((card[3]>=71)&&(card[3] <= 80))
                                                {
                                                    var img = g_gamethemeurl+"img/kyoto2.jpg";
                                                    this.addActionButton(args[this.getCurrentPlayerId()][0].buttons[nb], `<div class="cardbouton" style="background-image: url(${img}); background-position-y: -300%; background-position-x: ${((card[3]-71)*(-100))}%;"></div>`, 'onOpButton', null, null, 'none');
                                                    var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card[3]-71)*(-100), y: -300})+'</div></div>';
                                                    this.addTooltipHtml(args[this.getCurrentPlayerId()][0].buttons[nb], html,1000);
                                                }
                                        }

                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "trainstart")
                                            {
                                                this.addActionButton( 'trainstart', `<div class="boutontrain_1"></div>` ,'onOpButton', null, null, 'none' );
                                            }

                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "train")
                                            {
                                                this.addActionButton( 'train', `<div class="boutontrain_2"></div>` ,'onOpButton', null, null, 'none' );
                                            }

                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "normaltrain")
                                            {
                                                this.addActionButton( 'normaltrain', `<div class="boutontrain_3"></div>` ,'onOpButton', null, null, 'none' );
                                            }

                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "yes")
                                            {
                                                this.addActionButton( 'yes', _("Yes") ,'onOpButton', null, null, 'blue' );
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "no")
                                            {
                                                this.addActionButton( 'no', _("No") ,'onOpButton', null, null, 'red' );
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "red")
                                            {
                                                this.addActionButton( 'red', `<div class="red"></div>` ,'onOpButton', null, null, 'none' );
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "green")
                                            {
                                                this.addActionButton( 'green', `<div class="green"></div>` ,'onOpButton', null, null, 'none' );
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "pink")
                                            {
                                                this.addActionButton( 'pink', `<div class="pink"></div>` ,'onOpButton', null, null, 'none' );
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "yellow")
                                            {
                                                this.addActionButton( 'yellow', `<div class="yellow"></div>` ,'onOpButton', null, null, 'none' );
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "blue")
                                            {
                                                this.addActionButton( 'blue', `<div class="blue"></div>` ,'onOpButton', null, null, 'none' );
                                            }

                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "easy")
                                            {
                                                this.addActionButton( 'easy', _("Easy") ,'onOpButton', null, null, 'blue' );
                                                var texteasy = _("Your opponent must meet the requirements of their “Highlight of the Day” bonuses in order to score them. It does not use Train tokens.");
                                                var htmleasy = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: texteasy})+'</div></div>';
                                                this.addTooltipHtml( 'easy', htmleasy,500);
                                            }
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "normal")
                                            {
                                                this.addActionButton( 'normal', _("Normal") ,'onOpButton', null, null, 'gray' );
                                                var textnormal = _("Your opponent always scores all his “Highlights of the Day”. It does not use Train tokens.");
                                                var htmlnormal = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textnormal})+'</div></div>';
                                                this.addTooltipHtml( 'normal', htmlnormal,500);
                                            }
                
                                        if(args[this.getCurrentPlayerId()][0].buttons[nb] == "difficult")
                                            {
                                                this.addActionButton( 'difficult', _("Difficult") ,'onOpButton', null, null, 'red' );
                                                var textdifficult = _("Your opponent always scores all his “Highlights of the Day” and places a Luxury Train token each time he travels.");
                                                var htmldifficult = '<div class="toolt"><div class="infotoolt">'+this.format_block('jstpl_infotool',{text: textdifficult})+'</div></div>';
                                                this.addTooltipHtml( 'difficult', htmldifficult,500);
                                            }
                    
                    
                                    
                            }
                        }   
                            
                        break;
    
    
    
                    }
                }
                          
                
            },  
    
/////////////////////////////////////////////////////////////////////////////////         
//   _    _ _   _ _ _ _                          _   _               _     
//  | |  | | | (_) (_) |                        | | | |             | |    
//  | |  | | |_ _| |_| |_ _   _   _ __ ___   ___| |_| |__   ___   __| |___ 
//  | |  | | __| | | | __| | | | | '_ ` _ \ / _ \ __| '_ \ / _ \ / _` / __|
//  | |__| | |_| | | | |_| |_| | | | | | | |  __/ |_| | | | (_) | (_| \__ \
//   \____/ \__|_|_|_|\__|\__, | |_| |_| |_|\___|\__|_| |_|\___/ \__,_|___/
//                         __/ |                                           
//                        |___/                                            
/////////////////////////////////////////////////////////////////////////////////  
            
            divYou : function() {
                
                var color = this.players[this.player_id].color;
                var color_bg = "";
                var you = "<span style=\"font-weight:bold;color:#" + color + ";" + color_bg + "\">" + _("You") + "</span>";
                return you;
            },
        
            divActPlayer : function() {        	
                var color = this.players[this.getCurrentPlayerId()].color;
                var name = this.players[this.getCurrentPlayerId()].name;
                var color_bg = "";
                var you = "<span style=\"font-weight:bold;color:#" + color + ";" + color_bg + "\">" + name + "</span>";
                return you;
            },
        
            format_string_recursive : function(log, args) {
                try {
                    if (log && args && !args.processed) {
                        args.processed = true;
        
                        
                    }
                } catch (e) {
                    console.error(log,args,"Exception thrown", e.stack);
                }
                return this.inherited(arguments);
            },

            attachToNewParentNoDestroy: function (mobile_in, new_parent_in, relation, place_position) 
            {
        
                const mobile = $(mobile_in);
                const new_parent = $(new_parent_in);

                var src = dojo.position(mobile);
                if (place_position)
                    mobile.style.position = place_position;
                dojo.place(mobile, new_parent, relation);
                mobile.offsetTop;//force re-flow
                var tgt = dojo.position(mobile);
                var box = dojo.marginBox(mobile);
                var cbox = dojo.contentBox(mobile);
                var left = box.l + src.x - tgt.x;
                var top = box.t + src.y - tgt.y;

                mobile.style.position = "absolute";
                mobile.style.left = left + "px";
                mobile.style.top = top + "px";
                box.l += box.w - cbox.w;
                box.t += box.h - cbox.h;
                mobile.offsetTop;//force re-flow
                return box;
            },

            addTokenJour: function( jour, couleur, id)
            {   
                
                dojo.place( this.format_block( 'jstpl_tokenjour', {
                x: (couleur-1)*(-100),
                jour: jour,
                                        
                } ) , 'tokenjourposition_'+jour+'_'+id );

            },

            addTurn: function( turn)
            {   
                if(turn <=13)
                {
                dojo.place( this.format_block( 'jstpl_turn', {
                    
                                        
                } ) , 'turnboard_marqueur_'+turn );
                }

            },

            addHappy: function(smile, happy, angry, player, color)
            {   
                
                dojo.place( this.format_block( 'jstpl_smile', {
                   id: player,
                   color: color, 
                                        
                } ) , 'smileposition_'+smile+'_'+player );

                dojo.place( this.format_block( 'jstpl_happy', {
                    id: player, 
                                         
                 } ) , 'happyposition_'+happy+'_'+player );

                 dojo.place( this.format_block( 'jstpl_angry', {
                    id: player, 
                                         
                 } ) , 'angryposition_'+angry+'_'+player );

            },


            addCardTokyoHand: function( id, card, ville, location, player )  
            {
                if ((player == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1))
                {

                    if((card>=1)&&(card <= 10))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-1)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-1)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);

                    }
                    
                    if((card >=11)&&(card <=20))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-11)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-11)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=21)&&(card <=30))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-21)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-21)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=31)&&(card <=40))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-31)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-31)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=41)&&(card <=50))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-41)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-41)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
            
                    if((card >=51)&&(card <=60))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-51)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-51)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=61)&&(card <=70))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-61)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-61)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=71)&&(card <=80))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-71)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-71)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                        
                    
                    dojo.query("#card_"+ville+'_'+id).connect('onclick', this, 'onSelect' );
                    

                    

                    
                }
    

            },


            addCardKyotoHand: function( id, card, ville, location, player )  
            {
                if ((player == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1))
                {
    
                    if((card>=1)&&(card <= 10))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-1)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-1)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
    
                    }
                    
                    if((card >=11)&&(card <=20))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-11)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-11)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
    
                    if((card >=21)&&(card <=30))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-21)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-21)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=31)&&(card <=40))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-31)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-31)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
    
                    if((card >=41)&&(card <=50))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-41)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-41)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
            
                    if((card >=51)&&(card <=60))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-51)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-51)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=61)&&(card <=70))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-61)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-61)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
    
                    if((card >=71)&&(card <=80))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-71)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-71)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                        
                      
    
                    dojo.query("#card_"+ville+'_'+id).connect('onclick', this, 'onSelect' );
                    

                }
        
    
                
    
    

            },

            addCardTokyoTrip: function( id, card, ville, location, player, walk, finallocation=0, finalwalk=0 )  
            {
                if(walk == 0)
                {
                    if((card>=1)&&(card <= 10))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-1)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-1)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);


                    }
                    
                    if((card >=11)&&(card <=20))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-11)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-11)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=21)&&(card <=30))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-21)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-21)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=31)&&(card <=40))
                    {
                        var img = g_gamethemeurl+"img/tokyo1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-31)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo1tool',{x: (card-31)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=41)&&(card <=50))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-41)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-41)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
            
                    if((card >=51)&&(card <=60))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-51)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-51)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=61)&&(card <=70))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-61)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-61)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                   

                    if((card >=71)&&(card <=80))
                    {
                        var img = g_gamethemeurl+"img/tokyo2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-71)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyo2tool',{x: (card-71)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=72)&&(card <=80)&&(finallocation ==1))
                    {
                        
                        dojo.place( this.format_block( 'jstpl_finaltokyo', {
                            
                                                
                        } ) , 'card_1_'+id );

                    }

                    if((card >=72)&&(card <=80)&&(finallocation ==2))
                        {
                            
                            dojo.place( this.format_block( 'jstpl_finalkyoto', {
                                
                                                    
                            } ) , 'card_1_'+id );
    
                        }

                    if(finalwalk ==1)
                        {
                            
                            dojo.place( this.format_block( 'jstpl_finalwalk', {
                                
                                                    
                            } ) , 'card_1_'+id );
    
                        }
                        
                    

                    //dojo.query("#"+location+'_'+player).removeClass("masque");
                    var element = document.getElementById(location+'_'+player);
                    element.style.zIndex = "10";
                }   


                if(walk == 1)
                {
                    var img = g_gamethemeurl+"img/card_verso.png";
                        dojo.place( this.format_block( 'jstpl_cardverso', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: -100,
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var element = document.getElementById(location+'_'+player);
                        element.style.zIndex = "10";

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_tokyowalktool')+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);

                }
                    
                
    

            },


            addCardKyotoTrip: function( id, card, ville, location, player, walk, finallocation=0, finalwalk=0 )  
            {
                if(walk == 0)
                    {
    
                    if((card>=1)&&(card <= 10))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-1)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-1)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
    
                    }
                    
                    if((card >=11)&&(card <=20))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-11)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-11)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
    
                    if((card >=21)&&(card <=30))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-21)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-21)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=31)&&(card <=40))
                    {
                        var img = g_gamethemeurl+"img/kyoto1.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-31)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto1tool',{x: (card-31)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
    
                    if((card >=41)&&(card <=50))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-41)*(-100),
                            y: 0,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-41)*(-100), y: 0})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
            
                    if((card >=51)&&(card <=60))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-51)*(-100),
                            y: -100,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-51)*(-100), y: -100})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
                    
                    if((card >=61)&&(card <=70))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-61)*(-100),
                            y: -200,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-61)*(-100), y: -200})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }
    
                    if((card >=71)&&(card <=80))
                    {
                        var img = g_gamethemeurl+"img/kyoto2.jpg";
                        dojo.place( this.format_block( 'jstpl_card', {
                            id: id,
                            player_id: player,
                            imgfull: img,
                            x: (card-71)*(-100),
                            y: -300,
                            ville: ville,
                                                
                        } ) , location+'_'+player );

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyoto2tool',{x: (card-71)*(-100), y: -300})+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
                        
                    }

                    if((card >=72)&&(card <=80)&&(finallocation ==1))
                        {
                            dojo.place( this.format_block( 'jstpl_finaltokyo', {
                                
                                                    
                            } ) , 'card_2_'+id );
    
                        }

                    if((card >=72)&&(card <=80)&&(finallocation ==2))
                        {
                            dojo.place( this.format_block( 'jstpl_finalkyoto', {
                                
                                                    
                            } ) , 'card_2_'+id );
    
                        }
                            
                    if(finalwalk ==1)
                        {
                            
                            dojo.place( this.format_block( 'jstpl_finalwalk', {
                                
                                                    
                            } ) , 'card_2_'+id );
    
                        }
                        
                      
                    //dojo.query("#"+location+'_'+player).removeClass("masque");
                    var element = document.getElementById(location+'_'+player);
                    element.style.zIndex = "10";


    
                }

                if(walk == 1)
                    {
                        var img = g_gamethemeurl+"img/card_verso.png";
                            dojo.place( this.format_block( 'jstpl_cardverso', {
                                id: id,
                                player_id: player,
                                imgfull: img,
                                x: 0,
                                y: 0,
                                ville: ville,
                                                    
                            } ) , location+'_'+player );
    
                            var element = document.getElementById(location+'_'+player);
                            element.style.zIndex = "10";

                        var html = '<div class="toolt"><div class="cardtoolt">'+this.format_block('jstpl_kyotowalktool')+'</div></div>';
                        this.addTooltipHtml( 'card_'+ville+'_'+id, html,1000);
    
                    }
                        
              
        
    
                
    
    

            },

            addTrain: function(id, ville, train)
            {        	 
                
                dojo.place( this.format_block( 'jstpl_train', {
                    id: train,
                                                            
                } ) , 'card_'+ville+'_'+id);
                
                
                

            },

            addCheck: function(id, ville, check)
            {        	 
                
                dojo.place( this.format_block( 'jstpl_check', {
                    type: check,
                    ville: ville,
                    id: id,
                                                            
                } ) , 'card_'+ville+'_'+id);
                
                
                

            },

            /*addMaskTurn: function()
            {        	 
                
                
            if (this.gamedatas.countplayers[0]>1)
            {
                const element = document.querySelector('.turn_board');
                const element2 = document.querySelector('.playerhandtitle');
                const element3 = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    
                } 

                else 
                {
                    dojo.query(".turn_board").addClass("hidden");
                    
                    element2.style.top = "15px";
                    element3.style.top = "43px";
                    
                        playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 155) + "px";
                      });
                      global.style.height = (currentHeight - 150) + "px";
                }
            }

            if (this.gamedatas.countplayers[0]==1)
            {
                
                const element = document.querySelector('.turn_board');
                const element2 = document.querySelector('.playerhandtitle');
                const element3 = document.querySelector('.playerhand');
                const element4 = document.querySelector('.playerview_agent');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                                        
                } 

                else 
                {
                    dojo.query(".turn_board").addClass("hidden");
                    
                    element2.style.top = "15px";
                    element3.style.top = "43px";
                    
                        playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 155) + "px";
                        });
                        global.style.height = (currentHeight - 150) + "px";

                        var currentTopsolo = element4.offsetTop;
                        element4.style.top = (currentTopsolo -155) + "px";
                }

            }
   

            },

            
            addMaskHand: function()
            {        	 
                
            if (this.gamedatas.countplayers[0]>1)
            {
                const element = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    
                } 
                
                else 
                {
                    dojo.query(".playerhand").addClass("hidden");
                    dojo.query(".playerhandtitle").addClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 320) + "px";
                      });
                      global.style.height = (currentHeight - 300) + "px";
                }
            }

            if (this.gamedatas.countplayers[0]==1)
                {
                const element = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                const element4 = document.querySelector('.playerview_agent');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    
                } 
                
                else 
                {
                    dojo.query(".playerhand").addClass("hidden");
                    dojo.query(".playerhandtitle").addClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 320) + "px";
                        });
                        global.style.height = (currentHeight - 300) + "px";

                        var currentTopsolo = element4.offsetTop;
                      element4.style.top = (currentTopsolo -320) + "px";
                }
                }

                
                

            },*/

            addMask: function()
            {        	 
                
            if (this.gamedatas.countplayers[0]>1)
            {
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                
                
                dojo.query(".turn_board").addClass("hidden");
                dojo.query(".playerhand").addClass("hidden");
                dojo.query(".playerhandtitle").addClass("hidden");

                    playerviews.forEach(function(playerview) {
                       
                        
                        playerview.style.top = "2px";
                      });
                      global.style.height = "1020px";
                
            }

            if (this.gamedatas.countplayers[0]==1)
                {

                    var playerviews = document.querySelectorAll('.playerview');
                    var global = document.getElementById("global");
                    var element4 = document.querySelector('.playerview_agent');

                    element4.style.top = "850px";
                    
                    
                    dojo.query(".turn_board").addClass("hidden");
                    dojo.query(".playerhand").addClass("hidden");
                    dojo.query(".playerhandtitle").addClass("hidden");

                    playerviews.forEach(function(playerview) {
                       
                        
                        playerview.style.top = "2px";
                      });
                      global.style.height = "1650px";
                
                
                }

                
                

            },

            /*addSolo: function()
            {     
                
                var agent = document.querySelector('.playerview_agent');
                var global = document.getElementById("global"); 

                var currentglobal = global.clientHeight;
                var currentagent = agent.offsetTop;

                agent.style.top = (currentagent -160) + "px";
                global.style.height = (currentglobal - 150) + "px";
               

            },*/

            addMarqueur: function(r, g, p, y, b, id)
            {        	 
                if(r<12)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'r',
                        x: 0,
                                                                
                    } ) , 'marqueurposition_'+r+'_1_'+id);
                }

                if((r>=12)&&(r<=24))
                {

                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'r',
                        x: 0,
                                                                
                    } ) , 'marqueurposition_'+(r-12)+'_1_'+id);

                    $('marqueur_r_'+id).innerHTML = '+12';
                }

                if (r>24)
                {

                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'r',
                        x: 0,
                                                                
                    } ) , 'marqueurposition_12_1_'+id);

                    $('marqueur_r_'+id).innerHTML = '+12';
                }


                if(g<12)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'g',
                        x: -100,
                                                                
                    } ) , 'marqueurposition_'+g+'_2_'+id);
                }

                if((g>=12)&&(g<=24))
                {    
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'g',
                        x: -100,
                                                                
                    } ) , 'marqueurposition_'+(g-12)+'_2_'+id);
                    $('marqueur_g_'+id).innerHTML = '+12';
                }

                if (g>24)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'g',
                        x: -100,
                                                                
                    } ) , 'marqueurposition_12_2_'+id);
                    $('marqueur_g_'+id).innerHTML = '+12';
                }



                if(p<12)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'p',
                        x: -200,
                                                                
                    } ) , 'marqueurposition_'+p+'_3_'+id);
                }

                if((p>=12)&&(p<=24))
                {  
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'p',
                        x: -200,
                                                                
                    } ) , 'marqueurposition_'+(p-12)+'_3_'+id);
                    $('marqueur_p_'+id).innerHTML = '+12';
                }

                if (p>24)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'p',
                        x: -200,
                                                                
                    } ) , 'marqueurposition_12_3_'+id);
                    $('marqueur_p_'+id).innerHTML = '+12';
                }


                
                if(y<12)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'y',
                        x: -300,
                                                                
                    } ) , 'marqueurposition_'+y+'_4_'+id);
                }

                if((y>=12)&&(y<=24))
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'y',
                        x: -300,
                                                                
                    } ) , 'marqueurposition_'+(y-12)+'_4_'+id);

                    $('marqueur_y_'+id).innerHTML = '+12';
                }
                if (y>24)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'y',
                        x: -300,
                                                                
                    } ) , 'marqueurposition_12_4_'+id);

                    $('marqueur_y_'+id).innerHTML = '+12';

                }

                if(b<12)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'b',
                        x: -400,
                                                                
                    } ) , 'marqueurposition_'+b+'_5_'+id);
                }

                if((b>=12)&&(b<=24))
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'b',
                        x: -400,
                                                                
                    } ) , 'marqueurposition_'+(b-12)+'_5_'+id);
                    $('marqueur_b_'+id).innerHTML = '+12';
                }

                if (y>24)
                {
                    dojo.place( this.format_block( 'jstpl_marqueur', {
                        id: id,
                        type: 'b',
                        x: -400,
                                                                
                    } ) , 'marqueurposition_12_5_'+id);
                    $('marqueur_b_'+id).innerHTML = '+12';
                }
            },
    
    
/////////////////////////////////////////////////////////////////////////////////  
//         _____  _                       _                  _   _             
//        |  __ \| |                     ( )                | | (_)            
//        | |__) | | __ _ _   _  ___ _ __|/ ___    __ _  ___| |_ _  ___  _ __  
//        |  ___/| |/ _` | | | |/ _ \ '__| / __|  / _` |/ __| __| |/ _ \| '_ \ 
//        | |    | | (_| | |_| |  __/ |    \__ \ | (_| | (__| |_| | (_) | | | |
//        |_|    |_|\__,_|\__, |\___|_|    |___/  \__,_|\___|\__|_|\___/|_| |_|
//                         __/ |                                               
//                        |___/                                                
/////////////////////////////////////////////////////////////////////////////////  

                       
           
            onSelect: function(evt)
            {        	 
                // Preventing default browser reaction
                 dojo.stopEvent( evt );
    
                 

                if( this.isSpectator || (!(evt.currentTarget.classList.contains('selectable')) && !(evt.currentTarget.classList.contains('selectableswitch')) && !(evt.currentTarget.classList.contains('selectable2')) ))
                {   
                    
                    return; 
                }
                
                if(!this.isSpectator && (evt.currentTarget.classList.contains('selectable') || evt.currentTarget.classList.contains('selectable2') || evt.currentTarget.classList.contains('selectableswitch')) && this.checkAction( "actSelect" ))
                {
                    if(this.isCurrentPlayerActive())
                    {
                    var elements = document.querySelectorAll('[id^="playerview"]:not(.masque)');
                            var idsSansMasque = [];
                            elements.forEach(function(element) {
                                // Obtenez l'ID de chaque élément
                                var id = element.id;
                                
                                // Ajoutez l'ID à la liste
                                idsSansMasque.push(id);
                            });

                            dojo.query("#"+idsSansMasque[0]).addClass("masque");
                            dojo.query("#playerview_"+this.getCurrentPlayerId()).removeClass("masque");
                    }


                    
                    this.ajaxcall( "/letsgotojapan/letsgotojapan/actSelect.html", { 
                        lock: true,
                        arg1: evt.currentTarget.id
                        
                     }, 
                     this, function( result ) {}, function( is_error) {} );
                }

                   
                
    
    
            },
    
            onOpButton: function(evt)
            {
                if(this.isCurrentPlayerActive())
                    {
                    var elements = document.querySelectorAll('[id^="playerview"]:not(.masque)');
                            var idsSansMasque = [];
                            elements.forEach(function(element) {
                                // Obtenez l'ID de chaque élément
                                var id = element.id;
                                
                                // Ajoutez l'ID à la liste
                                idsSansMasque.push(id);
                            });

                            dojo.query("#"+idsSansMasque[0]).addClass("masque");
                            dojo.query("#playerview_"+this.getCurrentPlayerId()).removeClass("masque");
                        }
                
                        
                this.ajaxcall( "/letsgotojapan/letsgotojapan/actButton.html", { 
                    lock: true,
                    arg1: evt.currentTarget.id
                                
                    }, 
                    this, function( result ) {}, function( is_error) {} );
    
            },

            onNext: function(evt)
            {        	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

                var elements = document.querySelectorAll('[id^="playerview"]:not(.masque)');
                var idsSansMasque = [];
                elements.forEach(function(element) {
                    // Obtenez l'ID de chaque élément
                    var id = element.id;
                    
                    // Ajoutez l'ID à la liste
                    idsSansMasque.push(id);
                });

                var elementall = document.querySelectorAll('[id^="playerview"]');
                var idsAll = [];
                // Parcourez les éléments et affichez leur ID
                elementall.forEach(function(element) {
                    var id = element.id;
                    idsAll.push(id);
                });

                
                var variable = idsSansMasque[0];
                var index = idsAll.indexOf(variable);
                               
                if(index != (this.gamedatas.countplayers[0]-1))
                {
                    dojo.query("#"+variable).addClass("masque");
                    dojo.query("#"+idsAll[index+1]).removeClass("masque");

                }

                if(index == (this.gamedatas.countplayers[0]-1))
                {
                    dojo.query("#"+variable).addClass("masque");
                    dojo.query("#"+idsAll[0]).removeClass("masque");

                }
    

                
                

            },

            onPrev: function(evt)
            {        	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

                var elements = document.querySelectorAll('[id^="playerview"]:not(.masque)');
                var idsSansMasque = [];
                elements.forEach(function(element) {
                    // Obtenez l'ID de chaque élément
                    var id = element.id;
                    
                    // Ajoutez l'ID à la liste
                    idsSansMasque.push(id);
                });

                var elementall = document.querySelectorAll('[id^="playerview"]');
                var idsAll = [];
                // Parcourez les éléments et affichez leur ID
                elementall.forEach(function(element) {
                    var id = element.id;
                    idsAll.push(id);
                });

                
                var variable = idsSansMasque[0];
                var index = idsAll.indexOf(variable);
                

               
                if(index != 0)
                {
                    dojo.query("#"+variable).addClass("masque");
                    dojo.query("#"+idsAll[index-1]).removeClass("masque");

                }

                if(index == 0)
                {
                    dojo.query("#"+variable).addClass("masque");
                    dojo.query("#"+idsAll[this.gamedatas.countplayers[0]-1]).removeClass("masque");

                }
    

            },

            onEye: function(evt)
            {        	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

                var selection = evt.currentTarget.id;
                var nombre = selection.match(/\d+/);

                var elements = document.querySelectorAll('[id^="playerview"]:not(.masque)');
                var idsSansMasque = [];
                elements.forEach(function(element) {
                        // Obtenez l'ID de chaque élément
                        var id = element.id;
                        
                        // Ajoutez l'ID à la liste
                        idsSansMasque.push(id);
                });

                    dojo.query("#"+idsSansMasque[0]).addClass("masque");
                    dojo.query("#playerview_"+nombre[0]).removeClass("masque");

                
                

            },

            /*onMaskTurn: function(evt)
            {  
                // Preventing default browser reaction
                dojo.stopEvent( evt );


                if (this.gamedatas.countplayers[0]>1)
                {
                
                const element = document.querySelector('.turn_board');
                const element2 = document.querySelector('.playerhandtitle');
                const element3 = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    dojo.query(".turn_board").removeClass("hidden");

                    element2.style.top = "162px";
                    element3.style.top = "190px";


                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop + 135) + "px";
                      });
                      global.style.height = (currentHeight + 150) + "px";
                    
                } 

                else 
                {
                    dojo.query(".turn_board").addClass("hidden");
                    
                    element2.style.top = "15px";
                    element3.style.top = "43px";
                    
                        playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 155) + "px";
                      });
                      global.style.height = (currentHeight - 150) + "px";
                }
            }

            if (this.gamedatas.countplayers[0]==1)
                {
                
                const element = document.querySelector('.turn_board');
                const element2 = document.querySelector('.playerhandtitle');
                const element3 = document.querySelector('.playerhand');
                const element4 = document.querySelector('.playerview_agent');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    dojo.query(".turn_board").removeClass("hidden");

                    element2.style.top = "162px";
                    element3.style.top = "190px";


                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop + 135) + "px";
                      });
                      global.style.height = (currentHeight + 150) + "px";

                      var currentTopsolo = element4.offsetTop;
                      element4.style.top = (currentTopsolo +135) + "px";
                    
                } 

                else 
                {
                    dojo.query(".turn_board").addClass("hidden");
                    
                    element2.style.top = "15px";
                    element3.style.top = "43px";
                    
                        playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 155) + "px";
                      });
                      global.style.height = (currentHeight - 150) + "px";

                      var currentTopsolo = element4.offsetTop;
                      element4.style.top = (currentTopsolo -155) + "px";
                }
            }

   

            },

            onMaskHand: function(evt)
            {   
                     	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

                if (this.gamedatas.countplayers[0]>1)
                {
                const element = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    dojo.query(".playerhand").removeClass("hidden");
                    dojo.query(".playerhandtitle").removeClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop + 300) + "px";
                      });
                      global.style.height = (currentHeight + 300) + "px";
                } 
                
                else 
                {
                    dojo.query(".playerhand").addClass("hidden");
                    dojo.query(".playerhandtitle").addClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 320) + "px";
                      });
                      global.style.height = (currentHeight - 300) + "px";
                }
                }

                if (this.gamedatas.countplayers[0]==1)
                {
                const element = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                const element4 = document.querySelector('.playerview_agent');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    dojo.query(".playerhand").removeClass("hidden");
                    dojo.query(".playerhandtitle").removeClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop + 300) + "px";
                        });
                        global.style.height = (currentHeight + 300) + "px";

                        var currentTopsolo = element4.offsetTop;
                        element4.style.top = (currentTopsolo +300) + "px";
                } 
                
                else 
                {
                    dojo.query(".playerhand").addClass("hidden");
                    dojo.query(".playerhandtitle").addClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 320) + "px";
                        });
                        global.style.height = (currentHeight - 300) + "px";

                        var currentTopsolo = element4.offsetTop;
                      element4.style.top = (currentTopsolo -320) + "px";
                }
                }
                
                

            },*/

            onMaskTurn: function(evt)
            {  
                // Preventing default browser reaction
                dojo.stopEvent( evt );


                if (this.gamedatas.countplayers[0]>1)
                {
                
                const element = document.querySelector('.turn_board');
                const element2 = document.querySelector('.playerhandtitle');
                const element3 = document.querySelector('.playerhand');
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var currentHeight = global.clientHeight;
                
                if (element && element.classList.contains('hidden')) 
                {
                    dojo.query(".turn_board").removeClass("hidden");

                    if (element3 && !element3.classList.contains('switch')) 
                    {
                    element2.style.top = "162px";
                    element3.style.top = "190px";


                    playerviews.forEach(function(playerview) {
                        
                        
                        playerview.style.top ="460px";
                      });
                      global.style.height = (currentHeight + 150) + "px";
                    }
                    else
                    {

                        element2.style.top = "1170px";
                        element3.style.top = "1200px";
                    
                        playerviews.forEach(function(playerview) {
                        
                        
                        playerview.style.top ="152px";
                      });
                      global.style.height = (currentHeight + 150) + "px";

                    }
                    
                } 

                else 
                {
                    dojo.query(".turn_board").addClass("hidden");

                    if (element3 && !element3.classList.contains('switch')) 
                    {
                    
                    element2.style.top = "12px";
                    element3.style.top = "40px";
                    
                    
                        playerviews.forEach(function(playerview) {
                        
                        
                        playerview.style.top ="310px";
                      });
                      global.style.height = (currentHeight - 150) + "px";
                    }
                    else
                    {

                        element2.style.top = "1020px";
                        element3.style.top = "1050px";
                    
                        playerviews.forEach(function(playerview) {
                        
                        
                        playerview.style.top ="2px";
                      });
                      global.style.height = (currentHeight - 150) + "px";

                    }
                }
            }

            if (this.gamedatas.countplayers[0]==1)
                {
                
                    const element = document.querySelector('.turn_board');
                    const element2 = document.querySelector('.playerhandtitle');
                    const element3 = document.querySelector('.playerhand');
                    const element4 = document.querySelector('.playerview_agent');
                    var playerviews = document.querySelectorAll('.playerview');
                    var global = document.getElementById("global");
                    var currentHeight = global.clientHeight;
                    
                    if (element && element.classList.contains('hidden')) 
                    {
                        dojo.query(".turn_board").removeClass("hidden");
    
                        if (element3 && !element3.classList.contains('switch')) 
                        {
                        element2.style.top = "162px";
                        element3.style.top = "190px";
                        element4.style.top = "1470px";
    
    
                        playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="460px";
                          });
                          global.style.height = (currentHeight + 150) + "px";
                        }
                        else
                        {
    
                            element2.style.top = "1170px";
                            element3.style.top = "1200px";
                            element4.style.top = "1470px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="152px";
                          });
                          global.style.height = (currentHeight + 150) + "px";
    
                        }
                        
                    } 
    
                    else 
                    {
                        dojo.query(".turn_board").addClass("hidden");
    
                        if (element3 && !element3.classList.contains('switch')) 
                        {
                        
                        element2.style.top = "12px";
                        element3.style.top = "40px";
                        element4.style.top = "1320px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="310px";
                          });
                          global.style.height = (currentHeight - 150) + "px";
                        }
                        else
                        {
    
                            element2.style.top = "1020px";
                            element3.style.top = "1050px";
                            element4.style.top = "1320px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="2px";
                          });
                          global.style.height = (currentHeight - 150) + "px";
    
                        }
                    }
            }

   

            },

            onMaskHand: function(evt)
            {   
                     	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

                if (this.gamedatas.countplayers[0]>1)
                {
                    const element = document.querySelector('.turn_board');
                    const element2 = document.querySelector('.playerhandtitle');
                    const element3 = document.querySelector('.playerhand');
                    var playerviews = document.querySelectorAll('.playerview');
                    
                    
                    
                    if (element3 && element3.classList.contains('switch')) 
                    {
                        if (element && !element.classList.contains('hidden'))
                        {
                        dojo.query(".playerhand").removeClass("switch");
    
                        element2.style.top = "162px";
                        element3.style.top = "190px";
    
    
                        playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="460px";
                          });
                          
                        }
                        else
                        {

                            dojo.query(".playerhand").removeClass("switch");
    
                            element2.style.top = "12px";
                            element3.style.top = "40px";
        
        
                            playerviews.forEach(function(playerview) {
                                
                                
                                playerview.style.top ="310px";
                            });
                            

                                

                            }
                        
                    } 
    
                    else 
                    {
                        if (element && !element.classList.contains('hidden'))
                        {
                        dojo.query(".playerhand").addClass("switch");
                        
                        element2.style.top = "1170px";
                        element3.style.top = "1200px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="152px";
                          });
                          
                        }
                        else
                        {

                            dojo.query(".playerhand").addClass("switch");
                        
                            element2.style.top = "1020px";
                            element3.style.top = "1050px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="2px";
                          });
                          

                        }
                    }
                }

                if (this.gamedatas.countplayers[0]==1)
                {
                    
                    const element = document.querySelector('.turn_board');
                    const element2 = document.querySelector('.playerhandtitle');
                    const element3 = document.querySelector('.playerhand');
                    const element4 = document.querySelector('.playerview_agent');
                    var playerviews = document.querySelectorAll('.playerview');
                    
                    
                    
                    if (element3 && element3.classList.contains('switch')) 
                    {
                        if (element && !element.classList.contains('hidden'))
                        {
                        dojo.query(".playerhand").removeClass("switch");
    
                        element2.style.top = "162px";
                        element3.style.top = "190px";
    
    
                        playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="460px";
                          });
                          
                        }
                        else
                        {

                            dojo.query(".playerhand").removeClass("switch");
    
                            element2.style.top = "12px";
                            element3.style.top = "40px";
        
        
                            playerviews.forEach(function(playerview) {
                                
                                
                                playerview.style.top ="310px";
                            });
                            

                                

                            }
                        
                    } 
    
                    else 
                    {
                        if (element && !element.classList.contains('hidden'))
                        {
                        dojo.query(".playerhand").addClass("switch");
                        
                        element2.style.top = "1170px";
                        element3.style.top = "1200px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="152px";
                          });
                          
                        }
                        else
                        {

                            dojo.query(".playerhand").addClass("switch");
                        
                            element2.style.top = "1020px";
                            element3.style.top = "1050px";
                        
                            playerviews.forEach(function(playerview) {
                            
                            
                            playerview.style.top ="2px";
                          });
                          

                        }
                    }

                }
                
                

            },
            
            onOpValidate3Discard: function(evt)
            {

                dojo.stopEvent( evt );

                // Sélectionnez tous les éléments avec la classe spécifiée
                const elementsAvecClasse = document.querySelectorAll(".selectable2");

                // Convertissez la NodeList en un tableau et extrayez les IDs
                const ids = Array.from(elementsAvecClasse, element => element.id);

                                        
                this.ajaxcall( "/letsgotojapan/letsgotojapan/actValidate3Discard.html", { 
                        lock: true,
                        arg1: ids[0],
                        arg2: ids[1],
                        arg3: ids[2]
                                    
                        }, 
                this, function( result ) {}, function( is_error) {} );

            },

            onMaskScore: function(evt)
            {        	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );
                
                if(this.gamedatas.countplayers >= 2)
                {
                var playerviews = document.querySelectorAll('.playerview');
                var global = document.getElementById("global");
                var scorepad = document.getElementById("scorepad");
                var currentHeight = global.clientHeight;
                
                if (scorepad && scorepad.classList.contains('hidden')) 
                {
                    dojo.query("#scorepad").removeClass("hidden");
                    
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop + 467) + "px";
                      });
                      global.style.height = (currentHeight + 467) + "px";
                } 
                
                else 
                {
                    dojo.query("#scorepad").addClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 487) + "px";
                      });
                      global.style.height = (currentHeight - 467) + "px";
                }
                }


                if(this.gamedatas.countplayers == 1)
                    {
                    var playerview = document.querySelector('.playerview');
                    var agent = document.querySelector('.playerview_agent');
                    var global = document.getElementById('global');
                    var scorepad = document.getElementById("scorepad");
                    
                    if (scorepad && scorepad.classList.contains('hidden')) 
                    {
                        dojo.query("#scorepad").removeClass("hidden");
                        playerview.style.top = "525px"; 
                        agent.style.top = "1380px"; 
                        global.style.height = "2180px"; 
                    } 
                    
                    else 
                    {
                        dojo.query("#scorepad").addClass("hidden");
                        playerview.style.top = "45px"; 
                        agent.style.top = "900px"; 
                        global.style.height = "1700px"; 

                    }
                    }

                
                

            },
    
            
///////////////////////////////////////////////////////////////////////////////// 
//       _   _       _   _  __ _           _   _                 
//      | \ | |     | | (_)/ _(_)         | | (_)                
//      |  \| | ___ | |_ _| |_ _  ___ __ _| |_ _  ___  _ __  ___ 
//      | . ` |/ _ \| __| |  _| |/ __/ _` | __| |/ _ \| '_ \/ __|
//      | |\  | (_) | |_| | | | | (_| (_| | |_| | (_) | | | \__ \
//      |_| \_|\___/ \__|_|_| |_|\___\__,_|\__|_|\___/|_| |_|___/
//                                                                 
/////////////////////////////////////////////////////////////////////////////////  
    
            setupNotifications: function()
            {
                console.log( 'notifications subscriptions setup' );
                
                // TODO: here, associate your game notifications with local methods
                
                // Example 1: standard notification handling
                // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
                
                // Example 2: standard notification handling + tell the user interface to wait
                //            during 3 seconds after calling the method in order to let the players
                //            see what is happening in the game.
                // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
                // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
                // 
                dojo.subscribe( 'movecard', this, "notif_movecard" );
                dojo.subscribe( 'passcard', this, "notif_passcard" );
                dojo.subscribe( 'drawcard', this, "notif_drawcard" );
                dojo.subscribe( 'turn', this, "notif_turn" );
                dojo.subscribe( 'deployer', this, "notif_deployer" );
                dojo.subscribe( 'deployerextrawalk', this, "notif_deployerextrawalk" );
                dojo.subscribe( 'condensersansmodif', this, "notif_condensersansmodif" );
                dojo.subscribe( 'condenseravecmodif', this, "notif_condenseravecmodif" );
                dojo.subscribe( 'condenserextrawalkavecmodif', this, "notif_condenserextrawalkavecmodif" );
                dojo.subscribe( 'smile', this, "notif_smile" );
                dojo.subscribe( 'happy', this, "notif_happy" );
                dojo.subscribe( 'angry', this, "notif_angry" );
                dojo.subscribe( 'majpannel', this, "notif_majpannel" );
                dojo.subscribe( 'majcompteurdiscard', this, "notif_majcompteurdiscard" );
                dojo.subscribe( 'discard', this, "notif_discard" );
                dojo.subscribe( 'addwalk', this, "notif_addwalk" );
                dojo.subscribe( 'masque', this, "notif_masque" );
                dojo.subscribe( 'masquesolo', this, "notif_masquesolo" );
                dojo.subscribe( 'finallocation', this, "notif_finallocation" );
                dojo.subscribe( 'changecard', this, "notif_changecard" );
                dojo.subscribe( 'finalwalk', this, "notif_finalwalk" );
                dojo.subscribe( 'train', this, "notif_train" );
                dojo.subscribe( 'movetoken', this, "notif_movetoken" );
                dojo.subscribe( 'scorepad', this, "notif_scorepad" );
                dojo.subscribe( 'score', this, "notif_score" );
                dojo.subscribe( 'score2', this, "notif_score2" );
                dojo.subscribe( 'disabled', this, "notif_disabled" );
                dojo.subscribe( 'check', this, "notif_check" );
                dojo.subscribe( 'checkscore', this, "notif_checkscore" );
                dojo.subscribe( 'affichehand', this, "notif_affichehand" );
                dojo.subscribe( 'score2solo', this, "notif_score2solo" );
                dojo.subscribe( 'score2agent', this, "notif_score2agent" );
                dojo.subscribe( 'infolvl', this, "notif_infolvl" );

                


                
                this.notifqueue.setSynchronous( 'smile');
                this.notifqueue.setSynchronous( 'happy');
                this.notifqueue.setSynchronous( 'angry');
                this.notifqueue.setSynchronous( 'movetoken');
                this.notifqueue.setSynchronous( 'movecard');
                
            

                
                
            },  

            notif_masque: function( notif )
            {
                if(!this.isSpectator)
                { 
                    this.addMask();

                    dojo.query("#mask_turn").addClass("masque");
                    dojo.query("#mask_hand").addClass("masque");
                }

                if(this.isSpectator)
                    { 
                        dojo.query(".turn_board").addClass("hidden");

                        var elements = document.querySelectorAll("[id^='playerview']");
                        elements.forEach(function(element) {
                            element.style.top = "5px"; 
                            });

                        var global = document.getElementById('global');
                        global.style.height = "1020px"; 
                    }


            },

            notif_masquesolo: function( notif )
            {
                
                    this.addMask();
                    

                    dojo.query("#mask_turn").addClass("masque");
                    dojo.query("#mask_hand").addClass("masque");
                

                


            },

            notif_affichehand: function( notif )  ////je ne l'utilise plus
            {
                if(!this.isSpectator)
                { 
                    const element = document.querySelector('.playerhand');
                    
                
                    if (element && element.classList.contains('hidden')) 
                    {
                        if (this.gamedatas.countplayers[0]>1)
                        {
                            var playerviews = document.querySelectorAll('.playerview');
                            var global = document.getElementById("global");
                            var currentHeight = global.clientHeight;

                        dojo.query(".playerhand").removeClass("hidden");
                        dojo.query(".playerhandtitle").removeClass("hidden");
                        playerviews.forEach(function(playerview) {
                            var currentTop = playerview.offsetTop;
                            
                            playerview.style.top = (currentTop + 300) + "px";
                        });
                        global.style.height = (currentHeight + 300) + "px";
                        }

                        if (this.gamedatas.countplayers[0] == 1)
                        {
                            var playerviews = document.querySelectorAll('.playerview');
                            const element4 = document.querySelector('.playerview_agent');
                            var global = document.getElementById("global");
                            var currentHeight = global.clientHeight;

                            dojo.query(".playerhand").removeClass("hidden");
                            dojo.query(".playerhandtitle").removeClass("hidden");
                            playerviews.forEach(function(playerview) {
                            var currentTop = playerview.offsetTop;
                        
                            playerview.style.top = (currentTop + 300) + "px";
                            });
                            global.style.height = (currentHeight + 300) + "px";

                            var currentTopsolo = element4.offsetTop;
                            element4.style.top = (currentTopsolo +300) + "px";
                        
                        }


                    } 
                    
                }

               
            },

            notif_majpannel: function( notif )
            {
                $('nbrerecherche_'+notif.args.id).innerHTML = notif.args.recherche;
                $('nbretrain_'+notif.args.id).innerHTML = notif.args.train;
                $('nbretrainstart_'+notif.args.id).innerHTML = notif.args.trainstart;
                $('nbrewild_'+notif.args.id).innerHTML = notif.args.wild;

            },

            notif_majcompteurdiscard: function( notif )
            {
                $('compteurcardtokyodiscard_'+notif.args.playerid).innerHTML = notif.args.count1;
                $('compteurcardkyotodiscard_'+notif.args.playerid).innerHTML = notif.args.count2;
            },

            
            
            notif_movecard: function( notif )
            {
                if ((notif.args.playerid == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                    {
                        this.notifqueue.setSynchronousDuration(500);
                    }
    
                if ((notif.args.playerid != this.getCurrentPlayerId())&&(this.gamedatas.countplayers >= 2)) 
                    {
                        this.notifqueue.setSynchronousDuration(0);
                    }

                const agent = notif.args.parent.split("_");    


                if ((notif.args.playerid == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1))
                {
                    this.attachToNewParentNoDestroy( notif.args.mobile, notif.args.parent );
                    this.slideToObject( notif.args.mobile, notif.args.parent ).play();

                                        
                }

                  

                if ((notif.args.playerid != this.getCurrentPlayerId())&&(this.gamedatas.countplayers >= 2))
                {
                    if(notif.args.ville == 1)
                    {
                    this.addCardTokyoTrip( notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid, 0);
                    }
                    if(notif.args.ville == 2)
                    {
                    this.addCardKyotoTrip( notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid, 0);
                    }
                }


                if (agent[3] != 0)
                { 
                    var element = document.getElementById(notif.args.location+'_'+notif.args.playerid);
                    element.style.zIndex = "10";

                }
                
                if (agent[3] == 0)
                {   
    
                      
                    var element = document.getElementById(notif.args.location+'_0');
                    element.style.zIndex = "10";
                }

            },

            notif_discard: function( notif )
            {
                if ((notif.args.playerid == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                {
                    dojo.destroy(notif.args.carddiscard);
                }

            },

            notif_passcard: function( notif )
            {
                if (notif.args.playerid == this.getCurrentPlayerId()) 
                {
                    dojo.destroy('card_'+notif.args.ville+'_'+notif.args.id);
                }

                if (notif.args.playerid != this.getCurrentPlayerId()) 
                {
                    ////// A FAIRE ///////
                }

            },

            notif_drawcard: function( notif )
            {
                if ((notif.args.playerid == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                {
                    
                    if(notif.args.ville == 1)
                    {
                        this.addCardTokyoHand (notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid );
                        this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.id, 'player_boards' );
                        this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.id, notif.args.location+'_'+notif.args.playerid).play();
                        setTimeout(() => 
                            {
                                            
                                var element= document.getElementById('card_'+notif.args.ville+'_'+notif.args.id);
                                element.style.left = "0px"; 
                            
                            
                            }, "600");
                        
                    }    

                    if(notif.args.ville == 2)
                    {
                        this.addCardKyotoHand (notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid );
                        this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.id, 'player_boards' );
                        this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.id, notif.args.location+'_'+notif.args.playerid).play();
                        setTimeout(() => 
                            {
                                            
                                var element= document.getElementById('card_'+notif.args.ville+'_'+notif.args.id);
                                element.style.left = "0px"; 
                            
                            
                            }, "600");
                        
                        
                    }
                    
                
                    
                }

            },

            notif_addwalk: function( notif )
            {
                if(notif.args.ville==1)
                {
                    this.addCardTokyoTrip( notif.args.cardid, 0, notif.args.ville, notif.args.location, notif.args.playerid, 1, 1 );
                    if (notif.args.playerid == this.getCurrentPlayerId()) 
                    {
                        this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, 'player_boards' );
                        this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, notif.args.location+'_'+notif.args.playerid).play();
                    }
                }
                if(notif.args.ville==2)
                {
                    this.addCardKyotoTrip( notif.args.cardid, 0, notif.args.ville, notif.args.location, notif.args.playerid, 1, 2 );
                    if (notif.args.playerid == this.getCurrentPlayerId()) 
                        {
                            this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, 'player_boards' );
                            this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, notif.args.location+'_'+notif.args.playerid).play();
                        }
                }
            },

            
            notif_turn: function( notif )
            {
                this.attachToNewParentNoDestroy( 'turn', 'turnboard_marqueur_'+notif.args.turn );
                this.slideToObject( 'turn', 'turnboard_marqueur_'+notif.args.turn ).play();
            },

            notif_smile: function( notif )
            {
                if ((notif.args.player == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                    {
                        this.notifqueue.setSynchronousDuration(500);
                    }
    
                if ((notif.args.player != this.getCurrentPlayerId())&&(this.gamedatas.countplayers >= 2)) 
                    {
                        this.notifqueue.setSynchronousDuration(0);
                    }

                this.attachToNewParentNoDestroy( 'smile_'+notif.args.player, 'smileposition_'+notif.args.position+'_'+notif.args.player);
                this.slideToObject( 'smile_'+notif.args.player, 'smileposition_'+notif.args.position+'_'+notif.args.player ).play();
            },

            notif_happy: function( notif )
            {
                if ((notif.args.player == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                    {
                        this.notifqueue.setSynchronousDuration(500);
                    }
    
                if ((notif.args.player != this.getCurrentPlayerId())&&(this.gamedatas.countplayers >= 2)) 
                    {
                        this.notifqueue.setSynchronousDuration(0);
                    }
                this.attachToNewParentNoDestroy( 'happy_'+notif.args.player, 'happyposition_'+notif.args.position+'_'+notif.args.player);
                this.slideToObject( 'happy_'+notif.args.player, 'happyposition_'+notif.args.position+'_'+notif.args.player ).play();
            },

            notif_angry: function( notif )
            {
                if ((notif.args.player == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                    {
                        this.notifqueue.setSynchronousDuration(500);
                    }
    
                if ((notif.args.player != this.getCurrentPlayerId())&&(this.gamedatas.countplayers >= 2)) 
                    {
                        this.notifqueue.setSynchronousDuration(0);
                    }
                this.attachToNewParentNoDestroy( 'angry_'+notif.args.player, 'angryposition_'+notif.args.position+'_'+notif.args.player);
                this.slideToObject( 'angry_'+notif.args.player, 'angryposition_'+notif.args.position+'_'+notif.args.player ).play();
            },

            notif_deployer: function( notif )
            {
                if(this.gamedatas.countplayers == 1)
                {
                    if (notif.args.count == 1)
                    {

                        var agent = document.querySelector('.playerview_agent');
                        
                        var currentTop = agent.offsetTop;
                        
                        if (currentTop != 1368)  // marge de 10 de plus
                        {
                            agent.style.top = "1254px";
                        }

                    }

                    if (notif.args.count == 2)
                        {
    
                            var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1358px";
    
                        }


                }

                
                this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid ).play();
                var element1 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                element1.style.zIndex = "10";


               if (notif.args.count == 2)
                {
                this.attachToNewParentNoDestroy( 'card_'+notif.args.ville2+'_'+notif.args.card2, 'cardposition_'+notif.args.jour+'_4_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville2+'_'+notif.args.card2 , 'cardposition_'+notif.args.jour+'_4_'+notif.args.playerid ).play();
                var element2 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                element2.style.zIndex = "10";

                    
                }
                
               

            },


            notif_deployerextrawalk: function( notif )
            {
                this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid ).play();
                var element1 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                element1.style.zIndex = "10";

                this.attachToNewParentNoDestroy( 'card_'+notif.args.ville2+'_'+notif.args.card2, 'cardposition_'+notif.args.jour+'_4_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville2+'_'+notif.args.card2 , 'cardposition_'+notif.args.jour+'_4_'+notif.args.playerid ).play();
                var element2 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                element2.style.zIndex = "10";

                this.attachToNewParentNoDestroy( 'card_'+notif.args.ville3+'_'+notif.args.card3, 'cardposition_'+notif.args.jour+'_6_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville3+'_'+notif.args.card3 , 'cardposition_'+notif.args.jour+'_6_'+notif.args.playerid ).play();
                var element3 = document.getElementById('cardposition_'+notif.args.jour+'_6_'+notif.args.playerid);
                element3.style.zIndex = "10";


               
               

            },

            notif_condensersansmodif: function( notif )
            {

                

                


                this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid ).play();
                


               if (notif.args.count >= 2)
                {
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville2+'_'+notif.args.card2, 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid );
                this.slideToObject( 'card_'+notif.args.ville2+'_'+notif.args.card2 , 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid ).play();
                    
                }

                if (notif.args.count == 3)
                    {
                        this.attachToNewParentNoDestroy( 'card_'+notif.args.ville3+'_'+notif.args.card3, 'cardposition_'+notif.args.jour+'_3_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville3+'_'+notif.args.card3 , 'cardposition_'+notif.args.jour+'_3_'+notif.args.playerid ).play();
                        
                    }

                if (notif.args.count == 1)
                {
                    var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                    element1.style.zIndex = "10";
                    var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                    element2.style.zIndex = "0";

                }

                if (notif.args.count == 2)
                {
                    var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                    element1.style.zIndex = "10";
                    var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                    element2.style.zIndex = "10";
                    var element3 = document.getElementById('cardposition_'+notif.args.jour+'_3_'+notif.args.playerid);
                    element3.style.zIndex = "0";
                    var element4 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                    element4.style.zIndex = "0";

                }

                if (notif.args.count == 3)
                    {
                        var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                        element1.style.zIndex = "10";
                        var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                        element2.style.zIndex = "10";
                        var element3 = document.getElementById('cardposition_'+notif.args.jour+'_3_'+notif.args.playerid);
                        element3.style.zIndex = "10";
                        var element4 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                        element4.style.zIndex = "0";
                        var element5 = document.getElementById('cardposition_'+notif.args.jour+'_5_'+notif.args.playerid);
                        element5.style.zIndex = "0";
                        var element6 = document.getElementById('cardposition_'+notif.args.jour+'_6_'+notif.args.playerid);
                        element6.style.zIndex = "0";
    
                    }

                    if(this.gamedatas.countplayers == 1)
                        {
                            setTimeout(() => 
                                {
                                
                                
                            if ((notif.args.count == 1)||(notif.args.maxtrip == 1))
                            {
        
                                var agent = document.querySelector('.playerview_agent');
                                agent.style.top = "1150px";
        
                            }
        
                            if ((notif.args.count == 2)||(notif.args.maxtrip == 2))
                                {
            
                                    var agent = document.querySelector('.playerview_agent');
                                    agent.style.top = "1202px";
            
                                }
    
                            if ((notif.args.count == 3)||(notif.args.maxtrip == 3))
                                {
            
                                    var agent = document.querySelector('.playerview_agent');
                                    agent.style.top = "1254px";
            
                                }

                            }, "500");
        
        
                        }
               

            },

            notif_condenseravecmodif: function( notif )
            {
                
                
                if (notif.args.count == 1)
                {
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid ).play();
                                        
                }

               if (notif.args.count == 2)
                {
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid ).play();
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville2+'_'+notif.args.card2, 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville2+'_'+notif.args.card2 , 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid ).play();
                    
                }

                if (notif.args.count == 3)
                {
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid ).play();
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville2+'_'+notif.args.card2, 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville2+'_'+notif.args.card2 , 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid ).play();
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville3+'_'+notif.args.card3, 'cardposition_'+notif.args.jour+'_3_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville3+'_'+notif.args.card3 , 'cardposition_'+notif.args.jour+'_3_'+notif.args.playerid ).play();
                    
                }

                

                if (notif.args.count == 1)
                {
                    var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                    element1.style.zIndex = "10";
                    var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                    element2.style.zIndex = "0";
                    

                }
            
                if (notif.args.count == 2)
                {
                    var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                    element1.style.zIndex = "10";
                    var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                    element2.style.zIndex = "10";
                    var element3 = document.getElementById('cardposition_'+notif.args.jour+'_3_'+notif.args.playerid);
                    element3.style.zIndex = "0";
                    var element4 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                    element4.style.zIndex = "0";

                }

                if (notif.args.count == 3)
                    {
                        var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                        element1.style.zIndex = "10";
                        var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                        element2.style.zIndex = "10";
                        var element3 = document.getElementById('cardposition_'+notif.args.jour+'_3_'+notif.args.playerid);
                        element3.style.zIndex = "10";
                        var element4 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                        element4.style.zIndex = "0";
                        var element5 = document.getElementById('cardposition_'+notif.args.jour+'_5_'+notif.args.playerid);
                        element5.style.zIndex = "0";
                        var element6 = document.getElementById('cardposition_'+notif.args.jour+'_6_'+notif.args.playerid);
                        element6.style.zIndex = "0";
    
                    }

                    if(this.gamedatas.countplayers == 1)
                        {
                           



                                
                            if (((notif.args.count == 1)||(notif.args.count0 == 1))&&(notif.args.maxtrip == 1))
                            {
                                
        
                                var agent = document.querySelector('.playerview_agent');
                                agent.style.top = "1150px";
        
                            }

                            if (((notif.args.count == 1)||(notif.args.count0 == 1))&&(notif.args.maxtrip == 2))
                                {
                                   
            
                                    var agent = document.querySelector('.playerview_agent');
                                    agent.style.top = "1202px";
            
                                }

                            if (((notif.args.count == 1)||(notif.args.count0 == 1))&&(notif.args.maxtrip == 3))
                                {
                                    
                                    var agent = document.querySelector('.playerview_agent');
                                    agent.style.top = "1254px";
            
                                }


                                
                             if ((notif.args.count == 2)&&(notif.args.maxtrip == 2))
                                    {
                                        
                                        var agent = document.querySelector('.playerview_agent');
                                        agent.style.top = "1202px";
                
                                    }
    
                            if ((notif.args.count == 2)&&(notif.args.maxtrip == 3))
                                    {
                                        
                
                                        var agent = document.querySelector('.playerview_agent');
                                        agent.style.top = "1254px";
                
                                    }

                            if ((notif.args.count == 3)&&(notif.args.maxtrip == 3))
                                {
                                    
            
                                    var agent = document.querySelector('.playerview_agent');
                                    agent.style.top = "1254px";
            
                                }

        
                            

                            
        
        
                        }        
               

            },

            notif_condenserextrawalkavecmodif: function( notif )
            {
                
                
                
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville1+'_'+notif.args.card1, 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville1+'_'+notif.args.card1 , 'cardposition_'+notif.args.jour+'_1_'+notif.args.playerid ).play();
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville2+'_'+notif.args.card2, 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville2+'_'+notif.args.card2 , 'cardposition_'+notif.args.jour+'_2_'+notif.args.playerid ).play();
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville3+'_'+notif.args.card3, 'cardposition_'+notif.args.jour+'_3_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville3+'_'+notif.args.card3 , 'cardposition_'+notif.args.jour+'_3_'+notif.args.playerid ).play();
                    this.attachToNewParentNoDestroy( 'card_'+notif.args.ville4+'_'+notif.args.card4, 'cardposition_'+notif.args.jour+'_4_'+notif.args.playerid );
                    this.slideToObject( 'card_'+notif.args.ville4+'_'+notif.args.card4 , 'cardposition_'+notif.args.jour+'_4_'+notif.args.playerid ).play();
                
                    var element1 = document.getElementById('cardposition_'+notif.args.jour+'_1_'+notif.args.playerid);
                    element1.style.zIndex = "10";
                    var element2 = document.getElementById('cardposition_'+notif.args.jour+'_2_'+notif.args.playerid);
                    element2.style.zIndex = "10";
                    var element3 = document.getElementById('cardposition_'+notif.args.jour+'_3_'+notif.args.playerid);
                    element3.style.zIndex = "10";
                    var element4 = document.getElementById('cardposition_'+notif.args.jour+'_4_'+notif.args.playerid);
                    element4.style.zIndex = "10";
                    var element5 = document.getElementById('cardposition_'+notif.args.jour+'_5_'+notif.args.playerid);
                    element5.style.zIndex = "0";
                    var element6 = document.getElementById('cardposition_'+notif.args.jour+'_6_'+notif.args.playerid);
                    element6.style.zIndex = "0";
                    var element7 = document.getElementById('cardposition_'+notif.args.jour+'_7_'+notif.args.playerid);
                    element7.style.zIndex = "0";
    
                    
               

            },

            notif_finallocation: function( notif )
            {
                if (notif.args.ville == 1)
                {
                    dojo.place( this.format_block( 'jstpl_finaltokyo', {
                                    
                                                        
                    } ) , notif.args.card );
                }
                if (notif.args.ville == 2)
                {
                    dojo.place( this.format_block( 'jstpl_finalkyoto', {
                                    
                                                        
                    } ) , notif.args.card );
                }
                
            },

            notif_changecard: function( notif )
            {
                dojo.destroy(notif.args.cardid);

                if (notif.args.ville == 1)
                    {
                        this.addCardTokyoTrip( notif.args.id, notif.args.type, 1, notif.args.location, notif.args.playerid, 0, 1 );
                        if (notif.args.train >=1)
                        {
                            this.addTrain(notif.args.id, notif.args.ville, notif.args.train );
                        }
                        
                    }
                    if (notif.args.ville == 2)
                    {
                        this.addCardKyotoTrip( notif.args.id, notif.args.type, 2, notif.args.location, notif.args.playerid, 0, 2 );
                        if (notif.args.train >=1)
                        {
                            this.addTrain(notif.args.id, notif.args.ville, notif.args.train );
                        }
                    
                    }
            },

            notif_finalwalk: function( notif )
            {
                
                    dojo.place( this.format_block( 'jstpl_finalwalk', {
                                    
                                                        
                    } ) , notif.args.card );
                
                
                
                
            },

            notif_train: function( notif )
            {
                
                this.addTrain(notif.args.id, notif.args.ville, notif.args.train );

            },

            notif_movetoken: function( notif )
            {

                if ((notif.args.player == this.getCurrentPlayerId())||(this.gamedatas.countplayers == 1)) 
                    {
                        this.notifqueue.setSynchronousDuration(500);
                    }
    
                if ((notif.args.player != this.getCurrentPlayerId())&&(this.gamedatas.countplayers >= 2)) 
                    {
                        this.notifqueue.setSynchronousDuration(0);
                    }
                                
                
                if(notif.args.type == 'r')
                {
                    this.attachToNewParentNoDestroy( 'marqueur_r_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_1_'+notif.args.player);
                    this.slideToObject( 'marqueur_r_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_1_'+notif.args.player).play();

                    if(notif.args.plus == 1)
                        {
                            $('marqueur_r_'+notif.args.player).innerHTML = '+12';
                        }
                }

                if(notif.args.type == 'g')
                    {
                        this.attachToNewParentNoDestroy( 'marqueur_g_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_2_'+notif.args.player);
                        this.slideToObject( 'marqueur_g_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_2_'+notif.args.player).play();
    
                        if(notif.args.plus == 1)
                            {
                                $('marqueur_g_'+notif.args.player).innerHTML = '+12';
                            }
                    }

                if(notif.args.type == 'p')
                    {
                        this.attachToNewParentNoDestroy( 'marqueur_p_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_3_'+notif.args.player);
                        this.slideToObject( 'marqueur_p_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_3_'+notif.args.player).play();
    
                        if(notif.args.plus == 1)
                            {
                                $('marqueur_p_'+notif.args.player).innerHTML = '+12';
                            }
                    }

                if(notif.args.type == 'y')
                    {
                        this.attachToNewParentNoDestroy( 'marqueur_y_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_4_'+notif.args.player);
                        this.slideToObject( 'marqueur_y_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_4_'+notif.args.player).play();
                        if(notif.args.plus == 1)
                        {
                            $('marqueur_y_'+notif.args.player).innerHTML = '+12';
                        }
    
                    }

                if(notif.args.type == 'b')
                    {
                        this.attachToNewParentNoDestroy( 'marqueur_b_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_5_'+notif.args.player);
                        this.slideToObject( 'marqueur_b_'+notif.args.player, 'marqueurposition_'+notif.args.score+'_5_'+notif.args.player).play();
    
                        if(notif.args.plus == 1)
                            {
                                $('marqueur_b_'+notif.args.player).innerHTML = '+12';
                            }
                    }
                        
                    
                      
                                    
            },


            notif_scorepad: function( notif )
            {

                if(this.gamedatas.countplayers >= 2)
                {
                
                if(!this.isSpectator)
                    { 
                        this.addMask();
                            
                        dojo.query("#mask_turn").addClass("masque");
                        dojo.query("#mask_hand").addClass("masque");
                        dojo.query("#mask_score").removeClass("hidden");

                        dojo.query(".scorepad").removeClass("hidden");
                        var elements = document.querySelectorAll("[id^='playerview']");
                        elements.forEach(function(element) {
                            element.style.top = "525px"; 
                            });

                        var global = document.getElementById('global');
                        global.style.height = "1530px"; 
                    }
    
                    if(this.isSpectator)
                        { 
                            dojo.query(".turn_board").addClass("hidden");
                            dojo.query("#mask_score").addClass("hidden");
    
                            dojo.query(".scorepad").removeClass("hidden");
                            var elements = document.querySelectorAll("[id^='playerview']");
                            elements.forEach(function(element) {
                                element.style.top = "467px"; 
                                });

                            var global = document.getElementById('global');
                            global.style.height = "1476px"; 
                        }

                }

                if(this.gamedatas.countplayers == 1)
                {
                    if(!this.isSpectator)
                        { 
                            this.addMask();
                            
        
                            dojo.query("#mask_turn").addClass("masque");
                            dojo.query("#mask_hand").addClass("masque");
                            dojo.query("#mask_score").removeClass("hidden");
                            dojo.query(".scorepad").removeClass("hidden");

                            var playerview = document.querySelector('.playerview');
                            playerview.style.top = "525px"; 

                            var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1380px"; 
    
                            var global = document.getElementById('global');
                            global.style.height = "2180px"; 
                        }
        
                        if(this.isSpectator)
                            { 
                            this.addMask();
                            
        
                            dojo.query("#mask_turn").addClass("masque");
                            dojo.query("#mask_hand").addClass("masque");
                            dojo.query(".scorepad").removeClass("hidden");

                            var playerview = document.querySelector('.playerview');
                            playerview.style.top = "470px"; 

                            var agent = document.querySelector('.playerview_agent');
                            agent.style.top = "1325px"; 
    
                            var global = document.getElementById('global');
                            global.style.height = "2125px"; 
                            }
    
                }
            
                

            },

            notif_score: function( notif )
            {
                $('score_'+notif.args.numero+'_'+notif.args.position).innerHTML = notif.args.score;
                
            },

            notif_score2: function( notif )
            {
                $('score_'+notif.args.numero+'_7').innerHTML = notif.args.humeur;
                $('score_'+notif.args.numero+'_8').innerHTML = notif.args.token;
                $('score_'+notif.args.numero+'_9').innerHTML = notif.args.train;
                $('score_'+notif.args.numero+'_10').innerHTML = notif.args.recherche;
                $('score_'+notif.args.numero+'_11').innerHTML = notif.args.total;

                this.scoreCtrl[ notif.args.player ].toValue( notif.args.total );
                
            },

            notif_disabled: function( notif )
            {
                var bouton1 = document.getElementById('continue');
                if(bouton1 !== null)
                {
                dojo.addClass( 'continue', 'disabled');
                }

                var bouton2 = document.getElementById('yes');
                if(bouton2 !== null)
                {
                dojo.addClass( 'yes', 'disabled');
                }

                var bouton3 = document.getElementById('no');
                if(bouton3 !== null)
                {
                dojo.addClass( 'no', 'disabled');
                }
                
                
                
            },

            notif_check: function( notif )
            {
                
                this.addCheck(notif.args.id, notif.args.ville, notif.args.check);
                const check = document.getElementById('check_'+notif.args.ville+'_'+notif.args.id);
                check.classList.add("animate");
                

            },

            notif_checkscore: function( notif )
            {
                
                if (notif.args.check == 1)
                {
                    dojo.query("#checkscore_"+notif.args.numero+"_"+notif.args.position).addClass("checkscoreok");
                }

                if (notif.args.check == 2)
                {
                    dojo.query("#checkscore_"+notif.args.numero+"_"+notif.args.position).addClass("checkscoreko");
                }
                

            },

            notif_score2solo: function( notif )
            {
                $('score_'+notif.args.numero+'_7').innerHTML = notif.args.humeur;
                $('score_'+notif.args.numero+'_8').innerHTML = notif.args.token;
                $('score_'+notif.args.numero+'_9').innerHTML = notif.args.train;
                $('score_'+notif.args.numero+'_10').innerHTML = notif.args.recherche;
                $('score_'+notif.args.numero+'_11').innerHTML = notif.args.total;

                this.scoreCtrl[ notif.args.player ].toValue( notif.args.pannel);
                
            },

            notif_score2agent: function( notif )
            {
                $('score_2_7').innerHTML = notif.args.humeur;
                $('score_2_8').innerHTML = notif.args.token;
                $('score_2_9').innerHTML = notif.args.train;
                $('score_2_10').innerHTML = notif.args.recherche;
                $('score_2_11').innerHTML = notif.args.total;

                
                
            },


            notif_infolvl: function( notif )
            {
                var player_pannel = $('player_board_'+notif.args.playerid);

                if(notif.args.lvl == 1)
                    {
                        dojo.place( this.format_block('jstpl_infolvl', {id: notif.args.playerid} ), player_pannel );
                        var info = _("Easy level: Your opponent must meet the requirements of their “Highlight of the Day” bonuses in order to score them. It does not use Train tokens.");
                        $('infolvl_'+notif.args.playerid).innerHTML = info;

                    }

                    if(notif.args.lvl == 2)
                    {
                        dojo.place( this.format_block('jstpl_infolvl', {id: notif.args.playerid} ), player_pannel );
                        var info = _("Normal level: Your opponent always scores all his “Highlights of the Day”. It does not use Train tokens.");
                        $('infolvl_'+notif.args.playerid).innerHTML = info;

                    }

                    if(notif.args.lvl == 3)
                    {
                        dojo.place( this.format_block('jstpl_infolvl', {id: notif.args.playerid} ), player_pannel );
                        var info = _("Difficult level: Your opponent always scores all his “Highlights of the Day” and places a Luxury Train token each time he travels.");
                        $('infolvl_'+notif.args.playerid).innerHTML = info;

                    }

                
                
            },


    
    
       });             
    });
    