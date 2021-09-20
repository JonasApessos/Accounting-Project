<?php
function HTMLLogedIn(ME_CLogHandle &$InrLogHandle)
{
	if(isset($_SESSION['UserName']))
	{
		//Employee name
		printf("
		<div class='loged-in'>
			<div>
				<div><h2>Welcome</h2></div>
				<div><h4>%s</h4></div>
			</div>
			<div class='button-right'>
				<a href='.?Logout'><h4>Logout</h4></a>
			</div>
		</div>",
		(!empty($_SESSION['UserName']) ? $_SESSION['UserName'] : "No Name"));
	}
	else
		$InrLogHandle->AddLogMessage("Session username not declared", __FILE__, __FUNCTION__, __LINE__);
}

function HTMLLoginForm()
{
	print("
	<div class='login'>
		<form method='POST'>
			<div id='Title'><h4>Login</h4></div>
			<div><label>Email<input type='email' name='Email' required></label></div>
			<div><label>Password<input type='password' name='Pass' required></label></div>
			<div><input class='button-right' type='submit' value='Login' formaction='.?Login'></div>
		</form>
	</div>");
}
?>