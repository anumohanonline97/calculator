<!--view file for calculator and showing the last five calculations-->

<html>
<head>
    <title>Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
        <div class="col-md-12">
            <div id="message"></div>
        </div>

      <!--Calculator section-->  
    <div class="row">     
        <div class="col-md-6" style="border-right:2px solid #eee;">
            <h3 style="text-align:center;">Calculator</h3>
            <div class="col-md-6" style="margin-left:150px;">
            <input class="form-control" type="text" name="expression" id="expression" placeholder="Eg:(3+2)*6"/>
            <br/>
            <input class="border-0" type="text" id="answer"/>
            <div class="clearfix"></div>
            <button class="btn btn-primary" onclick="calculate_fn()">Calculate</button>
            <button class="btn btn-primary" onclick="reset_fn()">Reset</button>
            <!-- <button class="btn btn-success" onclick="save_fn()">Save</button> -->
            </div>
        </div>
<!--End-->
<!--Last 5 calculations display section-->

        <div class="col-md-6">
            <h3 style="text-align:center;">Last 5 calculations</h3>
            <div class="table-responsive" id="display_details">
            
            </div>
        </div>
    </div>   
<!--End-->
    <br> 
<!--saving calculation section-->
    <div class="row">
    <div class="card" style="width: 30%;padding: 10px;margin-left:150px;display:none;" id="save_details">
    <div class="card-body">
        <h5 class="card-title"><input class="border-0" type="text" id="save_exp" name="save_exp"/></h5>=
        <h5 class="card-title"><input class="border-0" type="text" id="save_answer" name="save_answer"/></h5>
    <button class="btn btn-success" onclick="save_fn()">Save</button>
  </div>
    </div>
    </div>  
<!--End--> 
</div>

<!--Scripting section-->
<script>
//on the page loading last 5 calculations will be shown.
    $(document).ready(function(){
        display();
    })
    
    //Ajax function for calculating mathematical expression entered in the textbox
    function calculate_fn(){
        //REgular expression for testing whether entered string is a mathematical expression or not.
        const re = /(\d+)(?:\s*)([\+\-\*\/])(?:\s*)(\d+)/;
        var exp= $('#expression').val();
        if(re.test(exp)){
            $.ajax({
                url:"calculate_exp",
                method:"POST",
                data:{exp:exp},
                dataType:"JSON",
                success:function(data)
                {
                    $('#answer').val('Answer: '+data.answer);
                    $('#save_details').css("display", "block");
                    $('#save_exp').val(exp);
                    $('#save_answer').val(data.answer);  
                }
            })
        } else{
            $('#message').addClass("alert alert-danger");
            $('#message').html("Enter a mathematical expression");
            $('#save_details').css("display", "none");
            $('#answer').val('');
        }
}


//Ajax function for saving mathematical expression into database
function save_fn(){
        var exp= $('#save_exp').val();
        var ans= $('#save_answer').val();
        
        $.ajax({
                url:"calculate_save",
                method:"POST",
                data:{exp:exp,ans:ans},
                dataType:"JSON",
                success:function(data)
                {
                    if(data){
                      display();
                    }
            }
            })
    }

//Function for displaying calculations
function display()
{
    $.ajax({
                            url:"display_details",
                            dataType:"JSON",
                            success:function(d)
                            {  
                                $('#display_details').html(d);
                                $('#save_details').css("display", "none");
                                $('#answer').val('');
                                $('#expression').val('');
                            }
                    })
}
   
//Function for reseting the window
function reset_fn()
{
    location.reload();
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>