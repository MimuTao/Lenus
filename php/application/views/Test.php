<!DOCTYPE html>
<head>
    <title>The Page of Post</title>
</head>
<body>
    <h3>Input the Message That U want to send.</h3>
    <form method="post" action =<?php echo base_url().'index.php/api' ?>>
        
        <lable>POST Data Input:</lable> <input type="text" name="data"/></br>
        <input type="submit" value="Send">
        
    </form>
</body>