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
    
        <div id="mask_turn"></div>
        <div id="mask_hand"></div>
    
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

        <!-- BEGIN playerhand -->
        
            <div id="playerhandtitle_{PLAYER_ID}" class="playerhandtitle" style="color:#{COLOR}; outline: 0.5px solid #{COLOR};">Your Hand</div>
            <div id="playerhand_{PLAYER_ID}" class="playerhand"></div>
        
        <!-- END playerhand -->

        <!-- BEGIN player -->
        <div id="playerview_{PLAYER_ID}" class="playerview">
            <div id="nameplayer_{PLAYER_ID}" class="nameplayer" style="color:#{COLOR}; outline: 0.5px solid #{COLOR};"><div class="left"><<<&nbsp;&nbsp;&nbsp;</div>{PLAYER_NAME}<div class="right">&nbsp;&nbsp;&nbsp;>>></div></div>
            <div id="playerboard_{PLAYER_ID}" class="playerboard color_{COLOR}">


                <div id="tokenjourposition_1" class="tokenjourposition" style="top: 85.5%; left: 1.2%;"></div>
                <div id="tokenjourposition_2" class="tokenjourposition" style="top: 85.5%; left: 16.4%;"></div>
                <div id="tokenjourposition_3" class="tokenjourposition" style="top: 85.5%; left: 33.3%;"></div>
                <div id="tokenjourposition_4" class="tokenjourposition" style="top: 85.5%; left: 50.5%;"></div>
                <div id="tokenjourposition_5" class="tokenjourposition" style="top: 85.5%; left: 66.7%;"></div>
                <div id="tokenjourposition_6" class="tokenjourposition" style="top: 85.5%; left: 83.8%;"></div>


                <div id="cardposition_1_1_{PLAYER_ID}"class="cardposition" style="top: 101%; left: 2.3%;"></div>
                <div id="cardposition_1_2_{PLAYER_ID}"class="cardposition" style="top: 115%; left: 2.3%;"></div>
                <div id="cardposition_1_3_{PLAYER_ID}"class="cardposition" style="top: 129%; left: 2.3%;"></div>
                <div id="cardposition_1_4_{PLAYER_ID}"class="cardposition" style="top: 143%; left: 2.3%;"></div>
                <div id="cardposition_1_5_{PLAYER_ID}"class="cardposition" style="top: 157%; left: 2.3%;"></div>
                <div id="cardposition_1_6_{PLAYER_ID}"class="cardposition" style="top: 171%; left: 2.3%;"></div>
                <div id="cardposition_1_7_{PLAYER_ID}"class="cardposition" style="top: 185%; left: 2.3%;"></div>

                <div id="cardposition_2_1_{PLAYER_ID}"class="cardposition" style="top: 101%; left: 19.2%;"></div>
                <div id="cardposition_2_2_{PLAYER_ID}"class="cardposition" style="top: 115%; left: 19.2%;"></div>
                <div id="cardposition_2_3_{PLAYER_ID}"class="cardposition" style="top: 129%; left: 19.2%;"></div>
                <div id="cardposition_2_4_{PLAYER_ID}"class="cardposition" style="top: 143%; left: 19.2%;"></div>
                <div id="cardposition_2_5_{PLAYER_ID}"class="cardposition" style="top: 157%; left: 19.2%;"></div>
                <div id="cardposition_2_6_{PLAYER_ID}"class="cardposition" style="top: 171%; left: 19.2%;"></div>
                <div id="cardposition_2_7_{PLAYER_ID}"class="cardposition" style="top: 185%; left: 19.2%;"></div>

                <div id="cardposition_3_1_{PLAYER_ID}"class="cardposition" style="top: 101%; left: 35.9%;"></div>
                <div id="cardposition_3_2_{PLAYER_ID}"class="cardposition" style="top: 115%; left: 35.9%;"></div>
                <div id="cardposition_3_3_{PLAYER_ID}"class="cardposition" style="top: 129%; left: 35.9%;"></div>
                <div id="cardposition_3_4_{PLAYER_ID}"class="cardposition" style="top: 143%; left: 35.9%;"></div>
                <div id="cardposition_3_5_{PLAYER_ID}"class="cardposition" style="top: 157%; left: 35.9%;"></div>
                <div id="cardposition_3_6_{PLAYER_ID}"class="cardposition" style="top: 171%; left: 35.9%;"></div>
                <div id="cardposition_3_7_{PLAYER_ID}"class="cardposition" style="top: 185%; left: 35.9%;"></div>

                <div id="cardposition_4_1_{PLAYER_ID}"class="cardposition" style="top: 101%; left: 52.7%;"></div>
                <div id="cardposition_4_2_{PLAYER_ID}"class="cardposition" style="top: 115%; left: 52.7%;"></div>
                <div id="cardposition_4_3_{PLAYER_ID}"class="cardposition" style="top: 129%; left: 52.7%;"></div>
                <div id="cardposition_4_4_{PLAYER_ID}"class="cardposition" style="top: 143%; left: 52.7%;"></div>
                <div id="cardposition_4_5_{PLAYER_ID}"class="cardposition" style="top: 157%; left: 52.7%;"></div>
                <div id="cardposition_4_6_{PLAYER_ID}"class="cardposition" style="top: 171%; left: 52.7%;"></div>
                <div id="cardposition_4_7_{PLAYER_ID}"class="cardposition" style="top: 185%; left: 52.7%;"></div>

                <div id="cardposition_5_1_{PLAYER_ID}"class="cardposition" style="top: 101%; left: 69.4%;"></div>
                <div id="cardposition_5_2_{PLAYER_ID}"class="cardposition" style="top: 115%; left: 69.4%;"></div>
                <div id="cardposition_5_3_{PLAYER_ID}"class="cardposition" style="top: 129%; left: 69.4%;"></div>
                <div id="cardposition_5_4_{PLAYER_ID}"class="cardposition" style="top: 143%; left: 69.4%;"></div>
                <div id="cardposition_5_5_{PLAYER_ID}"class="cardposition" style="top: 157%; left: 69.4%;"></div>
                <div id="cardposition_5_6_{PLAYER_ID}"class="cardposition" style="top: 171%; left: 69.4%;"></div>
                <div id="cardposition_5_7_{PLAYER_ID}"class="cardposition" style="top: 185%; left: 69.4%;"></div>

                <div id="cardposition_6_1_{PLAYER_ID}"class="cardposition" style="top: 101%; left: 86.2%;"></div>
                <div id="cardposition_6_2_{PLAYER_ID}"class="cardposition" style="top: 115%; left: 86.2%;"></div>
                <div id="cardposition_6_3_{PLAYER_ID}"class="cardposition" style="top: 129%; left: 86.2%;"></div>
                <div id="cardposition_6_4_{PLAYER_ID}"class="cardposition" style="top: 143%; left: 86.2%;"></div>
                <div id="cardposition_6_5_{PLAYER_ID}"class="cardposition" style="top: 157%; left: 86.2%;"></div>
                <div id="cardposition_6_6_{PLAYER_ID}"class="cardposition" style="top: 171%; left: 86.2%;"></div>
                <div id="cardposition_6_7_{PLAYER_ID}"class="cardposition" style="top: 185%; left: 86.2%;"></div>

            </div>
        </div>
        <!-- END player -->
    
</div>





<script type="text/javascript">

var jstpl_titre='<div id="titre"></div>';
var jstpl_eye='<div id="eye_${id}" class="eye" style="display: inline-block;"></div>';
var jstpl_tokenjour='<div id="tokenjour_${jour}" class="tokenjour" style="background-position-x: ${x}%;"></div>';
var jstpl_card='<div id="card_${ville}_${id}" class="card" style="background-image: url(${imgfull}); background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_turn='<div id="turn" class="turn"></div>';

</script>  

{OVERALL_GAME_FOOTER}
