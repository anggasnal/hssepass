<?php
                error_reporting(E_ALL ^ E_NOTICE);
                $script_dir          = '/filemanager/'; // IF IN ROOT leave like this: '/'  if in root/files   then    '/files/'
                $upload_dir          = '/filemanager/uploads/'; //NOTE: TRAILING FORWARD SLASHES! FULL PATH to current folder relative to root, DON'T FORGET TO SET permissions for this folder to 777 on UNIX servers.
                $upload_notify_email = 'admin@admin.com'; //email for notifications of new file upload.

                $db_host = '192.168.104.29'; //hostname
                $db_user = 'usrhsse'; // username
                $db_password = 'pgn.Hs53'; // password
                $db_name = 'hssepass'; //database name

                $db_pr = 'afm_'; //database prefix

                $md5_salt = '14c09ac988c8147e60b1cbc245bc6661';

                $demo        = false;
//                 @$mysqli = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
                @$mysqli = @mysqli_connect($db_host, $db_user, $db_password, $db_name, '3307');

                if (!$mysqli) {
                    header("Location:install.php");
                    exit();
                }
              ?>
