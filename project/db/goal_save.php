<?php
    $goal_name = $_POST['goal_name'];
    $term = $_POST['term'];
    if($term = "term_sel"){
        $term_s_date = $_POST['term_s_date'];
        $term_e_date = $_POST['term_e_date'];
    }
    for($i=0; $i < 1; $i++) {
        $name = "routine_name".$i;
        $weak = "routine".$i;
        $routine_name[$i] = $_POST[$name];
        $repeats = $_POST[$weak];

    echo $goal_name.", ".$term_s_date.", ".$term_e_date.", ".$routine_name[$i].", ";
    foreach($repeats as $repeat){
        echo $repeat.", ";
    }
    }
?>