<?php
/**
 * Template Name: Player Cards v2
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
 
<main id="site-content" role="main">
<div id="content">


<?php

$url = "https://spreadsheets.google.com/feeds/list/1PDjpBknCu5WzNBvDuJFTaO0Xf5bm23iYd6O2CSWacmU/1/public/values?alt=json";
$json = file_get_contents($url);
$data = json_decode($json, TRUE);


echo '<h1>';
if (!empty($_GET['team'])) {echo $_GET['team'];} else {echo $_GET['league'];};
echo ' Team Cards</h1>';
  //var_dump($data['feed']['entry']);
  //shows basic array and starting point of json data
         
//create array to store, clubs and leagues
$clubs=array(); 
$leagues=array(); 
//loop for each into array - need to do for each loop to get into next layer of array
foreach ($data['feed']['entry'] as $item) 
{
$clubs[]=  $item['gsx$clubs']['$t'];
$leagues[]=  $item['gsx$league']['$t'];

}
//take array and get unique clubs and leagues
$clubs =array_unique($clubs);
$leagues =array_unique($leagues);

if (empty($_GET['league'])) 
  { 
        echo '<ul class="php-ul">';
        //print out unique clubs in drop down menu lis
        foreach ($leagues as $key => $league)
        {
       echo "<a href='?league=".$league."'><div class ='php-button'>".$league." Card Stats</div></a>";
        }

        echo //end of dropdown class
        //echo <input type="hidden" name="action" value="rateThisThing" /> this can add other things to the url
      '</ul>
        ';

  }

elseif ( !empty($_GET['league']) && empty($_GET['team']))

{ 


          //name league
               $selected_league =  $_GET[ 'league'];


                //var_dump($data);
                $data_league_filtered=array_filter($data['feed']['entry'],function($var) use ($selected_league){

                  return($var['gsx$league']['$t']==$selected_league);
                });
                

                            //create array to store, clubs and leagues
            $clubs_by_league=array(); 
            //loop for each into array - need to do for each loop to get into next layer of array
            foreach ($data_league_filtered as $item) 
            {
            $clubs_by_league[]=  $item['gsx$clubs']['$t'];
            }
            //take array and get unique clubs and leagues
            $clubs_by_league =array_unique($clubs_by_league);

echo '<div class="options-contaner"><div class="dropdown">
                <form action="/player-cards">
    <input type="submit" value="Pick different league" />
</form></div>';
                 echo '<div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select a team
            <span class="caret"></span></button>
            <ul class="dropdown-menu">';
            //print out unique clubs in drop down menu lis
            foreach ($clubs_by_league as $key => $club) 
            {
   
           echo "<li><a href='?league=".$selected_league."&team=".$club."'>".$club."</a></li>";

            }
              echo //end of dropdown class
              ' </ul>
                </div>';


                  //  echo '<pre>';
                 //print_r($data_league_filtered); //have a look at the filter league data
                //echo '</pre>';

               /* $final = json_encode($data_league_filtered);
                echo $final;*/ // view data as json for easier reading

                //var_dump($data_league_team_filtered);
                    //var_dump($data2);

                 /*echo '<table class="table-rag">

                <tr>
                <td>Likes a card</td>
                <td class="table-rag-cell table-green">
                </tr>
                 <tr>
                <td>Doesnt mind a card</td>
                <td class="table-rag-cell table-orange"></td>
                  </tr>
                  <tr>
                <td>Doesnt get a lot of cards</td>
                <td class="table-rag-cell table-red">
                 </tr>
                </table>';*/
                echo'</div>';

                echo '<div class="scroll">';
                echo '<table> <th>Players</th><th>Club</th><th>Cards</th><th>Minutes</th><th>Minutes per card</th>
                <th class="table-mob-expand">1st Half</th>
                <th class="table-mob-expand">2nd Half</th>
                <th class="table-mob-expand">Home</th>
                <th class="table-mob-expand">Away</th>';
                foreach ($data_league_filtered as $text) 
                {
                    echo '<tr>';
                    echo  '<td>' . $text['gsx$players']['$t']  . '</td>'; 
                    echo '<td>' . $text['gsx$clubs']['$t']  . '</td>'; 
                
                    echo '<td>' . $text['gsx$cards']['$t']. '</td>'; 
                    echo '<td>' . $text['gsx$min.']['$t']. '</td>'; 
                    echo '<td class=table-'.$text['gsx$cardspergamerag']['$t'].'>' . $text['gsx$minutescards']['$t']. '</td>'; 
                   
                    echo  '<td class="table-mob-expand">' . $text['gsx$fh']['$t']  . '</td>'; 
                    echo  '<td class="table-mob-expand">' . $text['gsx$sh']['$t']  . '</td>'; 
                    echo  '<td class="table-mob-expand">' . $text['gsx$h']['$t']  . '</td>'; 
                    echo  '<td class="table-mob-expand">' . $text['gsx$a']['$t']  . '</td>'; 




                        // echo '<td class='.$text['gsx$cardspergamerag']['$t'].'>'.$text['gsx$cardspergame']['$t'].'</td>';
                       //example of concantation working

                 };
                echo '</tr></table></div>';

}


elseif  ( !empty($_GET['league']))  {

          //name league
               $selected_league =  $_GET[ 'league'];
               $selected_team =  $_GET[ 'team'];

                //var_dump($data);
                $data_league_filtered=array_filter($data['feed']['entry'],function($var) use ($selected_team){

                  return($var['gsx$clubs']['$t']==$selected_team);
                });
                                 //create array to store, clubs and leagues
            $clubs_by_league=array(); 
            //loop for each into array - need to do for each loop to get into next layer of array
            foreach ($data_league_filtered as $item) 
            {
            $clubs_by_league[]=  $item['gsx$clubs']['$t'];
            }
            //take array and get unique clubs and leagues
            $clubs_by_league =array_unique($clubs_by_league);

echo '
<div class="options-contaner"><div class="dropdown">
                <form action="/player-cards">
    <input type="submit" value="Pick different league" />
</form></div>';

                 echo '<div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select a team
            <span class="caret"></span></button>
            <ul class="dropdown-menu">';
            //print out unique clubs in drop down menu lis
            foreach ($clubs_by_league as $key => $club) 
            {
   
           echo "<li><a href='?league=".$selected_league."&team=".$club."'>".$club."</a></li>";

            }
              echo //end of dropdown class
              ' </ul>
                </div>';


                  //  echo '<pre>';
                 //print_r($data_league_filtered); //have a look at the filter league data
                //echo '</pre>';

               /* $final = json_encode($data_league_filtered);
                echo $final;*/ // view data as json for easier reading

                //var_dump($data_league_team_filtered);
                    //var_dump($data2);

                /*echo '<table class="table-rag">

                <tr>
                <td>Likes a card</td>
                <td class="table-rag-cell table-green">
                </tr>
                 <tr>
                <td>Doesnt mind a card</td>
                <td class="table-rag-cell table-orange"></td>
                  </tr>
                  <tr>
                <td>Doesnt get a lot of cards</td>
                <td class="table-rag-cell table-red">
                 </tr>
                </table>'; */
               echo '</div>';
           echo '<div class="scroll">';
                   echo '<table> <th>Players</th><th>Club</th><th>Cards</th><th>Minutes</th><th>Minutes per card</th>
                <th class="table-mob-expand">1st Half</th>
                <th class="table-mob-expand">2nd Half</th>
                <th class="table-mob-expand">Home</th>
                <th class="table-mob-expand">Away</th>';
                foreach ($data_league_filtered as $text) 
                {
                 echo '<tr>';
                    echo  '<td>' . $text['gsx$players']['$t']  . '</td>'; 
                    echo '<td>' . $text['gsx$clubs']['$t']  . '</td>'; 
                
                    echo '<td>' . $text['gsx$cards']['$t']. '</td>'; 
                    echo '<td>' . $text['gsx$min.']['$t']. '</td>'; 
                    echo '<td class=table-'.$text['gsx$cardspergamerag']['$t'].'>' . $text['gsx$minutescards']['$t']. '</td>'; 
                   
                    echo  '<td class="table-mob-expand">' . $text['gsx$fh']['$t']  . '</td>'; 
                    echo  '<td class="table-mob-expand">' . $text['gsx$sh']['$t']  . '</td>'; 
                    echo  '<td class="table-mob-expand">' . $text['gsx$h']['$t']  . '</td>'; 
                    echo  '<td class="table-mob-expand">' . $text['gsx$a']['$t']  . '</td>'; 





                        // echo '<td class='.$text['gsx$cardspergamerag']['$t'].'>'.$text['gsx$cardspergame']['$t'].'</td>';
                       //example of concantation working

                 };
                echo '</tr></table></div>';


}


?>
</div>
</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
