
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<style>

  #block_error{
      width: 845px;
      height: 384px;
      border: 1px solid #cccccc;
      margin: 72px auto 0;
      -moz-border-radius: 4px;
      -webkit-border-radius: 4px;
      border-radius: 4px;
      background: #fff url(<?php echo base_url(); ?>public_html/uploads/block.gif) no-repeat 0 51px;
  }
  #block_error div{
      padding: 100px 40px 0 186px;
  }
  #block_error div h1{
      color: red;
      font-size: 24px;
      display: block;
      padding: 0 0 14px 0;
      border-bottom: 1px solid #cccccc;
      margin-bottom: 12px;
      font-weight: normal;
  }</style>
	</head>
<body marginwidth="0" marginheight="0">
    <div id="block_error">
        <div>
         <h1><?php echo $head ?? '';?></h1>
        <p>
        <?php echo $body ??  '';?>
        </p>
        </div>
    </div>
</body>

</html>