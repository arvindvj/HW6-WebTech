<?php
    ini_set('session.cache_limiter','public');
    session_cache_limiter(false);

    $statecode=array(
                'Alabama' => 'AL', 'Montana' => 'MT', 
                'Alaska' => 'AK', 'Nebraska' => 'NE', 
                'Arizona' => 'AZ', 'Nevada' => 'NV', 
                'Arkansas' => 'AR', 'New Hampshire' => 'NH',
                'California' => 'CA', 'New Jersey' => 'NJ', 
                'Colorado' => 'CO', 'New Mexico' => 'NM', 
                'Connecticut' => 'CT', 'New York' => 'NY',
                'Delaware' => 'DE', 'North Carolina' => 'NC', 
                'District Of Columbia' => 'DC', 'North Dakota' => 'ND', 
                'Florida' => 'FL', 'Ohio' => 'OH', 
                'Georgia' => 'GA', 'Oklahoma' => 'OK', 
                'Hawaii' => 'HI', 'Oregon' => 'OR', 
                'Idaho' => 'ID', 'Pennsylvania' => 'PA', 
                'Illinois' => 'IL', 'Rhode Island' => 'RI', 
                'Indiana' => 'IN', 'South Carolina' => 'SC', 
                'Iowa' => 'IA', 'South Dakota' => 'SD', 
                'Kansas' => 'KS', 'Tennessee' => 'TN', 
                'Kentucky' => 'KY', 'Texas' => 'TX', 
                'Louisiana' => 'LA', 'Utah' => 'UT',
                'Maine' => 'ME', 'Vermont' => 'VT', 
                'Maryland' => 'MD', 'Virginia' => 'VA', 
                'Massachusetts' => 'MA', 'Washington' => 'WA', 
                'Michigan' => 'MI', 'West Virginia' => 'WV', 
                'Minnesota' => 'MN', 'Wisconsin' => 'WI', 
                'Mississippi' => 'MS', 'Wyoming' => 'WY', 
                'Missouri' => 'MO'   );

    $change = array(
                'Sel' => 'Keyword*',
                'legislators' => 'State/Representative*',
                'committees' => 'Committee ID*',
                'bills' => 'Bill ID*',
                'amendments' => 'Amendment ID*'
            );
    
    $ran=$change['Sel'];
    //$_SESSION['change1']=$ran;
    //$ran=$_SESSION['change1'];
    //echo $ran;
    $tbox=$rad=$drop=$sun_url=$sun_json=$sun_array=$num=$res=$dets=$clear=$tbo=$cha="";
    $output="<br> <br>";

    //$clear=$_GET['clear'];
    //if($clear=='clear')
    //    session_destroy();

    

    error_reporting(E_ERROR | E_PARSE);
    session_start();

    if (!empty($_POST["tebo"])) {
        $tbox = $_POST["tebo"];
        if (!empty($_POST["SH"])) {
            $rad = $_POST["SH"];
            if (!empty($_POST["selop"])) { 
                $drop = $_POST["selop"];
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    $ran="";
                    if(strlen($statecode[ucfirst(strtolower($tbox))])==0)
                        $sun_url = 'http://congress.api.sunlightfoundation.com/legislators?chamber='.$rad.'&query='.$tbox.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                    else {
                        if(strlen($tbox)>2) {
                            $tbo = $statecode[ucfirst(strtolower($tbox))];
                        }
                        $sun_url = 'http://congress.api.sunlightfoundation.com/legislators?chamber='.$rad.'&state='.$tbo.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                    }
                    
                    $_SESSION['change1']=$change[$drop];
                    $_SESSION['drop1']=$drop;
                    $_SESSION['rad1']=$rad;
                    $_SESSION['tbox1']=$tbox;
                    
                    if($drop == "legislators") {
                        
                        $sun_json = file_get_contents($sun_url);
                        $sun_array = json_decode($sun_json,true);
                        $_SESSION['url1']=$sun_array;
                        $num = (int)$sun_array['count'];
                        if(!$num)
                            $output .= "The API returned zero results for the request";
                        else
                            $output .= "<table id=\"tab1\" border=1 cellpadding=\"5\"><tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                        
                        foreach($sun_array['results'] as $result) {
                            $output.="<tr><td>".$result['first_name']." ".$result['last_name']."</td><td>".$result['state_name']."</td><td>".$result['chamber']."</td><td><a href=new.php?resul=".$result['bioguide_id']."&sta=".$result[$statecode['state_name']].">View Details</a></td></tr>";
                        }
                        $output.="</table><br> <br>";
                    }
                    
                    if($drop == "committees") {
                        $sun_url = 'http://congress.api.sunlightfoundation.com/committees?committee_id='.$tbox.'&chamber='.$rad.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                        $sun_json = file_get_contents($sun_url);
                        $sun_array = json_decode($sun_json,true);
                        $_SESSION['url1']=$sun_array;
                        $num = (int)$sun_array['count'];
                        if(!$num)
                            $output .= "The API returned zero results for the request";
                        else
                            $output .= "<table id=\"tab1\" border=1 cellpadding=\"5\"><tr><th>Committee ID</th><th>Committee Name</th><th>Chamber</th>";
                        
                        foreach($sun_array['results'] as $result) {
                            $output.="<tr><td>".$result['committee_id']."</td><td>".$result['name']."</td><td>".$result['chamber']."</td></tr>";
                        }
                        $output.="</table><br> <br>";
                    }
                    
                    if($drop == "bills") {
                        $sun_url = 'http://congress.api.sunlightfoundation.com/bills?bill_id='.$tbox.'&chamber='.$rad.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                        $sun_json = file_get_contents($sun_url);
                        $sun_array = json_decode($sun_json,true);
                        $_SESSION['url1']=$sun_array;
                        $num = (int)$sun_array['count'];
                        if(!$num)
                            $output .= "The API returned zero results for the request";
                        else
                            $output .= "<table id=\"tab1\" border=1 cellpadding=\"5\"><tr><th>Bill ID</th><th>Short Title</th><th>Chamber</th><th>Details</th>";
                        
                        foreach($sun_array['results'] as $result) {
                            $output.="<tr><td>".$result['bill_id']."</td><td>".$result['short_title']."</td><td>".$result['chamber']."</td><td><a href=new.php?resul=".$result['bill_id'].">View Details</a></td></tr>";
                        }
                        $output.="</table><br> <br>";
                    }
                    
                    if($drop == "amendments") {
                        $sun_url = 'http://congress.api.sunlightfoundation.com/amendments?amendment_id='.$tbox.'&chamber='.$rad.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                        $sun_json = file_get_contents($sun_url);
                        $sun_array = json_decode($sun_json,true);
                        $_SESSION['url1']=$sun_array;
                        $num = (int)$sun_array['count'];
                        if(!$num)
                            $output .= "The API returned zero results for the request";
                        else
                            $output .= "<table id=\"tab1\" border=1 cellpadding=\"5\"><tr><th>Amendment ID</th><th>Amendment Type</th><th>Chamber</th><th>Introduced On</th>";
                        
                        foreach($sun_array['results'] as $result) {
                            $output.="<tr><td>".$result['amendment_id']."</td><td>".$result['amendment_type']."</td><td>".$result['chamber']."</td><td>".$result['introduced_on']."</td></tr>";
                        }
                        $output.="</table><br> <br>";
                    }
                }
            }
        }
    }
    else {
        
        $res = $_GET['resul'];
        $rad=$_SESSION['rad1'];
        $tbox=$_SESSION['tbox1'];
        if($res==$tbox) {
            $dets = $_SESSION['url1'];
            foreach($dets['results'] as $result) {
                if($result['bill_id']==$res) {
                    $output .= "<div id=\"box\"><br><table id=\"tab2\"border=0 cellpadding=\"5\"><tr><td width=300px>Bill ID</td><td>".$result['bill_id']."</td></tr><tr><td>Bill Title</td><td>".$result['short_title']."</td></tr><tr><td>Sponsor</td><td>".$result['sponsor']['title']." ".$result['sponsor']['first_name']." ".$result['sponsor']['last_name']."</td></tr><tr><td>Introduced On</td><td>".$result['introduced_on']."</td></tr><tr><td>Last action with date</td><td>".$result['last_version']['version_name']." ".$result['last_action_at']."</td></tr><tr><td>Bill URL</td><td><a href=\"".$result['last_version']['urls']['pdf']."\" target=\"_blank\">".$result['short_title']."</td></tr></table><br></div><br> <br>";
                    $ran="";
                }
            }
        }
        else {
            
            $tbox=$_GET['sta'];
            $sun_url = 'http://congress.api.sunlightfoundation.com/legislators?chamber='.$rad.'&state='.$tbox.'&bioguide_id='.$res.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
            $sun_json = file_get_contents($sun_url);
            $dets = json_decode($sun_json,true);
            foreach($dets['results'] as $result) {
                if($result['bioguide_id']==$res) {
                    $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                    $output .= "<table id=\"tab2\"border=0 cellpadding=\"5\"><tr><td width=250px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td><a href=\"".$result['website']."\" target=\"_blank\">".$result['website']."</a></td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td><a href=\"https://www.facebook.com/".$result['facebook_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr><tr><td>Twitter</td><td><a href=\"https://twitter.com/".$result['twitter_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr></table><br></div><br> <br>";
                    $ran="";
                }
            }
        }
        //$_SESSION['drop1']="";
        //$_SESSION['rad1']="";
        //$_SESSION['tbox1']="";
    }

?>
<!DOCTYPE HTML>
<html>
    <meta http-equiv="content-type" content="text/html; charset=windows-1252">
    <head>
        <title>Forecast</title>
        <style>
            #tab1 {
                border-collapse: collapse;
                width: 1000px;
                text-align: center;
            }
            #tab2 {
                width: 550px;
                
                
            }
            body {
                line-height: 150%;
            }
            #tb {
                width: 130px;
            }
            #maintab {
                border-style: groove;
                width: 300px;
                height: auto;
            }
            #l {
                float: left;
                width: 150px;
                height: 100px;
            }
            #r {
                float: right;
                width: 150px;
                height: 100px;
            }
            #box {
                border: 1px solid;
                width: 1000px;
            }
        </style>
        <script>
            var changes = {
                'Sel' : 'Keyword*',
                'legislators' : 'State/Representative*',
                'committees' : 'Committee ID*',
                'bills' : 'Bill ID*',
                'amendments' : 'Amendment ID*'
            }
            function updatefunc() {
                var inputBox = document.getElementById("cv");
                var selectedOption = inputBox.options[inputBox.selectedIndex].value;
                document.getElementById("vc").innerHTML = changes[selectedOption];
            }
            function validate() {
                var msg = "Please enter the following missing information : ";
                var x = document.forms["myform"]["selop"].value;
                var y = document.forms["myform"]["tebo"].value;
                if (x == "Sel") {
                    msg += "Congress Database";
                    if (y == null || y == "") {
                        msg += ", Keyword";
                        alert(msg);
                        return true;
                    }
                    else {
                        alert(msg);
                        return true;
                    }
                }
                else {
                    if (y == null || y == "") {
                        msg += "Keyword";
                        alert(msg);
                        return true;
                    }
                    else {
                        return;
                    }
                }
            }
        </script>
    </head>
    <body>
        <center>
            <h1>Congress Information Search</h1>
            <div id="maintab">
                <div id="l">
                    <center>
                        Congress Database <br>
                        Chamber <br>
                        <label id="vc" value="Keyword*"><?php if($ran==""){$cha=$_SESSION['change1']; echo $cha;} else echo $ran;?></label> <br>
                    </center>
                </div>
                <div id="r">
                    <center>
                        <form method="post" name="myform" id="f" action="new.php">
                            <select id="cv" onchange="updatefunc()" name="selop" >
                                <option selected disabled value="Sel">Select your option</option>
                                <option value="legislators" <?php $drop=$_SESSION['drop1']; echo ($drop=="legislators")?'selected':'' ?>>Legislators</option> 
                                <option value="committees" <?php $drop=$_SESSION['drop1']; echo ($drop=="committees")?'selected':'' ?>>Committees</option>
                                <option value="bills" <?php $drop=$_SESSION['drop1']; echo ($drop=="bills")?'selected':'' ?>>Bills</option>
                                <option value="amendments" <?php $drop=$_SESSION['drop1']; echo ($drop=="amendments")?'selected':'' ?>>Amendments</option>
                            </select>
                            <label><input type="radio" name="SH" checked="checked" value="senate" <?php $rad=$_SESSION['rad1']; echo ($rad=="senate")?'checked':'' ?>>Senate</label>  <label><input type="radio" name="SH" value="house" <?php $rad=$_SESSION['rad1']; echo ($rad=="house")?'checked':'' ?>>House</label>
                            <input type="text" id="tb" name="tebo" value="<?php $tbox=$_SESSION['tbox1']; echo $tbox; ?>">
                            <input type="submit" value="Search" onclick="validate()">
                            <input type="button" onclick="new.php" value="Clear"  >
                        </form>
                    </center>
                </div>
                <a href="http://sunlightfoundation.com/" target="_blank">Powered by Sunlight Foundation</a>
            </div>
            <?php
                echo $output;
            ?>
        </center>
    </body>
</html>
                        