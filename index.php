<?php
require_once 'gitConfig.php';
require_once 'User.class.php';
$user = new User();

$loginURL = $gitClient->getAuthorizeURL($_SESSION['state']);
if(isset($_SESSION['access_token'])){

    // it help to get user profile
    $gitUser = $gitClient->apiRequest($_SESSION['access_token']);
    if(!empty($gitUser)){

        $gitUserData = array();
        $gitUserData['oauth_provider'] = 'github';
        $gitUserData['oauth_uid'] = !empty($gitUser->id)?$gitUser->id:'';
        $gitUserData['name'] = !empty($gitUser->name)?$gitUser->name:'';
        $gitUserData['username'] = !empty($gitUser->login)?$gitUser->login:'';
        $gitUserData['email'] = !empty($gitUser->email)?$gitUser->email:'';
        $gitUserData['location'] = !empty($gitUser->location)?$gitUser->location:'';
        $gitUserData['picture'] = !empty($gitUser->avatar_url)?$gitUser->avatar_url:'';
        $gitUserData['link'] = !empty($gitUser->html_url)?$gitUser->html_url:'';
        // it used for insert or update
        $userData = $user->checkUser($gitUserData);
        $_SESSION['userData'] = $userData;
        $output  = '<h2>Github Profile Details</h2>';
        $output .= '<img src="'.$userData['picture'].'" />';
        $output .= '<p>ID: '.$userData['oauth_uid'].'</p>';
        $output .= '<p>Name: '.$userData['name'].'</p>';
        $output .= '<p>Login Username: '.$userData['username'].'</p>';
        $output .= '<p>Email: '.$userData['email'].'</p>';
        $output .= '<p>Location: '.$userData['location'].'</p>';
        $output .= '<p>Profile Link :  <a href="'.$userData['link'].'" target="_blank">Click to visit GitHub page</a></p>';
        $output .= '<p>Logout from <a href="logout.php">GitHub</a></p>'; 
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
    
}else if(isset($_GET['code'])){


    // if(!$_GET['state'] || $_SESSION['state'] != $_GET['state']) {
    //     header("Location:".$_SERVER['PHP_SELF']);
    // }


   
    $accessToken = $gitClient->getAccessToken($_GET['state'], $_GET['code']);
    $_SESSION['access_token']= $accessToken;

  
    header('Location: ./');
}else{
    $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);

    unset($_SESSION['access_token']);

  


    $output = '<a class="btn btn-primary" href="'.htmlspecialchars($loginURL).'"><i class="fa fa-github"></i> Continue with github  </a>';
}
?>
<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"  prefix="og: http://ogp.me/ns#" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login with with Github</title>
	
	<link rel="shortcut icon" href="https://learncodeweb.com/demo/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131906273-1"></script>
</head>

<body>
 <div class="d-flex justify-content-center py5" style="background:#000;">
        <h5 class="text-white">IREMBO | Practical CAT</h5>
    </div>
	<div class="container">
    	<div class="row d-flex justify-content-center align-items-center" style="height:90vh;">
			<div class="col-sm-12 col-md-4 m-auto">
				<div class="border p-5 mb-5">
					<form method="post">
						<div class="form-group1" style="width: 10vh">
							
							<strong class="connect">Connect to Irembo</strong>
						</div>
						<div class="form-group">
							<a href="<?php echo htmlspecialchars($loginURL); ?>" class="btn btn-block btn-dark text-white" style="background:#000; color:white;"><i class="fab fa-github-square"></i> Continue With Github</a>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div> 
	

	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    
</body>


<style type="text/css">
    .connect{
        margin-left: 50px;
        position: absolute;
    }
    .form-group1{
        height: 250px;
        width: 200px;
    }
</style>