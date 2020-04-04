<?php
        include('connect.php');
        $date1 = new DateTime("now");
        $query = "SELECT * FROM `promotions` WHERE `code` = '" . $_POST['id'] . "'";
        if($result = mysqli_query($connect, $query))
        {
            if (mysqli_num_rows($result)==0)
            {
                echo '0';
            }
            else
            {
                $result1 = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if($result1['count'] >= 0 AND $result1['expireDate'] >= date('Y-m-d'))
                {
                    echo $result1['discount'];
                }
                else
                {
                    echo '0';
                }
            }
        }
        else
        {
            echo '0';
        }
?>