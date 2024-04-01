<?php

if ($this->session->userdata('userLoginsession')) 
{
	$udata = $this->session->userdata('userLoginsession');
	echo 'welcome' . ''. $udata['username'];	
}
else{
	redirect(base_url('welcome/login'));	
}

?>

<a href="<?=base_url('welcome/logout')?>">Logout</a>	