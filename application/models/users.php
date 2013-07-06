<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * XtraUpload
 *
 * A turn-key open source web 2.0 PHP file uploading package requiring PHP v5
 *
 * @package		XtraUpload
 * @author		Matthew Glinski
 * @copyright	Copyright (c) 2006, XtraFile.com
 * @license		http://xtrafile.com/docs/license
 * @link		http://xtrafile.com
 * @since		Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * XtraUpload Users Model
 *
 * @package		XtraUpload
 * @subpackage	Model
 * @category	Model
 * @author		Matthew Glinski
 * @link		http://xtrafile.com/docs/pages/files
 */

// ------------------------------------------------------------------------

class Users extends CI_Model
{
    public $loggedin = false;

	// ------------------------------------------------------------------------
	
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->checkUserAuth();
    }
	
	// ------------------------------------------------------------------------

    /**
     * Retrieve the User by ID
     *
     * @param int $id
     * @return object
     */
    public function getUserById($id)
	{
		$query = $this->db->get_where('users', array('id' => (int) $id));

		return $query->row();
	}
    
	// ------------------------------------------------------------------------
	
	/**
	 * Users->checkUserAuth()
	 *
	 * Load a view variable to see if the user is logged in
	 *
	 * @access	public
	 * @param	string
	 * @return	none
	 */
    public function checkUserAuth()
    {
		if($this->session->userdata('id'))
		{
			$this->load->vars(array('loggedin' => true));
			$this->loggedin = true;
		}
		else
		{
			$this->load->vars(array('loggedin' => false));
			if(!stristr($this->uri->uri_string(),'/user/login'))
			{
				// Force all users to login by uncommenting the following line
				//redirect('/user/login');
			}
		}
    }
	
	// ------------------------------------------------------------------------

    /**
     * Retrieve Username By User ID
     *
     * @param int $id
     * @return string
     */
    public function getUsernameById($id)
	{
		$query = $this->db->get_where('users', array('id' => $id));

		if($query->num_rows() > 0)
		{
            return $query->row()->username;
		}

        return 'Anonymous';
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Users->userLogout()
	 *
	 * Log the user out
	 *
	 * @access	public
	 * @return	bool
	 */
	public function userLogout()
    {
        // TODO: This should use unset_userdata to avoid messing up flash data.
		$this->session->sess_destroy();
		return true;
    }
	
	// ------------------------------------------------------------------------

    /**
     * Update the currently logged in user with an array of parameters.
     *
     * @param array $data
     * @return bool
     */
    public function userUpdate($data)
	{
		$this->db->where('id', $this->session->userdata('id'));

		return $this->db->update('users', $data);
	}
	
	// ------------------------------------------------------------------------

    /**
     * Update the password of the username specified.
     *
     * @param string $pass
     * @param string $username
     * @return bool
     */
    public function userUpdateForgot($pass, $username)
	{
		$this->db->where('username', $username);

        return $this->db->update('users', array('password' => $pass));
	}
	
	// ------------------------------------------------------------------------

    /**
     * Process a user login.
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function processLogin($username, $password)
	{
		$query = $this->db->get_where('users', array('username' => $username, 'status' => 1, 'password' => md5($this->config->config['encryption_key'].$password)));

        if (!($query->num_rows() === 1)){
            return false;
        }

        // Get user data and setup session
        $userData = $query->row();

        $this->session->set_userdata(
            array(
                'username'  	=> $username,
                'id'			=> $userData->id,
                'group'		    => $userData->group,
                'email'     	=> $userData->email,
                'loggedin'	    => TRUE,
                'login'		    => TRUE,
                'ip_logged' 	=> FALSE
            )
        );

        return true;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Users->genPass()
	 *
	 * Generate a password
	 * DEPERICIATED
	 *
	 * @access	public
	 * @param	string
	 * @param	bool
	 * @return	none
	 */
	public function genPass($length, $caps=true)
	{
		// Depriciated, use the refrenced function
		return $this->functions->genPass($length, $caps);
	}
	
	// ------------------------------------------------------------------------

    /**
     * Create a new user and send an email off.
     *
     * @param array $userData
     * @param bool $hasPaid
     * @return int
     */
    public function newUser(array $userData, $hasPaid = false)
	{
		$this->db->insert('users', $userData);

		$id = $this->db->insert_id();

        // TODO: Refactor this into separate functions. SINGLE RESPONSIBILITY!
        $to = $userData['email'];
        $user = $this->db->get_where('users', array('id' => $id))->row();
		
		if ($hasPaid)
        {
            $this->sendPayLinkEmail($to, $user, $id);
		}
		else
        {
            $group = $this->db->get_where('groups', array('id' => $user->group))->row();
            $this->sendNewUserEmail($to, $user, $group);
		}
		
		return $id;
	}

    // ------------------------------------------------------------------------

    // TODO: Move this into a library for sending emails.
	public function sendNewUserEmail($to, $user, $group)
	{
		// Load the email library
		$this->load->library('email');
		
		// Setup the mail library
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$rec = array(
			'd' => 'Daily',
			'w' => 'Weekly',
			'm' => 'Monthly',
			'y' => 'Yearly',
			'dy' => 'Bi-Yearly',
		);
		
		// Set email options
		$this->email->from($this->startup->site_config['site_email'], $this->startup->site_config['sitename'].' Support');
		$this->email->to($to);
		$this->email->subject('New user at '.$this->startup->site_config['sitename'].'!');
		
		$msg = 'Hello '.$user->username.',<br />Welcome to '.$this->startup->site_config['sitename'].'!<br /><br />Here are your account details should you ever need them:<br /><br />--------------------------<br />Username: '.$user->username.'<br />Group: '.ucwords($group->name).'<br />';

		if($group->price > 0.00)
		{
			$msg .= 'Ammount Paid: '.$group->price.'<br />';
			if($group->repeat_billing)
			{
				$msg .= 'Billing Period: '.$rec[$group->repeat_billing].'<br />';
			}
		}
		
		$msg .= '--------------------------<br /><br />Thanks for joining our community!<br />'.$this->startup->site_config['sitename'].' Administration';

		$this->email->message($msg);
		
		// Send the email
		$this->email->send();
	}

    // TODO: Move this into a library for sending emails.
	public function sendPayLinkEmail($to, $user, $id)
	{
		// Load the email library
		$this->load->library('email');
		
		// Setup the mail library
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		// Set email options
		$this->email->from($this->startup->site_config['site_email'], $this->startup->site_config['sitename'].' Support');
		$this->email->to($to);
		$this->email->subject('New user at '.$this->startup->site_config['sitename'].'!');
		
		$msg = 'Hello '.$user->username.',<br />Welcome to '.$this->startup->site_config['sitename'].'!<br /><br />Before you account is activated you need to pay using the following link. If you have already completed the payment process, please wait while we authorize your payment. Once complete you will recive a new email containg your details.<br /><br /><a href="'.site_url('user/pay_new/'.$id.'/'.$user->gateway).'">Pay Here</a><br /><br />Thanks for joining our community!<br />'.$this->startup->site_config['sitename'].' Administration';

		$this->email->message($msg);
		
		// Send the email
		$this->email->send();
	}
}
