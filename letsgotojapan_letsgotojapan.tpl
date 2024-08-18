{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
-- letsgotojapan implementation : © <Mathieu Chatrain> <mathieu.chatrain@gmail.com>
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

        <div class="scorepad hidden">
        <div id="scorename_1" class="scorename" style="left: 25.2%; top: 0.2%;"></div>
        <div id="score_1_1" class="score" style="left: 25.2%; top: 9.2%;"></div>
        <div id="checkscore_1_1" class="checkscore" style="left: 35%; top: 12.8%;"></div>
        <div id="score_1_2" class="score" style="left: 25.2%; top: 17.3%;"></div>
        <div id="checkscore_1_2" class="checkscore" style="left: 35%; top: 21.2%;"></div>
        <div id="score_1_3" class="score" style="left: 25.2%; top: 26.1%;"></div>
        <div id="checkscore_1_3" class="checkscore" style="left: 35%; top: 29.6%;"></div>
        <div id="score_1_4" class="score" style="left: 25.2%; top: 34.3%;"></div>
        <div id="checkscore_1_4" class="checkscore" style="left: 35%; top: 37.9%;"></div>
        <div id="score_1_5" class="score" style="left: 25.2%; top: 42.2%;"></div>
        <div id="checkscore_1_5" class="checkscore" style="left: 35%; top: 45.8%;"></div>
        <div id="score_1_6" class="score" style="left: 25.2%; top: 50.3%;"></div>
        <div id="checkscore_1_6" class="checkscore" style="left: 35%; top: 54.2%;"></div>
        <div id="score_1_7" class="score" style="left: 25.2%; top: 59.1%;"></div>
        <div id="score_1_8" class="score" style="left: 25.2%; top: 67.2%;"></div>
        <div id="score_1_9" class="score" style="left: 25.2%; top: 75.2%;"></div>
        <div id="score_1_10" class="score" style="left: 25.2%; top: 83.9%;"></div>
        <div id="score_1_11" class="score" style="left: 25.2%; top: 92.1%;"></div>
        <div id="scorename_2" class="scorename" style="left: 40.3%; top: 0.2%;"></div>
        <div id="score_2_1" class="score" style="left: 40.3%; top: 9.2%;"></div>
        <div id="checkscore_2_1" class="checkscore" style="left: 49.8%; top: 12.8%;"></div>
        <div id="score_2_2" class="score" style="left: 40.3%; top: 17.3%;"></div>
        <div id="checkscore_2_2" class="checkscore" style="left: 49.8%; top: 21.2%;"></div>
        <div id="score_2_3" class="score" style="left: 40.3%; top: 26.1%;"></div>
        <div id="checkscore_2_3" class="checkscore" style="left: 49.8%; top: 29.6%;"></div>
        <div id="score_2_4" class="score" style="left: 40.3%; top: 34.3%;"></div>
        <div id="checkscore_2_4" class="checkscore" style="left: 49.8%; top: 37.9%;"></div>
        <div id="score_2_5" class="score" style="left: 40.3%; top: 42.2%;"></div>
        <div id="checkscore_2_5" class="checkscore" style="left: 49.8%; top: 45.8%;"></div>
        <div id="score_2_6" class="score" style="left: 40.3%; top: 50.3%;"></div>
        <div id="checkscore_2_6" class="checkscore" style="left: 49.8%; top: 54.2%;"></div>
        <div id="score_2_7" class="score" style="left: 40.3%; top: 59.1%;"></div>
        <div id="score_2_8" class="score" style="left: 40.3%; top: 67.2%;"></div>
        <div id="score_2_9" class="score" style="left: 40.3%; top: 75.2%;"></div>
        <div id="score_2_10" class="score" style="left: 40.3%; top: 83.9%;"></div>
        <div id="score_2_11" class="score" style="left: 40.3%; top: 92.1%;"></div>
        <div id="scorename_3" class="scorename" style="left: 55.3%; top: 0.2%;"></div>
        <div id="score_3_1" class="score" style="left: 55.3%; top: 9.2%;"></div>
        <div id="checkscore_3_1" class="checkscore" style="left: 64.5%; top: 12.8%;"></div>
        <div id="score_3_2" class="score" style="left: 55.3%; top: 17.3%;"></div>
        <div id="checkscore_3_2" class="checkscore" style="left: 64.5%; top: 21.2%;"></div>
        <div id="score_3_3" class="score" style="left: 55.3%; top: 26.1%;"></div>
        <div id="checkscore_3_3" class="checkscore" style="left: 64.5%; top: 29.6%;"></div>
        <div id="score_3_4" class="score" style="left: 55.3%; top: 34.3%;"></div>
        <div id="checkscore_3_4" class="checkscore" style="left: 64.5%; top: 37.9%;"></div>
        <div id="score_3_5" class="score" style="left: 55.3%; top: 42.2%;"></div>
        <div id="checkscore_3_5" class="checkscore" style="left: 64.5%; top: 45.8%;"></div>
        <div id="score_3_6" class="score" style="left: 55.3%; top: 50.3%;"></div>
        <div id="checkscore_2_6" class="checkscore" style="left: 64.5%; top: 54.2%;"></div>
        <div id="score_3_7" class="score" style="left: 55.3%; top: 59.1%;"></div>
        <div id="score_3_8" class="score" style="left: 55.3%; top: 67.2%;"></div>
        <div id="score_3_9" class="score" style="left: 55.3%; top: 75.2%;"></div>
        <div id="score_3_10" class="score" style="left: 55.3%; top: 83.9%;"></div>
        <div id="score_3_11" class="score" style="left: 55.3%; top: 92.1%;"></div>
        <div id="scorename_4" class="scorename" style="left: 70%; top: 0.2%;"></div>
        <div id="score_4_1" class="score" style="left: 70%; top: 9.2%;"></div>
        <div id="checkscore_4_1" class="checkscore" style="left: 79.3%; top: 12.8%;"></div>
        <div id="score_4_2" class="score" style="left: 70%; top: 17.3%;"></div>
        <div id="checkscore_4_2" class="checkscore" style="left: 79.3%; top: 21.2%;"></div>
        <div id="score_4_3" class="score" style="left: 70%; top: 26.1%;"></div>
        <div id="checkscore_4_3" class="checkscore" style="left: 79.3%; top: 29.6%;"></div>
        <div id="score_4_4" class="score" style="left: 70%; top: 34.3%;"></div>
        <div id="checkscore_4_4" class="checkscore" style="left: 79.3%; top: 37.9%;"></div>
        <div id="score_4_5" class="score" style="left: 70%; top: 42.2%;"></div>
        <div id="checkscore_4_5" class="checkscore" style="left: 79.3%; top: 45.8%;"></div>
        <div id="score_4_6" class="score" style="left: 70%; top: 50.3%;"></div>
        <div id="checkscore_4_6" class="checkscore" style="left: 79.3%; top: 54.2%;"></div>
        <div id="score_4_7" class="score" style="left: 70%; top: 59.1%;"></div>
        <div id="score_4_8" class="score" style="left: 70%; top: 67.2%;"></div>
        <div id="score_4_9" class="score" style="left: 70%; top: 75.2%;"></div>
        <div id="score_4_10" class="score" style="left: 70%; top: 83.9%;"></div>
        <div id="score_4_11" class="score" style="left: 70%; top: 92.1%;"></div>
        <div id="scorename_5" class="scorename" style="left: 85%; top: 0.2%;"></div>
        <div id="score_5_1" class="score" style="left: 85%; top: 9.2%;"></div>
        <div id="checkscore_5_1" class="checkscore" style="left: 94.8%; top: 12.8%;"></div>
        <div id="score_5_2" class="score" style="left: 85%; top: 17.3%;"></div>
        <div id="checkscore_5_2" class="checkscore" style="left: 94.8%; top: 21.2%;"></div>
        <div id="score_5_3" class="score" style="left: 85%; top: 26.1%;"></div>
        <div id="checkscore_5_3" class="checkscore" style="left: 94.8%; top: 29.6%;"></div>
        <div id="score_5_4" class="score" style="left: 85%; top: 34.3%;"></div>
        <div id="checkscore_5_4" class="checkscore" style="left: 94.8%; top: 37.9%;"></div>
        <div id="score_5_5" class="score" style="left: 85%; top: 42.2%;"></div>
        <div id="checkscore_5_5" class="checkscore" style="left: 94.8%; top: 45.8%;"></div>
        <div id="score_5_6" class="score" style="left: 85%; top: 50.3%;"></div>
        <div id="checkscore_5_6" class="checkscore" style="left: 94.8%; top: 54.2%;"></div>
        <div id="score_5_7" class="score" style="left: 85%; top: 59.1%;"></div>
        <div id="score_5_8" class="score" style="left: 85%; top: 67.2%;"></div>
        <div id="score_5_9" class="score" style="left: 85%; top: 75.2%;"></div>
        <div id="score_5_10" class="score" style="left: 85%; top: 83.9%;"></div>
        <div id="score_5_11" class="score" style="left: 85%; top: 92.1%;"></div>
        </div>
    
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
            <div id="turnboard_marqueur_13" class = "turnboard_marqueur" style="left: 89.9%; top: 5.5%;"></div>
        </div>

        <!-- BEGIN playerhand -->
        
            <div id="playerhandtitle_{PLAYER_ID}" class="playerhandtitle" style="color:#{COLOR}; outline: 0.5px solid #{COLOR};">{HAND}</div>
            <div id="playerhand_{PLAYER_ID}" class="playerhand"></div>
        
        <!-- END playerhand -->

        <!-- BEGIN player -->
        <div id="playerview_{PLAYER_ID}" class="playerview">
            <div id="nameplayer_{PLAYER_ID}" class="nameplayer" style="color:#{COLOR}; outline: 0.5px solid #{COLOR};"><div class="left"><<<&nbsp;&nbsp;&nbsp;</div><span style="font-weight: bold;">{PLAYER_NAME}</span><div class="right">&nbsp;&nbsp;&nbsp;>>></div></div>
            <div id="playerboard_{PLAYER_ID}" class="playerboard color_{COLOR}">

                <div id="smileposition_-3_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 36.1%;"></div>
                <div id="smileposition_-2_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 39.6%;"></div>
                <div id="smileposition_-1_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 43.3%;"></div>
                <div id="smileposition_0_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 47.3%;"></div>
                <div id="smileposition_1_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 51.3%;"></div>
                <div id="smileposition_2_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 55%;"></div>
                <div id="smileposition_3_{PLAYER_ID}" class="smileposition" style="top: 10.4%; left: 58.7%;"></div>

                <div id="happyposition_0_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 49.7%;"></div>
                <div id="happyposition_1_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 52.8%;"></div>
                <div id="happyposition_2_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 56%;"></div>
                <div id="happyposition_3_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 59.2%;"></div>

                <div id="angryposition_0_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 35.8%;"></div>
                <div id="angryposition_1_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 38.9%;"></div>
                <div id="angryposition_2_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 42.1%;"></div>
                <div id="angryposition_3_{PLAYER_ID}" class="smileposition" style="top: 26.2%; left: 45.2%;"></div>

                <div id="bonusjournee_1_{PLAYER_ID}" class="bonusjournee" style="top: 5.5%; left: 7.25%;"></div>
                <div id="bonusjournee_2_{PLAYER_ID}" class="bonusjournee" style="top: 5.5%; left: 16.5%;"></div>
                <div id="bonusjournee_3_{PLAYER_ID}" class="bonusjournee" style="top: 5.5%; left: 25.7%;"></div>

                <div id="bonusjournee_1_1_{PLAYER_ID}" class="bonusjournee1" style="top: 22%; left: 6.5%;"></div>
                <div id="bonusjournee_2_1_{PLAYER_ID}" class="bonusjournee2" style="top: 16.8%; left: 14.1%;"></div>
                <div id="bonusjournee_2_2_{PLAYER_ID}" class="bonusjournee2" style="top: 30.1%; left: 14.1%;"></div>
                <div id="bonusjournee_3_1_{PLAYER_ID}" class="bonusjournee2" style="top: 16.4%; left: 23.3%;"></div>
                <div id="bonusjournee_3_2_{PLAYER_ID}" class="bonusjournee2" style="top: 30.1%; left: 23.3%;"></div>

                <div id="tokenjourposition_1_{PLAYER_ID}" class="tokenjourposition" style="top: 85.5%; left: 1.2%;"></div>
                <div id="tokenjourposition_2_{PLAYER_ID}" class="tokenjourposition" style="top: 85.5%; left: 16.4%;"></div>
                <div id="tokenjourposition_3_{PLAYER_ID}" class="tokenjourposition" style="top: 85.5%; left: 33.3%;"></div>
                <div id="tokenjourposition_4_{PLAYER_ID}" class="tokenjourposition" style="top: 85.5%; left: 50.5%;"></div>
                <div id="tokenjourposition_5_{PLAYER_ID}" class="tokenjourposition" style="top: 85.5%; left: 66.7%;"></div>
                <div id="tokenjourposition_6_{PLAYER_ID}" class="tokenjourposition" style="top: 85.5%; left: 83.8%;"></div>

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

                <div class="cardtokyodiscard" style="top: 7%; left: 77.4%;"></div>
                <div class="cardkyotodiscard" style="top: 7%; left: 91.5%;"></div>

                <div id="compteurcardtokyodiscard_{PLAYER_ID}" class="compteurdiscard" style="top: 34.7%; left: 82.3%;"></div>
                <div id="compteurcardkyotodiscard_{PLAYER_ID}" class="compteurdiscard" style="top: 34.7%; left: 90.3%;"></div>

                <div id="marqueurposition_0_1_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 0.5%;"></div>
                <div id="marqueurposition_0_2_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 5.5%;"></div>
                <div id="marqueurposition_0_3_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 0.5%;"></div>
                <div id="marqueurposition_0_4_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 5.5%;"></div>
                <div id="marqueurposition_0_5_{PLAYER_ID}"class="marqueurposition" style="top: 54.1%; left: 3%;"></div>

                <div id="marqueurposition_1_1_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 11.1%;"></div>
                <div id="marqueurposition_1_2_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 16.1%;"></div>
                <div id="marqueurposition_1_3_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 11.1%;"></div>
                <div id="marqueurposition_1_4_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 16.1%;"></div>
                <div id="marqueurposition_1_5_{PLAYER_ID}"class="marqueurposition" style="top: 54.1%; left: 13.6%;"></div>

                <div id="marqueurposition_2_1_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 20.6%;"></div>
                <div id="marqueurposition_2_2_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 25.6%;"></div>
                <div id="marqueurposition_2_3_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 20.6%;"></div>
                <div id="marqueurposition_2_4_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 25.6%;"></div>
                <div id="marqueurposition_2_5_{PLAYER_ID}"class="marqueurposition" style="top: 54.1%; left: 23.1%;"></div>

                <div id="marqueurposition_3_1_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 29.9%;"></div>
                <div id="marqueurposition_3_2_{PLAYER_ID}"class="marqueurposition" style="top: 47.7%; left: 34.9%;"></div>
                <div id="marqueurposition_3_3_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 29.9%;"></div>
                <div id="marqueurposition_3_4_{PLAYER_ID}"class="marqueurposition" style="top: 59.8%; left: 34.9%;"></div>
                <div id="marqueurposition_3_5_{PLAYER_ID}"class="marqueurposition" style="top: 54.1%; left: 32.4%;"></div>

                <div id="marqueurposition_4_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 39.3%;"></div>
                <div id="marqueurposition_4_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 42.3%;"></div>
                <div id="marqueurposition_4_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 41.2%;"></div>
                <div id="marqueurposition_4_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 41.2%;"></div>
                <div id="marqueurposition_4_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 42.3%;"></div>

                <div id="marqueurposition_5_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 46.2%;"></div>
                <div id="marqueurposition_5_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 49.3%;"></div>
                <div id="marqueurposition_5_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 48.1%;"></div>
                <div id="marqueurposition_5_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 49.1%;"></div>
                <div id="marqueurposition_5_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 49.3%;"></div>

                <div id="marqueurposition_6_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 52.9%;"></div> 
                <div id="marqueurposition_6_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 56%;"></div>
                <div id="marqueurposition_6_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 54.8%;"></div>
                <div id="marqueurposition_6_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 55.8%;"></div>
                <div id="marqueurposition_6_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 56%;"></div>

                <div id="marqueurposition_7_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 59.8%;"></div>
                <div id="marqueurposition_7_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 62.9%;"></div>
                <div id="marqueurposition_7_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 61.7%;"></div>
                <div id="marqueurposition_7_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 62.7%;"></div>
                <div id="marqueurposition_7_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 62.9%;"></div>

                <div id="marqueurposition_8_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 66.6%;"></div>
                <div id="marqueurposition_8_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 69.7%;"></div>
                <div id="marqueurposition_8_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 68.5%;"></div>
                <div id="marqueurposition_8_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 69.5%;"></div>
                <div id="marqueurposition_8_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 69.7%;"></div>

                <div id="marqueurposition_9_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 73.3%;"></div>
                <div id="marqueurposition_9_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 76.4%;"></div>
                <div id="marqueurposition_9_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 75.2%;"></div>
                <div id="marqueurposition_9_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 76.2%;"></div>
                <div id="marqueurposition_9_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 76.4%;"></div>

                <div id="marqueurposition_10_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 80.1%;"></div>
                <div id="marqueurposition_10_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 83.2%;"></div>
                <div id="marqueurposition_10_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 82%;"></div>
                <div id="marqueurposition_10_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 83%;"></div>
                <div id="marqueurposition_10_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 83.2%;"></div>

                <div id="marqueurposition_11_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 86.9%;"></div>
                <div id="marqueurposition_11_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 90%;"></div>
                <div id="marqueurposition_11_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 88.8%;"></div>
                <div id="marqueurposition_11_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 89.8%;"></div>
                <div id="marqueurposition_11_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 90%;"></div>

                <div id="marqueurposition_12_1_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 93.8%;"></div>
                <div id="marqueurposition_12_2_{PLAYER_ID}"class="marqueurposition" style="top: 59.1%; left: 96.1%;"></div>
                <div id="marqueurposition_12_3_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 95%;"></div>
                <div id="marqueurposition_12_4_{PLAYER_ID}"class="marqueurposition" style="top: 53.9%; left: 96.1%;"></div>
                <div id="marqueurposition_12_5_{PLAYER_ID}"class="marqueurposition" style="top: 66.3%; left: 96.2%;"></div>

                



            </div>
        </div>
        <!-- END player -->
    
</div>





<script type="text/javascript">

var jstpl_titre='<div id="titre"></div>';
var jstpl_eye='<div id="eye_${id}" class="eye" style="display: inline-block;"></div>';
var jstpl_tokenjour='<div id="tokenjour_${jour}" class="tokenjour" style="background-position-x: ${x}%;"></div>';
var jstpl_smile='<div id="smile_${id}" class="smile" style="background-color: #${color}"></div>';
var jstpl_happy='<div id="happy_${id}" class="happy"></div>';
var jstpl_angry='<div id="angry_${id}" class="angry"></div>';
var jstpl_card='<div id="card_${ville}_${id}" class="card" style="background-image: url(${imgfull}); background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_cardverso='<div id="card_${ville}_${id}" class="cardverso" style="background-image: url(${imgfull}); background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_turn='<div id="turn" class="turn"></div>';

var jstpl_player_compteurs = '<div class="player_compteurs" id="player_compteurs_${id}" style="display: flex; align-items: center; flex-direction: column; justify-content: center; z-index: 100; position: relative;">\
<div id="icons_player_compteurs_${id}" style="text-align: center; align-items: center; display: flex; margin-top: 10px; margin-bottom: 5px;">\
<div id="iconrecherche_${id}" class="iconrecherchepannel" style="display: inline-block; margin-right: 5px;"></div>\
<div id="nbrerecherche_${id}" class="nbrerecherche" style="display: inline-block; margin-right: 10px;"></div>\
<div id="icontrainstart_${id}" class="icontrainstartpannel" style="display: inline-block; margin-right: 5px;"></div>\
<div id="nbretrainstart_${id}" class="nbretrainstart" style="display: inline-block; margin-right: 10px;"></div>\
<div id="icontrain_${id}" class="icontrainpannel" style="display: inline-block; margin-right: 5px;"></div>\
<div id="nbretrain_${id}" class="nbretrain" style="display: inline-block; margin-right: 10px;"></div>\
<div id="iconwild_${id}" class="iconwildpannel" style="display: inline-block; margin-right: 5px;"></div>\
<div id="nbrewild_${id}" class="nbrewild" style="display: inline-block; margin-right: 0px;"></div>\
</div>\
</div>';

var jstpl_finaltokyo='<div class="finaltokyo">T</div>';
var jstpl_finalkyoto='<div class="finalkyoto">K</div>';
var jstpl_finalwalk='<div class="finalwalk"></div>';
var jstpl_train='<div class="train_${id}"></div>';

var jstpl_check='<div id="check_${ville}_${id}" class="check_${type}"></div>';

var jstpl_marqueur='<div id="marqueur_${type}_${id}" class="marqueur" style="background-position-x: ${x}%;"></div>';

var jstpl_tokyo1tool='<div class="tokyo1tool" style="background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_tokyo2tool='<div class="tokyo2tool" style="background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_kyoto1tool='<div class="kyoto1tool" style="background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_kyoto2tool='<div class="kyoto2tool" style="background-position-x: ${x}%; background-position-y: ${y}%;"></div>';
var jstpl_tokyowalktool='<div class="tokyowalktool"></div>';
var jstpl_kyotowalktool='<div class="kyotowalktool"></div>';
var jstpl_kyotowalktool='<div class="kyotowalktool"></div>';
var jstpl_infotool='<div class="infotexttoolt"><div style="text-align: center;">${text}</div></div>';

</script>  

{OVERALL_GAME_FOOTER}
