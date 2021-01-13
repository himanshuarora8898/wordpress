<?php
function enqueue_scripts(){


    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_shoppingcart-admin.js', array( 'jquery' ), $this->version, false );
}
?>

<?php get_header(); ?>
<div id='display_product_list'>
    <form method='POST'>
        <table class='text-center'>
            <tr>
                <th>Product-Name</th>
                <th>Product</th>
                <th>Product-Discription</th>
                <th>Product-Price</th>
                <th>Action</th>
            </tr>

            <tr>
                <td><?php the_title('<h4> <a href=' . get_permalink() . '>' | '</a> </h4>'); ?></td>
                <td><?php the_post_thumbnail(); ?></td>
                <td><?php the_content(); ?></td>
                <td>
                    <?php
                        $dprice = get_post_meta(get_the_ID() , 'Dis_Pricing_Key', 1);
                        $price = get_post_meta(get_the_ID() , 'Pricing_Key', 1);
                        if ($dprice > 0)
                        {
                            echo '$'.$dprice;
                            echo '<input type="hidden" name="dprice" value="'.$dprice.'">';
                        }
                        else
                        {
                            echo '$'.$price;
                            echo '<input type="hidden" name="price" value="'.$price.'">';
                        }
                        ?>
                </td>
                <td> <input type='submit' name='add' id='' value='Add To Cart'> </td>
            </tr>
        </table>
        <form>
</div>

<?php get_footer(); ?>

<?php
if(isset($_POST['add'])){
    $pname=get_the_title();
    $pimage=get_the_post_thumbnail();
    $pdiscrip=get_the_content();
    $Dprice=$_POST['dprice'];
    $rprice=isset($_POST['price']);
    $meta_id=get_current_user_id();
    $prodId=get_the_ID();
    $quantity=1;
    
    $meta_val=array('Id'=>$prodId,
    'Name'=>$pname,
    'Image'=>$pimage,
    'Discription'=>$pdiscrip,
    'DPrice'=>$dprice,
    'OPrice'=>$price,
    'Quantity'=>$quantity
    );
    
    if(isset($_SESSION['cartdata'][$prodId]) && !empty($_SESSION['cartdata'][$prodId])){
        
        $Qty =$_SESSION['cartdata'][$prodId]['Quantity']+1;
        $_SESSION['cartdata'][$prodId]=array('Id' => $prodId, 'Name'=>$pname, 'Image'=>$pimage, 'Discription'=>$pdiscrip, 'DPrice'=>$dprice,'OPrice'=>$price, 'Quantity'=>$Qty);
    }
    else{
        $_SESSION['cartdata'][$prodId]=$meta_val;
    }

    if(is_user_logged_in()){
        if(isset($_SESSION['cartdata'])){
            // echo $meta_id;
            echo "<pre>";
            print_r($_SESSION['cartdata']);
            // update_user_meta($meta_id,'Cart-Data',$_SESSION['cartdata']);
        }
        // $meta_val_arr[] = $meta_val;
        // print_r($meta_val_arr);
        // update_user_meta($user_id,'Cart_Data',$meta_val_arr);
        $meta_key=array();
        $meta_key=get_user_meta($meta_id,'Cart-Data',true);
        if( empty( $meta_key ) || !is_array($meta_key) )
        {
            $meta_key = array();
        }
        if(isset($meta_key[$prodId]) && !empty($meta_key[$prodId])){
        
            $Qty =intval($meta_key[$prodId]['Quantity'])+1;
            $meta_key[$prodId]=array('Id' => $prodId, 'Name'=>$pname, 'Image'=>$pimage, 'Discription'=>$pdiscrip, 'DPrice'=>$dprice,'OPrice'=>$price, 'Quantity'=>$Qty);
        }
        else{
            $meta_key[$prodId]=$meta_val;
        }


        
    
    update_user_meta($meta_id,'Cart-Data',$meta_key);
    }
    
}


// session_destroy();
?>