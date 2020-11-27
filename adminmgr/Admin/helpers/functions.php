<?php 
class App{
    function is_admin(){
        if(isset($_SESSION["agentRole"])){
            if(($_SESSION["agentRole"] == "ADMIN") || ($_SESSION["agentRole"] == "SADMIN"))  
            {
                return true;
            }
            else{
                return false;
            }
        }
    }

    function agent_login_redirect(){    
        if(basename($_SERVER['PHP_SELF']) != "agentaccess.php"){
            if(!isset($_SESSION["agentId"])){
                header("location:agentaccess.php");
            }
        }
    }

    function is_agent_logged_in(){    
        if(isset($_SESSION["agentId"])){
            return true;
        }else{
            return false;
        }
    }

    function is_merchant(){
        if(isset($_SESSION["FinancialInstitutionAdmin"])){
            if($_SESSION["FinancialInstitutionAdmin"] == true)  
            {
                return true;
            }
            else{
                return false;
            }
        }
    }

    function is_loading_center()
	{
        return true;
        if(isset($_SESSION["isLoadCenter"]))
        {
            if($_SESSION["isLoadCenter"] == true)
			{
                return true;
            }else
			{
                return false;
            }
        }
    }

    function is_epayadmin(){
        if(isset($_SESSION["EPayAdmin"])){
            if($_SESSION["EPayAdmin"] == true)  
            {
                return true;
            }
            else{
                return false;
            }
        }
    }
  
}
?>