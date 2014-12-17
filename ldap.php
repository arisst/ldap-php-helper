<?php 
/**
* LDAP HELPER
*/
class LdapHelper
{
	protected $host = 's.airputih.id';
	protected $baseDn = 'dc=s,dc=airputih,dc=id';


	function connect()
	{
		$ldap_conn = ldap_connect($this->host);
		ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);
		return $ldap_conn;
	}

	function disconnect()
	{
	  $ldap_conn = ldap_connect($this->host);
		return ldap_close($ldap_conn);
	}

	function search($filter) //pencarian
	{
		$ldap_conn = $this->connect();
		$result = ldap_search($ldap_conn, $this->baseDn, $filter);
		ldap_sort($this->connect(), $result, "sn");
		return ldap_get_entries($ldap_conn, $result); 
	}

	function bind($dn, $pass) //binding untuk login dsb
	{
		return ldap_bind($this->connect(), $dn, $pass);
	}

	function update($dn, $currentpass, $entry) //mengubah entry
	{
		$ldap_conn = $this->connect();
		$bind = ldap_bind($ldap_conn, $dn, $currentpass);
		if ($bind){
			return ldap_mod_replace($ldap_conn, $dn, $entry);
		}else
		{
			echo "Current pass salah";
		}
	}
}
 ?>
