<?php
    $tbox=$rad=$drop=$sun_url=$sun_json=$sun_array=$output=$num="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["tebo"])) 
            $tbox = $_POST["tebo"];
        if (!empty($_POST["SH"])) 
            $rad = $_POST["SH"];
        if (!empty($_POST["selop"])) 
            $drop = $_POST["selop"];
        
        $sun_url = 'http://congress.api.sunlightfoundation.com/'.$drop.'?chamber='.$rad.'&state='.$tbox.'&apikey=725651676ce9425d9cea2e39d3c2dc88';
        $sun_json = file_get_contents($sun_url);
        $sun_array = json_decode($sun_json,true);
        $num = (int)$sun_array['count'];
        if(!$num)
            $output = "The API returned zero results for the request";
        else
            $output = "<table border=1><tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
    }
        
?>
<!DOCTYPE HTML>
<html>
    <meta http-equiv="content-type" content="text/html; charset=windows-1252">
    <head>
        <title>Forecast</title>
        <style>
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
                height: 110px;
            }
            #r {
                float: right;
                width: 150px;
                height: 110px;
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
                            <select id="cv" onchange="updatefunc()" name="selop">
                                <option selected disabled value="Sel">Select your option</option>
                                <option value="legislators">Legislators</option> 
                                <option value="committees">Committees</option>
                                <option value="bills">Bills</option>
                                <option value="amendments">Amendments</option>
                            </select>
                            <input type="radio" name="SH" checked="checked" value="senate">Senate  <input type="radio" name="SH" value="house">House
                            <input type="text" id="tb" name="tebo" value="<?php echo isset($_POST['tebo']) ? $_POST['tebo'] : '' ?>">
                            <input type="submit" value="Search" onclick="validate()">
                            <input type="button" onclick="myFunction()" value="Clear">
                        </form>
                    </center>
                </div>
                <a href="http://sunlightfoundation.com/">Powered by Sunlight Foundation</a>
            </div>
            <?php
                error_reporting(E_ERROR | E_PARSE);
                foreach($sun_array['results'] as $result) {
                    $output.="<tr><td>".$result['first_name']." ".$result['last_name']."</td><td>".$result['state_name']."</td><td>".$result['chamber']."</td><td>View Details</td></tr>";
                }
                $output.="</table>";
                echo $output;
            ?>
        </center>
    </body>
</html>