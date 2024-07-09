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
                
                this.players = gamedatas.players;
    
    
                // Setting up player boards
                for( var player_id in gamedatas.players )
                {
                    var player = gamedatas.players[player_id];
                             
                    // TODO: Setting up players boards if needed
                }
                
                // TODO: Set up your game interface here, according to "gamedatas"
                
     
                // Setup game notifications to handle (see "setupNotifications" method below)
                this.setupNotifications();
    
                dojo.query(".carre").connect('onclick', this, 'onSelect' );
    
    
                console.log( "Ending game setup" );
            },
           
    
            ///////////////////////////////////////////////////
            //// Game & client states
            
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
    
            ///////////////////////////////////////////////////
            //// Utility methods
            
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
    
    
            ///////////////////////////////////////////////////
            //// Player's action
            
           
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
    
            
            ///////////////////////////////////////////////////
            //// Reaction to cometD notifications
    
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
    