{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
-- letsgotojapan implementation : © <Your name here> <Your email address here>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------

    letsgotojapan_letsgotojapan.tpl
    
    This is the HTML template of your game.
    
    Everything you are writing in this file will be displayed in the HTML page of your game user interface,
    in the "main game zone" of the screen.6.8
    
    You can use in this template:
    _ variables, with the format {MY_VARIABLE_ELEMENT}.
    _ HTML block, with the BEGIN/END format
    
    See your "view" PHP file to check how to set variables and control blocks
    
    Please REMOVE this comment before publishing your game on BGA
-->



<div id="global">
    
   
    
        <div class="turn_board">
            <div id="turnboard_marqueur_1" class = "turnboard_marqueur" style="left: 1.6%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_2" class = "turnboard_marqueur" style="left: 8.9%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_3" class = "turnboard_marqueur" style="left: 16%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_4" class = "turnboard_marqueur" style="left: 23.4%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_5" class = "turnboard_marqueur" style="left: 31.1%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_6" class = "turnboard_marqueur" style="left: 38.4%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_7" class = "turnboard_marqueur" style="left: 45.5% ; top: 5.5%;"></div>
            <div id="turnboard_marqueur_8" class = "turnboard_marqueur" style="left: 52.9%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_9" class = "turnboard_marqueur" style="left: 60.2%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_10" class = "turnboard_marqueur" style="left: 68.2%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_11" class = "turnboard_marqueur" style="left: 75.4%; top: 5.5%;"></div>
            <div id="turnboard_marqueur_12" class = "turnboard_marqueur" style="left: 82.6%; top: 5.5%;"></div>
            <div id "turnboard_marqueur_13" class = "turnboard_marqueur" style="left: 89.9%; top: 5.5%;"></div>
        </div>

        <!-- BEGIN player -->
        
        
        <div id="playerview_{PLAYER_ID}" class="playerview">
        <div id="playername_{PLAYER_ID}" class="playername" style="color:#{COLOR}; outline: 0.5px solid #{COLOR};"><div class="left"><<<&nbsp;&nbsp;&nbsp;</div>{PLAYER_NAME}<div class="right">&nbsp;&nbsp;&nbsp;>>></div></div>
        <div id="playerboard_{PLAYER_ID}" class="playerboard color_{COLOR}"></div>
        </div>
            
        
        <!-- END player -->
    
</div>





<script type="text/javascript">


</script>  

{OVERALL_GAME_FOOTER}
