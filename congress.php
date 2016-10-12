<?php
    ini_set('session.cache_limiter','public');
    session_cache_limiter(false);
    $tbox=$rad=$drop=$sun_url=$sun_json=$sun_array=$num=$res="";
    $output="<br> <br>";
    error_reporting(E_ERROR | E_PARSE);
    session_start();

    
        if (!empty($_POST["tebo"])) {
            $tbox = $_POST["tebo"];
            if (!empty($_POST["SH"])) {
                $rad = $_POST["SH"];
                if (!empty($_POST["selop"])) { 
                    $drop = $_POST["selop"];
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $_SESSION['drop1']=$drop;
                    $_SESSION['rad1']=$rad;
                    $_SESSION['tbox1']=$tbox;
                    $sun_url = 'http://congress.api.sunlightfoundation.com/'.$drop.'?chamber='.$rad.'&state='.$tbox.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                    $sun_json = file_get_contents($sun_url);
                    $sun_array = json_decode($sun_json,true);
                    $_SESSION['url1']=$sun_array;
                    $num = (int)$sun_array['count'];
                    if(!$num)
                        $output .= "The API returned zero results for the request";
                    else
                        $output .= "<table border=1 cellpadding=\"5\"><tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                }
            }
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <meta http-equiv="content-type" content="text/html; charset=windows-1252">
    <head>
        <title>Forecast</title>
        <style>
            table, td, th {
                
                border-collapse: collapse;
                width: 1000px;
                text-align: center;
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
            
            var statecode {
                'AL' : 'Alabama', 'MT' : 'Montana', 
                'AK' : 'Alaska', 'NE' : 'Nebraska', 
                'AZ' : 'Arizona', 'NV' : 'Nevada', 
                'AR' : 'Arkansas', 'NH' : 'New Hampshire',
                'CA' : 'California', 'NJ' : 'New Jersey', 
                'CO' : 'Colorado', 'NM' : 'New Mexico', 
                'CT' : 'Connecticut', 'NY' : 'New York',
                'DE' : 'Delaware', 'NC' : 'North Carolina', 
                'DC' : 'District Of Columbia', 'ND' : 'North Dakota', 
                'FL' : 'Florida', 'OH' : 'Ohio', 
                'GA' : 'Georgia', 'OK' : 'Oklahoma', 
                'HI' : 'Hawaii', 'OR' : 'Oregon', 
                'ID' : 'Idaho', 'PA' : 'Pennsylvania', 
                'IL' : 'Illinois', 'RI' : 'Rhode Island', 
                'IN' : 'Indiana', 'SC' : 'South Carolina', 
                'IA' : 'Iowa', 'SD' : 'South Dakota', 
                'KS' : 'Kansas', 'TN' : 'Tennessee', 
                'KY' : 'Kentucky', 'TX' : 'Texas', 
                'LA' : 'Louisiana', 'UT' : 'Utah',
                'ME' : 'Maine', 'VT' : 'Vermont', 
                'MD' : 'Maryland', 'VA' : 'Virginia', 
                'MA' : 'Massachusetts', 'WA' : 'Washington', 
                'MI' : 'Michigan', 'WV' : 'West Virginia', 
                'MN' : 'Minnesota', 'WI' : 'Wisconsin', 
                'MS' : 'Mississippi', 'WY' : 'Wyoming', 
                'MO' : 'Missouri',   
            }
            
            function myFunction() {
                document.getElementById("f").reset();
                document.getElementById("vc").innerHTML = changes['Sel'];                
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
                        return false;
                    }
                    else {
                        alert(msg);
                        return false;
                    }
                }
                else {
                    if (y == null || y == "") {
                        msg += "Keyword";
                        alert(msg);
                        return false;
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
                        <span id="vc">Keyword*</span> <br>
                    </center>
                </div>
                <div id="r">
                    <center>
                        <form method="post" name="myform" id="f" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <select id="cv" onchange="updatefunc()" name="selop" >
                                <option selected disabled value="Sel">Select your option</option>
                                <option value="legislators" <?php echo ($drop=="legislators")?'selected':'' ?>>Legislators</option> 
                                <option value="committees" <?php echo ($drop=="committees")?'selected':'' ?>>Committees</option>
                                <option value="bills" <?php echo ($drop=="bills")?'selected':'' ?>>Bills</option>
                                <option value="amendments" <?php echo ($drop=="amendments")?'selected':'' ?>>Amendments</option>
                            </select>
                            <label><input type="radio" name="SH" checked="checked" value="senate" <?php echo ($rad=="senate")?'checked':'' ?>>Senate</label>  <label><input type="radio" name="SH" value="house" <?php echo ($rad=="house")?'checked':'' ?>>House</label>
                            <input type="text" id="tb" name="tebo" value="<?php if(isset($_POST['tebo'])) { echo htmlentities ($_POST['tebo']); }?>">
                            <input type="submit" value="Search" onclick="validate()">
                            <input type="button" onclick="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" value="Clear">
                        </form>
                    </center>
                </div>
                <a href="http://sunlightfoundation.com/">Powered by Sunlight Foundation</a>
            </div>
            <?php
                $tbox=$rad=$drop=$sun_url=$sun_json=$sun_array=$num=$res="";
    $output="<br> <br>";
    error_reporting(E_ERROR | E_PARSE);
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["tebo"])) {
            $tbox = $_POST["tebo"];
            if (!empty($_POST["SH"])) {
                $rad = $_POST["SH"];
                if (!empty($_POST["selop"])) { 
                    $drop = $_POST["selop"];
                    $_SESSION['drop1']=$drop;
                    $_SESSION['rad1']=$rad;
                    $_SESSION['tbox1']=$tbox;
                    $sun_url = 'http://congress.api.sunlightfoundation.com/'.$drop.'?chamber='.$rad.'&state='.$tbox.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
                    $sun_json = file_get_contents($sun_url);
                    $sun_array = json_decode($sun_json,true);
                    $_SESSION['url1']=$sun_array;
                    $num = (int)$sun_array['count'];
                    if(!$num)
                        $output .= "The API returned zero results for the request";
                    else
                        $output .= "<table border=1 cellpadding=\"5\"><tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                    
                    foreach($sun_array['results'] as $result) {
                    $output.="<tr><td>".$result['first_name']." ".$result['last_name']."</td><td>".$result['state_name']."</td><td>".$result['chamber']."</td><td><a href=congress.php?resul=".$result['bioguide_id'].">View Details</a></td></tr>";
                }
                $output.="</table><br> <br>";
                echo $output;
                }
            }
        }
    }
    else {
        //a href=\"\" onclick=\"<?php echo htmlspecialchars(\$_SERVER[\"PHP_SELF\"]);?
        //$drop=$_SESSION['drop1'];
        //$rad=$_SESSION['rad1'];
        //$tbox=$_SESSION['tbox1'];
        $sun_array=$_SESSION['url1'];
        $res = $_GET['resul'];
        echo $outpost;
        foreach($sun_array['results'] as $result) {
            if($result['bioguide_id']==$res) {
                $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                $output .= "<table border=0 cellpadding=\"5\"><tr><td>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td>".$result['website']."</td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td><a href=\"https://www.facebook.com/".result['facebook_id']."\">".$result['first_name']." ".$result['last_name']."</a></td></tr><tr><td>Twitter</td><td>".$result['twitter_id']."</td></tr></table><br></div><br> <br>";
            }
        }
        echo $output;
        
    }
        
                
            ?>
        </center>
    </body>
</html>