<?php
session_start();

if(!$_SESSION["a"]){
    $a = rand(1,50);
    $b = rand(1,50);
     $_SESSION["a"] = $a;
    $_SESSION["b"] = $b;  
}

$email = '';
$message = '';
$name ='';
$result ='';
$error ='';

if(isset($_POST['submit'])){
      // echo '<h1>Submit Clicked !!!! '.$_POST['submit'].'</h1>';
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $check = intval($_POST['secCheck']);
    
        if(!$_POST['name']){ $error .= 'Please enter your name! <br>'; }
        if(!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ $error .= 'Please enter your email! <br>'; }
        if(!$_POST['message']){ $error .= 'Please enter a message! <br>'; }
        if($check !== ($_SESSION["a"] + $_SESSION["b"])){ $error .= 'Wrong AntiSpam value <br>'; }  
 

if($error == ''){
    $from = '';
    $to =   ''; // email that you want to receive the email to. YOUR ADDRESS
    $subject = 'Message from contact form';
    $body = "From: $name ($email) \n Message \n $message";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <'.$from.'>' . "\r\n";  
    if(mail($to,$subject,$body,$headers)){
     $result = '<div class="alert alert-success">Mail Sent</div>';  
        }else{
               $result = '<div class="alert alert-success">Mail wasn\'t sent</div>';    
        }
    $email = '';
    $message = '';
    $name ='';
    
    // Send email
} else {
    $result = '<div class="alert alert-danger">Error Found:<br>'.$error.'</div>';
}
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Contact form</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            .text-danger {
                display:none;
            }
 
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <form method="post" action="index.php" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" value="<?php echo $name;?>">
                            <p class="text-danger">You need to enter a name value</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" id="email" name="email" placeholder="your@email.com" class="form-control" value="<?php echo $email;?>">
                            <p class="text-danger">You need to enter a valid email</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-10">
                            <textarea id="message" name="message" rows="4" class="form-control"><?php echo $message;?></textarea>
                            <p class="text-danger">You need to enter a message</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="secCheck" class="col-sm-2 control-label">
                            <?php echo $_SESSION["a"]  . ' + ' .$_SESSION["b"] ; ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="secCheck" name="secCheck" class="form-control">
                            <p class="text-danger">Answer the question above</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <input type="submit" value="Send" class="btn btn-primary btn-large btn-block" id="submit" name="submit">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <?php echo $result; ?>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>
            $('form').on('submit',function(){
                $(".text-danger").hide();
                var holderValue = false;
                $(this).find('input[type!="hidden"]').each(function(){
                    if(!$(this).val()){holderValue =true; $(this).parent().find(".text-danger").show();}
                })
                 if(!$("#message").val()  ){holderValue =true; $("#message").parent().find(".text-danger").show();};
     
                //event.preventDefault();
               /// console.log($('#message').val() );
                
            })
        </script>
    </body>

    </html>