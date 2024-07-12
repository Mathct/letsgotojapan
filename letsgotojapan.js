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
                    }

                ////////////////////////////////////////////////////////////////////////////////////////////

                for( var tokyo in gamedatas.tokyo)
                    {
                        var tokyo = gamedatas.tokyo[tokyo];
                        console.warn (tokyo);
                        //this.addMateria(materia.id, materia.type, materia.type_arg, materia.location, materia.location_arg);
                        
                        
                    }

                for( var kyoto in gamedatas.kyoto)
                    {
                        var kyoto = gamedatas.kyoto[kyoto];
                        console.warn (kyoto);
                        //this.addMateria(materia.id, materia.type, materia.type_arg, materia.location, materia.location_arg);
                        
                        
                    }

                
                




                
                
     
                // Setup game notifications to handle (see "setupNotifications" method below)
                this.setupNotifications();
    
                dojo.query(".left").connect('onclick', this, 'onPrev' );
                dojo.query(".right").connect('onclick', this, 'onNext' );
    
    
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
    
                            
                            if(this.args[this.getCurrentPlayerId()][0].titleyou != null)
                            {
                                $('pagemaintitletext').innerHTML = 	this.format_string_recursive(_(this.args[this.getCurrentPlayerId()][0].titleyou).replace('${you}', this.divYou()).replace('#nb#',args.args.nb).replace('#nb2#',args.args.nb2).replace('#icon#',args.args.icon), args.args);
                            }



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
                                        this.addActionButton( 'cancel', _("Cancel") ,'onOpButton', null, null, 'gray' );
                                    }
                                    if(args[this.getCurrentPlayerId()][0].buttons[nb] == "pass")
                                    {
                                        this.addActionButton( 'pass', _("Pass") ,'onOpButton', null, null, 'gray' );
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
                    
                    this.ajaxcall( "/letsgotojapan/letsgotojapan/actSelect.html", { 
                        lock: true,
                        arg1: evt.currentTarget.id
                        
                     }, 
                     this, function( result ) {}, function( is_error) {} );
                }
    
                
    
    
            },
    
            onOpButton: function(evt)
            {
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
            },  
            
            
    
    
    
       });             
    });
    