<?php
if (isset($_GET['page'])) {
    $link2 = "";
    $link =$_SERVER['REQUEST_URI'];
    $pos = strpos( $link ,  'page=');
    if (!$pos){
        $pos =  strpos( $link ,  '?');
        if (!$pos)
            $link1 = $link .'?page=';
        else{
            $link1 = substr($link , 0 , $pos).'?page=';
            $coun = 1;
            $char = $link[$pos];
            while (is_numeric($char))
                $coun++;
            $link2 = '&'.substr($link , $pos +$coun  );
        }

    }else{
        $link1 = substr($link , 0 , $pos+5);
        $coun = 1;
        $char = $link[$pos];
        while (is_numeric($char))
            $coun++;
        $link2 = substr($link , $pos+6+$coun );
    }
    ?>
<div class="d-block pt-5-5 m-auto" style="width: fit-content;padding-top: 30px;" >
<ul class=" text-center pagination">
    <?php
    if ($_GET['page'] > 1){ ?>
        <li class="page-item"><a class="page-link" href="<?= $link1.($_GET['page']- 1).$link2 ?>">Previous</a></li>
    <?php }

    if ($_GET['page'] < 6)
        $start = 1 ;
    else { $start =  $_GET['page'] - 3 ?>
        <li class="page-item  "><a class="page-link"  href="<?= $link1.'1'.$link2 ?>">1</a></li>
        <li class="page-item"><a class="page-link" href="">.....</a></li>
    <?php }
    $end = $start + 5 > $_GET['totalpages'] ?  $_GET['totalpages'] : $start + 5   ;
    for ($i = $start ; $end >= $i ;$i++){ ?>
        <li class="page-item <?= $i == $_GET['page'] ? ' active ' : '' ?> "><a class="page-link"  href="<?= $link1.$i.$link2 ?>"><?=$i ?> </a></li>
    <?php  }
    if ( ( $_GET['totalpages'] - $_GET['page'] ) > 3 ){  ?>
        <li class="page-item"><a class="page-link" href="">....</a></li>
        <li class="page-item"><a class="page-link" href="<?= $link1. $_GET['totalpages'] .$link2 ?>"><?= $_GET['totalpages'] ?></a></li>
    <?php }
    if ($_GET['page'] != $_GET['totalpages'] ){  ?>
        <li class="page-item"><a class="page-link" href="<?= $link1.($_GET['page'] + 1).$link2 ?>">Next</a></li>
    <?php } ?>
</ul>

<?php }
?>

</div>