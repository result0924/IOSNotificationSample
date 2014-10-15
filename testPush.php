    <?php

        // $deviceToken = 'b6511c20210e54188399d5675c63f62a75a02ac1aec4944aab2f65511a93ddbec';
    $deviceToken = '5f2bccd13672df1d967b3c8da226cfabd2c4050647a636f482b1f32e952b6430';
        // 把PEM檔的密碼打在這:
        //$passphrase = '';
        
        // 訊息:
        $message = mb_substr('testPush!',0,50,"UTF-8");
        //echo $message;
	//exit();
        $pem = 'pushcert.pem';

        
        ////////////////////////////////////////////////////////////////////////////////
        
        $ctx = stream_context_create();
        //stream_context_set_option($ctx, 'ssl', 'local_cert', 'CertKey.pem');
        stream_context_set_option($ctx, 'ssl', 'local_cert', $pem);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        
        // Open a connection to the APNS server

        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);                    

        /*
        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
         */
        
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        echo '<br>'.date("Y-m-d H:i:s").' Connected to APNS' . PHP_EOL;
       


                $fp = stream_socket_client(
                    'ssl://gateway.sandbox.push.apple.com:2195', $err,
                    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);                    
                
                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);

                echo '<br>'.date("Y-m-d H:i:s").' Connected to APNS' . PHP_EOL;

	    // Create the payload body
            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default'
                );
            // Encode the payload as JSON
            $payload = json_encode($body);
            //echo $deviceToken;

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            
            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));
            
            // We can check if an error has been returned while we are sending, but we also need to 
            // check once more after we are done sending in case there was a delay with error response.
            // if (!$result)
            //     echo 'Message not delivered' . PHP_EOL;
            // else
            //     echo 'Message successfully delivered' . PHP_EOL;
            if (!$result) {
                echo '<br>'.date("Y-m-d H:i:s").' Message not delivered' . PHP_EOL;  
                fclose($fp);
                sleep(1);

                $fp = stream_socket_client(
                    'ssl://gateway.push.apple.com:2195', $err,
                    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);                    
                
                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);

                echo '<br>'.$deviceToken.' - '.date("Y-m-d H:i:s").' Connected to APNS' . PHP_EOL;

            } else {
                echo '<br>'.$deviceToken.'<br>'.date("Y-m-d H:i:s").' Message successfully delivered' . PHP_EOL;
            }
            
        //}

        // Close the connection to the server
        fclose($fp);
        echo '<br>'.date("Y-m-d H:i:s").' Connection closed to APNS' . PHP_EOL;
    ?>