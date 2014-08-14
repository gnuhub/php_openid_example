<?php
require 'vendor/autoload.php';
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
    OpenID: <input type="hidden" name="openid_identifier" value="gnuhub.pip.verisignlabs.com" /> <button>Submit</button>
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
	print_r($openid->getAttributes());
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}