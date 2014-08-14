<?php
require 'vendor/autoload.php';

function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

try {
    # Change 'localhost:8080' to your domain name.
    $openid = new LightOpenID('localhost:8080');
    if(!$openid->mode) {
        if(isset($_POST['openid_identifier'])) {
            $openid->identity = $_POST['openid_identifier'];
            # The following two lines request email, full name, and a nickname
            # from the provider. Remove them if you don't need that data.
            $openid->required = array('contact/email');
            $openid->optional = array('namePerson', 'namePerson/friendly');
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="" method="post">
    <!--
    test gnuhub.pip.verisignlabs.com
    OpenID: <input type="hidden" name="openid_identifier" value="gnuhub.pip.verisignlabs.com" /> <button>Submit</button>
    test ibm openid
    OpenID: <input type="hidden" name="openid_identifier" value="https://w3-wisit.toronto.ca.ibm.com/FIM/openidsso" /> <button>Submit</button>
    input openid_identifier
    OpenID: <input type="text" name="openid_identifier" /> <button>Submit</button>
    -->
    <input type="hidden" name="openid_identifier" value="gnuhub.pip.verisignlabs.com" /> <button>Login with OpenID</button>
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
	dump($openid->getAttributes());
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}