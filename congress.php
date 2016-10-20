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
    $tbox=$rad=$drop=$sun_url=$sun_json=$sun_array=$num=$res=$dets=$clear=$tbo=$cha="";
    $output="<br>";

    error_reporting(E_ERROR | E_PARSE);
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['kill'])) {
            $_SESSION['drop1']="";
            $_SESSION['rad1']="";
            $_SESSION['tbox1']="";
        }
        
        else if($_POST["new"]) {
            
            $rad=$_SESSION['rad1'];
            $tbox=$statecode[$_POST['new'][1]];        
            $bio=$_POST['new'][0];
            $sun_url = 'http://congress.api.sunlightfoundation.com/legislators?chamber='.$rad.'&state='.$tbox.'&bioguide_id='.$bio.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
            $sun_json = file_get_contents($sun_url);
            $dets = json_decode($sun_json,true);
            foreach($dets['results'] as $result) {
                if($result['bioguide_id']==$bio) {
                    if($result['facebook_id']=="") {
                        if($result['twitter_id']=="") {
                            if($result['website']=="") {
                                $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                                $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td>N/A</td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td>N/A</td></tr><tr><td>Twitter</td><td>N/A</td></tr></table><br></div><br> <br>";
                            }
                            else {
                                $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                                $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td><a href=\"".$result['website']."\" target=\"_blank\">".$result['website']."</a></td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td>N/A</td></tr><tr><td>Twitter</td><td>N/A</td></tr></table><br></div><br> <br>";
                            }
                        }
                        else if($result['website']=="") {
                            $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                            $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td>N/A</td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td>N/A</td></tr><tr><td>Twitter</td><td><a href=\"https://twitter.com/".$result['twitter_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr></table><br></div><br> <br>";
                        }
                        else {
                            $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                            $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td><a href=\"".$result['website']."\" target=\"_blank\">".$result['website']."</a></td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td>N/A</td></tr><tr><td>Twitter</td><td><a href=\"https://twitter.com/".$result['twitter_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr></table><br></div><br> <br>";
                        }
                    }
                    else if($result['twitter_id']=="") {
                        if($result['website']=="") {
                            $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                            $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td>N/A</td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td><a href=\"https://www.facebook.com/".$result['facebook_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr><tr><td>Twitter</td><td>N/A</td></tr></table><br></div><br> <br>";
                        }
                        else {
                            $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                            $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td><a href=\"".$result['website']."\" target=\"_blank\">".$result['website']."</a></td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td><a href=\"https://www.facebook.com/".$result['facebook_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr><tr><td>Twitter</td><td>N/A</td></tr></table><br></div><br> <br>";
                        }
                    }
                    else if($result['website']=="") {
                        $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                        $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td>N/A</td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td><a href=\"https://www.facebook.com/".$result['facebook_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr><tr><td>Twitter</td><td><a href=\"https://twitter.com/".$result['twitter_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr></table><br></div><br> <br>";
                    }
                    else {
                        $output .= "<div id=\"box\"><br><img src=\"https://theunitedstates.io/images/congress/225x275/".$result['bioguide_id'].".jpg\"> <br>";
                        $output .= "<table id=\"tab2\"border=0 ><tr><td width=90px>Full Name</td><td>".$result['title']." ".$result['first_name']." ".$result['last_name']."</td></tr><tr><td>Term Ends on</td><td>".$result['term_end']."</td></tr><tr><td>Website</td><td><a href=\"".$result['website']."\" target=\"_blank\">".$result['website']."</a></td></tr><tr><td>Office</td><td>".$result['office']."</td></tr><tr><td>Facebook</td><td><a href=\"https://www.facebook.com/".$result['facebook_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr><tr><td>Twitter</td><td><a href=\"https://twitter.com/".$result['twitter_id']."\" target=\"_blank\">".$result['first_name']." ".$result['last_name']."</a></td></tr></table><br></div><br> <br>";
                    }
                    $ran="";
                }
            }
        }
        else if($_POST["newb"]) {
            $res = $_POST['newb'];
            $rad=$_SESSION['rad1'];
            $tbox=$_SESSION['tbox1'];
            if($res==$tbox) {
                $dets = $_SESSION['url1'];
                foreach($dets['results'] as $result) {
                    if($result['bill_id']==$res) {
                        $output .= "<div id=\"box\"><br><table id=\"tab3\"border=0 ><tr><td width=300px>Bill ID</td><td>".$result['bill_id']."</td></tr><tr><td>Bill Title</td><td>".$result['short_title']."</td></tr><tr><td>Sponsor</td><td>".$result['sponsor']['title']." ".$result['sponsor']['first_name']." ".$result['sponsor']['last_name']."</td></tr><tr><td>Introduced On</td><td>".$result['introduced_on']."</td></tr><tr><td>Last action with date</td><td>".$result['last_version']['version_name']." ".$result['last_action_at']."</td></tr><tr><td>Bill URL</td><td><a href=\"".$result['last_version']['urls']['pdf']."\" target=\"_blank\">".$result['short_title']."</td></tr></table><br></div><br> <br>";
                        $ran="";
                    }
                }
            }
        }
        else {
            if (!empty($_POST["tebo"])) {
                $tbox = trim($_POST["tebo"]);
                if (!empty($_POST["SH"])) {
                    $rad = $_POST["SH"];
                    if (!empty($_POST["selop"])) { 
                        $drop = $_POST["selop"];
                            
                        $ran="";
                        if(strlen($statecode[ucfirst(strtolower($tbox))])==0) {
                            $names = explode(" ", $tbox);
                            if(count($names) >= 2)
                            {
                                $first_name = ucfirst(array_shift($names));
                                $last_name = ucfirst(array_shift($names));
                                foreach ($names as $n)  
                                    $last_name = $last_name." ".ucfirst(array_shift($names)); 
                                $tebox=$last_name;
                            }
                            else {
                                $tebox=$tbox;
                            }   
                            $sun_url = "http://congress.api.sunlightfoundation.com/legislators?chamber=".$rad;
                            if(isset($first_name))
                                $sun_url = $sun_url."&first_name=".$first_name;
                            if(isset($last_name))
                                $sun_url  = $sun_url."&last_name=".urlencode($last_name);
                            if(isset($tebox))
                                $sun_url = $sun_url."&query=".urlencode($tebox);
                            $sun_url = $sun_url."&apikey=725651676ce9425d9cea2e39d3c2dc88";  
                        }
                        
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
                                $output .= "<form method=\"post\" action=congress.php id=\"f2\"><input type=\"hidden\" value=\" \" name=\"new[]\" id='selected_bioguideID' ><input type=\"hidden\" value=\"".$tbox."\" name=\"new[]\" ></form><table id=\"tab1\" border=1 ><tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                        
                            foreach($sun_array['results'] as $result) {
                                $output.="<tr><td id=\"tdleft\">".$result['first_name']." ".$result['last_name']."</td><td>".$result['state_name']."</td><td>".$result['chamber']."</td><td><a href='#' onclick='submitForm(this)'>View Details<input type='hidden' value='".$result['bioguide_id']."'/></a></td></tr>";
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
                                $output .= "<table id=\"tabx\" border=1 ><tr><th>Committee ID</th><th>Committee Name</th><th>Chamber</th>";
                        
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
                                $output .= "<table id=\"tabx\" border=1 ><tr><th>Bill ID</th><th>Short Title</th><th>Chamber</th><th>Details</th>";
                        
                            foreach($sun_array['results'] as $result) {
                                $output.="<tr><td>".$result['bill_id']."</td><td>".$result['short_title']."</td><td>".$result['chamber']."</td><td><form method=\"post\" action=congress.php id=\"f3\"><input type=\"hidden\" value=".$result['bill_id']." name=\"newb\" ><a href='#' onclick='submitForm2()'>View Details</a></form></td></tr>";
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
                                $output .= "<table id=\"tabx\" border=1 ><tr><th>Amendment ID</th><th>Amendment Type</th><th>Chamber</th><th>Introduced On</th>";
                        
                            foreach($sun_array['results'] as $result) {
                                $output.="<tr><td>".$result['amendment_id']."</td><td>".$result['amendment_type']."</td><td>".$result['chamber']."</td><td>".$result['introduced_on']."</td></tr>";
                            }
                            $output.="</table><br> <br>";
                        }
                    }
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
            #tab1 {
                border-collapse: collapse;
                width: 1000px;
                text-align: center;
            }
            #tab1 td:first-child {
                text-align: left;
                padding-left: 95px;
                width: 250px;
            }
            #tabx {
                border-collapse: collapse;
                width: 1000px;
                text-align: center;
            }
            #tab1 td {
                text-align: center;
            }
            #tab2 {
                width: 600px;
            }
            #tab3 {
                width: 550px;
            }
            #tab2 td {
                padding-left: 100px;
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
                width: 800px;
            }
            #butt { 
                background: none;
                border: none;
                color: blue;
                text-decoration: underline;
                cursor: pointer; 
            }
        </style>
        <script>
            function submitForm(e) {
                var myForm = document.getElementById('f2');
                document.getElementById("selected_bioguideID").value = e.childNodes[1].value;
                myForm.submit();
            }
            function submitForm2() {
                document.getElementById("f3").submit();
            }
            var changes = {
                'Sel' : 'Keyword*',
                'legislators' : 'State/Representative*',
                'committees' : 'Committee ID*',
                'bills' : 'Bill ID*',
                'amendments' : 'Amendment ID*'
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
                        return true;
                    }
                }
            }
        </script>
    </head>
    <body>
        <center>
            <h2>Congress Information Search</h2>
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
                        <form method="post" name="myform" id="f" action="congress.php">
                            <select id="cv" onchange="updatefunc()" name="selop" >
                                <option selected disabled value="Sel">Select your option</option>
                                <option value="legislators" <?php $drop=$_SESSION['drop1']; echo ($drop=="legislators")?'selected':'' ?>>Legislators</option> 
                                <option value="committees" <?php $drop=$_SESSION['drop1']; echo ($drop=="committees")?'selected':'' ?>>Committees</option>
                                <option value="bills" <?php $drop=$_SESSION['drop1']; echo ($drop=="bills")?'selected':'' ?>>Bills</option>
                                <option value="amendments" <?php $drop=$_SESSION['drop1']; echo ($drop=="amendments")?'selected':'' ?>>Amendments</option>
                            </select>
                            <label><input type="radio" name="SH" checked="checked" value="senate" <?php $rad=$_SESSION['rad1']; echo ($rad=="senate")?'checked':'' ?>>Senate</label>  <label><input type="radio" name="SH" value="house" <?php $rad=$_SESSION['rad1']; echo ($rad=="house")?'checked':'' ?>>House</label>
                            <input type="text" id="tb" name="tebo" value="<?php $tbox=$_SESSION['tbox1']; echo $tbox; ?>">
                            <input type="submit" value="Search" onclick="return validate()" name="keep">
                            <input type="submit" onclick="myFunction()" value="Clear" name="kill" >
                        </form>
                    </center>
                </div>
                <a href="http://sunlightfoundation.com/" target="_blank">Powered by Sunlight Foundation</a>
            </div>
            <?php
                echo $output;
                $output="";
            ?>
        </center>
    </body>
</html>
                        