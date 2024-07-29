/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * letsgotojapan implementation : © <Your name here> <Your email address here>
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
                        
                        
                    }

                for( var player_id in gamedatas.players )   
                    {
                                            
                        
                        $('nbrerecherche_'+player_id).innerHTML = gamedatas.nbrerecherche[player_id];
                        $('nbretrain_'+player_id).innerHTML = gamedatas.nbretrain[player_id];
                        $('nbrewild_'+player_id).innerHTML = gamedatas.nbrewild[player_id];
                        
                        
                    }



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

                
                for( var player_id in gamedatas.players )
                    {
                        var player = gamedatas.players[player_id].id;
                        if(player != this.getCurrentPlayerId())
                        {
                            dojo.query("#playerview_"+player).addClass("masque");
                        }
    
                                                    
                        
                    }

                if(this.isSpectator)
                    {
                        var player = gamedatas.listplayers[0];
                        dojo.query("#playerview_"+player).removeClass("masque");
                        dojo.query(".playerhandtitle").addClass("masque");
                        dojo.query(".playerhand").addClass("masque");
                        dojo.query("#mask_turn").addClass("masque");
                        dojo.query("#mask_hand").addClass("masque");

                        var elements = document.querySelectorAll("[id^='playerview']");
                        elements.forEach(function(element) {
                            element.style.top = "151px"; 
                          });

                        var global = document.getElementById('global');
                        global.style.height = "1150px"; 
                    }


                this.addTurn(gamedatas.turn);

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
                        
                            this.addCardTokyoTrip(tokyo.id, tokyo.type, tokyo.type_arg, tokyo.location, tokyo.location_arg, tokyo.walk);

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
                            
                            this.addCardKyotoTrip(kyoto.id, kyoto.type, kyoto.type_arg, kyoto.location, kyoto.location_arg, kyoto.walk);
                            }
                        
                        
                    }

                
                for( var jour in gamedatas.tokenjour)
                    {
                        var tokenjour = gamedatas.tokenjour[jour];

                        this.addTokenJour(tokenjour.name, tokenjour.level);
                        
                    }
    
                for( var player_id in gamedatas.players )
                    {
                        var smile = gamedatas.smile[player_id];
                        var happy = gamedatas.happy[player_id];
                        var angry = gamedatas.angry[player_id];
                        var color = gamedatas.color[player_id];
                        
                        this.addHappy(smile, happy, angry, player_id, color);
                        
                                                    
                        
                    }
                    
                

                

                
                
     
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
                dojo.query(".selected").removeClass("selected"); 
                
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
                                        /*if(this.args[this.getCurrentPlayerId()][0].selectable[sid].startsWith("cardposition"))
                                        {
                                            var element = document.getElementById(this.args[this.getCurrentPlayerId()][0].selectable[sid]);
                                            var currentZIndex = window.getComputedStyle(element).getPropertyValue("z-index");
                                            var newZIndex = parseInt(currentZIndex, 10) + 10;
                                            element.style.zIndex = newZIndex;
                                        }*/
    
                                }
                            }


                            if (this.args[this.getCurrentPlayerId()][0].selected)
                                {
                                for( var sid in this.args[this.getCurrentPlayerId()][0].selected)
                                    {
                                        
                                            
                                            dojo.query("#"+this.args[this.getCurrentPlayerId()][0].selected[sid]).addClass("selected");
        
                                    }
                                }
    
                            
                            if(this.args[this.getCurrentPlayerId()][0].titleyou != null)
                            {
                                $('pagemaintitletext').innerHTML = 	this.format_string_recursive(_(this.args[this.getCurrentPlayerId()][0].titleyou).replace('${you}', this.divYou()).replace('#nb#',args.args.nb).replace('#nb2#',args.args.nb2).replace('#icon#',args.args.icon), args.args);
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
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "recherche")
                                    {
                                        this.addActionButton( 'recherche', `<div class="iconrecherche"></div>` ,'onOpButton', null, null, 'none' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "tokyo")
                                    {
                                        this.addActionButton( 'tokyo', `<div class="boutontokyo">Tokyo</div>` ,'onOpButton', null, null, 'none' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "kyoto")
                                    {
                                        this.addActionButton( 'kyoto', `<div class="boutonkyoto">Kyoto</div>` ,'onOpButton', null, null, 'none' );
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

            addTokenJour: function( jour, couleur)
            {   
                
                dojo.place( this.format_block( 'jstpl_tokenjour', {
                x: (couleur-1)*(-100),
                jour: jour,
                                        
                } ) , 'tokenjourposition_'+jour );

            },

            addTurn: function( turn)
            {   
                
                dojo.place( this.format_block( 'jstpl_turn', {
                    
                                        
                } ) , 'turnboard_marqueur_'+turn );

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
                if (player == this.getCurrentPlayerId())
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
                        
                    }
                        
                    
                    dojo.query("#card_"+ville+'_'+id).connect('onclick', this, 'onSelect' );
                    



                    /// tooltip
                    
                    /*var type = set+color;
                    var name = _(this.gamedatas.listecards[type].name);
                    var description3 = _(this.gamedatas.listecards[type].description3);
                    var description4 = _(this.gamedatas.listecards[type].description4);
                    var description5 = _(this.gamedatas.listecards[type].description5);
                
                    if(set ==1)
                    {
                    var html = '<div class="anatooltip"><div class="anatcard">'+this.format_block('jstpl_cardtool1',{name: name, description3: description3, description4: description4, description5: description5, x: (color-1)*(-100), y: 0})+'</div></div>';
                    this.addTooltipHtml( 'card_'+color+'_'+player, html,500);
                    }
                    if(set ==2)
                    {
                    var html = '<div class="anatooltip"><div class="anatcard">'+this.format_block('jstpl_cardtool2',{name: name, description3: description3, description4: description4, description5: description5, x: (color-1)*(-100), y: 0})+'</div></div>';
                    this.addTooltipHtml( 'card_'+color+'_'+player, html,500);
                    }
                    if(set ==3)
                    {
                    var html = '<div class="anatooltip"><div class="anatcard">'+this.format_block('jstpl_cardtool3',{name: name, description3: description3, description4: description4, description5: description5, x: (color-1)*(-100), y: 0})+'</div></div>';
                    this.addTooltipHtml( 'card_'+color+'_'+player, html,500);
                    }*/
                }
    

            },


            addCardKyotoHand: function( id, card, ville, location, player )  
            {
                if (player == this.getCurrentPlayerId())
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
                        
                    }
                        
                      
    
                    dojo.query("#card_"+ville+'_'+id).connect('onclick', this, 'onSelect' );
                    

                }
        
    
                
    
    

            },

            addCardTokyoTrip: function( id, card, ville, location, player, walk )  
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

                }
                    
                
    

            },


            addCardKyotoTrip: function( id, card, ville, location, player, walk )  
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
    
                
                if( this.isSpectator || !(evt.currentTarget.classList.contains('selectable')) )
                {   
                    return; 
                }
                
                if(!this.isSpectator && evt.currentTarget.classList.contains('selectable') && this.checkAction( "actSelect" ))
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
                    ock: true,
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

            onMaskTurn: function(evt)
            {        	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

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
                      global.style.height = (currentHeight + 160) + "px";
                    
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
                      global.style.height = (currentHeight - 160) + "px";
                }
   

            },

            onMaskHand: function(evt)
            {        	 
                // Preventing default browser reaction
                dojo.stopEvent( evt );

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
                        
                        playerview.style.top = (currentTop + 290) + "px";
                      });
                      global.style.height = (currentHeight + 300) + "px";
                } 
                
                else 
                {
                    dojo.query(".playerhand").addClass("hidden");
                    dojo.query(".playerhandtitle").addClass("hidden");
                    playerviews.forEach(function(playerview) {
                        var currentTop = playerview.offsetTop;
                        
                        playerview.style.top = (currentTop - 310) + "px";
                      });
                      global.style.height = (currentHeight - 300) + "px";
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
                dojo.subscribe( 'condensersansmodif', this, "notif_condensersansmodif" );
                dojo.subscribe( 'condenseravecmodif', this, "notif_condenseravecmodif" );
                dojo.subscribe( 'smile', this, "notif_smile" );
                dojo.subscribe( 'happy', this, "notif_happy" );
                dojo.subscribe( 'angry', this, "notif_angry" );
                dojo.subscribe( 'majpannel', this, "notif_majpannel" );
                dojo.subscribe( 'discard', this, "notif_discard" );
                dojo.subscribe( 'addwalk', this, "notif_addwalk" );
                

                
            },  

            notif_majpannel: function( notif )
            {
                $('nbrerecherche_'+notif.args.id).innerHTML = notif.args.recherche;
                $('nbretrain_'+notif.args.id).innerHTML = notif.args.train;
                $('nbrewild_'+notif.args.id).innerHTML = notif.args.wild;
            },

            
            
            notif_movecard: function( notif )
            {
                if (notif.args.playerid == this.getCurrentPlayerId()) 
                {
                    this.attachToNewParentNoDestroy( notif.args.mobile, notif.args.parent );
                    this.slideToObject( notif.args.mobile, notif.args.parent ).play();
                }

                if (notif.args.playerid != this.getCurrentPlayerId()) 
                {
                    if(notif.args.ville == 1)
                    {
                    this.addCardTokyoTrip( notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid, 0 );
                    }
                    if(notif.args.ville == 2)
                    {
                    this.addCardKyotoTrip( notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid, 0 );
                    }
                }

                var element = document.getElementById(notif.args.location+'_'+notif.args.playerid);
                element.style.zIndex = "10";

            },

            notif_discard: function( notif )
            {
                if (notif.args.playerid == this.getCurrentPlayerId()) 
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
                if (notif.args.playerid == this.getCurrentPlayerId()) 
                {
                    if(notif.args.ville == 1)
                    {
                        this.addCardTokyoHand (notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid );
                        /*this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.id, 'player_boards' );
                        this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.id, notif.args.location+'_'+notif.args.playerid).play();*/
                    }

                    if(notif.args.ville == 2)
                    {
                        this.addCardKyotoHand (notif.args.id, notif.args.card, notif.args.ville, notif.args.location, notif.args.playerid );
                        /*this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.id, 'player_boards' );
                        this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.id, notif.args.location+'_'+notif.args.playerid).play();*/
                    }
                
                    
                }

            },

            notif_addwalk: function( notif )
            {
                if(notif.args.ville==1)
                {
                    this.addCardTokyoTrip( notif.args.cardid, 0, notif.args.ville, notif.args.location, notif.args.playerid, 1 );
                    if (notif.args.playerid == this.getCurrentPlayerId()) 
                    {
                        this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, 'player_boards' );
                        this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, notif.args.location+'_'+notif.args.playerid).play();
                    }
                }
                if(notif.args.ville==2)
                {
                    this.addCardKyotoTrip( notif.args.cardid, 0, notif.args.ville, notif.args.location, notif.args.playerid, 1 );
                    if (notif.args.playerid == this.getCurrentPlayerId()) 
                        {
                            this.placeOnObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, 'player_boards' );
                            this.slideToObject( 'card_'+notif.args.ville+'_'+notif.args.cardid, notif.args.location+'_'+notif.args.playerid).play();
                        }
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

            notif_turn: function( notif )
            {
                this.attachToNewParentNoDestroy( 'turn', 'turnboard_marqueur_'+notif.args.turn );
                this.slideToObject( 'turn', 'turnboard_marqueur_'+notif.args.turn ).play();
            },

            notif_smile: function( notif )
            {
                this.attachToNewParentNoDestroy( 'smile_'+notif.args.player, 'smileposition_'+notif.args.position+'_'+notif.args.player);
                this.slideToObject( 'smile_'+notif.args.player, 'smileposition_'+notif.args.position+'_'+notif.args.player ).play();
            },

            notif_happy: function( notif )
            {
                this.attachToNewParentNoDestroy( 'happy_'+notif.args.player, 'happyposition_'+notif.args.position+'_'+notif.args.player);
                this.slideToObject( 'happy_'+notif.args.player, 'happyposition_'+notif.args.position+'_'+notif.args.player ).play();
            },

            notif_angry: function( notif )
            {
                this.attachToNewParentNoDestroy( 'angry_'+notif.args.player, 'angryposition_'+notif.args.position+'_'+notif.args.player);
                this.slideToObject( 'angry_'+notif.args.player, 'angryposition_'+notif.args.position+'_'+notif.args.player ).play();
            },

            notif_deployer: function( notif )
            {
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
                        element5.style.zIndex = "6";
    
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
                        element5.style.zIndex = "6";
    
                    }
               

            },
    
    
       });             
    });
    