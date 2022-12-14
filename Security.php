<?php
/**
 * Created By :    
 * User: Welly
 * Date: 08/02/2017
 * Time: 15.41
 */
    


    session_start();

    if(!isset($_SESSION['ujilogin']))
    {
        echo"
                <script>
                    alert('Anda tidak memiliki hak akses\\nSilahkan login terlebih dahulu!!');
                    location.href = 'Login.php';
                </script>
            ";
    }