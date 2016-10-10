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
                'Legislators' : 'State/Representative*',
                'Committees' : 'Committee ID*',
                'Bills' : 'Bill ID*',
                'Amendments' : 'Amendment ID*'
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
                        alert("Peace");
                        return false;
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
                        <form method="post" name="myform" id="f">
                            <select id="cv" onchange="updatefunc()" name="selop">
                                <option selected disabled value="Sel">Select your option</option>
                                <option value="Legislators">Legislators</option> 
                                <option value="Committees">Committees</option>
                                <option value="Bills">Bills</option>
                                <option value="Amendments">Amendments</option>
                            </select>
                            <input type="radio" name="SH" checked="checked">Senate  <input type="radio" name="SH">House
                            <input type="text" id="tb" name="tebo">
                            <input type="button" value="Search" onclick="validate()">
                            <input type="button" onclick="myFunction()" value="Clear">
                        </form>
                    </center>
                </div>
                <a href="http://sunlightfoundation.com/">Powered by Sunlight Foundation</a>
            </div>
            
        </center>
    </body>
</html>